<?php 


	class Dashboard extends Controllers{
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
            
			getPermisos(1); //Modulo - Funcion , funcion del helpers!
		}
        
        //Metodo
		public function dashboard()
		{   
			//Utilizamos el metodo getView enviando como parametro el this y la vista que queremos mostrar "home"
            //Array de la data
			$data['page_id'] = 2;
			$data['page_tag'] = "Rest-Food";
			$data['page_title'] = "Rest-Food";
			$data['page_title1'] = "Inicio";
			$data['page_name'] = "dashboard";
			$this->views->getView($this,"dashboard",$data);
		}

		
	}
 ?>