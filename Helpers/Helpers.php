<?php
    
   //Retorna la url del proyecto
   function base_url(){
       return BASE_URL;
   }

   //Retorna la url de Assets
   function media(){
       return BASE_URL."/Assets";
   }

   //Funciones para el template para requerir, inicializamos a data como vacio para usar las variables del controlador
   function headerAdmin($data=""){
       $view_header = "Views/Template/header_admin.php";
       require_once ($view_header);
   }

   function headerDashboard($data=""){
       $view_dashboard = "Views/Template/header_dashboard.php";
       require_once ($view_dashboard);
   }

   function footerAdmin($data=""){
       $view_footer = "Views/Template/footer_admin.php";
       require_once ($view_footer);
   }
    

   //Header y footer para la tienda onlien

   function headerTienda($data=""){
    $view_header = "Views/Template/header_tienda.php";
    require_once ($view_header);
   }

   function footerTienda($data=""){
    $view_footer = "Views/Template/footer_tienda.php";
    require_once ($view_footer);
   }
 

   //Muestra informacin de los objetos o array de forma formateada
   //Envia el array data con formato json de array
   function dep($data){
       $format = print_r('<pre>');
       $format = print_r($data);
       $format = print_r('</pre>');
       return $format;
   }

   //Funcion de getModal para los roles, recibe un string y un array de la data
   //Abre el modal que enviamos como parametro ==>$stringnamemodal
   function getModal($stringnamemodal, $data){
       $view_modal = "Views/Template/Modals/{$stringnamemodal}.php";
       require_once $view_modal;
   }
   
   //funcion para obtener archivo de las vistas
   function getFile($stringurl, $data){
       ob_start(); //para incializar el buffer
       require_once("Views/{$stringurl}.php"); //ingresa a la carpeta views luego se dirigige a la url que es template/modals/modalcarrito.php 
       $file = ob_get_clean(); //funcion ob_get_clean => levantamos el archivo para utilizar las variables que enviamos como parametro en este caso "DATA" ------------- LIMPIAMOS EL BUFFER
       return $file; //RETORNAMOS
   }

   
   //Envio de correo
   function sendEmail($data,$template) //recibe los datos y el template de email_cambiopassword
   {
    $asunto = $data['asunto'];//asunto del mensaje del array en el controlador Login.php
    $emailDestino = $data['email'];
    $empresa = NOMBRE_REMITENTE; //variables globales
    $remitente = EMAIL_REMITENTE;

    //IF TERNARIO PARA VALIDACION
    //la variable emailcopia va ser igual si existe ese elemento en el array le coloca lo que trae lo del elemento, toma el valor sino se cumple va ser vacio.
    $emailCopia = !empty($data['emailCopia']) ? $data['emailCopia'] : "";

    //ENVIO DE CORREO - ENCABEZADOS PARA QUE EL CORREO SE ENVIE CORRECTAMENTE
    $de = "MIME-Version: 1.0\r\n"; //VERSION 
    $de .= "Content-type: text/html; charset=UTF-8\r\n"; //TIPO DE CONTENIDO - RETORNO Y SALTO DE LINEA CON BACKSALH N
    $de .= "From: {$empresa} <{$remitente}>\r\n"; //DE DONDE ENVIAMOS EL CORREO ELECTRONICO EN ESTE CASO EMPRESA Y REMITENTE

    //para enviar el correo de copia a la empresa enviando la variable al correo que pertenece.
    $de .= "Bcc: $emailCopia\r\n";

    ob_start(); //CARGA EN MEMORIA O EN BUFFER EL ARCHIVO QUE EXPECIFICAMOS QUE ES EL DE ABAJO
    require_once("Views/Template/Email/".$template.".php"); //ESTE ARCHIVO ENVIAMOS  QUE SERA EMAILCAMBIOPASWWORD
    $mensaje = ob_get_clean();// OBTENEMOS EL ARCHIVO PARA HACER USO DE TODOS LOS DATOS Y LE ASIGNAMOS A LA VARIABLE MENSAJE
    $send = mail($emailDestino, $asunto, $mensaje, $de); //MAIL => LA FUNCION QUE HACE EL ENVIO DE CORREOS CON LOS PARAMETROS, EMAILDESTINO EL CORREO QUE ENVIAMOS
    return $send;
   }



   /*Funcion para los permisos*/
   function getPermisos($intidmodulo){
       //extraer los permisos, requerimos el modelo permisos 
       require_once("Models/PermisosModel.php");
       $objPermisos = new PermisosModel(); //Objeto de tipo permisosmodel
       $idrol = $_SESSION['userData']['idrol']; //obtener la informacion del usuario logeado y su idrol
       $arrPermisos = $objPermisos->permisosModulo($idrol); //metodo creado en el modelpermisos
       $permisos = '';
       $permisosMod = ''; 

       //validacion para saber si el array viene vacio
       if(count($arrPermisos) > 0){ //si trae permisos
           $permisos = $arrPermisos; //variable permisos que le damos el array
           $permisosMod = isset($arrPermisos[$intidmodulo]) ? $arrPermisos[$intidmodulo] : "";  //si existe en la posicion del array le coloca todo el conjunto de elemento a la variable permisosMod "?" => de lo contrario si no existe lo coloca vacio.
       } 


       //variables de sesion para almacenar permisos, permisosMod 
       $_SESSION['permisos'] = $permisos; //almacenanos el permiso
       $_SESSION['permisosMod'] = $permisosMod;  //almacenamos el modulo a visualizar

   }
  
   
   //FUNCION PARA IMAGENES
   function uploadImage($arraydata, $stringname){ //array de la foto, y nombre portada.
       $url_temp = $arraydata['tmp_name']; //accedemos al array en la posicion tmp_name para la ruta temporal
       $destino = 'Assets/images/uploads/'.$stringname; //destino de la imagen enviando la portada.
       $move = move_uploaded_file($url_temp,$destino); //variable move donde enviamos la funcion move_uploaded_file enviamos como parametros la ruta temporal y el destino de la imagen.
       return $move;
   }

    

   //Eliminar el exceso que se escriban en los formularios entre palabras para que nuestra base de datos este limpia
   //Limpiar una cadena
   function strClean($stringcadena){

      $string = preg_replace(['/\s+/','/^\s|\$/'],[' ',''], $stringcadena); //Limpia el exceso de palabras que escriben en los formularios
      $string = trim($string); //Elimina espacios en blanco al inicio y al final
      $string = stripslashes($string); //Elimina los \ invertidos
      //Si encuentra <script> y igual para lo demas en el formulario lo quitara y lo dejara como vacio por ==> "" 
      //Para evitar inyecciones SQL nos brinda seguridad 
      $string = str_ireplace("<script>","",$string); 
      $string = str_ireplace("</script>","",$string);
      $string = str_ireplace("<script src>","",$string);
      $string = str_ireplace("<script type=>","",$string);
      $string = str_ireplace("SELECT * FROM","",$string);
      $string = str_ireplace("DELETE FROM","",$string);
      $string = str_ireplace("INSERT INTO","",$string);
      $string = str_ireplace("SELECT COUNT(*) FROM","",$string);
      $string = str_ireplace("DROP TABLE","",$string);
      $string = str_ireplace("OR '1'='1","",$string);
      $string = str_ireplace('OR "1"="1"',"",$string);
      $string = str_ireplace('OR ´1´= ´1´',"",$string);
      $string = str_ireplace("is NULL; --","",$string);
      $string = str_ireplace("is NULL; --","",$string);
      $string = str_ireplace("LIKE '","",$string);
      $string = str_ireplace('LIKE "',"",$string);
      $string = str_ireplace("LIKE ´","",$string);
      $string = str_ireplace("OR 'a'='a","",$string);
      $string = str_ireplace('OR "a"="a',"",$string);
      $string = str_ireplace("OR ´a´=´a","",$string);
      $string = str_ireplace("OR ´a´=´a","",$string);
      $string = str_ireplace("--","",$string);
      $string = str_ireplace("^","",$string);
      $string = str_ireplace("[","",$string);
      $string = str_ireplace("]","",$string);
      $string = str_ireplace("==","",$string);
      return $string;

   }

   function clear_cadena($stringcadena){
    //Reemplazamos la A y a
    $stringcadena = str_replace(
    array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
    array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
    $stringcadena
    );

    //Reemplazamos la E y e
    $stringcadena = str_replace(
    array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
    array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
    $stringcadena );

    //Reemplazamos la I y i
    $stringcadena = str_replace(
    array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
    array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
    $stringcadena );

    //Reemplazamos la O y o
    $stringcadena = str_replace(
    array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
    array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
    $stringcadena );

    //Reemplazamos la U y u
    $stringcadena = str_replace(
    array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
    array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
    $stringcadena );

    //Reemplazamos la N, n, C y c
    $stringcadena = str_replace(
    array('Ñ', 'ñ', 'Ç', 'ç',',','.',';',':'),
    array('N', 'n', 'C', 'c','','','',''),
    $stringcadena
    );
    return $stringcadena;
}

   //Funcion para generar contraseña de 10 caracteres
   function passGenerador($lenght = 10)
   { 
     $pass = "";
     $longitudPass=$lenght;
     //Genera un password incluyendo todos estos caracteres para registro de usuarios 
     //Generarle una constraseña de forma automatica que sera enviada por correo luego el usuario la cambia en su perfil
     $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
     $longitudCadena=strlen($cadena);

     for($i=1; $i<=$longitudPass; $i++){
         //Funcion rand numeros aleatorios
         $pos = rand(0,$longitudCadena-1);
         //Funcion substr => devuelve caracteres de la cadena, comenzando en la posición especificada y de la longitud especificada.
         $pass .= substr($cadena,$pos,1);
     }
     return $pass;
   } 

   //Funcion para Generar un TOKEN
   function token($length = 32){
    if(!isset($length) || intval($length) <= 8 ){
      $length = 32;
    }
    if (function_exists('random_bytes')) {
        return bin2hex(random_bytes($length));
    }
    if (function_exists('mcrypt_create_iv')) {
        return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
    }
    if (function_exists('openssl_random_pseudo_bytes')) {
        return bin2hex(openssl_random_pseudo_bytes($length));
    }
}

   //Funcion para darle valor monetarios depende el PAIS 
   function formatoMoney($cantidad){
       //2 DECIMALES, SPD".", SPM","
       $cantidad = number_format($cantidad,2,SPD,SPM);
       return $cantidad;
   }

   
   //token para consumir  la api de paypal
   function getTokenPaypal(){

    //curl es una libreria que permite realizar peticiones HTTP con el objetivo de transferir informacion con sintaxis de url.  permite armar un script que literalmente se comporte como un navegador para asi realizar una peticion a otro servidor remoto.


     $payLogin = curl_init(URLPAYPAL."/v1/oauth2/token"); //inicializamos la sesion de curl, como parametro enviamos la ruta a la que nos vamos a conectar que sera la ruta de la api de paypal.

     curl_setopt($payLogin, CURLOPT_SSL_VERIFYPEER, FALSE); // El segundo parametro verifica el certificado SSL en la conexion
     curl_setopt($payLogin, CURLOPT_RETURNTRANSFER,TRUE); //retorna infomacion
     //ENVIAMOS LOS DATOS DEL LOGIN ES DECIR EL IDCLIENTE Y LA CONTRASEÑA
     curl_setopt($payLogin, CURLOPT_USERPWD, IDCLIENTE.":".SECRET);
     curl_setopt($payLogin, CURLOPT_POSTFIELDS, "grant_type=client_credentials"); //segundo parametro para enviar datos en el body enviando el granttype y las credenciales.

     //ejecute la configuracion
     $result = curl_exec($payLogin); //ejecuta toda la configuracion por medio de la variable paylogin

     //validacion para capturar los posibles error que vayamos a tener
     $err = curl_error($payLogin);

     //cerramos la session de curl enviando como parametro la variable de la session de ruta.
     curl_close($payLogin);
     if($err){
         $request = "CURL Error #:" .$err; //retornamos el error que nos da
     }else{
         //de lo contrario convertimos a un objeto todo el formato json 
         $objData = json_decode($result);
         //desde el objeto nos dirigimos al token con la flecha "->"
         $request = $objData->access_token;

     }
     return $request; //obtenemos el obten
    
   }
   
   //funcion donde indicamos que va hacer una conexion de tipo get a la api de paypal, donde recibimos como parametro la ruta y content que valor por defecto sera null
   function CurlConnectionGet($stringruta, $stringcontentType = null, $stringtoken){

      //validacion if ternario
      //si este parametro es diferente de null entonces va a tomar el valor que estamos enviando caso contrario sera "application/x-www-form-urlencoded"
      $stringcontentType = $stringcontentType != null ? $stringcontentType : "application/x-www-form-urlencoded";

      //validacion donde quiere decir que si estamos enviando el token
      if($stringtoken != null){
         //array header donde envianmos el token enviado
        $arrHeader =  array('Content-Type:'.$stringcontentType,
        'Authorization: Bearer '.$stringtoken);
      }else{
        $arrHeader =  array('Content-Type:'.$stringcontentType);
      }
      
      
      //inciilizamos la sesion de la ruta con curl
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $stringruta); //concatenamos a la url la ruta que estamos enviando.
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      //ENVIAMOS EL ARRAY DE LOS HEADERS DEL TOKEN
      curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
      $result = curl_exec($ch);
      $err = curl_error($ch);
      //cerramos la conexion 
      curl_close($ch);
      
      //validacion
      if($err){
        $request = "CURL Error #:" .$err; //retornamos el error que nos da
      }else{
        //de lo contrario convertimos a un objeto todo el formato json 
        $request = json_decode($result);
      }
      return $request; //obtenemos el obten

   }


  //metodo post para la api de paypal
   function CurlConnectionPost($stringruta, $stringcontentType = null, $stringtoken){

    //validacion if ternario
    //si este parametro es diferente de null entonces va a tomar el valor que estamos enviando caso contrario sera "application/x-www-form-urlencoded"
    $stringcontentType = $stringcontentType != null ? $stringcontentType : "application/x-www-form-urlencoded";

    //validacion donde quiere decir que si estamos enviando el token
    if($stringtoken != null){
       //array header donde envianmos el token enviado
      $arrHeader =  array('Content-Type:'.$stringcontentType,
      'Authorization: Bearer '.$stringtoken);
    }else{
      $arrHeader =  array('Content-Type:'.$stringcontentType);
    }
    
    
    //inciilizamos la sesion de la ruta con curl
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $stringruta); //concatenamos a la url la ruta que estamos enviando.
    
    //hace peticiones de tipo post
    curl_setopt($ch, CURLOPT_POST, TRUE);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    //ENVIAMOS EL ARRAY DE LOS HEA DERS DEL TOKEN
    curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
    $result = curl_exec($ch);
    $err = curl_error($ch);
    //cerramos la conexion 
    curl_close($ch);
    
    //validacion
    if($err){
      $request = "CURL Error #:" .$err; //retornamos el error que nos da
    }else{
      //de lo contrario convertimos a un objeto todo el formato json 
      $request = json_decode($result);
    }
    return $request; //obtenemos el obten

 }
 
?>