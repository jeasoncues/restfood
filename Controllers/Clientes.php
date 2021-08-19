<?php
 
 class Clientes extends Controllers{
    public function __construct()
    {   
        //Invocando al constuctor del controlador que hereda con parent EJECUTANDO
        parent::__construct();

        //Restringuir acceso para usuarios que no estan logeados
        //Validacion para el login para que al momento de escribir en la url no se pueda acceder a inicio sin estar logeado
        session_start();
        if(empty($_SESSION['login']))//si no existe la variable de sesion osea si el id no es true no accedera de lo contrario si existe continua todoe el proceso
        {
            header('Location: '.base_url().'/login');
        }

        getPermisos(3); //funcion en el helpers
    }
    
    //Metodo
    public function Clientes()
    {   
        //Validacion en caso no tenga permisos para entrar al modulo clientes.
        if(empty($_SESSION['permisosMod']['r'])){
            header("Location:".base_url().'/dashboard');
        }
        //Utilizamos el metodo getView enviando como parametro el this y la vista que queremos mostrar "home"
        //Array de la data
        $data['page_tag'] = "Clientes";
        $data['page_title'] = "Clientes";
        $data['page_name'] = "clientes";
        $this->views->getView($this,"clientes",$data);//llamado de vista
    }

    public function setClientes()
    {
        if($_POST){
			if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombres']) || empty($_POST['txtApellidos']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['txtNit']) || empty($_POST['txtNombreFiscal']) || empty($_POST['txtDirFiscal']) )
			{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{ 
				$idUsuario = intval($_POST['idUsuario']);
				$strIdentificacion = strClean($_POST['txtIdentificacion']);
				$strNombre = ucwords(strClean($_POST['txtNombres']));
				$strApellido = ucwords(strClean($_POST['txtApellidos']));
				$intTelefono = intval(strClean($_POST['txtTelefono']));
				$strEmail = strtolower(strClean($_POST['txtEmail']));
				$strNit = strClean($_POST['txtNit']);
				$strNomFiscal = strClean($_POST['txtNombreFiscal']);
				$strDirFiscal = strClean($_POST['txtDirFiscal']);
				$intTipoId = 8;

				if($idUsuario == 0)
				{
					$option = 1;
					$strPassword =  empty($_POST['txtPassword']) ? passGenerador() : $_POST['txtPassword'];
					$strPasswordEncript = hash("SHA256",$strPassword);
					$request_user = $this->model->insertCliente($strIdentificacion,
																		$strNombre, 
																		$strApellido, 
																		$intTelefono, 
																		$strEmail,
																		$strPasswordEncript,
																		$intTipoId, 
																		$strNit,
																		$strNomFiscal,
																		$strDirFiscal );
				}else{
					/*$option = 2;
					$strPassword =  empty($_POST['txtPassword']) ? "" : hash("SHA256",$_POST['txtPassword']);
					$request_user = $this->model->updateCliente($idUsuario,
																$strIdentificacion, 
																$strNombre,
																$strApellido, 
																$intTelefono, 
																$strEmail,
																$strPassword, 
																$strNit,
																$strNomFiscal, 
																$strDirFiscal);*/
				}

				if($request_user > 0 )
				{
					if($option == 1){
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                        $nombreUsuario = $strNombre.' '.$strApellido;
						$dataUsuario = array('nombreUsuario' => $nombreUsuario,
												 'email' => $strEmail,
												 'password' => $strPassword,
												'asunto' => 'Bienvenido a Donattos Restaurante');
						$sendEmail = sendEmail($dataUsuario,'email_bienvenida');

					}else{
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}else if($request_user == 'exist'){
					$arrResponse = array('status' => false, 'msg' => '¡Atención! el email o la identificación ya existe, ingrese otro.');		
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();

	}
	
	public function getClientes()
	{
		$arrData = $this->model->selectClientes();//invocamos al metodo del modeloClientes
			
			//Recorre hasta que termine la cantidad de elemtnos del array, y incrementa
			for ($i=0; $i < count($arrData); $i++){

				//Variables para los botones
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';

				//Validacion para los botones respecto a los permisos 
				if($_SESSION['permisosMod']['r']){
					$btnView = '<button class="btn btn-info btn-sm btnViewCliente" onClick="fntViewCliente('.$arrData[$i]['idpersona'].')" title="Ver Cliente"><i class="far fa-eye"></i></button>';

				}

				if($_SESSION['permisosMod']['u']){
					
					$btnEdit = '<button class="btn btn-secondary btn-sm btnEditCliente" onClick="fntEditCliente('.$arrData[$i]['idpersona'].')" title="Editar Cliente"><i class="fas fa-pencil-alt"></i></button>';
				}

				if($_SESSION['permisosMod']['d']){
					$btnDelete = '<button class="btn btn-danger btn-sm btnDelCliente" onClick="fntDelCliente('.$arrData[$i]['idpersona'].')" title="Eliminar Cliente"><i class="fas fa-trash-alt"></i></button>';
				}
			
				//Botones, agregamos el onclick con su funcion para que al momento de cambiar de paginacion no presente incovenientes, CONCATENAMOS LAS VARIABLES DE LOS BOTONES
				$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
	}

 }


?>