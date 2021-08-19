<?php
 
  class Mesas extends Controllers{

     public function __construct(){
         parent::__construct();
         session_start();
         if(empty($_SESSION['login'])){
             header('Location: '.base_url().'/login');
         }
     }

     public function mesas(){
         $data['page_tag'] = "Mesas";
         $data['page_title'] = "Mesas";
         $data['page_name'] = "mesas";
         $this->views->getView($this, "mesas", $data);
     }
     
     //Listar Mesas
     public function getMesas(){
         $btnDelete = '';
         $arrData = $this->model->selectMesas();

         for ($i=0; $i < count($arrData); $i++){

            if($arrData[$i]['estado']==1)
				{
					$arrData[$i]['estado'] = '<span class="badge badge-success">Libre</span>';
			}else {
					$arrData[$i]['estado'] = '<span class="badge badge-danger">Ocupada</span>';
		    }

        
             if($_SESSION['permisosMod']['d']){ //permisos para eliminar
                $btnDelete = '<button class="btn btn-danger btn-sm btnDelMesa" onClick="fntDelMesa('.$arrData[$i]['idmesa'].')" title="Eliminar Mesa"><i class="fas fa-trash-alt"></i></button>';
            }

            $arrData[$i]['options'] = '<div class="text-center">'.$btnDelete.'</div>';
         }
         echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
         die();
     }
     

     //Enviar mesas a la bd
     public function setMesas(){

        if($_POST){
            if(empty($_POST['txtnombre'])){
                $arrResponse = array("status" => false, "msg" => "Datos incorrectos.");
            }else{
                $intIdMesa = intval($_POST['idMesa']);
                $strMesa = strClean($_POST['txtnombre']);
                $intEstado =  intval($_POST['listStatus']);

                //almacenar imagenes
                $foto         = $_FILES['foto'];
                $nombre_foto  = $foto['name'];
                $type         = $foto['type'];
                $url_temporal = $foto['tmp_name'];
                $imgPortada = 'mesa2.png';

                if($nombre_foto != ''){
                    $imgPortada = 'img_'.md5(date('d-m-Y H:m:s')).'.jpg';
                }

                if($intIdMesa == 0){
                    //Crear Mesa
                    $request_mesa = $this->model->insertarMesa($strMesa,$imgPortada,$intEstado);
                    $option = 1;
                }else {
                    //Actualizar Mesa
                    $request_mesa = $this->model->updateMesa($intIdMesa, $strMesa, $imgPortada, $intEstado);
                    $option = 2;
                }

                if($request_mesa > 0){
                    if($option == 1){
                       $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
                       if($nombre_foto != ''){
                           uploadImage($foto,$imgPortada);
                       }
                    }else {
                        $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
                    }
                }else if($request_mesa == 'exist'){
                    $arrResponse = array('status' => false, 'msg' => 'Atencion! La mesa ya existe');
                }else{
                    $arrResponse = array("status" => false, "msg" => "No es posible almacenar datos");
                }
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
     }
     
  }
?>