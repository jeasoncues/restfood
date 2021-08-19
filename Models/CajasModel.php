<?php 

	class CajasModel extends Mysql
	{
		private $intIdCaja;
		private $strFecha;
		private $intTurno;
		private $strCajaChica;
		private $strCajaCierre;
		

		public function __construct()
		{   
			//Cargar el metodo constructor de la clase padre
			parent::__construct();
		}

		public function insertarArqueoInicial($stringfecha, $intturno, $stringcajachica){
			$return = 0;
			$this->strFecha = $stringfecha;
			$this->intTurno = $intIdArqueoInicial;
			$this->strCajaChica = $stringcajachica;
   
   
			$query_insert = "INSERT INTO arqueo_inicial(fecha,turno,cajachica) VALUES (?,?,?)";
			$arrData = array(
							 $this->strFecha,
							 $this->intTurno,
							 $this->strCajaChica
							);
			$request_insert = $this->insertar($query_insert,$arrData);
			$return = $request_insert;
			return $retun;
		}
	
	}
 ?>