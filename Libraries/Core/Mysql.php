<?php
 
 class Mysql extends Conexion{
     private $conexion;
     private $strQuery;
     private $arrValues;

     function __construct(){
         $this->conexion = new Conexion();
         //Metodo connect de la clase conexion
         $this->conexion = $this->conexion->connect();
     }

     //Metodos 
     //Metodo insertar
     public function insertar($stringquery, $arrayvalues){
        //Atributo strQuery almacena el stringquery que viene como parametro
        $this->strQuery = $stringquery;
        $this->arrValues = $arrayvalues;
        
        //Preparamos el query
        $insertar = $this->conexion->prepare($this->strQuery);
        //Ejecutando los datos que estan almacenando
        $restInsertar = $insertar->execute($this->arrValues);
        //Validacion si devuelve true -==> devuelve datos, sino se almaceno muestra 0 y retorna el ultimo valor
        if($restInsertar)
        {
            $lastInsert =  $this->conexion->lastInsertId(); //autoincremento del id
        }else{
            $lastInsert = 0;
        }
        return $lastInsert;
        
    }

    //Metodo para buscar 1 registro
    public function Buscar($stringquery){
        $this->strQuery = $stringquery;
        //Paramos el query que recibimos el parametro
        $result = $this->conexion->prepare($this->strQuery);
        //Ejecutamos la instruccion con execute
        $result->execute();
        //Por medio de data estamos obtenido los valores, por fetch obtenemos 1registro
        $data = $result->fetch(PDO::FETCH_ASSOC);
        //Devolvemos la informacion
        return $data;
    }

    //Metodo que devuelve todos los registros
    public function MostrarRegistros($stringquery){
        $this->strQuery = $stringquery;
        $result = $this->conexion->prepare($this->strQuery);
        $result->execute();
        //Por medio de FETCHALL ==> Muestra todos los registros
        $data = $result->fetchall(PDO::FETCH_ASSOC);
        return $data;
    }

    //Metodo para actualizar registros
    public function Actualizar($stringquery, $arrayvalues){
        $this->strQuery = $stringquery;
        $this->arrValues = $arrayvalues;

        $actualizar =  $this->conexion->prepare($this->strQuery);
        $resultExecute = $actualizar->execute($this->arrValues);
        return $resultExecute;
    }

    //Metodo para eliminar registros
    public function Eliminar($stringquery){
        $this->strQuery = $stringquery;
        $result = $this->conexion->prepare($this->strQuery);
        $delete = $result->execute();
        return $delete;
    }
    
 }
 


?>