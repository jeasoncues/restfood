<?php 

	//para usar el trait categoria y productos
	require_once("Models/TraitCategoria.php");
	require_once("Models/TraitProducto.php");
	require_once("Models/TraitTipoPago.php");
	require_once("Models/TraitCliente.php");

	class Carrito extends Controllers{
		use TraitCategoria, TraitProducto, TraitTipoPago, TraitCliente; //usamos el trait categoria, producto (SE USA PARA HACER MULTIPLE HERENCIA)

		public function __construct()
		{   
			//Invocando al constuctor del controlador que hereda con parent EJECUTANDO
			parent::__construct();
			session_start(); //inicializamos las sesiones

		}
        
        //Metodo
		public function carrito()
		{   

            //Array de la data
			$data['page_tag'] = "Rest-Food | Carrito";
			$data['page_title'] = 'Carrito de compras';
			$data['page_name'] = "carrito";
			$this->views->getView($this,"carrito",$data);
        }
        
        public function procesarpago()
		{   
			//validacion para saber si existe la variable de sesion de carrito donde tiene los productos.
			
			
            if(empty($_SESSION['arrCarrito'])){
                header("Location:".base_url());
                die();
			}
			
			
			
            //Array de la data
			$data['page_tag'] = "Rest-Food | Procesar Pago";
			$data['page_title'] = "Procesar Pago";
			$data['page_name'] = "procesarpago";
			$data['tiposPago'] = $this->getTiposPagoTienda();
			$this->views->getView($this,"procesarpago",$data);
		}
	
	}
 ?>