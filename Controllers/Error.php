<?php 
    
	class Errors extends Controllers{
		public function __construct()
		{   
            //Invocando al constuctor del controlador que hereda con parent EJECUTANDO
			parent::__construct();
		}
        
        //Metodos
		public function notFound()
		{   
			//Invocamos a la vista error
			$this->views->getView($this,"error");
		}
	}
    //Creamos instancia de la clase error
	$notFound = new Errors();
	//Llamamos al metodo notfound
	$notFound->notFound();

	

	
 ?>