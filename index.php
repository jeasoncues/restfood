<?php 
	require_once("Config/Config.php");
	require_once("Helpers/Helpers.php");

	
	//Configuracion de enviar la URL, !EMPTY => CONDICION  "SI EXISTE" por el "!"
    //Para saber si no envias nada en la url aparecera "home/home", si es que hay algo en la url aparecera lo enviado
	$url = !empty($_GET['url']) ? $_GET['url'] : 'home/home';
	//Funcion de PHP => explode que pide dos parametros para separar con el delimitador "/"
	$arrUrl = explode("/", $url);
	//Lo que venga en la posicion 0
	$controller = $arrUrl[0];
	$method = $arrUrl[0];
	$params = "";

    //Validacion para saber si existe la posicion 1 del array
    //si la posicion 1 es diferente de vacio 
	if(!empty($arrUrl[1]))
	{
		if($arrUrl[1] != "")
		{
			$method = $arrUrl[1];	
		}
	}
    
    //Validacion para obtener el parametro
	if(!empty($arrUrl[2]))
	{
		if($arrUrl[2] != "")
		{   
			//Recorrer las posiciones de los parametros
			for ($i=2; $i < count($arrUrl); $i++) {
				$params .=  $arrUrl[$i].',';
				# code...
			}
			//Funcion remover el ultimo caracter de una cadena ==> elimine la coma que esta en la ultima cadena
			$params = trim($params,',');
		}
	}
	require_once("Libraries/Core/Autoload.php");
	require_once("Libraries/Core/Load.php");

 ?>