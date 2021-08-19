<?php 

	class RolesModel extends Mysql
	{
        //Atributos del rol
        public $intIdrol;
        public $strRol;
        public $strDescripcion;
        public $intStatus;

		public function __construct()
		{   
			//Cargar el metodo constructor de la clase padre
			parent::__construct();
        }
        
        //Metodo selectRoles()
        public function selectRoles()
        {
            //Extraer los roles de la BD
            $sql = "SELECT * FROM rol WHERE status != 0";
            $request = $this->MostrarRegistros($sql);
            return $request;
        }

        //Metodo para obtener 1 rol
        public function selectRol($intidrol){
            //Buscar rol
            $this->intIdrol = $intidrol;
            $sql = "SELECT * FROM rol WHERE idrol = $this->intIdrol"; //donde el idrol sea igual al parametro
            $request = $this->Buscar($sql); //obtenemos el resultado que enviamos como parametro sql
            return $request; //retorna la respuesta
        }

        //Metodo para enviar datos que va a recibir parametros
        public function insertarRol($stringrol, $stringdescripcion, $intstatus)
        {
            $return = "";
            $this->strRol = $stringrol;
            $this->strDescripcion = $stringdescripcion;
            $this->intStatus = $intstatus;

            //Consulta para saber si ya existe esa tabla
            $sql = "SELECT * FROM rol WHERE nombrerol = '{$this->strRol}'";
            $request = $this->MostrarRegistros($sql); //Obtenemos todos los registros y ejecuta lo quese envia en la variable sql
            
            if(empty($request))  //Si el request es vacio quiere decir que no encontro ningun recibo
            {   
                //Ejecutamos esta sentencia
                $query_insert = "INSERT INTO rol(nombrerol,descripcion,status) VALUES (?,?,?)";
                $arrData = array($this->strRol, $this->strDescripcion, $this->intStatus); //Armamos el array de los datos , como primer item el rol
                $request_insert = $this->insertar($query_insert,$arrData); //Metodo insertar de MYSQL
                $return = $request_insert;//Retorna el id
            }else{
                $return = "exits"; //Si existe el rol retorna esto
            }

            return $return;
        }


        public function updateRol($intidrol, $stringrol, $stringdescripcion, $intstatus){
            $this->intIdRol = $intidrol;
            $this->strRol = $stringrol;
            $this->strDescripcion = $stringdescripcion;
            $this->intStatus = $intstatus;

            $sql = "SELECT * FROM rol WHERE nombrerol = '$this->strRol' AND idrol != $this->intIdRol"; //donde el nombre sea igual al nombre que enviamos y el id sea diferente el id que estamos enviando
            $request = $this->MostrarRegistros($sql); //request almacenado la respuesa de mostrrar registros

            if(empty($request)) //si esta vacio no se cumple lo de arriba entonces lo que hace es acctualizar
            {
                $sql = "UPDATE rol SET nombrerol = ?, descripcion = ?, status = ? WHERE idrol = $this->intIdRol ";
                $arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
                $request = $this->Actualizar($sql,$arrData);

            }else{
                $request = "exist";
            }

            return $request;
        }

        public function deleteRol($intidrol){
			$this->intIdrol = $intidrol;
			$sql = "SELECT * FROM persona WHERE rolid = $this->intIdrol";
			$request = $this->MostrarRegistros($sql);
			if(empty($request)){
				$sql = "UPDATE rol SET status = ? WHERE idrol = $this->intIdrol";
				$arrData = array(0);
				$request = $this->Actualizar($sql,$arrData);
				if($request){
					$request = 'ok';
				} else{
					$request = 'error';
				} 
			} else {
				$request = 'exist';
			}
			return $request;
		}


	 
	}
 ?>