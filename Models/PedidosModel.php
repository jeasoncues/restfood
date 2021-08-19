<?php 


	class PedidosModel extends Mysql
	{

		public function __construct()
		{   

			parent::__construct();

		}


		public function selectPedidos(){
            $sql = "SELECT p.idpedido,
                           p.referenciacobro,
                           p.idtransaccionpaypal,
                           DATE_FORMAT(p.fecha, '%d/%m/%Y') as fecha,
                           p.monto,
                           tp.tipopago,
                           tp.idtipopago,
                           p.status
                    FROM pedido p
                    INNER JOIN tipopago tp
                    ON p.tipopagoid = tp.idtipopago";
            $request = $this->MostrarRegistros($sql);
            return $request; //retornamos hacia el controlador
	
		}

	
	}
 ?>