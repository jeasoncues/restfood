var tableUsuarios;


//Al momento que se carga la pagina html va agregar los eventos que configuremos.
document.addEventListener('DOMContentLoaded', function(){
	
	tableUsuarios = $('#tableUsuarios').DataTable({ /*ID de la tabla*/
		"aProcessing":true,
		"aServerside":true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" /*Idioma de visualizacion*/
		},
		"ajax":{
			"url": " "+base_url+"/Usuarios/getUsuarios",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
		"dataSrc":""
		},
		"columns":[/* Campos de la base de datos*/
			{"data":"idpersona"},
			{"data":"nombres"},
			{"data":"apellidos"},
			{"data":"email_user"},
			{"data":"telefono"},
			{"data":"nombrerol"},
			{"data":"status"},
			{"data":"options"}
		],
		'dom': 'lBfrtip',
		'buttons': [
			 {
				"extend": "excelHtml5", /* Tipo de Botton */
				"text": "<i class='fas fa-file-excel'></i> Excel",/* Icono y texto*/
				"titleAttr": "Exportar a Excel",/* Posicionar el puntero de mouse */
				"className": "btn btn-success",/* clase y estilo del boton */
				"exportOptions": {
                    //indicamos las columnas que vamos a exportar
                    "columns": [0, 1, 2, 3, 4, 5, 6]
                }
			 },{
				"extend": "pdfHtml5",
				"text": "<i class='fas fa-file-pdf'></i> PDF",
				"titleAttr": "Exportar a PDF",
				"className": "btn btn-danger",
				"exportOptions": {
                    //indicamos las columnas que vamos a exportar
                    "columns": [0, 1, 2, 3, 4, 5, 6]
                }
			 },{
				"extend": "csvHtml5",
				"text": "<i class='fas fa-file-csv'></i> CSV",
				"titleAttr": "Exportar a CSV",
				"className": "btn btn-secondary",
				"exportOptions": {
                    //indicamos las columnas que vamos a exportar
                    "columns": [0, 1, 2, 3, 4, 5, 6]
                }
			 }
		],
		"responsieve":"true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order":[[0,"asc"]] /*Ordenar de forma Desendente*/

	});
    

    //Nuevo Usuario
	var formUsuario = document.querySelector('#formUsuario');//hacemos referencia el id del formulario
	//colocamos el evento del formusuario, onsubmit => activamos evento que va hacer igual a la funcion
	formUsuario.onsubmit = function(e){
		e.preventDefault();//evita a que se recarge la pagina al momento que damos click en guardar
		//Hacemos referencia a los campos del formulario
		var strIdentificacion = document.querySelector('#txtIdentificacion').value;
		var strNombre = document.querySelector('#txtNombres').value;
		var strApellido = document.querySelector('#txtApellidos').value;
		var intTelefono = document.querySelector('#txtTelefono').value;
		var strEmail = document.querySelector('#txtEmail').value;
		var intTipousuario = document.querySelector('#listRolid').value;
		var strPassword = document.querySelector('#txtPassword').value;

		//Validacion de los datos a ingresar y mostrar con swal una alerta
		//No validamos contraseña ya que si no la escribe ingresaremos una automaticamente
		if(strIdentificacion == ''  || strNombre == '' || strApellido == '' || intTelefono == '' || strEmail == '' || intTipousuario == ''){
			swal("Atencion", "Todos los campos son obligatorios.", "error");
			return false;
		}

		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP'); //Navegador
		var ajaxUrl = base_url+'/Usuarios/setUsuarios'; //Enviamos la ruta mas el metodo set del controlador usuarios
		var formData = new FormData(formUsuario); //enviamos como parametro el selector id formUsuario
		request.open("POST",ajaxUrl,true); /*Envia datos con el metodo POST por la variable ajaxUrl*/
		request.send(formData); /*Envia los datos del formulario con send*/

		request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200) { 
				var objData = JSON.parse(request.responseText);
				if(objData.status){ //si se guardo el registro
					$('#modalFormUsuario').modal("hide"); //.modal hide ocultamos el modalformusuario
					formUsuario.reset();//reseteamos los campos
					swal("Usuarios", objData.msg,"success");//mostramos alerta y accedemos al msg con objdata.msg
					tableUsuarios.ajax.reload();
				}else {
					swal("Error", objData.msg, "error"); //de lo contrario si status es falso muestra el mensaje con alerta
				}
			}
		}
	}
}, false);


//Ejecutar funcion al momento de abrir el modal
window.addEventListener("load",function(){
	setTimeout(() => { 
   fntRolesUsuario();//ejecutamos la funcion 
   //YA NO ES NECESARIO YA QUE SE CARGA CON EL ONCLICK DESDE EL CONTROLADOR USUARIO
   /*fntViewUsuario();
   fntEditUsuario();
   fntDelUsuario();*/
  }, 500);
},false);



function fntRolesUsuario(){
	//peticion ajax para obtener los valores de usuario
	var ajaxUrl = base_url+'/Roles/getSelectRoles';
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	request.open("GET",ajaxUrl,true); //abrimos peticion
	request.send();//enviamos peticion

	//Obtenemos los resultados de la peticion del AJAX
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){ //si se hizo la peticion y devuelve info
			document.querySelector('#listRolid').innerHTML = request.responseText;//corresponde al listado, con innerhtml colocamos lo que viene en los option de los models
			document.querySelector('#listRolid').value = 1; //seleccionamos con value el primer option
			$('#listRolid').selectpicker('render');//Actualizamos el select para que se muestren los registros
		}
	}
}



//Funcion para el ver Usuarios recibe como parametro el idpersona 
function fntViewUsuario(idpersona){
  
		   var idpersona = idpersona;
		   var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		   var ajaxUrl = base_url+'/Usuarios/getUsuario/'+idpersona;
		   request.open("GET",ajaxUrl, true);
		   request.send();

		   request.onreadystatechange = function(){
			   if(request.readyState == 4 && request.status == 200){ //si el status se hizo la peticion devuelve informacion
				var objData = JSON.parse(request.responseText);//convierte a un objeto el array obtenido en json

				   if(objData.status) //si el status es verdadero
				   {
					   var estadoUsuario = objData.data.status == 1 ? //accedemos a los objetos luego a dato luego a status si es igual a 1 vamos a obtener lo de abajo
					   '<span class="badge badge-success">Activo</span>':
					   '<span class="badge badge-danger">Inactivo</span>';

					   document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
					   document.querySelector("#celNombre").innerHTML = objData.data.nombres;
					   document.querySelector("#celApellido").innerHTML = objData.data.apellidos;
					   document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
					   document.querySelector("#celEmail").innerHTML = objData.data.email_user;
					   document.querySelector("#celTipoUsuario").innerHTML = objData.data.nombrerol;
					   document.querySelector("#celEstado").innerHTML = estadoUsuario;
					   document.querySelector("#celFechaRegistro").innerHTML = objData.data.FechaRegistro;
					   $('#modalViewUser').modal('show');//Mostramos el modal
				   }else{
					   swal("Error", objData.msg , "error");
				   }
			   }
		   }

}



//Edita Usuario
function fntEditUsuario(idpersona){
	
			//Apariencia del modal editar
			document.querySelector('#titleModal').innerHTML = "Actualizar Usuario";
			document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
			document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
			document.querySelector('#btnText').innerHTML = "Actualizar";


			var idpersona = idpersona; //colocamos la variable al parametro que recibimos
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = base_url+'/Usuarios/getUsuario/'+idpersona;
			request.open("GET",ajaxUrl, true);//open abre la conexion
			request.send();
 
			request.onreadystatechange = function(){

				if(request.readyState == 4 && request.status == 200){
					var objData = JSON.parse(request.responseText);

					if(objData.status)
					{   
						//a la caja de texto le colocamos con el objdata.data.idpersona lo que trae de la base de datos
						document.querySelector('#idUsuario').value = objData.data.idpersona; 
						document.querySelector('#txtIdentificacion').value = objData.data.identificacion; 
						document.querySelector('#txtNombres').value = objData.data.nombres;
						document.querySelector('#txtApellidos').value = objData.data.apellidos;
						document.querySelector('#txtTelefono').value = objData.data.telefono;
						document.querySelector('#txtEmail').value = objData.data.email_user;
						document.querySelector('#listRolid').value = objData.data.idrol;
						//con JQUERY seleccionamos el tipo de usuario le colocamos render para renderice los option y le coloque el valor de la bd
						$('#listRolid').selectpicker('render');

						//Condiciones para el status para que renderice y coloque el valor de la bd
						if(objData.data.status ==1) 
						{
							document.querySelector('#listStatus').value = 1;
						}else{
							document.querySelector('#listStatus').value = 2;
						}
						$('#listStatus').selectpicker('render');
					}
				}
				
				$('#modalFormUsuario').modal('show');

			}

 }
 
 //Eliminar Usuario
 function fntDelUsuario(idpersona){
	
			var idUsuario = idpersona;
			
			//Alerta swal
			swal({
				title: "Eliminar Usuario",
				text: "¿Realmente quiere eliminar el usuario?",
				type: "warning",
				showCancelButton: true,
				confirmButtonText: "Si, eliminar!",
				cancelButtontext: "No, cancelar!",
				closeOnConfirm: false,
				closeOnCancel: true
			}, function(isConfirm){

				if(isConfirm){
					var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
					var ajaxUrl = base_url+'/Usuarios/delUsuario/';
					var strData = "idUsuario="+idUsuario;
					request.open("POST",ajaxUrl,true);
					request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					request.send(strData);
					request.onreadystatechange = function(){
						if(request.readyState = 4 && request.status == 200){
							var objData = JSON.parse(request.responseText);
							if(objData.status){
								swal("Eliminar!", objData.msg, "success");//tipo de alerta success
								tableRoles.ajax.reload(function(){ //recargamos las funciones
									fntRolesUsuario();
									fntViewUsuario();
									fntEditUsuario();
									fntDelUsuario();
								});
							} else{ 
							swal("Atencion!", objData.msg, "error");
							}
						}
					}
				}
			});

}


//Abrir el Modal nuevo usuario
function openModal(){

	document.querySelector('#idUsuario').value ="";// el id del input en modalUsuarios y le enviamos un valor vacio
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister"); //nos dirigimos al elemento con queryselect, con classlist reemplazamos las clases
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary"); //reemplazamos las clases de los botones	
	document.querySelector('#btnText').innerHTML ="Guardar";//nos referimos al btntext del id del spam
	document.querySelector('#titleModal').innerHTML ="Nuevo Usuario";//Nos referimos al titulo con innerhtml nuevo Usuario
	document.querySelector('#formUsuario').reset();//limpiar todos los campos con reset del formulario usuario


     $('#modalFormUsuario').modal('show'); //muestra el modal con el id "modalformusuario"
 } 

