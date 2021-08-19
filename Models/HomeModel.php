<?php 

//INCLUIMOS A CATEGORIAMODEL.PHP
//require_once("CategoriasModel.php");

	class HomeModel extends Mysql
	{
		//private $objCategoria;

		public function __construct()
		{   
			//Cargar el metodo constructor de la clase padre
			parent::__construct();
			//creamos objeto de tipo categoriamodel
			//$this->objCategoria =  new CategoriasModel();
		}

		//METODO PARA EXTRAER CATEGORIAS
		public function getCategorias(){
			//desde el objeto llamamos al metodo selectcategorias para extraer todas las categorias
			//return $this->objCategoria->selectCategorias();
		}

		//VAMOS A UTILIZAR LOS TRAITS PARA EXTRAER PRODUCTOS Y CATEGORIAS
	
	}
 ?>