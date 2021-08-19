<?php 

	class ProductosModel extends Mysql
	{
        private $intIdProducto;
        private $strNombre;
        private $strDescripcion;
        private $intCodigo;
        private $intCategoriaId;
        private $strPrecio;
        private $intStock;
        private $strRuta;
        private $intStatus;
        private $strImagen;


		public function __construct()
		{   
			
			parent::__construct();
        }
        
        public function selectProductos()
        {
            $sql = "SELECT p.idproducto,
                           p.codigo,
                           p.nombre,
                           p.descripcion,
                           p.categoriaid,
                           c.nombre as categoria,
                           p.precio,
                           p.stock,
                           p.status
                    FROM producto p
                    INNER JOIN categoria c
                    ON p.categoriaid = c.idcategoria
                    WHERE p.status != 0 ";
            $request = $this->MostrarRegistros($sql);
            return $request;
        }

        public function insertProducto($stringnombre, $stringdescripcion, $intcodigo, $intcategoriaid, $stringprecio, $intstock, $stringruta, $intstatus){

            $this->strNombre = $stringnombre;
            $this->strDescripcion = $stringdescripcion;
            $this->intCodigo = $intcodigo;
            $this->intCategoriaId = $intcategoriaid;
            $this->strPrecio = $stringprecio;
            $this->intStock = $intstock;
            $this->strRuta = $stringruta;
            $this->intStatus = $intstatus;
            $return = 0;
            
            $sql = "SELECT * FROM producto WHERE codigo = $this->intCodigo"; //no podemos guardar un producto con un codigo de barra que ya existe.
            $request = $this->MostrarRegistros($sql);

            if(empty($request))//quiere decir que no encontro ningun producto con ese codigo
            {
                $query_insert = "INSERT INTO producto(categoriaid,
                                                      codigo,
                                                      nombre,
                                                      descripcion,
                                                      precio,
                                                      stock,
                                                      ruta,
                                                      status)
                                 VALUES(?,?,?,?,?,?,?,?)";
                //Los signos de interrogacion son sustituidos con este array se coloca en el mismo orden del insert into. 
                $arrData = array($this->intCategoriaId,
                                 $this->intCodigo,
                                 $this->strNombre,
                                 $this->strDescripcion,
                                 $this->strPrecio,
                                 $this->intStock,
                                 $this->strRuta,
                                 $this->intStatus);
                $request_insert = $this->insertar($query_insert,$arrData);
                $return = $request_insert;
                                                      
            }else{
                $return = "exist"; //si existe el producto con ese codigo.

            }
            return $return;


        }
        
        //obtiendo un producto seleccionado
        public function selectProducto($intidproducto){
          $this->intIdProducto = $intidproducto;
          $sql = "SELECT p.idproducto,
                         p.codigo,
                         p.nombre,
                         p.descripcion,
                         p.precio,
                         p.stock,
                         p.categoriaid,
                         c.nombre as categoria,
                         p.status
                  FROM producto p
                  INNER JOIN categoria c
                  ON p.categoriaid = c.idcategoria
                  WHERE idproducto = $this->intIdProducto"; //donde el idproducto sea igual al producto que seleccionamos.
          $request = $this->Buscar($sql);
          return $request;
        }
         
        
        public function insertImage($intidproducto, $stringimagen){
            $this->intIdProducto = $intidproducto;
            $this->strImagen = $stringimagen;
            $query_insert = "INSERT INTO imagen(productoid,img) VALUES(?,?)";
            //array que agrega los valores de la propiedad
            $arrData = array($this->intIdProducto, 
                             $this->strImagen);
            $request_insert = $this->insertar($query_insert,$arrData); //obtiene el valor del metodo insertar.
            return $request_insert;


        }


        //Obtener la imagen del producto.
        public function selectImages($intidproducto){
            $this->intIdProducto = $intidproducto;
            $sql = "SELECT productoid, img
                    FROM imagen
                    WHERE productoid = $this->intIdProducto"; //donde el productoid sea el que estamos enviando.
            $request = $this->MostrarRegistros($sql);
            return $request;
        }


	
	}
 ?>