<?php
 
 class Categorias extends Controllers{
     public function __construct()
     {
         parent::__construct();
         session_start();
         if(empty($_SESSION['login']))
         {
            header('Location: '.base_url.'/login'); 
         }
         getPermisos(12);
     }

     public function Categorias()
     {
         if(empty($_SESSION['permisosMod']['r'])){
             header('Location:'.base_url.'/dashboard');
         }
         $data['page_tag'] = "Categorias";
         $data['page_title'] = "Categorias";
         $data['page_name'] = "categorias";
         $this->views->getView($this,"categorias",$data);
     }    

     public function setCategoria(){
        
        //validamos si esque enviamos una peticion POST
        if($_POST){

            if(empty($_POST['txtnombre']) || empty($_POST['txtdescripcion']) || empty($_POST['listStatus']))
            {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            }else{

                $intIdCategoria = intval($_POST['idCategoria']);
                $strCategoria = strClean($_POST['txtnombre']);
                $strDescripcion = strClean($_POST['txtdescripcion']);
                $intStatus = intval($_POST['listStatus']);

                $ruta = strtolower(clear_cadena($strCategoria)); //convierte mayusculas a minusculas, clear deja sin tildes.
                $ruta = str_replace(" ","-",$ruta); //los nombres en espacios en blanco reemplaza por la variable ruta agregando un guion

                //variables para almacenar imagen
                $foto        = $_FILES['foto']; //Array general de la foto
                //elementos del array foto
                $nombre_foto = $foto['name']; //nos dirigimos al elemento name
                $type        = $foto['type']; //nos dirigimos al elemento type
                $url_temp    = $foto['tmp_name']; //nos dirigimos al elemento de la url temporal
                $imgPortada  = 'portada_categoria.png'; //foto por defecto

                if($nombre_foto != '' ){ //validacion para saber si estamos enviando una imagen
                    $imgPortada = 'img_'.md5(date('d-m-Y H:m:s')).'.jpg';//encriptamos con md5 la funcion date
                }
                

                if($intIdCategoria == 0) //si no vienen ningun id vamos a insertar la categoria
                {
                    //crear
                    $request_categoria = $this->model->insertarCategoria($strCategoria, $strDescripcion,$imgPortada, $ruta, $intStatus);
                    $option = 1; //variable option igual a 1 
 
                }else { //si lo contrario el id no es 0 queire decir que si trae el id 
                    //Actualizar
                    $request_categoria = $this->model->updateCategoria($intIdCategoria, $strCategoria, $strDescripcion, $ruta, $intStatus); //ennviamos id , y todo lo demas
                    $option = 2;
                }

                if($request_categoria > 0) //Si la respuesta es mayor a 0 si se inserto el registro devuelve el mensaje de abajo
                {   
                    if($option == 1){
                        $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
                        if($nombre_foto != ''){ //si estamos enviando una foto
                            uploadImage($foto,$imgPortada); //funcion uploadImage y enviamos como parametro el array de la variable foto y el img portada que corresponde al nombre de la imagen esta funcion estara en HELPERS.
                        }
                    }else { //option dos para actualizar 
                        $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
                    }
        
                }else if($request_categoria == 'exist'){ //Si el elemento existe muestra el mensaje de abajo
        
                    $arrResponse = array('status' => false, 'msg' => 'Atencion! La Categoria ya existe.');
        
                }else{ //De lo contrario si no devuelve los valores no se inserto
                    $arrResponse = array("status" =>false, "msg" => "No es posible almacenar los datos");
        
                }

            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE); 
        }
        die(); 

    }

    public function getCategorias()
    {
		$arrData = $this->model->selectCategorias();//invocamos al metodo del modeloCategorias
			
			//Recorre hasta que termine la cantidad de elemtnos del array, y incrementa
			for ($i=0; $i < count($arrData); $i++){

				//Variables para los botones
				$btnView = '';
				$btnEdit = '';
                $btnDelete = '';
                
                //validacion para el status
                if($arrData[$i]['status']==1)
				{
					$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
				}else {
					$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
				}
				//Validacion para los botones respecto a los permisos 
				if($_SESSION['permisosMod']['r']){ //permiso para lectura
					$btnView = '<button class="btn btn-info btn-sm btnViewCategoria" onClick="fntViewCategoria('.$arrData[$i]['idcategoria'].')" title="Ver Categoria"><i class="far fa-eye"></i></button>';

				}
				if($_SESSION['permisosMod']['u']){ //permiso de actualizar
					
					$btnEdit = '<button class="btn btn-secondary btn-sm btnEditCategoria" onClick="fntEditCategoria('.$arrData[$i]['idcategoria'].')" title="Editar Categoria"><i class="fas fa-pencil-alt"></i></button>';
				}
				if($_SESSION['permisosMod']['d']){ //permisos para eliminar
					$btnDelete = '<button class="btn btn-danger btn-sm btnDelCategoria" onClick="fntDelCategoria('.$arrData[$i]['idcategoria'].')" title="Eliminar Categoria"><i class="fas fa-trash-alt"></i></button>';
				}
			
				//Botones, agregamos el onclick con su funcion para que al momento de cambiar de paginacion no presente incovenientes, CONCATENAMOS LAS VARIABLES DE LOS BOTONES
				$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
    }
    
    
    public function getCategoria($intidcategoria)
    { 
        $intIdCategoria =  intval($intidcategoria); 

        if($intIdCategoria > 0) 
        {
            $arrData = $this->model->selectCategoria($intIdCategoria);
            if(empty($arrData))
            {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');

            }else{
                //funcion medica obtiene la ruta hasta el directorio assets concatenando el nombre que trae el array de la portada de la imagen.
                $arrData['url_portada'] = media().'/images/uploads/'.$arrData['portada'];
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
           
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE); //se convierte en array para el archivo JS
        }  
        die(); 
    }

    public function getSelectCategorias(){
        $htmlOptions = "";
        $arrData = $this->model->selectCategorias();
        //validacion para contar cuantos elementos tiene el array 
        if(count($arrData) > 0){ //si es mayor a 0 hace todo lo de abajo
            for ($i=0; $i < count($arrData); $i++){ //recorremos 
                if($arrData[$i]['status'] == 1){
                    //concatenamos el idcategoria y el nombre.
                    $htmlOptions .= '<option value="'.$arrData[$i]['idcategoria'].'">'.$arrData[$i]['nombre'].'</option>';
                }
            }
        }
        echo $htmlOptions;
        die();
    }


 }


?>