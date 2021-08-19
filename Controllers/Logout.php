<?php

  class Logout
  {   
      //CERRAR SESION
      public function __construct(){
          session_start(); //Inicializando sesion
          session_unset(); //Limpiamos las variables de sesion
          session_destroy(); //Destruir todas las sesiones
          header('location: '.base_url().'/login'); //Redireccionamos a la ruta de login
      }
  }
  
?>