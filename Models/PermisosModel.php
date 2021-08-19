<?php 

	class PermisosModel extends Mysql
	{
        public $intIdpermiso;
        public $intRolid;
        public $intModuloid;
        public $r;//leer
        public $w;//escribir
        public $u;//actualizar
        public $d;//eliminar

		public function __construct()
		{   
			//Cargar el metodo constructor de la clase padre
			parent::__construct();
        }

        public function selectModulos()
        {
            $sql = "SELECT * FROM modulo  WHERE status != 0";
            $request = $this->MostrarRegistros($sql);
            return $request;
        }
        
        public function selectPermisosRol($intidrol)
        {
            $this->intRolid = $intidrol;
            $sql = "SELECT * FROM permisos WHERE rolid = $this->intRolid";
            $request = $this->MostrarRegistros($sql);
            return $request;
        }

        public function deletePermisos($intidrol)
        {
            $this->intRolid = $intidrol;
            $sql = "DELETE FROM permisos WHERE rolid = $this->intRolid";
            $request = $this->Eliminar($sql);
            return $request;
        }

        public function insertPermisos($intidrol, $intidmodulo, $intr, $intw, $intu, $intd){
            $return = "";
            $this->intRolid = $intidrol;
            $this->intModuloid = $intidmodulo;
            $this->r = $intr;
            $this->w = $intw;
            $this->u = $intu;
            $this->d = $intd;
            $query_insert  = "INSERT INTO permisos(rolid,moduloid,r,w,u,d) VALUES(?,?,?,?,?,?)";
        	$arrData = array($this->intRolid, $this->intModuloid, $this->r, $this->w, $this->u, $this->d);
        	$request_insert = $this->insertar($query_insert,$arrData);		
	        return $request_insert;
        }


        public function permisosModulo($intidrol)
        {
            $this->intRolid = $intidrol;
            $sql = "SELECT p.rolid,
						   p.moduloid,
						   m.titulo as modulo,
						   p.r,
						   p.w,
						   p.u,
						   p.d 
					FROM permisos p 
					INNER JOIN modulo m
					ON p.moduloid = m.idmodulo
					WHERE p.rolid = $this->intRolid";
			$request = $this->MostrarRegistros($sql);
			$arrPermisos = array();
			for ($i=0; $i < count($request); $i++) { 
				$arrPermisos[$request[$i]['moduloid']] = $request[$i];
			}
			return $arrPermisos;
    
        }
	}
 ?>