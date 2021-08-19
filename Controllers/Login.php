<?php 
	class Login extends Controllers{
		public function __construct()
		{   
			session_start(); //funcion para crear variables de sesion 
			if(isset($_SESSION['login'])) //isset => si existe esta variable de session redireccionamos a inicio
			{
				header('Location: '.base_url().'/dashboard');
			}
			//Invocando al constuctor del controlador que hereda con parent EJECUTANDO
			parent::__construct();
		}


        //Metodo
		public function login()
		{   
			//Utilizamos el metodo getView enviando como parametro el this y la vista que queremos mostrar "login"
            //Array de la data
			$data['page_tag'] = "Rest-Food - Iniciar sesión";
			$data['page_title'] = "Login";
			$data['page_name'] = "login";
			$data['page_title1'] = "Rest-Food";
 			$this->views->getView($this,"login",$data);
		}


		//METODO PARA INICIAR SESION
		public function loginUser(){
			if($_POST){//si alguien a hecho una peticion de metodo POST pasamos a validar
				//que los campos no esten vacios
				if(empty($_POST['txtEmail']) || empty($_POST['txtPassword'])){
					$arrResponse = array('status' => false, 'msg' => 'Error de datos');
				}else{ //si no esta vacio
					$strUsuario = strtolower(strClean($_POST['txtEmail'])); //strtolower convierte las letras en minuscula, strclean limpia
					$strPassword = hash('SHA256', $_POST['txtPassword']);//hash encriptacion
					$requestUser = $this->model->loginUser($strUsuario,$strPassword);//modelogin metodo loginuser 

					if(empty($requestUser)){ //si la variable requestuser esta vacia
						$arrResponse = array('status' => false, 'msg' => 'El usuario o la contraseña es incorrecta');
					}else{//de lo contrario quiere decir que si encontro el usuario
						$arrData = $requestUser; //le colocamos el array de datos idpersona, status
						if ($arrData['status'] = 1){ //si el status es 1
							 
							//variables de sesion que va a ser igual al idpersona quiere decir que toma su id
							$_SESSION['idUser'] = $arrData['idpersona'];
							$_SESSION['login'] = true;//variable sesion login que es true

							$arrData = $this->model->sessionLogin($_SESSION['idUser']);//Metodo del modelo que enviamos como parametro el idusuario 
							$_SESSION['userData'] = $arrData;//Obtenemos todos los datos del usuario

							$arrResponse = array('status' => true, 'msg' => 'ok');

						}else{  //de lo contrario quiere decir que el usuario esta inactivo
							$arrResponse = array('status' => false, 'msg' => 'Usuario Inactivo');

						}
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				 
			}
			die();
		}
		


		public function resetPass(){
			if($_POST){//si hay una peticion POST

				if(empty($_POST['txtEmailReset'])){
					$arrResponse = array('status' => false, 'msg' => 'Error de datos');
				}else{
					$token=token(); //funcion token en helpers numeros aleatorios
					$strEmail = strtolower(strclean($_POST['txtEmailReset'])); //strtolower convierte a minuscula
					$arrData = $this->model->getUserEmail($strEmail);

					if(empty($arrData)){ //si el array esta vacia
						$arrResponse = array('status' => false, 'msg' => 'Usuario no existente');
					}else{ //si encotro el usuario
                      
						$idpersona = $arrData['idpersona'];
						$nombreUsuario = $arrData['nombres'].' '.$arrData['apellidos'];

						$url_recovery = base_url().'/login/confirmUser/'.$strEmail.'/'.$token; //Url para recuperar contraseña
						$requestUpdate = $this->model->setTokenUser($idpersona,$token); //actualizar el token desde el metodo settoken y enviamos parametros idpersona y el token
						
						//Data usuario para el array donde muestra el nombre, email, asunto, y la url para recuperar cuenta
						$dataUsuario = array('nombreUsuario' => $nombreUsuario,
											 'email' => $strEmail,
											 'asunto' => 'Recuperar Cuenta - '.NOMBRE_REMITENTE,
											 'url_recovery' => $url_recovery);
					  
					
						
						//VALIDACION DEL TOKEN
						if($requestUpdate ){
							//funcion sendemail que esta en helpers que enviamos la data del usuario y indicamos cual es la plantilla que sera emailcambiopassword
							$sendEmail = sendEmail($dataUsuario, 'email_cambioPassword');

							if($sendEmail)//si se envio el correo
							{
								$arrResponse = array('status' => true, 'msg' => 'Se ha enviado un email a tu cuenta de correo para cambiar la contraseña.');
							}else{
								$arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intenta mas tarde.');
							}
						}else{ 
							$arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intenta mas tarde.');
						
						}

					}

				}
				echo  json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			}
			die();
		}



		public function confirmUser($stringparams)
		{   
			if(empty($stringparams)){//si el parametro esta vacio 
				header('Location: '.base_url());//redireccionamos a la ruta principal 

			}else{
				$arrParams = explode(',',$stringparams);//traemos los parametros que enviamos con explode convertimos la cadena y separamos por la ","
				$strEmail = strClean($arrParams[0]); //le colocamos al array la varaiable en la posicion 0
				$strToken = strClean($arrParams[1]);
				
				
				//Consulta a la BD
				$arrResponse = $this->model->getUsuario($strEmail, $strToken);
				if(empty($arrResponse)){//no encontro el registro
					header("Location: ".base_url());
				}else{

					$data['page_tag'] = "Donattos Restaurante";
					$data['page_title'] = "Login";
					$data['page_name'] = "cambiar_contrasenia";
					$data['page_title1'] = "Donattos";
					$data['email'] = $strEmail;
					$data['token'] = $strToken;
					$data['idpersona'] = $arrResponse['idpersona'];//arrresponse el id de la persona los datos.
					$this->views->getView($this,"cambiar_password",$data);

				}

			}
			die();
		}


		
		//Actualizar contraseña
		public function setPassword()
		{   
			//Validar que no vengan vacios los campos
			if(empty($_POST['idUsuario']) || empty($_POST['txtEmail']) || empty($_POST['txtToken']) || empty($_POST['txtPassword']) || empty($_POST['txtPasswordConfirm'])){
				$arrResponse = array('status' => false, 'msg' => 'Error de datos' );
			}else{ //si no vienen vacios los campos los guardamos en las variables
				$intIdpersona = intval($_POST['idUsuario']);
				$strPassword = $_POST['txtPassword'];
				$strPasswordConfirm = $_POST['txtPasswordConfirm'];
				$strEmail = strClean($_POST['txtEmail']);
				$strToken = strClean($_POST['txtToken']);
				
				//validacion para que las contraseñas sean iguales
				if($strPassword != $strPasswordConfirm){
					$arrResponse = array('status' => false, 'msg' => 'Las contraseñas no son iguales.');
				}else{
					//Consulta para verificar que el token y el email sean los correctos.
					$arrResponseUser = $this->model->getUsuario($strEmail, $strToken);
					if(empty($arrResponseUser)){//no encontro el registro
						$arrResponse = array('status' => false, 'msg' => 'Error de datos.' );
					}else{
                        //Encriptamos la contraseña con sha
						$strPassword = hash("SHA256", $strPassword);
						//ya teniendo encriptada la contraseña le enviamos el password al idpersona
						$requestPass = $this->model->insertPassword($intIdpersona,$strPassword);

						//validacion por si se creo la variable pass
						if($requestPass){
							$arrResponse = array('status' => true, 'msg' => 'Contraseña actualizada con exito.');
						}else{ 
							//en caso de problemas con la BD
							$arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intenta mas tarde.');
						}
					}
				}
			
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();

		}
	}
 ?>