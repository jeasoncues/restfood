<?php 

	class Usuarios extends Controllers{
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

			getPermisos(2); //funcion en el helpers
		}
        
        //Metodo
		public function Usuarios()
		{   
            //Validacion en caso no tenga permisos para entrar al modulo usuarios.
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			//Utilizamos el metodo getView enviando como parametro el this y la vista que queremos mostrar "home"
			//Array de la data
			$data['page_tag'] = "Usuarios";
			$data['page_title'] = "Usuarios";
			$data['page_name'] = "usuarios";
			$this->views->getView($this,"usuarios",$data);
		}

		//Metodo setUsuarios
		public function setUsuarios(){
			//Validacion si hay una peticion POST
			if ($_POST){
			    //Validamos con el operador or || para prevenir que alguien no envie datos 
				if(empty($_POST['txtIdentificacion'])|| empty($_POST['txtNombres']) || empty($_POST['txtApellidos']) ||
				 empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listRolid']) || empty($_POST['listStatus']))
				  {
					  $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');//Retornamos array en caso de que realicen peticion sin enviar datos
				}else{//En caso si envien datos creamos variables para almacenar los datos
					 
				    $idUsuario = intval($_POST['idUsuario']);
					$strIdentificacion = intval($_POST['txtIdentificacion']);//intval convertimos a entero
					$strNombre = ucwords(strClean($_POST['txtNombres'])); 
					$strApellido = ucwords(strClean($_POST['txtApellidos']));
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strEmail = strtolower(strClean($_POST['txtEmail'])); //Convierte todas las letras en miniscula strtolower
					$intRolid =  intval(strClean($_POST['listRolid']));
					$intStatus =  intval(strClean($_POST['listStatus']));


					//Validacion para el id para saber si se envia o no el usuario
					if($idUsuario == 0)//cuando no envia quiere decir que estamos creando nuevo usuario
					{   
						$option = 1;
						//Validacion para la contraseña
					    //validamos con empty si password esta vacio generamos  con nuestra funcion passGenerador que esta en la carpeta helpers generamos una contraseña de 10 caractereses , con hash encriptamos la contraseña 
					    // ":" => de lo contrario el campo no viene vacio igual increntamos y enviamos con POST 
						$strPassword = empty($_POST['txtPassword']) ? hash("SHA256", passGenerador()): 
					    hash("SHA256", $_POST['txtPassword']);
					    //enviamos en el metodo insertUsuario de la carpeta modelo enviamos todos esos parametros
					    $request_user = $this->model->insertUsuario($strIdentificacion,
																$strNombre,
																$strApellido,
																$intTelefono,
																$strEmail,
																$strPassword,
																$intRolid,
																$intStatus);

					}else{//si  se envia el id pasamos a actualizar datos
						$option = 2;
						$strPassword = empty($_POST['txtPassword']) ?  "" : hash("SHA256", $_POST['txtPassword']); //enviamos el password encriptado
					    //enviamos en el metodo insertUsuario de la carpeta modelo enviamos todos esos parametros
					    $request_user = $this->model->updateUsuario($idUsuario, $strIdentificacion,
																$strNombre,
																$strApellido,
																$intTelefono,
																$strEmail,
																$strPassword,
																$intRolid,
																$intStatus);

					}

					
					if($request_user > 0) //si la variable es mayor a 0 quiere decir que si se ingreso el registro
					{   
						if($option == 1){//quiere decir que se hizo un insert
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
						}else{//quiere decir que option es 2 se hizo una actualizacion
							$arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
						}

					}else if($request_user == 'exist'){ //si el usuario ya existe{
						$arrResponse = array('status' => false, 'msg' => '!Atencion! el email o la identificacion ya existe, ingrese otro');
					}else{
						$arrResponse = array ('status' => false, 'msg' => 'No es posible almacenar datos');
					}		 									
				}

				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

			}
			die();
		}

		/*
		public function CountUsuarios(){
			$arrData = $this->model->ContarUsuarios();

			die();

		}*/

		public function getUsuarios()
		{
			$arrData = $this->model->selectUsuarios();//invocamos al metodo del modeloUsuarios
			
			//Recorre hasta que termine la cantidad de elemtnos del array, y incrementa
			for ($i=0; $i < count($arrData); $i++){

				//Variables para los botones
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';

				if($arrData[$i]['status']==1)
				{
					$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
				}else {
					$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
				}

				//Validacion para los botones respecto a los permisos 
				if($_SESSION['permisosMod']['r']){
					$btnView = '<button class="btn btn-info btn-sm btnViewUsuario" onClick="fntViewUsuario('.$arrData[$i]['idpersona'].')" title="Ver usuario"><i class="far fa-eye"></i></button>';

				}

				if($_SESSION['permisosMod']['u']){
					
					$btnEdit = '<button class="btn btn-secondary btn-sm btnEditUsuario" onClick="fntEditUsuario('.$arrData[$i]['idpersona'].')" title="Editar usuario"><i class="fas fa-pencil-alt"></i></button>';
				}

				if($_SESSION['permisosMod']['d']){
					$btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario('.$arrData[$i]['idpersona'].')" title="Eliminar usuario"><i class="fas fa-trash-alt"></i></button>';
				}
			
				//Botones, agregamos el onclick con su funcion para que al momento de cambiar de paginacion no presente incovenientes, CONCATENAMOS LAS VARIABLES DE LOS BOTONES
				$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}
        //Metodo para extraer usuario
		public function getUsuario($intidpersona)
		{
			$idusuario = intval($intidpersona);
			if($idusuario > 0) //si es mayor a 0 quiere decir que si es un id valido
			{
				$arrData = $this->model->selectUsuario($idusuario);//modelo del usuario
				
				if(empty($arrData)) //empty quiere decir si esta vacio 
				{
				   $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
					$arrResponse = array('status' => true, 'data' => $arrData); //item data obtiene el arreglo
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();

		}

		public function delUsuario()
		{
			if($_POST){
				$intIdpersona = intval($_POST['idUsuario']); //enviamos por el metodo post lo que corresponde al idpersona
				$requestDelete = $this->model->deleteUsuario($intIdpersona);//devuelve el metoo delete del modelo
				if($requestDelete){//si el resultado es igual a verdadero muestra la alerta de abajo en array
					$arrResponse = array('status' =>true , 'msg' => 'Se ha eliminado correctamente');
				}else{
					$arrResponse = array('status' =>false, 'msg' => 'Error al eliminar el usuario.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function perfil(){

			$data['page_tag'] = "Perfil";
			$data['page_title'] = "Perfil de Usuario";
			$data['page_name'] = "perfil";
			$this->views->getView($this,"perfil",$data);

		}

		
	}
 ?>