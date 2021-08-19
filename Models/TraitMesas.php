<?php
 
 require_once("Libraries/Core/Mysql.php");
 
 trait TraitMesas{
     private $con;

     public function getMesasRestaurante(){
        $this->con =  new Mysql(); //asignamos a la propiedad con , creando un objeto de tipo MYSQL
        $sql = "SELECT idmesa, nombre, imagen, estado
                FROM mesas"; 
        $request = $this->con->MostrarRegistros($sql); 
        if(count($request) > 0){ //si encontro registros
            for ($c=0; $c < count($request); $c++){ //recorremos el array
                $request[$c]['imagen'] = BASE_URL.'/Assets/images/uploads/'.$request[$c]['imagen']; //armamos una url donde mandamos la portada que corresponde a la imagen.
            }
        }
        return $request;//devolvemos el array con el nuevo elemento

     }
 }

?>