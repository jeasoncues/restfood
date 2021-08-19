<?php 

	class Ventas extends Controllers{
		public function __construct()
		{   
			
			parent::__construct();


			session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
		}
        

		public function ventas()
		{   
	
			$data['page_tag'] = "Ventas";
			$data['page_title'] = "Ventas";
			$data['page_name'] = "ventas";
			$this->views->getView($this,"ventas",$data);
		}

		
	}
 ?>