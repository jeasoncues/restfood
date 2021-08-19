<?php 

	class CategoriasModel extends Mysql
	{  
        public $intIdCategoria;
        public $strCategoria;
        public $strDescripcion;
        public $intStatus;
        public $strRuta;
        public $strPortada;

		public function __construct()
		{   
			//Cargar el metodo constructor de la clase padre
			parent::__construct();
        }

        public function insertarCategoria($stringnombre, $stringdescripcion, $stringportada, $stringruta, $intstatus)
        {
            $return = 0;
            $this->strCategoria = $stringnombre;
            $this->strDescripcion = $stringdescripcion;
            $this->strPortada = $stringportada;
            $this->strRuta = $stringruta;
            $this->intStatus = $intstatus;

            //Consulta para saber si ya existe esa tabla
            $sql = "SELECT * FROM categoria WHERE nombre = '{$this->strCategoria}'";
            $request = $this->MostrarRegistros($sql); //Obtenemos todos los registros y ejecuta lo quese envia en la variable sql
            
            if(empty($request))  //Si el request es vacio quiere decir que no encontro ningun recibo
            {   
                //Ejecutamos esta sentencia
                $query_insert = "INSERT INTO categoria(nombre,descripcion,portada,ruta,status) VALUES (?,?,?,?,?)";
                //Array de datos
                $arrData = array($this->strCategoria,
                                 $this->strDescripcion,
                                 $this->strPortada,
                                 $this->strRuta,
                                 $this->intStatus);
                                 
                $request_insert = $this->insertar($query_insert,$arrData); //Metodo insertar de MYSQL
                $return = $request_insert;//Retorna el id para el controlador
            }else{
                $return = "exist"; //Si existe la categoria retorna esto
            }

            return $return;
        }
        

        //Listar categorias
        public function selectCategorias(){

            $sql = "SELECT * FROM categoria WHERE status != 0"; //extrae categorias que no esten como eliminadas.
            $request = $this->MostrarRegistros($sql);
            return $request;
        }
        

        //Seleccionar una categoria
        public function selectCategoria($intidcategoria)
        {
            $this->intIdCategoria = $intidcategoria;
            $sql = "SELECT * FROM categoria
                    WHERE idcategoria = $this->intIdCategoria";
            $request = $this->Buscar($sql);
            return $request;
        }
	
	}
 ?>