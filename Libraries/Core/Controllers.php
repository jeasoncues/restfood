<?php 
	
	class Controllers
	{   
		//Constructor 
		public function __construct()
		{
			$this->views = new Views();
			$this->loadModel();
		}
        
        //Metodo para cagar los modelos
		public function loadModel()
		{
			//Mediante la funcion get_class obtnemos la carpeta models
			$model = get_class($this)."Model";
			//Busca el archivo
			$routClass = "Models/".$model.".php";
			//Validacion para saber si existe el archivo
			if(file_exists($routClass)){
				require_once($routClass);
				$this->model = new $model();
			}
		}
	}

 ?>