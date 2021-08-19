<?php 
  //para usar el trait categoria y productos
	require_once("Models/TraitCategoria.php");
	require_once("Models/TraitProducto.php");
	require_once("Models/TraitTipoPago.php");
	require_once("Models/TraitCliente.php");

	class Cuenta extends Controllers{
		use TraitCategoria, TraitProducto, TraitTipoPago, TraitCliente; //usamos el trait categoria, producto (SE USA PARA HACER MULTIPLE HERENCIA)

		public function __construct()
		{   
			//Invocando al constuctor del controlador que hereda con parent EJECUTANDO
			parent::__construct();
			session_start(); //inicializamos las sesiones

		}
        
        //Metodo
		public function cuenta()
		{   

            //Array de la data
			$data['page_tag'] = "Cuenta | RestFood";
			$data['page_title'] = 'Mi Cuenta';
			$data['page_name'] = "cuenta";
			$this->views->getView($this,"cuenta",$data);
        }
        
    }

?>