<?php
 

 class Productos extends Controllers{
  

    public function __construct()
    {
    
        parent::__construct();
        session_start();
        if(empty($_SESSION['login']))
        {
           header('Location: '.base_url.'/login'); 
        }
        getPermisos(10);
    }

    public function Productos()
    {
        if(empty($_SESSION['permisosMod']['r'])){
            header('Location:'.base_url.'/dashboard');
        }
        
        $data['page_tag'] = "Productos";
        $data['page_title'] = "Productos";
        $data['page_name'] = "productos";
        $this->views->getView($this,"productos",$data);
    }   
    

    public function setProductos()
    {
         //validamos si esque enviamos una peticion POST
         if($_POST){
            
            //validacion para que los campos no esten vacios
            if(empty($_POST['txtnombre']) || empty($_POST['txtCodigo']) || empty($_POST['listCategoria']) || empty($_POST['txtPrecio']) || empty($_POST['txtStock']) || empty($_POST['listStatus']))
            {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            }else{
                
                $idProducto = intval($_POST['idProducto']); //automatica va ser 0 por el intval propiedad de php
                $strNombre = strClean($_POST['txtnombre']);
                $strDescripcion = strClean($_POST['txtdescripcion']);
                $intCodigo = strClean($_POST['txtCodigo']);
                $intCategoriaId = intval(strClean($_POST['listCategoria']));
                $strPrecio = strClean($_POST['txtPrecio']);
                $intStock = intval($_POST['txtStock']);
                $intStatus = intval($_POST['listStatus']);
                $request_producto = "";
                
                $ruta = strtolower(clear_cadena($strNombre)); //convierte mayusculas a minusculas, clear deja sin tildes.
                $ruta = str_replace(" ","-",$ruta); //los nombres en espacios en blanco reemplaza por la variable ruta agregando un guion

                if($idProducto == 0) //no estamos enviando id quiere decir que vamos a insertar
                {
                    $option = 1;
                    $request_producto = $this->model->insertProducto($strNombre,
                                                                     $strDescripcion,
                                                                     $intCodigo,
                                                                     $intCategoriaId,
                                                                     $strPrecio,
                                                                     $intStock,
                                                                     $ruta,
                                                                     $intStatus);

                }else{ //en caso si enviamos el id de producto pasamos a actualizar producto

                    $option = 2;

                }

                //validacion para el insertar 
                if($request_producto > 0 )
                {
                    if($option == 1){ //se guardo un producto
                        $arrResponse = array('status' => true, 'idproducto' => $request_producto, 'msg' => 'Datos guardados correctamente.');
                    }else{

                    }
                }else if($request_producto == 'exist'){
                    $arrResponse = array('status' => false, 'msg' => 'Atencion, ya existe un producto con el codigo ingresado');
                }      
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE); 
        }
        die(); 
    }
    




    public function getProductos(){
        $arrData = $this->model->selectProductos();
			
			//Recorre hasta que termine la cantidad de elemtnos del array, y incrementa
			for ($i=0; $i < count($arrData); $i++){

				//Variables para los botones
				$btnView = '';
				$btnEdit = '';
                $btnDelete = '';
                
                //validacion para el status
                if($arrData[$i]['status']==1)
				{
					$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
				}else {
					$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                }
                
                //al campo de precio le agregamos el simbolo de moneda del config variable global dandole un formato de moneda creada en helpers
                $arrData[$i]['precio'] = SMONEY.formatoMoney($arrData[$i]['precio']);

				//Validacion para los botones respecto a los permisos 
				if($_SESSION['permisosMod']['r']){ //permiso para lectura
					$btnView = '<button class="btn btn-info btn-sm btnViewProducto" onClick="fntViewProducto('.$arrData[$i]['idproducto'].')" title="Ver Producto"><i class="far fa-eye"></i></button>';

				}
				if($_SESSION['permisosMod']['u']){ //permiso de actualizar
					
					$btnEdit = '<button class="btn btn-secondary btn-sm btnEditProducto" onClick="fntEditProducto('.$arrData[$i]['idproducto'].')" title="Editar Producto"><i class="fas fa-pencil-alt"></i></button>';
				}
				if($_SESSION['permisosMod']['d']){ //permisos para eliminar
					$btnDelete = '<button class="btn btn-danger btn-sm btnDelProducto" onClick="fntDelProducto('.$arrData[$i]['idproducto'].')" title="Eliminar Producto"><i class="fas fa-trash-alt"></i></button>';
				}
			
				//Botones, agregamos el onclick con su funcion para que al momento de cambiar de paginacion no presente incovenientes, CONCATENAMOS LAS VARIABLES DE LOS BOTONES
				$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
    }

    
    //Obtener un producto
    public function getProducto($intidproducto){
         $idproducto = intval($intidproducto);
         if($idproducto > 0){
             $arrData = $this->model->selectProducto($idproducto);
             if(empty($arrData)){
                 $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
             }else{
                 $arrImg = $this->model->selectImages($idproducto);
                 if(count($arrImg) > 0){ //cuenta cuantos elementos tiene el array de la imagen
                    for ($i=0; $i < count($arrImg); $i++) { //recorre los registros,que es menor a la cantidad de registros del array

                        //accedemos a la primera posicion del array, inicia en posicion 0, concatenamos el nombre de la imagen del elemento img para obtener la ruta de la imagen "url_image"
                        $arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];

                    }
                 }
                 $arrData['images'] = $arrImg; //agrega el elemento al arrimg (variable)
                 $arrResponse = array('status' => true, 'data' => $arrData);
             }
             echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
             die();
         }
    }



    //Para enviar imagenes
    public function setImage()
    {
       if($_POST){
           //validacion para saber si el idproducto esta vacio
           if(empty($_POST['idproducto'])){
            $arrResponse = array('status' => false, 'msg' => 'Error de dato');
           }else{
            $idProducto = intval($_POST['idproducto']);
            $foto       = $_FILES['foto'];
            $imgNombre  = 'pro_'.md5(date('d-m-Y H:m:s')).'.jpg'; //pro es una abreviatura para el producto y mandamos encriptado para que el nombre de la imagen no se repita enviando la funcioon date y concatenamos la extension que sera jpg.
            $request_image = $this->model->insertImage($idProducto,$imgNombre); //al metodo isnertar le enviamos como parametro el id producto y el nombnre de la imagen.
 
            //validacion que queire decir que si se almacenaron los datos 
            if($request_image){
                $uploadImage =  uploadImage($foto,$imgNombre); //uploadimage funcion de helpers que es para subir la imagen al servidor.
                $arrResponse = array('status' => true, 'imgname' => $imgNombre, 'msg' => 'Archivo cargado.'); //enviamos el imgNombre obteniendo el nombre de la imagen encriptada. 
            }else{
                $arrResponse = array('status' => false, 'msg' => 'Error de carga');
            }
         }
         echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); 
           
       }
       sleep(2); //observar el loading al momento de enviar la imagen para que cargue con un tiempo de 2 segundos.
       die();
    }


} 

?>