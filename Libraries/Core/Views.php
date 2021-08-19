<?php 
	
	class Views
	{   
		//Metodo , $data como vacio por si no mandemos ningun valor
		function getView($controller,$view,$data="")
		{   
			//Obtiene la clase controller
			$controller = get_class($controller);
			//Validacion para buscar la vista de home 
			if($controller == "Home"){
				$view = "Views/".$view.".php";
			}else{
				$view = "Views/".$controller."/".$view.".php";
			}
			require_once ($view);
		}
	}

 ?>