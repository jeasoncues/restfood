<?php 

	class GastosModel extends Mysql
	{
		private $intCodigo;
		private $strNombre;
		private $intPrecio;
		private $strFecha;
		private $intTipoid;

		public function __construct()
		{   
			
			parent::__construct();
		}

		public function insertarGasto($stringnombre, $intprecio, $stringfecha, $inttipoid){
			$this->strNombre = $stringnombre;
			$this->intPrecio = $intprecio;
			$this->strFecha = $stringfecha;
			$this->intTipoid = $inttipoid;
			$return = 0;

			$sql = "INSERT INTO gastos(nombre,precio,fecha,rolid) VALUES (?,?,?,?)";
			$arrData =  array($this->strNombre,
							  $this->intPrecio,
							  $this->strFecha,
							  $this->intTipoid);
			$request_insertar = $this->insertar($sql,$arrData);
			$return = $request_insertar;
			return $return;
		}
		


		public function selectGastos() 
		{
			$sql = "SELECT g.codigo,g.nombre,g.precio,g.fecha,r.nombrerol
			FROM gastos g
			INNER JOIN rol r
			ON g.rolid = r.idrol";
			$request = $this->MostrarRegistros($sql);
			return $request;
			
		}

		public function updateGasto()
		{
			
		}
	
	}
 ?>