<?php

 class MesasModel extends Mysql{
     public $intIdMesa;
     public $strMesa;
     public $strPortada;
     public $intEstado;

     public function __construct(){
         parent::__construct();
     }

     public function selectMesas(){
         $sql = "SELECT * FROM mesas";
         $request = $this->MostrarRegistros($sql);
         return $request;
     }
     
     public function insertarMesa($stringmesa, $stringportada,$intestado){
         $return = 0;
         $this->strMesa = $stringmesa;
         $this->strPortada = $stringportada;
         $this->intEstado = $intestado;
         
         //en caso la mesa ya exista con este nombre
         $sql = "SELECT * FROM mesas WHERE nombre = '{$this->strMesa}'";
         $request = $this->MostrarRegistros($sql);

         if(empty($request)){
             $query_insert = "INSERT INTO mesas(nombre,imagen,estado) VALUES (?,?,?)";
             $arrData = array($this->strMesa,
                              $this->strPortada,
                              $this->intEstado);
             $request_insert = $this->insertar($query_insert,$arrData);
             $return = $request_insert;
         }else{
             $return = "exist";
         }
         return $return;
         
      }
 }

?>