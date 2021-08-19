<?php 

	class Gastos extends Controllers{
		public function __construct()
		{   
            parent::__construct();
            
			session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
		}
        

		public function gastos()
		{   
			
			$data['page_tag'] = "Gastos";
			$data['page_title'] = "Gastos";
			$data['page_name'] = "gastos";
			$this->views->getView($this,"gastos",$data);
        }
		
		
		public function getGastos() 
		{
			$arrData = $this->model->selectGastos();

		    for ($i=0; $i < count($arrData); $i++){
				
				$arrData[$i]['options'] = '<div class="text-center">

				<button class="btn btn-info btn-sm  btnViewGasto" onClick="fntViewGasto('.$arrData[$i]['codigo'].')" title="Ver Gasto"><i class="far fa-eye"></i></button>

				<button class="btn btn-secondary btn-sm btnEditGasto" onClick="fntEditGasto('.$arrData[$i]['codigo'].')" title="Editar Gasto"><i class="fas fa-pencil-alt"></i></button>
	
				<button class="btn btn-danger btn-sm btnDelGasto" onClick="fntDelGasto('.$arrData[$i]['codigo'].')" title="Eliminar Gasto"><i class="fas fa-trash-alt"></i></button> </div>';

			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();

		}
		
		
		public function setGastos()
		{ 
			$intCodigo = intval($_POST['idGasto']);
			$strNombre = strClean($_POST['txtNombre']);
			$intPrecio = $_POST['txtPrecio'];
			$strFecha =  $_POST['txtFecha'];
			$intRolid = strClean($_POST['listRolid']);

			if($intCodigo == 0)
			{   
				//Insertamos Gasto
				$request_gasto = $this->model->insertarGasto($strNombre, $intPrecio, $strFecha, $intRolid);
				$option = 1;
			}else{
				//Actualizar en caso ya tenga el codigo de gasto
				$request_gasto = $this->model->updateGasto($intCodigo, $strNombre, $intPrecio, $strFecha, $intRolid);

				$option = 2;
			}

			if($request_gasto > 0)
			{
				if($option == 1){
					$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
				}else{ //en caso no sea 1 la opcion sera 2
					$arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');  
				}
			}else if($request_gasto == 'exist'){
				$arrResponse = array('status' => false, 'msg' => 'Atencion! El gasto ya existe');
			}else{ 
				$arrResponse = array("status" => false, "msg" => "No es posible almacenar datos, intente mas tarde");
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();

		}

		
	}
 ?> 