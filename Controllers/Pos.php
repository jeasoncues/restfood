<?php 

	class Pos extends Controllers{
		public function __construct()
		{   
			
			parent::__construct();


			session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
		}
        

		public function pos()
		{   
	
			$data['page_tag'] = "POS";
			$data['page_title'] = "POS";
			$data['page_name'] = "pos";
			$this->views->getView($this,"pos",$data);
		}

		
	}
 ?>