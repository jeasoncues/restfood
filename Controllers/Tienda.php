<?php
 require_once("Models/TraitCategoria.php");
 require_once("Models/TraitProducto.php");
 require_once("Models/TraitCliente.php");
 require_once("Models/LoginModel.php");

  class Tienda extends Controllers{
    use TraitCategoria, TraitProducto, TraitCliente;
    public $login; //propiedad para crear instancia
    public function __construct(){
        parent::__construct();
        session_start(); //variable de sesion
        $this->login = new LoginModel(); //objeto de tipo loginModel
    }

    public function tienda()
    {
        $data['page_tag'] = "Rest-Food | Tienda Online";
        $data['page_title'] = "Productos";
        $data['page_name'] = "tienda";
        $data['productos'] = $this->getProductosTienda();
        $this->views->getView($this,"tienda",$data);
    }
    

    //para mostrar la vista categoria
    public function categoria($params)
    {
        if(empty($params)){ //si no viene nada en el parametro redireccionamos a  la ruta base de la tienda
            header("Location:".base_url());
        }else{
            $arrParams = explode(",",$params); //explode -> buscar caracter en este caso "," porque es la separacion del id y categoria.
            $idcategoria = intval($arrParams[0]); //posicion 0 toma el idcategoria
            $ruta = strClean($arrParams[1]); //posicion 1 que es la categoria la toma la ruta.
            $infocategoria = $this->getProductosCategoriaTienda($idcategoria,$ruta);


            $categoria = strClean($params); //limpiamos con la funcion strclean en caso de que escriban otras cosas en la url 
            //invocamos a la vista categoria
            $data['page_tag'] = "Rest-Food | Tienda Online"."-".$infocategoria['categoria'];
            $data['page_title'] = $infocategoria['categoria'];
            $data['page_name'] = "categoria";
            $data['productos'] = $infocategoria['productos'];
            $this->views->getView($this,"categoria",$data);

        }

    }

    //metodo para detalle de producto
    public function producto($params)
    {
        if(empty($params)){ //si no viene nada en el parametro redireccionamos a  la ruta base de la tienda
            header("Location:".base_url());
        }else{
            $arrParams = explode(",",$params);
            $idproducto = intval($arrParams[0]);
            $ruta = strClean($arrParams[1]);
            $infoProducto = $this->getProductosT($idproducto,$ruta);
            if(empty($infoProducto)){
               header("Location:".base_url());
            }
            $data['page_tag'] = "Rest-Food | Tienda Online"." - ".$infoProducto['nombre'];
            $data['page_title'] = $infoProducto['nombre'];
            $data['page_name'] = "producto";
            $data['producto'] = $infoProducto;
            $data['productos'] = $this->getProductosRandom($infoProducto['categoriaid'],2,"r"); //2 productos cantidad que queremos mostrar en el slider, forma para extraer los productos con "R" de forma aleatoria., si enviamos a -> ascendente , d->descendente.
            $this->views->getView($this,"producto",$data);

        }

    }


    //Metodo para agregar al carrito
    public function addCarrito(){
        if($_POST){
            //unset($_SESSION['arrCarrito']);exit; //limpiar el carrito, unset elimina la variable de session arrcarrito
            $arrCarrito = array();
            $cantCarrito = 0; //cantidad de productos del carrito.
            //openssl_decrypt => desencriptamos el id del producto encriptado
            $idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
            $cantidad = $_POST['cant'];
            //si las dos variables son numericos agregara al carrito de lo contrario no, eso se hace con is_numeric
            if(is_numeric($idproducto) and is_numeric($cantidad)){
                $arrInfoProducto = $this->getProductoIDT($idproducto);
                if(!empty($arrInfoProducto)){ //validacion para saber si no esta vacio recuperamos los datos
                    $arrProducto = array('idproducto' => $idproducto,
                                         'producto' => $arrInfoProducto['nombre'],
                                         'cantidad' => $cantidad,
                                         'precio' => $arrInfoProducto['precio'],
                                         'imagen' => $arrInfoProducto['imagen'][0]['url_image']
                                        );
                    //validacion para saber si tenemos una variable de sesion iniciada , quiere decir que ya agregamos un carrito para saber si existe.
                    if(isset($_SESSION['arrCarrito'])){
                       $on = true; 
                       $arrCarrito = $_SESSION['arrCarrito'];
                       for ($pr=0; $pr < count($arrCarrito); $pr++) {  //cantidad de elemento del array
                            if($arrCarrito[$pr]['idproducto'] == $idproducto){
                                $arrCarrito[$pr]['cantidad'] = $arrCarrito[$pr]['cantidad'] + $cantidad; //le suma lo que tiene el elemento con la variable
                                $on =  false; //para verificar si vamos agregar al carrito o no
                            }
                       }
                       //validacion para saber si vamos agregar un elemento o asignamos a la variable de sesion del carrito
                        if($on){
                        array_push($arrCarrito,$arrProducto); //agregamos al carrito
                        }
                        $_SESSION['arrCarrito'] = $arrCarrito; 

                    }else{ //si no existe agregamos al carrito
                        //agrega un elemento al array
                        array_push($arrCarrito, $arrProducto);
                        $_SESSION['arrCarrito'] = $arrCarrito; //ya existe la sesion y agrega el primer producto al carrrito. 
                    }
                    //recorrer el array obteniendo los datos del array
                    //obtenemos el array de la sesion y se lo coloca a la variable $pro y luego nos dirigimos a cantidad.
                    foreach ($_SESSION['arrCarrito'] as $pro) {
                        $cantCarrito = $cantCarrito + $pro['cantidad'];
                    }
                    //extraemos un archivo con getFile que se encuentra en el siguiente directorio => template... 
                    $htmlCarrito = getFile('Template/Modals/modalCarrito',$_SESSION['arrCarrito']);
                    //array donde obtenemos todos los datos del carrito que devuelve en formato JSON.
                    $arrResponse = array("status" => true,
                                         "msg" => '¡Se agrego al carrito!',
                                         "cantCarrito" => $cantCarrito,
                                         "htmlCarrito" => $htmlCarrito
                                        ); 

                }else{
                    $arrResponse = array("status" => false, "msg" => 'Producto no existente.');
                }

            }else{
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            
        }
        die();
    }


    //Funcion para eliminar desde el modal carrito
    public function delCarrito(){
        if($_POST){
            $arrCarrito = array();
            $cantCarrito = 0; //cantidad de productos del carrito.
            $subtotal = 0;
            //openssl_decrypt => desencriptamos el id del producto encriptado
            $idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
            $option = $_POST['option'];
            
            //validacion para saber si son numericos los datos
            if(is_numeric($idproducto) and ($option == 1 or $option == 2)){
                $arrCarrito = $_SESSION['arrCarrito'];
                //si existe la variable sesion del carrito recorremos con el for
                for ($pr=0; $pr < count($arrCarrito) ; $pr++) { 
                    if($arrCarrito[$pr]['idproducto'] == $idproducto){ //es igual al id que estamos envianado quiere decir que si existe
                        unset($arrCarrito[$pr]); //funcion unset sirve para eliminar, lo cual estamos eliminado el array en la posicion del ciclo for
                    }
                }
                sort($arrCarrito); //ordena de nuevo el array. 
                $_SESSION['arrCarrito'] = $arrCarrito; //para mostrar de nuevo en el modal
                foreach($_SESSION['arrCarrito'] as $pro) {
                    $cantCarrito = $cantCarrito + $pro['cantidad']; //cantidad de los productos en el carrito
                    $subtotal = $subtotal + $pro['cantidad'] * $pro['precio'];
                }
                $htmlCarrito = "";
                if($option == 1){
                //hacemos el llamado del modal
                $htmlCarrito = getFile('Template/Modals/modalCarrito',$_SESSION['arrCarrito']);
                }
                 //array donde obtenemos todos los datos del carrito que devuelve en formato JSON.
                 $arrResponse = array("status" => true,
                                        "msg" => '¡Producto eliminado!',
                                        "cantCarrito" => $cantCarrito,
                                        "htmlCarrito" => $htmlCarrito,
                                        "subTotal" => SMONEY.formatoMoney($subtotal),
                                        "total" => SMONEY.formatoMoney($subtotal + COSTOENVIO)
                                        ); 
            }else{
                $arrResponse = array("status" => false, "msg" => 'Datos incorrecto.');
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }


    //Metodo para actualizar cantidad en la vista carrito
    public function updCarrito(){
        if($_POST){
            $arrCarrito = "";
            $totalProducto = 0; //sirve para actualizar los productos
            $subtotal = 0;
            $total = 0;
            
            //openssl_decrypt => desencriptamos el id del producto encriptado
            $idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
            $cantidad = intval($_POST['cantidad']);
            if(is_numeric($idproducto) and $cantidad > 0){
                $arrCarrito = $_SESSION['arrCarrito'];
                for ($p=0; $p < count($arrCarrito); $p++) {  //p es menor que la cantidad de elemento de la variable
                    if($arrCarrito[$p]['idproducto'] == $idproducto){ //si el arraycarrito en la posicion que se encuentra el ciclo el idproducto es igual al idproducto que estamos enviando entonces va actualizar la cantidad.
                        $arrCarrito[$p]['cantidad'] = $cantidad; //es igual a la nueva cantidad que estamos enviando que seria la variable cantidad.
                        $totalProducto = $arrCarrito[$p]['precio'] * $cantidad; //actualiza el totalproducto que es igual al elemento precio y se multiplica por la nueva cantidad
                        break; //finaliza
                    }
                }
                $_SESSION['arrCarrito'] = $arrCarrito; //a la variable de sesion le mandamos la nueva variable para la actualizacion
                //recorremos todo lo que tenga la variable de sesion carrito
                foreach($_SESSION['arrCarrito'] as $pro){
                    $subtotal = $subtotal + $pro['cantidad'] *  $pro['precio'];
                }
                
                $arrResponse = array("status" => true,
                                     "msg" => '¡Producto actualizado!',
                                     "totalProducto" => SMONEY.formatoMoney($totalProducto),
                                     "subTotal" => SMONEY.formatoMoney($subtotal),
                                     "total" => SMONEY.formatoMoney($subtotal + COSTOENVIO)
                                    );
            }else{
                $arrResponse = array("status" => false, "msg" => 'Datos Incorrectos.');
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
           
        }
        die();
    }
   

  //METODO PARA CREAR CLIENTES
  public function registro()
    {
        if($_POST){
			if(empty($_POST['txtNombres']) || empty($_POST['txtApellidos']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmailCliente']))
			{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{ 
				$strNombre = ucwords(strClean($_POST['txtNombres']));
				$strApellido = ucwords(strClean($_POST['txtApellidos']));
				$intTelefono = intval(strClean($_POST['txtTelefono']));
				$strEmail = strtolower(strClean($_POST['txtEmailCliente']));
                $intTipoId = 8; //rol de usuario => cliente
                $request_user = "";
                
                $strPassword =  passGenerador(); //contraseña automatica
                $strPasswordEncript = hash("SHA256",$strPassword); //encriptamos password
                //trait insertcliente
                $request_user = $this->insertCliente(
                                                            $strNombre, 
                                                            $strApellido, 
                                                            $intTelefono, 
                                                            $strEmail,
                                                            $strPasswordEncript,
                                                            $intTipoId, 
                                                                    );
				
				if($request_user > 0 )
				{ 
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                    $nombreUsuario = $strNombre.' '.$strApellido; //nombre completo para enviar al correo sus datos.
                    $dataUsuario = array('nombreUsuario' => $nombreUsuario,
                                             'email' => $strEmail,
                                             'password' => $strPassword,
                                            'asunto' => 'Bienvenido a Donattos Restaurante');
                    //variables de session
                    $_SESSION['idUser'] = $request_user;
                    $_SESSION['login'] = true;
                    $this->login->sessionLogin($request_user); //enviamos como parametro al id del cliente para extraer toda la informacion del cliente y crear la variable de session.
                    //$sendEmail = sendEmail($dataUsuario,'email_bienvenida'); //enviar por correo

				}else if($request_user == 'exist'){
					$arrResponse = array('status' => false, 'msg' => '¡Atención! el email ya existe, ingrese otro.');		
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();

	}
    
    

    /* Metodo para procesar venta */
    public function procesarVenta(){

       if($_POST){
         
          //variablles 
          $idtransaccionpaypal = NULL;
          $datospaypal = NULL;
          $personaid = $_SESSION['idUser']; //variable de session 
          $monto = 0;
          $tipopagoid = intval($_POST['inttipopago']);
          $direccionenvio = strClean($_POST['direccion']).', '.strClean($_POST['ciudad']); //concatenamos la direccion y ciudad
          $status = "Pendiente"; //inician en el estado de Pendiente
          $subtotal = 0;
          $costo_envio = COSTOENVIO; //enviando el valor actual de la constante costoenvio

          //validacion para saber si existe la variable del carrito quiere decir que si tenemos productos en el carrito.
          if(!empty($_SESSION['arrCarrito'])){

            foreach ($_SESSION['arrCarrito'] as $pro){
                $subtotal = $subtotal + $pro['cantidad'] * $pro['precio'];
            }
            $monto =  formatoMoney($subtotal + COSTOENVIO);

            //VALIDACION PARA SABER SI ENVIAMOS LOS DATOS DE PAYPAL O POR CONTRAENTREGA
            //pago contraentrega
            if(empty($_POST['datapay'])){ //si esta vacio quiere decir que no estamos enviando los datos de paypal y que la compra sera para CONTRAENTREGA.

                //Crear pedido (metodo)
                $request_pedido = $this->insertPedido($idtransaccionpaypal,
                                                        $datospaypal,
                                                        $personaid,
                                                        $costo_envio,
                                                        $monto,
                                                        $tipopagoid,
                                                        $direccionenvio,
                                                        $status); //el estado estara pendiente hasta que se complete el proceso.

                if($request_pedido > 0){//si se inserto el pedido en la tabla

                    //insertamos el detalle del pedido 
                    foreach ($_SESSION['arrCarrito'] as $producto) { //recorremos todos los productos de la variable de session carrito y accedemos a los elementos.
                        $productoid = $producto['idproducto']; //ingresamos al array en el elemento idproducto de igual forma en los otros.
                        $precio = $producto['precio'];
                        $cantidad = $producto['cantidad'];
                        $this->insertDetalle($request_pedido,$productoid,$precio,$cantidad);//invocamos al metodo insertdetalle enviamos el idpedido, producto, precio y cantidad.
                    }
                
                
                //enviamos el email al correo electronico del cliente y de la empresa notificacion de compra

                //extraer pedidos detalle indicando el id que es la variable requestpedido enviandola como parametro
                $infoOrden =  $this->getPedido($request_pedido);
                //array para enviarlo por correo el pedido.
                $dataEmailOrden = array('asunto' => "Tu pedido N°.$request_pedido. fue confirmado",
                                        'email' => $_SESSION['userData']['email_user'],
                                        'emailCopia' => EMAIL_PEDIDOS,
                                        'pedido' => $infoOrden);
                
                //funcion de enviar correos enviando como primer parametro el array de datos y el template
                sendEmail($dataEmailOrden,"email_notificacion_orden");

                //FUNCION DE ENCRIPTACION DONDE ENVIAMOS EL METODO DE ENCRIPTACION Y LA LLAVE.
                $orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
                $transaccion =  openssl_encrypt($idtransaccionpaypal, METHODENCRIPT, KEY);


                $arrResponse = array("status" => true, 
                                    "order" => $orden,
                                    "transaccion" => $transaccion,
                                    "msg" => 'Pedido realizado.'
                                    );
                $_SESSION['dataorden'] = $arrResponse; //variable de session de la orden.

                //destruimos la variabla de ssesion
                unset($_SESSION['arrCarrito']);
                session_regenerate_id(true);//restablecemos el id de la session activa, se limpia el carrito
              }

            }else{

                //pago con paypal

                $jsonPaypal = $_POST['datapay'];
                $objPaypal = json_decode($jsonPaypal); //convertimos a un objeto el json
                $status = "Aprobado";

                if(is_object($objPaypal)){ //si es un objeto continuamos el proceso
                    $datospaypal = $jsonPaypal;
                    $idtransaccionpaypal = $objPaypal->purchase_units[0]->payments->captures[0]->id; //en la variable idtransaccion accedemos al objetos y para ingresar al objeto colocamos "->" ingresando al elemento purchase_units en la posicion 0 donde esta posicion tiene otro objeto y nos dirigimos con "->" y de payments nos dirigimos a captures en la posicion 0 y nos dirigimos al elemento "id". 

                    /* validamos el estado de la transaccion */
                    if($objPaypal->status == "COMPLETED"){
                        $totalPaypal = formatoMoney($objPaypal->purchase_units[0]->amount->value);//nos dirigmos a purchase_units en la posicion 0 y accedemos a amount que es el monto y obtenemos el valor. 
                        if($monto == $totalPaypal){ //si el monto de los productos es igual al monto que cobro paypal entonces estara completada la venta.
                            $status = "Completo";

                        }

                        //Crear pedido (metodo)
                        $request_pedido = $this->insertPedido($idtransaccionpaypal,
                                                              $datospaypal,
                                                              $personaid,
                                                              $costo_envio,
                                                              $monto,
                                                              $tipopagoid,
                                                              $direccionenvio,
                                                              $status);

                        if($request_pedido > 0){//si se inserto el pedido en la tabla

                            //insertamos el detalle del pedido 
                            foreach ($_SESSION['arrCarrito'] as $producto) { //recorremos todos los productos de la variable de session carrito y accedemos a los elementos.
                                $productoid = $producto['idproducto']; //ingresamos al array en el elemento idproducto de igual forma en los otros.
                                $precio = $producto['precio'];
                                $cantidad = $producto['cantidad'];
                                $this->insertDetalle($request_pedido,$productoid,$precio,$cantidad);//invocamos al metodo insertdetalle enviamos el idpedido, producto, precio y cantidad.
                            }

                            //extraer pedidos detalle indicando el id que es la variable requestpedido enviandola como parametro
                            $infoOrden =  $this->getPedido($request_pedido);
                            //array para enviarlo por correo el pedido.
                            $dataEmailOrden = array('asunto' => "Tu pedido N°.$request_pedido. fue confirmado",
                                                    'email' => $_SESSION['userData']['email_user'],
                                                    'emailCopia' => EMAIL_PEDIDOS,
                                                    'pedido' => $infoOrden);
                            
                            //funcion de enviar correos enviando como primer parametro el array de datos y el template
                            sendEmail($dataEmailOrden,"email_notificacion_orden");
                            
                            
                            //FUNCION DE ENCRIPTACION DONDE ENVIAMOS EL METODO DE ENCRIPTACION Y LA LLAVE.
                            $orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
                            $transaccion =  openssl_encrypt($idtransaccionpaypal, METHODENCRIPT, KEY);

                            $arrResponse = array("status" => true, 
                                                 "order" => $orden,
                                                 "transaccion" => $transaccion,
                                                  "msg" => 'Pedido realizado.'
                                                );
                            $_SESSION['dataorden'] = $arrResponse; //variable de session de la orden.

                            //destruimos la variabla de ssesion
                            unset($_SESSION['arrCarrito']);
                            session_regenerate_id(true);//restablecemos el id de la session activa, se limpia el carrito
                           
                        }else{
                            $arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
                        }

                    }else{
                        $arrResponse = array("status" => false, "msg" => 'No es posible completar el pago con PayPal.');
                    }

                }else{
                    $arrResponse = array("status" =>false, "msg" => 'Hubo un error en la transaccion');
                }

            }


          }else{
              $arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
          }

       }else{
           $arrResponse =  array("status" => false, "msg" =>  'No es posible procesar el pedido.');
       }
       echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
       die();
    }

    public function confirmarpedido(){
        //si no existe la variable de session de la orden de pedido redireccionamos a la pagina principal.
        if(empty($_SESSION['dataorden'])){
            header("Location: ".base_url());

            //si existe una variable de session mostramos la vista de confirmacion de pedido.
        }else{
            //pedido datos
            //VARIABLE DE SESSION
            //DESENCRIPTAR ENVIANDO LA VARIABLE ORDEN CON EL METODO Y LA LLAVE
            $dataorden = $_SESSION['dataorden'];
            $idpedido = openssl_decrypt($dataorden['order'], METHODENCRIPT, KEY);
            //DESENCRIPTAR ENVIANDO LA VARIABLE TRANSACCION CON EL METODO Y LA LLAVE
            $transaccion = openssl_decrypt($dataorden['transaccion'], METHODENCRIPT, KEY);
            $data['page_tag'] = "Confirmar Pedido";
            $data['page_title'] = "Confirmar Pedido";
            $data['page_name'] = "confirmarpedido";
            $data['orden'] = $idpedido;
            $data['transaccion'] = $transaccion;
            $this->views->getView($this,"confirmarpedido",$data);

        }
        //destruye la variable de session para que unicamente se vea una sola vez la compra de sus productos.
        unset($_SESSION['dataorden']);
    }

  }
?>