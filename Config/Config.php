<?php 
	//Variables constantes con DEFINE o con CONST (2 FORMAS)
    //define ("BASE URL","http://localhost/RestFood/" );
    //Por medio de estas variables nos dirigimos a estos archivos por medio del directorio con el "/"
    const BASE_URL = "http://localhost/RestFood";
    //Zona Horaria de nuestro pais region lima
    date_default_timezone_set('America/Lima');
    //Variables constantes para hacer la conexion a la base de datos
    const DB_HOST = "localhost";
    const DB_NAME = "db_sistema";
    const DB_USER = "root";
    const DB_PASSWORD = "";
    //Codificador de la base de datos
    const DB_CHARSET = "charset=utf8";
    //Deliminadores decimal y millar Ej, 24,1989.00
    const SPD = ".";
    const SPM = ",";

    //Simbolo de Moneda
    const SMONEY = "S/";
    const CURRENCY = "USD";

    //constante para el id de paypal de la api - version prueba
    const URLPAYPAL = "https://api-m.sandbox.paypal.com";
    const IDCLIENTE = "AZx9A7OX9HsbUGOwhYQOWeebuKHHgFTb2duvc30wO6p8pI4RmApnuteLsDClzewkJU-5JtAgSdr-PHsH";
    //constante de contraseña de la version prueba.
    const SECRET = "EM0bL5ims84oT3wcy7eLPuEuFv-AGoMHmzK-u1BI0KCCrPTISFHUriTustVogcU-d6tkgK2pJTSMnnqY";

    //constantes para el id de paypal de la api, la url de la api, y la contraseña - version original de produccion
    const IDCLIENTE_PRODUCCION =  "AaBN5UepX8VHMy80SL2Dk1zSiwlcz5fhGF8pFpqsrEsgs61H05aVFfUtkitaPyadjFUynfiuBLnGWhpN";
   // const URLPAYPAL = "https://api-m.paypal.com";
   // const SECRET = "EOYLNpMyu5RqkWnvjT3WwgJgipX9KgrehbMYKHmApq8u3Q1bXwAPtl61oxrnhUKabHrCC7kSpTDQiLk9";



    //DATOS DE ENVIO DE CORREO  
    const NOMBRE_REMITENTE = "Rest-Food";
    const EMAIL_REMITENTE = "no-reply@rest-food.com"; //no debe responder al correo que enviamos con no-reply
    const NOMBRE_EMPRESA = "Rest-Food";
    const NOMBRE_EMPRESA_PEDIDO = "Rest-Food | Tienda Online";
    const WEB_EMPRESA = "www.restfood.com";


    //datos de empresa
    const DIRECCION =  "Piura, Perú";
    const TELEFONOEMPRESA = "+(51) 999134381";
    const EMAIL_EMPRESA = "restfood@gmail.com";
    const EMAIL_PEDIDOS = "jeasoncues@gmail.com";

    const CAT_SLIDER = "10"; //QUE CATEGORIAS VAMOS A EXTRAER PARA EL SLIDER DE LA TIENDA VIRTUAL
    const CAT_BANNER = "10,11,12,14,15"; //BANNER DE CATEGORIAS
    
    //Datos para encriptar / Desencriptar
    const KEY= 'donattos';
    const METHODENCRIPT = "AES-128-ECB";

    //VARIABLE PARA ENVIO
    const COSTOENVIO = 5;

 ?>