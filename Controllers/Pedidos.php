<?php
 
  class Pedidos extends Controllers{
      public function __construct(){
          parent::__construct();
          session_start(); //inicializamos las sessiones
          session_regenerate_id(true); //generamos un nuevo id de session
          if(empty($_SESSION['login']))
          {
              header('Location: '.base_url().'/login');
              die();
          }
          getPermisos(5); //extraemos permisos del modulo pedidos
      }

      public function pedidos(){
          //si no tiene permisos de lectura para el modulo redireccionamos a inicio
          if(empty($_SESSION['permisosMod']['r'])){
              header("Location:".base_url().'/dashboard');
          }
          $data['page_tag'] = "Pedidos";
          $data['page_title'] = "Pedidos de la tienda online";
          $data['page_name'] = "pedidos";
          $this->views->getView($this,"pedidos",$data);
      }


      //metodo para extraer pedidos
      public function getPedidos(){

        $arrData = $this->model->selectPedidos();
			
        //Recorre todo los registros hasta que termine la cantidad de elemtnos del array, y incrementa
        for ($i=0; $i < count($arrData); $i++){

            //Variables para los botones
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            
            //elementos de cada item transaccion le colocamos como valor lo que venga en referenciacobro
            $arrData[$i]['transaccion'] = $arrData[$i]['referenciacobro'];
            //validacion si el idtransaccion es diferente de vacio a la transaccion le colocamos lo que viene en el elemento de la transaccionpaypal
            if($arrData[$i]['idtransaccionpaypal'] != ""){
                $arrData[$i]['transaccion'] = $arrData[$i]['idtransaccionpaypal'];
            }
            
            //le damos formato al elemento monto con el simbolo.
            $arrData[$i]['monto'] = SMONEY.formatoMoney($arrData[$i]['monto']);


            //Validacion para los botones respecto a los permisos 
            if($_SESSION['permisosMod']['r']){ //permiso para lectura
                
                //le colocamos un enlace concatenando el pedido y orden y enviamos como parametro el id de pedido
                $btnView .= '<a href="'.base_url().'/pedidos/orden/'.$arrData[$i]['idpedido'].'" target="_blanck" class="btn btn-primary btn-sm"> <i class="far fa-eye"></i> </a>
                
                <button class="btn btn-danger btn-sm" onClick="fntViewPDF('.$arrData[$i]['idpedido'].')" title="Generar PDF"><i class="fas fa-file-pdf"></i></button> ';

                //validacion para el boton de paypal en caso el pedido fue cancelado con paypal
                if($arrData[$i]['idtipopago'] == 1){
                    $btnView .= '<button class="btn btn-warning btn-sm" onClick="fntViewInfo('.$arrData[$i]['idpedido'].')" title="Ver Transacción"><i class="fa fa-paypal" aria-hidden="true"></i></button> ';
                }else{
                    $btnView .= '<button  class="btn btn-secondary btn-sm" disabled=""><i class="fa fa-paypal" aria-hidden="true"></i></button> ';

                }

            }

            if($_SESSION['permisosMod']['u']){ //permiso de actualizar
                
                $btnEdit = '<button class="btn btn-info btn-sm" onClick="fntEditInfo('.$arrData[$i]['idpedido'].')" title="Editar Pedido"><i class="fas fa-pencil-alt"></i></button>';
            }
            if($_SESSION['permisosMod']['d']){ //permisos para eliminar
                $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idpedido'].')" title="Eliminar Pedido"><i class="fas fa-trash-alt"></i></button>';
            }
        
            //Botones, agregamos el onclick con su funcion para que al momento de cambiar de paginacion no presente incovenientes, CONCATENAMOS LAS VARIABLES DE LOS BOTONES
            $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
        }
        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();
      }
  }


?>