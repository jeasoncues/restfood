<?php 
	
	//Archivo Load
	//Convertir la primera letra en mayuscula de los controladore
	$controller = ucwords($controller);
    //Busca el archivo controller en el directorio CONTROLLERS
	$controllerFile = "Controllers/".$controller.".php";
	//Validacion para saber si existe el archivo en la carpeta controlador con ==> FILE_EXITS
	if(file_exists($controllerFile))
	{
		require_once($controllerFile);
		//Instanciamos el controlador
		$controller = new $controller();
		//Validacion para saber si existe el metodo y recibe los parametros si es que enviamos
		if(method_exists($controller, $method))
		{
			$controller->{$method}($params);
		}else{
			require_once("Controllers/Error.php");
		}
	}else{
		require_once("Controllers/Error.php");
	}

 ?>