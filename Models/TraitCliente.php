<?php
 //requerimos los metodos que estan en el mysql CRUD
 require_once("Libraries/Core/Mysql.php");

 trait TraitCliente{
     private $con; //conexion de mysql
     private $intIdUsuario;
     private $strNombre;
     private $strApellido;
     private $intTelefono;
     private $strEmail;
     private $strPassword;
     private $strToken;
     private $intTipoId;
     private $intIdTransaccion;

     public function insertCliente($stringnombre, $stringapellido, $inttelefono, $stringemail, $stringpassword, $inttipoid){
        $this->con = new Mysql();
        $this->strNombre = $stringnombre;
        $this->strApellido = $stringapellido;
        $this->intTelefono = $inttelefono;
        $this->strEmail = $stringemail;
        $this->strPassword = $stringpassword;
        $this->intTipoId = $inttipoid;

            
        $return = 0;
        //validacion para saber si existe el correo si no existe procedemos a registrar al cliente.
        $sql = "SELECT * FROM persona WHERE 
                email_user = '{$this->strEmail}' ";
        $request = $this->con->MostrarRegistros($sql);

        if(empty($request))
        {
            $query_insert  = "INSERT INTO persona(nombres,apellidos,telefono,email_user,password,rolid) 
                            VALUES(?,?,?,?,?,?)";
            $arrData = array(
                            $this->strNombre,
                            $this->strApellido,
                            $this->intTelefono,
                            $this->strEmail,
                            $this->strPassword,
                            $this->intTipoId,
                          );
            $request_insert = $this->con->insertar($query_insert,$arrData);
            $return = $request_insert;
        }else{
            $return = "exist";
        }
        return $return;
    }

    public function insertPedido($stringidtransaccionpaypal = NULL, $stringdatospaypal = NULL, $intpersonaid, $floatcosto_envio, $stringmonto, $inttipopagoid, $stringidreccionenvio, $stringstatus){
        $this->con = new Mysql(); //instancia
        $query_insert = "INSERT INTO pedido(idtransaccionpaypal,datospaypal,personaid,costo_envio,monto,tipopagoid,direccion_envio,status) VALUES(?,?,?,?,?,?,?,?)";
        $arrData = array($stringidtransaccionpaypal, 
                         $stringdatospaypal,
                         $intpersonaid,
                         $floatcosto_envio,
                         $stringmonto,
                         $inttipopagoid,
                         $stringidreccionenvio,
                         $stringstatus
                        );
        $request_insert =  $this->con->insertar($query_insert,$arrData);
        $return = $request_insert;
        return $return; //retornamos al cotnrolador el resultado.

    }
    
    public function insertDetalle($intidpedido, $intproductoid, $floatprecio, $intcantidad){
        $this->con =  new Mysql();
        $query_insert = "INSERT INTO detalle_pedido(pedidoid,productoid,precio,cantidad) VALUES(?,?,?,?)";
        $arrData = array($intidpedido,
                        $intproductoid,
                        $floatprecio,
                        $intcantidad
                        ); 
        $request_insert = $this->con->insertar($query_insert,$arrData);
        $return = $request_insert;
        return $return;

    }

    public function insertDetalleTemp($arraypedido){
        $this->intIdUsuario = $arraypedido['idcliente'];
        $this->intIdTransaccion= $arraypedido['idtransaccion'];
        $productos = $arraypedido['productos'];
        $this->con = new Mysql(); //instancia.
        
        /* ===================================
         ==== Consulta a la tabla temporal ==== */

        $sql = "SELECT * FROM detalle_temp WHERE 
                   transaccionid = '{$this->intIdTransaccion}' AND
                   personaid = $this->intIdUsuario";
        $request = $this->con->MostrarRegistros($sql);

        /* Validacion para saber si la variable request esta vacia va a cumplir lo sgte: */
        if(empty($request)){
            foreach ($productos as $producto) { /* insertamos con un foreach en el array productos asignandoles a cada uno de los elementos en la variable producto. */
                $query_insert = "INSERT INTO detalle_temp(personaid,productoid,precio,cantidad,transaccionid) VALUES (?,?,?,?,?)"; 

                /* Array de datos */
                $arrData = array(
                                 $this->intIdUsuario,
                                 $producto['idproducto'],
                                 $producto['precio'],
                                 $producto['cantidad'],
                                 $this->intIdTransaccion
                                );
                $request_insert =  $this->con->insertar($query_insert,$arrData);
            }
        /* Actualizacion */
        }else{
            $sqlDel = "DELETE FROM detalle_temp  WHERE 
                     transaccionid = '{$this->intIdTransaccion}' AND
                     personaid = $this->intIdUsuario";
            $request = $this->con->Eliminar($sqlDel);
            
            /* Insertamos nuevamente los productos */
            foreach ($productos as $producto){
                $query_insert = "INSERT INTO detalle_temp(personaid,productoid,precio,cantidad,transaccionid) VALUES (?,?,?,?,?)";
                $arrData = array(
                                 $this->intIdUsuario,
                                 $producto['idproducto'],
                                 $producto['precio'],
                                 $producto['cantidad'],
                                 $this->intIdTransaccion
                                );
                $request_insert = $this->con->insertar($query_insert,$arrData);

            }

        }
    }
    
    //extraer pedido
    public function getPedido($intidpedido){
        $this->con = new Mysql();
        $request = array(); //en caso el pedido no existe retorna un array vacio
        $sql = "SELECT p.idpedido,
                       p.referenciacobro,
                       p.idtransaccionpaypal,
                       p.personaid,
                       p.fecha,
                       p.costo_envio,
                       p.monto,
                       p.tipopagoid,
                       t.tipopago,
                       p.direccion_envio,
                       p.status
                FROM pedido as p
                INNER JOIN tipopago t
                ON p.tipopagoid = t.idtipopago
                WHERE p.idpedido = $intidpedido";
        $requestPedido = $this->con->Buscar($sql);
        //validacion donde sabemos que si existe el pedido
        if(count($requestPedido) > 0){
            $sql_detalle = "SELECT p.idproducto,
                                   p.nombre as producto,
                                   d.precio,
                                   d.cantidad
                            FROM detalle_pedido d
                            INNER JOIN producto p
                            ON d.productoid = p.idproducto
                            WHERE d.pedidoid = $intidpedido";
            $requestProductos = $this->con->MostrarRegistros($sql_detalle);
            $request = array('orden' => $requestPedido,
                             'detalle' => $requestProductos
                            );

        }
        return $request; 
    }

 }

?>