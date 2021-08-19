<?php

 //requerimos los metodos que estan en el mysql CRUD
 require_once("Libraries/Core/Mysql.php");
 trait TraitProducto{
     private $con;
     private $strCategoria;
     private $intIdcategoria;
     private $intIdproducto;
     private $strProducto;
     private $intCantidad;
     private $stringOption;
     private $strRuta;
    
    //EXTRAER PRODUCTOS
    public function getProductosTienda()
    {
        $this->con = new Mysql(); //creamos un objeto de tipo mysql
        $sql = "SELECT p.idproducto,
                       p.codigo,
                       p.nombre,
                       p.descripcion,
                       p.categoriaid,
                       c.nombre as categoria,
                       p.precio,
                       p.ruta,
                       p.stock
                FROM producto p
                INNER JOIN categoria c
                ON p.categoriaid = c.idcategoria
                WHERE p.status != 0 ORDER BY p.idproducto DESC";
        $request = $this->con->MostrarRegistros($sql);
        //si encontramos registros
        if(count($request) > 0){
            for($c=0; $c < count($request); $c++){ //menor que los registros
                //ingresamos al array luego al item idproducto , esta variable lo almacena
                $intIdProducto = $request[$c]['idproducto'];
                //Extraemos la imagen del producto de la tabla imagen
                $sqlimg = "SELECT img
                        FROM imagen
                        WHERE productoid = $intIdProducto"; //donde el productoid sea el que estamos enviando.
                $arrImg = $this->con->MostrarRegistros($sqlimg);
                if(count($arrImg) > 0){ //quiere decir que si encontro imagenes
                   for ($i=0; $i < count($arrImg); $i++) {  //tiene que ser menor de la cantidad de registros del array
                       $arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img']; //el array de la posicion url image concatena la ruta en la posicion del array y con img asigna la imagen de los productos
                   }
                }
                $request[$c]['imagen'] = $arrImg; //en la posicion del ciclo le agrega la imagen donde va a tener el array con todas las imagenes.
            }
        }
        return $request;
    }

    public function getProductosCategoriaTienda($intidcategoria, $stringruta)
    {   
        $this->intIdcategoria = $intidcategoria;
        $this->strRuta = $stringruta;
        $this->con = new Mysql();
        
        $sql_categoria =  "SELECT idcategoria,nombre FROM categoria WHERE idcategoria = '{$this->intIdcategoria}'";
        $request = $this->con->Buscar($sql_categoria);  //vamos a buscar un registro.

        if(!empty($request)) //si existe el registro va a mostrar todo
        {
            $this->strCategoria = $request['nombre'];
            $sql = "SELECT p.idproducto,
                    p.codigo,
                    p.nombre,
                    p.descripcion,
                    p.categoriaid,
                    c.nombre as categoria,
                    p.precio,
                    p.ruta,
                    p.stock
                    FROM producto p
                    INNER JOIN categoria c
                    ON p.categoriaid = c.idcategoria
                    WHERE p.status != 0  AND p.categoriaid = $this->intIdcategoria AND c.ruta = '{$this->strRuta}' "; //extrae productos no eliminados y los que tienen el id de categoria a la que pertenece y ruta sea igual a la ruta que enviamos.
            $request = $this->con->MostrarRegistros($sql);
            //si encontramos registros
            if(count($request) > 0){
                for($c=0; $c < count($request); $c++){ //menor que los registros
                //ingresamos al array luego al item idproducto , esta variable lo almacena
                $intIdProducto = $request[$c]['idproducto'];
                //Extraemos la imagen del producto de la tabla imagen
                $sqlimg = "SELECT img
                            FROM imagen
                            WHERE productoid = $intIdProducto"; //donde el productoid sea el que estamos enviando.
                $arrImg = $this->con->MostrarRegistros($sqlimg);
                if(count($arrImg) > 0){ //quiere decir que si encontro imagenes
                    for ($i=0; $i < count($arrImg); $i++) {  //tiene que ser menor de la cantidad de registros del array
                        $arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img']; //el array de la posicion url image concatena la ruta en la posicion del array y con img asigna la imagen de los productos
                    }
                }
                $request[$c]['imagen'] = $arrImg; //en la posicion del ciclo le agrega la imagen donde va a tener el array con todas las imagenes.
              }
            }

            $request = array('idcategoria' => $this->intIdcategoria,
                             'categoria' => $this->strCategoria,
                             'productos' => $request
                   );

        }
        return $request;
    }
    
    //EXTRAER UN PRODUCTO 
    public function getProductosT($intidproducto, $stringruta)
    {
        $this->con = new Mysql(); //creamos un objeto de tipo mysql
        $this->intIdproducto = $intidproducto;
        $this->strRuta = $stringruta;
        $sql = "SELECT p.idproducto,
                       p.codigo,
                       p.nombre,
                       p.descripcion,
                       p.categoriaid,
                       c.nombre as categoria,
                       p.precio,
                       p.ruta,
                       p.stock
                FROM producto p
                INNER JOIN categoria c
                ON p.categoriaid = c.idcategoria
                WHERE p.status != 0 AND p.idproducto = '{$this->intIdproducto}' AND p.ruta = '{$this->strRuta}' "; //muestra producto por media del nombre
        $request = $this->con->Buscar($sql);
        //si no esta vacio recorremos
        if(!empty($request)){ 
                //ingresamos al array luego al item idproducto , esta variable lo almacena
                $intIdProducto = $request['idproducto'];
                //Extraemos la imagen del producto de la tabla imagen
                $sqlimg = "SELECT img
                        FROM imagen
                        WHERE productoid = $intIdProducto"; //donde el productoid sea el que estamos enviando.
                $arrImg = $this->con->MostrarRegistros($sqlimg);
                if(count($arrImg) > 0){ //quiere decir que si encontro imagenes
                   for ($i=0; $i < count($arrImg); $i++) {  //tiene que ser menor de la cantidad de registros del array
                       $arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img']; //el array de la posicion url image concatena la ruta en la posicion del array y con img asigna la imagen de los productos
                   }
                }else{ //imagenes por defecto en caso no tenga imagen el producto.
                    $arrImg[0]['url_image'] = media().'/images/uploads/producto.png';
                }
                $request['imagen'] = $arrImg; //en la posicion del ciclo le agrega la imagen donde va a tener el array con todas las imagenes.
        }
        return $request;
    }

    //EXTRAER PRODUCTOS DE FORMA ALEATORIA
    public function getProductosRandom($intidcategoria, $intcantidad, $stringoption){
       $this->intIdcategoria = $intidcategoria;
       $this->intCantidad = $intcantidad;
       $this->stringOption = $stringoption;

       if($stringoption == "r"){
        $this->option = " RAND() ";
        }else if($stringoption == "a"){
            $this->option = " idproducto ASC ";
        }else{
            $this->option = " idproducto DESC ";
        }
       $this->con = new Mysql();
           $sql = "SELECT p.idproducto,
                   p.codigo,
                   p.nombre,
                   p.descripcion,
                   p.categoriaid,
                   c.nombre as categoria,
                   p.precio,
                   p.ruta,
                   p.stock
                   FROM producto p
                   INNER JOIN categoria c
                   ON p.categoriaid = c.idcategoria
                   WHERE p.status != 0  AND p.categoriaid = $this->intIdcategoria
                   ORDER BY $this->option LIMIT  $this->intCantidad"; //extrae los productos de acuerdo a la cantidad ingresada y de manera ordenada en random.
           $request = $this->con->MostrarRegistros($sql);
           //si encontramos registros
           if(count($request) > 0){
               for($c=0; $c < count($request); $c++){ //menor que los registros
               //ingresamos al array luego al item idproducto , esta variable lo almacena
               $intIdProducto = $request[$c]['idproducto'];
               //Extraemos la imagen del producto de la tabla imagen
               $sqlimg = "SELECT img
                           FROM imagen
                           WHERE productoid = $intIdProducto"; //donde el productoid sea el que estamos enviando.
               $arrImg = $this->con->MostrarRegistros($sqlimg);
               if(count($arrImg) > 0){ //quiere decir que si encontro imagenes
                   for ($i=0; $i < count($arrImg); $i++) {  //tiene que ser menor de la cantidad de registros del array
                       $arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img']; //el array de la posicion url image concatena la ruta en la posicion del array y con img asigna la imagen de los productos
                   }
               }
               $request[$c]['imagen'] = $arrImg; //en la posicion del ciclo le agrega la imagen donde va a tener el array con todas las imagenes.
             }
           }
       return $request;
    }

    //METODO PARA AGREGAR UN PRODUCTO AL CARRITO
    public function getProductoIDT($intidproducto)
    {
        $this->con = new Mysql(); //creamos un objeto de tipo mysql
        $this->intIdproducto = $intidproducto;
        $sql = "SELECT p.idproducto,
                       p.codigo,
                       p.nombre,
                       p.descripcion,
                       p.categoriaid,
                       c.nombre as categoria,
                       p.precio,
                       p.ruta,
                       p.stock
                FROM producto p
                INNER JOIN categoria c
                ON p.categoriaid = c.idcategoria
                WHERE p.status != 0 AND p.idproducto = '{$this->intIdproducto}' "; 
        $request = $this->con->Buscar($sql);

        if(!empty($request)){ 
       
                $intIdProducto = $request['idproducto'];
         
                $sqlimg = "SELECT img
                        FROM imagen
                        WHERE productoid = $intIdProducto"; 
                $arrImg = $this->con->MostrarRegistros($sqlimg);
                if(count($arrImg) > 0){ 
                   for ($i=0; $i < count($arrImg); $i++) {
                       $arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img']; 
                   }
                }else{ 
                    $arrImg[0]['url_image'] = media().'/images/uploads/producto.png';
                }
                $request['imagen'] = $arrImg; 
        }
        return $request;
    }

    
 }
?>