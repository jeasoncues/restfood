<?php
   
//Conexion con PDO, llamamos las variables constantes del config.php
  class Conexion{
      //Atributos 
      private $conect;

      //Metodo constructor
      public function __construct(){
          $connectionString = "mysql:hos=".DB_HOST.";dbname=".DB_NAME.";.DB_CHARSET.";
          try{
              //Creamos un objeto PDO haciendo la conexion, con que usuario y contraseña nos conectaremos
              $this->conect = new PDO($connectionString, DB_USER, DB_PASSWORD );

              //Metodo setAttribute de PDO sirve para detectar errores en el sistema
              $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              //Para saber si se conecto ===> echo 'Conexion Exitosa';
          }catch (Exception $e){
              $this->conect = 'Error de Conexion';
              //Imprimiendo el error
              echo "ERROR: ".$e->getMessage();
          }
      }
      
       //Metodo Conect ===> retorna la conexion
       public function connect(){
       return $this->conect;
       }
  }
?>