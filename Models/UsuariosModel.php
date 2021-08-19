<?php 

	class UsuariosModel extends Mysql
	{   
		private $intIdUsuario;
		private $strIdentificacion;
		private $strNombre;
		private $strApellido;
		private $intTelefono;
		private $strEmail;
		private $strPassword;
		private $strToken;
		private $intTipoId;
		private $intStatus;

		public function __construct(){
			 parent::__construct();
		}
		
		/*
        public function ContarUsuarios(){

			$sql = "SELECT COUNT(*) from persona";
			$request = $this->MostrarRegistros($sql);
			return $request;
		}*/



		public function insertUsuario($stringidentificacion, $stringnombre, $stringapellido, $inttelefono, $stringemail, $stringpassword, $inttipoid, $intstatus){

			$this->strIdentificacion = $stringidentificacion;
			$this->strNombre = $stringnombre;
			$this->strApellido = $stringapellido;
			$this->intTelefono = $inttelefono;
			$this->strEmail = $stringemail;
			$this->strPassword = $stringpassword;
			$this->intTipoId = $inttipoid;
			$this->intStatus = $intstatus;
			$return = 0;

			$sql = "SELECT * FROM persona WHERE 
						email_user = '{$this->strEmail}' or identificacion = '{$this->strIdentificacion}'";
			$request = $this->MostrarRegistros($sql);

			if(empty($request)){
				$query_insert = "INSERT INTO persona(identificacion,nombres,apellidos,telefono,email_user,password,rolid,status) VALUES (?,?,?,?,?,?,?,?)";
				$arrData = array($this->strIdentificacion,
								$this->strNombre,
								$this->strApellido,
								$this->intTelefono,
								$this->strEmail,
								$this->strPassword,
								$this->intTipoId,
								$this->intStatus);
				$request_insert = $this->insertar($query_insert,$arrData);
				$return = $request_insert;
			} else {
				$return = "exist";
			}
			return $return;
		}

	    //Extraer todos los usuarios de la BD
		public function selectUsuarios()
		{  
			$sql = "SELECT p.idpersona,p.identificacion,p.nombres,p.apellidos,p.telefono,p.email_user,p.status,r.nombrerol
					FROM persona p /*alias p a persona*/
					INNER JOIN rol r /*alias r al rol*/
					ON p.rolid = r.idrol
					WHERE p.status != 0 ";/*Extrae a usuarios que no estan eliminados y que sean diferentes de 0*/
					$request = $this->MostrarRegistros($sql);
					return $request;
		}
		
		
		public function selectUsuario($intidpersona)
		{ 
			$this->intIdUsuario = $intidpersona;
			$sql = "SELECT p.idpersona,p.identificacion,p.nombres,p.apellidos,p.telefono,p.email_user,p.nit,p.nombrefiscal,p.direccionfiscal,r.idrol,
					r.nombrerol, p.status, 
					DATE_FORMAT(p.datecreated, '%d-%m-%y') as FechaRegistro /*funcion date_format da formato a dia - mes - año y un alias fecharegistro*/
					FROM persona p
					INNER JOIN rol r
					ON p.rolid = r.idrol
					WHERE p.idpersona = $this->intIdUsuario";/*Extrae los datos que el idpersona sea igual a la propiedad intIdUsuario*/
			$request = $this->Buscar($sql);
			return $request;
		}

		public function updateUsuario($intidusuario, $stringidentificacion, $stringnombre, $stringapellido, $inttelefono, $stringemail, $stringpassword, $inttipoid, $intstatus)
		{
			$this->intIdUsuario =  $intidusuario;
			$this->strIdentificacion = $stringidentificacion;
			$this->strNombre = $stringnombre;
			$this->strApellido = $stringapellido;
			$this->intTelefono = $inttelefono;
			$this->strEmail = $stringemail;
			$this->strPassword = $stringpassword;
			$this->intTipoId = $inttipoid;
			$this->intStatus = $intstatus;

			//Validacion para saber si la identificacion o email ya existe
			$sql = "SELECT * FROM persona WHERE (email_user = '{$this->strEmail}' AND idpersona != $this->intIdUsuario) OR (identificacion = '{$this->strIdentificacion}' AND idpersona != $this->intIdUsuario)";

			$request = $this->MostrarRegistros($sql);

			if(empty($request)){
				//si se envia la contraseña tambien se actualiza
				if($this->strPassword != ""){
					$sql = "UPDATE persona SET identificacion=?, nombres=?, apellidos=?, telefono=?, email_user=?, password=?, rolid=?, status=?
					WHERE idpersona = $this->intIdUsuario";
					$arrData = array($this->strIdentificacion,
									$this->strNombre,
									$this->strApellido,
									$this->intTelefono,
									$this->strEmail,
									$this->strPassword,
									$this->intTipoId,
									$this->intStatus);
				}else{//si es vacia no se envia actualizacion de password
					$sql = "UPDATE persona SET identificacion=?, nombres=?, apellidos=?, telefono=?, email_user=?, rolid=?, status=?
					WHERE idpersona = $this->intIdUsuario";
					$arrData = array($this->strIdentificacion,
									$this->strNombre,
									$this->strApellido,
									$this->intTelefono,
									$this->strEmail,
									$this->intTipoId,
									$this->intStatus);
				}
				$request = $this->Actualizar($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;

		}

		public function deleteUsuario($intidpersona){

			$this->intIdUsuario = $intidpersona; //al atributo idusuario enviamos el valor del parametro idpersona
			$sql =  "UPDATE persona SET status = ? WHERE idpersona = $this->intIdUsuario ";//actualizamos y seteamos el status donde el idpersona sea igual al id que enviamos
			$arrData = array(0);//un elemento que corresponde a 0 que insertamos en status
			$request = $this->Actualizar($sql,$arrData);
			return $request;

		}
	
	}
 ?>