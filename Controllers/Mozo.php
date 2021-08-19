<?php
 
 require_once("Models/TraitMesas.php");
 class Mozo extends Controllers{
     use TraitMesas;
     public function __construct()
     {
         parent::__construct();

         session_start();
         if(empty($_SESSION['login']))
         {
             header('Location: '.base_url().'/login');
         }
     }

     public function mozo(){
         $data['page_tag'] = "Mozo";
         $data['page_title'] = "Mozo";
         $data['page_name'] = "mozo";
         $data['mesas'] = $this->getMesasRestaurante();
         $this->views->getView($this,"mozo",$data);
     }

 }

?>