<?php
 //requerimos los metodos que estan en el mysql CRUD
 require_once("Libraries/Core/Mysql.php");

 trait TraitCategoria{
     private $con; //conexion de mysql

     public function getCategoriasTienda($stringcategorias){
         $this->con =  new Mysql(); //asignamos a la propiedad con , creando un objeto de tipo MYSQL
         $sql = "SELECT idcategoria, nombre, descripcion, portada, ruta
                 FROM categoria WHERE status != 0 AND idcategoria IN ($stringcategorias)"; //and porque extraemos mas de una categoria, con "in" lo que estamos obteniendo como parametro.
         $request = $this->con->MostrarRegistros($sql); 
         if(count($request) > 0){ //si encontro registros
             for ($c=0; $c < count($request); $c++){ //recorremos el array
                 $request[$c]['portada'] = BASE_URL.'/Assets/images/uploads/'.$request[$c]['portada']; //armamos una url donde mandamos la portada que corresponde a la imagen.
             }
         }
         return $request;//devolvemos el array con el nuevo elemento

     }
 }

?>