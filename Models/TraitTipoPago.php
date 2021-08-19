<?php
 //requerimos los metodos que estan en el mysql CRUD
 require_once("Libraries/Core/Mysql.php");

 trait TraitTipoPago{
     private $con; //conexion de mysql

    //metodo de los tipo de pago que tenemos en la base de datos
    public function getTiposPagoTienda(){
        $this->con =  new Mysql();
        $sql = "SELECT * FROM tipopago WHERE status != 0";
        $request = $this->con->MostrarRegistros($sql);
        return $request;
    }
 }

?>