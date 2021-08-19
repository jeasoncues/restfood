<?php 

	//para usar el trait categoria
	require_once("Models/TraitCategoria.php");
	require_once("Models/TraitProducto.php");

	class Home extends Controllers{
		use TraitCategoria, TraitProducto; //usamos el trait categoria, producto (SE USA PARA HACER MULTIPLE HERENCIA)

		public function __construct()
		{   
			//Invocando al constuctor del controlador que hereda con parent EJECUTANDO
			parent::__construct();
			session_start();

		}
        
        //Metodo
		public function home()
		{   

			//Utilizamos el metodo getView enviando como parametro el this y la vista que queremos mostrar "home"
            //Array de la data
			$data['page_tag'] = "Rest-Food | Tienda Online";
			$data['page_title'] = "Rest-Food | Tienda Online";
			$data['page_name'] = "Tienda Online";
			
			//LLAMAR AL METODO GETCATEGORIATIENDA DEL TRAIT, Y LA VARIABLE GLOBAL CAT_SLIDER DE CONFIG
			$data['slider'] = $this->getCategoriasTienda(CAT_SLIDER);
			//BANNER TIENDA VIRTUAL
			$data['banner'] = $this->getCategoriasTienda(CAT_BANNER);
			//LLAMADO PARA LOS PRODUCTOS
			$data['productos'] = $this->getProductosTienda();
			$this->views->getView($this,"home",$data);
		}

		
	}
 ?>