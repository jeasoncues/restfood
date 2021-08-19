<?php 

	class Roles extends Controllers{
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
        
        //Metodo
		public function Roles()
		{   
			//Validacion en caso no tenga permisos para entrar al modulo usuarios.
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}

			//Utilizamos el metodo getView enviando como parametro el this y la vista que queremos mostrar "home"
            //Array de la data
			$data['page_id'] = 3;
			$data['page_tag'] = "Roles Usuario";
			$data['page_name'] = "rol_usuario";
			$data['page_title'] = "Roles Usuario";
			$this->views->getView($this,"roles",$data);
		}

		//Metodo para traer el listado de roles desde la base de datos
		public function getRoles()
		{   
			$btnView = '';
		    $btnEdit = '';
			$btnDelete = '';
			//con la variable hacemos llamado al modelo del metodo selectRoles
			$arrData = $this->model->selectRoles();
			
			//Recorre hasta que termine la cantidad de elemtnos del array, y incrementa
			for ($i=0; $i < count($arrData); $i++){

				if($arrData[$i]['status']==1)
				{
					$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
				}else {
					$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
				}

				//Validacion para los botones respecto a los permisos 
			
				if($_SESSION['permisosMod']['u']){

					$btnView = '<button class="btn btn-secondary btn-sm btnPermisosRol" onClick="fntPermisos('.$arrData[$i]['idrol'].')" title="Permisos"><i class="fas fa-key"></i></button>';

     
					$btnEdit = '<button class="btn btn-primary btn-sm btnEditRol" onClick="fntEditRol('.$arrData[$i]['idrol'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
				}

				if($_SESSION['permisosMod']['d']){
					$btnDelete = '<button class="btn btn-danger btn-sm btnDelRol" onClick="fntDelRol('.$arrData[$i]['idrol'].')" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
					</div>';
				}
			
				//Botones, agregamos el onclick con su funcion para que al momento de cambiar de paginacion no presente incovenientes, CONCATENAMOS LAS VARIABLES DE LOS BOTONES
				$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
			
			
			}
			//Imprimir con formato JSON para que sea consumido desde cualquier lenguaje de programacion
			//Imprimimos con la funcion json_encode de PHP
			//Enviamos como parametro el array
			//El siguiente parametro lo convertimos a un objeto en caso de caracteres especiales o tildes
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			//Finaliza el proceso 
			die();

		}

		//Metodo getSelectRoles
		public function getSelectRoles()
		{
			$htmlOptions = ""; 
			$arrData = $this->model->selectRoles(); //metodo selectroles del modelo
			if(count($arrData) > 0){ //si la cantidad de registros de la variable es mayor a 0
				for($i =0; $i < count($arrData); $i++){ //recorremos el array, inicia en posicion 0 , la variable i es menor a la cantidad de registros
					$htmlOptions .= '<option value ="'.$arrData[$i]['idrol'].'">'.$arrData[$i]['nombrerol'].'</option>';//trae el valor del array en la posicion i
				}
			}
			echo $htmlOptions;
			die();
		}

		
		//Metodo para traer 1 rol
		public function getRol($intidrol){ //Recibe un parametro entero
			$intIdrol =  intval(strClean($intidrol)); //intval lo convertimos a entero, strclean limpia la variable en caso de una inyeccion sql
			if($intIdrol > 0) //validamos si la variable es mayor a 0 quiere decir que el id es valida
			{
				$arrData = $this->model->selectRol($intIdrol);//metodo del modelo rol
				//validar la respuesta 
				if(empty($arrData))//si esta vacia quiere decir que no existe el rol
				{
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');

				}else{//de lo contrario si existe el registro , en data devuelve el metodo
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				//Imprimimos en formato JSON enviando como parametro el array
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}  
			die(); //Finaliza el proceso
		}

		//Metodo para enviar datos crear el rol
		public function setRol(){
			
			//Creamos variables para almacenar los datos
			//Funcion strClean limpia toda la cadena para dejar la data pura para que no hagan inyeccion SQL
			//Funcion intval  para obtener un entero
            $intIdrol = intval($_POST['idRol']);
			$strRol = strClean($_POST['txtnombre']);
			$strDescripcion = strClean($_POST['txtdescripcion']);
			$intStatus = intval($_POST['listStatus']);

			if($intIdrol == 0) //si no vienen ningun id vamos a insertar rol
			{
				//crear
				$request_rol = $this->model->insertarRol($strRol, $strDescripcion, $intStatus);
				$option = 1; //variable option igual a 1 
			}else { //si lo contrario el id no es 0 queire decir que si trae el id 
				//Actualizar
				$request_rol = $this->model->updateRol($intIdrol, $strRol, $strDescripcion, $intStatus); //ennviamos id , y todo lo demas
				$option = 2;
			}

			if($request_rol > 0) //Si la respuesta es mayor a 0 si se inserto el registro devuelve el mensaje de abajo
			{   
				if($option == 1){
					$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
				}else { //option dos para actualizar 
					$arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
				}

			}else if($request_rol == 'exits'){ //Si el elemento existe muestra el mensaje de abajo

				$arrResponse = array('status' => false, 'msg' => 'Atencion! El Rol ya existe.');

			}else{ //De lo contrario si no devuelve los valores no se inserto
				$arrResponse = array("status" =>false, "msg" => "No es posible almacenar los datos");

			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE); //Imprimimos con formato JSON, enviando caaracteres especiales
			die(); //Finaliza el proceso del metodo

		}
		
		//Metodo para eliminar
	
		public function delRol(){
			if($_POST){
				$intIdrol = intval($_POST['idrol']);
				$requestDelete = $this->model->deleteRol($intIdrol);
				if($requestDelete == 'ok'){
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el rol');
				}else if($requestDelete == 'exist'){
					$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un Rol asociado a usuarios.');
				}else {
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Rol');
				} 
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			} 
			die();
		}

		
	}
 ?>