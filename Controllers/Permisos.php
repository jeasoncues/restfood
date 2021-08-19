<?php 

	class Permisos extends Controllers{
		public function __construct()
		{   
			//Invocando al constuctor del controlador que hereda con parent EJECUTANDO
			parent::__construct();

			//Restringuir acceso para usuarios que no estan logeados
			//Validacion para el login para que al momento de escribir en la url no se pueda acceder a inicio sin estar logeado
			session_start();
			if(empty($_SESSION['login']))//si no existe la variable de sesion osea si el id no es true no accedera de lo contrario si existe continua todoe el proceso
			{
				header('Location: '.base_url().'/login');
			}
		}
        
        public function getPermisosRol($intidrol)
        {
			$rolid = intval($intidrol);
			if($rolid > 0)//si trae un id valido
			{
				$arrModulos = $this->model->selectModulos();
				$arrPermisosRol = $this->model->selectPermisosRol($rolid);//mandamos el parametro 
				$arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
				$arrPermisoRol = array('idrol' => $rolid );

				if(empty($arrPermisosRol))
				{
					for ($i=0; $i < count($arrModulos) ; $i++) { //la variable i va a llegar hasta la cantidad de elementos del arraymodulo

						$arrModulos[$i]['permisos'] = $arrPermisos;//operaciones de los permisos
					}
				}else{//si es que ya tenemos los permisos
					for ($i=0; $i < count($arrModulos); $i++) {
						 //Asignamos como valor del array en la posicion del ciclo for
                         //en caso no haga cambios de permisos 
						$arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
						//Validacion para saber si existe el modulo con permiso asignado
						if(isset($arrPermisosRol[$i])){
							$arrPermisos = array('r' => $arrPermisosRol[$i]['r'], 
												 'w' => $arrPermisosRol[$i]['w'], 
												 'u' => $arrPermisosRol[$i]['u'], 
												 'd' => $arrPermisosRol[$i]['d'] 
												);
						}
						$arrModulos[$i]['permisos'] = $arrPermisos;
					}
				}
				$arrPermisoRol['modulos'] = $arrModulos;//a la posicion modulos le asignamos el array modulos
				$html = getModal("modalPermisos",$arrPermisoRol);//Metodo getModal de la carpeta helpers  donde enviamos el modal para visualizar
			

			}
			die();

        }


        public function setPermisos()
        {
			if($_POST)
			{
				$intIdrol = intval($_POST['idrol']);
				$modulos = $_POST['modulos'];

				$this->model->deletePermisos($intIdrol);
				foreach ($modulos as $modulo) {
					$idModulo = $modulo['idmodulo'];
					$r = empty($modulo['r']) ? 0 : 1;
					$w = empty($modulo['w']) ? 0 : 1;
					$u = empty($modulo['u']) ? 0 : 1;
					$d = empty($modulo['d']) ? 0 : 1;
					$requestPermiso = $this->model->insertPermisos($intIdrol, $idModulo, $r, $w, $u, $d);
				}
				if($requestPermiso > 0)
				{
					$arrResponse = array('status' => true, 'msg' => 'Permisos asignados correctamente.');
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible asignar los permisos.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
        }
		
	}
 ?>