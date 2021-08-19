<?php 

	class LoginModel extends Mysql
	{   
        private $intIdUsuario;
        private $strUsuario;
        private $strPassword;
        private $strToken;

		public function __construct()
		{   
			//Cargar el metodo constructor de la clase padre
			parent::__construct();
        }

        public function loginUser($stringusuario, $stringpassword){
            $this->strUsuario = $stringusuario;
            $this->strPassword = $stringpassword;
            //status != 0 quiere decir que el usuario no este eliminado
            $sql = "SELECT idpersona, status FROM persona WHERE email_user = '$this->strUsuario' and password = '$this->strPassword' and status != 0";
            $request = $this->Buscar($sql);
            return $request; 

        }

        public function sessionLogin($intiduser){
            $this->intIdUsuario =  $intiduser;

            //Buscar Rol
            $sql = "SELECT p.idpersona,
                           p.identificacion,
                           p.nombres,
                           p.apellidos,
                           p.telefono,
                           p.email_user,
                           p.nit,
                           p.nombrefiscal,
                           p.direccionfiscal,
                           r.idrol,r.nombrerol,
                           p.status
                    FROM persona p
                    INNER JOIN rol r 
                    ON p.rolid = r.idrol
                    WHERE p.idpersona = $this->intIdUsuario";
            $request = $this->Buscar($sql);
            return $request;                  
        }	

        public function getUserEmail($stringemail){
            
            //Para saber si el usuario existe lo buscamos en la bd
            $this->strUsuario = $stringemail;
            $sql = "SELECT idpersona,nombres,apellidos,status FROM persona WHERE email_user = '$this->strUsuario' and status = 1 "; //verifica si el usuario esta activo con status para recuperar contraseña (1)
            $request = $this->Buscar($sql); //variable request para retorna el metodo buscar de la instruccion
            return $request;
        }

        public function setTokenUser($intidpersona, $stringtoken)
        {
            $this->intIdUsuario = $intidpersona;
            $this->strToken = $stringtoken;
            
            $sql = "UPDATE persona SET token = ? WHERE idpersona = $this->intIdUsuario ";
            $arrData =  array($this->strToken);
            $request =  $this->Actualizar($sql, $arrData);
            return $request;
        }

        public function getUsuario($stringemail, $stringtoken)
        {
            $this->strUsuario = $stringemail;
            $this->strToken = $stringtoken;
            $sql = "SELECT idpersona FROM persona WHERE email_user = '$this->strUsuario' and token = '$this->strToken' and status = 1 ";
            $request = $this->Buscar($sql);
            return $request;
        }

        public function insertPassword($intidpersona, $stringpassword)
        {
            $this->intIdUsuario = $intidpersona;
            $this->strPassword = $stringpassword;
            $sql = "UPDATE persona SET password = ?, token = ? WHERE idpersona = $this->intIdUsuario";
            //armamos el array de datos primero la posicion password y despues el token pero en vacio => ""
            $arrData = array($this->strPassword,"");
            $request = $this->Actualizar($sql,$arrData);
            return $request;

        }

	}
 ?>

 