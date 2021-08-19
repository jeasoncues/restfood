<?php 
 
 require_once("Models/TraitMesas.php");
 
	class Cajas extends Controllers{
		use TraitMesas;
		public function __construct()
		{   

			parent::__construct();


			session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
		}
        
     
		public function cajas()
		{    
		
		
			$data['page_tag'] = "Caja";
			$data['page_title'] = "Caja";
			$data['page_name'] = "cajas";
			$data['mesas'] = $this->getMesasRestaurante();
			$this->views->getView($this,"cajas",$data);
		}

		public function pos(){

			if(empty($_SESSION['arrCaja'])){
				header("Location:".base_url());
				die();
			}
			$data['page_tag'] = "Rest-Food | POS";
			$data['page_title'] = "POS Rest-Food";
			$data['page_name'] = "procesarpago";
			$data['tiposPago'] = $this->getTiposPagoTienda();
			$this->views->getView($this,"procesarpago",$data);
		}

		public function setCaja(){
			if($_POST){
				if(empty($_POST['txtFecha']) || empty($_POST['listTurno']) || empty($_POST['txtcajachica']) || empty($_POST['listEstado']) || empty($_POST['listCajero'])){
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					$intIdArqueoInicial = intval($_POST['idArqueo']);
					$strFecha = strClean($_POST['txtFecha']);
					$intTurno = intval($_POST['listTurno']);
					$strCajaChica = intval($_POST['txtcajachica']);
					$strCajaCierre =  intval($_POST['txtcajacierre']);
					$intEstado = intval($_POST['listEstado']);
					$intCajero = strClean($_POST['listCajero']);
   
					if($intIdArqueoInicial == 0){
						$request_arqueoinicial = $this->model->insertarArqueoInicial($strFecha,$intTurno,$strCajaChica,$strCajaCierre,$intEstado,$intCajero);
   
					}
   
					if($request_arqueoinicial > 0){
						$arrResponse = array('status'=> true, 'msg' => 'Datos guardados correctamente');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'No es posible almacenar datos');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			   
			}
			die();
		}
		

		
	}
 ?>