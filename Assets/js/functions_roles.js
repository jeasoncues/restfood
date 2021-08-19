/*!
 * Creamos una variable tableRoles , luego colocamos una inscripcion para agregar un evento al momento que se abra el archivo
 * agregamos un documento para que al momento que se que cargue muestre la funcion
 * luego en formato json enviamos el lenguaje español, el id de la tabla, las columnas con sus nombres, que ordene de forma descende
 * mostramos los 100 primos registros con iDisplay
 * ================================*/
var tableRoles;
document.addEventListener('DOMContentLoaded', function(){

	tableRoles = $('#tableRoles').DataTable({ /*ID de la tabla*/
		"aProcessing":true,
		"aServerside":true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" /*Idioma de visualizacion*/
		},
		"ajax":{
			"url": " "+base_url+"/Roles/getRoles",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
		"dataSrc":""
		},
		"columns":[/* Campos de la base de datos*/
			{"data":"idrol"},
			{"data":"nombrerol"},
			{"data":"descripcion"},
			{"data":"status"},
			{"data":"options"}
		],
		"responsieve":"true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order":[[0,"asc"]] /*Ordenar de forma ascndente*/

	});
});

/*Nuevo Rol para capturar los datos desde el formulario NUEVO enviandolo por AJAX , utilizamos JAVASCRIPT PURO
		como es un id el formRol se envia con "#"
		*/
		var formRol = document.querySelector("#formRol");
		formRol.onsubmit = function(e) {
			e.preventDefault(); /* Previene a que se recargue la pagina*/
			
			var intIdRol = document.querySelector('#idRol').value;
			/*Hace referencia a las cajas de texto ('#txtnombre') y el value captura el valor que esta escribiendo ahi*/
			var strNombre = document.querySelector('#txtnombre').value;
			var strDescripcion = document.querySelector('#txtdescripcion').value;
			var intStatus = document.querySelector('#listStatus').value;
			
			/*validacion si las variables son vacias muestra la alerta de error*/
			if(strNombre  == '' || strDescripcion == '' || intStatus == '')
			{
				swal("Atencion", "Todos los campos son obligatorios.", "error");
				return false; /* Detiene el proceso*/
			}

			/* Validacion con un fin simplificado para XMLHttp para crear si estamos en google chrome
			 de lo contrario new Active si estamos en internet explore edge*/
			 var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = base_url+'/Roles/setRol';


			
			var formData = new FormData(formRol); /*Crea un objeto*/
			request.open("POST",ajaxUrl,true); /*Envia datos con el metodo POST por la variable ajaxUrl*/
			request.send(formData); /*Envia los datos del formulario con send*/
			request.onreadystatechange = function(){


				/*Obtenemos la informacion*/
				if(request.readyState == 4 && request.status == 200) {
					
					//Convertimos el formato JSON a un objeto en javascript
					var objData = JSON.parse(request.responseText);

					if(objData.status)
					{   
						//Cerramos el modal por medio de modal hide
						$('#modalFormRol').modal("hide");
						formRol.reset(); //Limpiar los campos
						swal("Roles de usuario", objData.msg ,"success"); //Libreria swal enviando mensaje con "msg" depende el texto
						tableRoles.ajax.reload();

					}else{//Si no es verdadero
						swal("Error", objData.msg ,"Error"); //Mensaje de error
					}
				}
			}

		}





$('#tableRoles').DataTable();

/*!
 * Funcion openModal para que se abra el boton nuevo de roles, show==> muestra aplicamos jquery de boostrap
 * ================================*/

 function openModal(){

	document.querySelector('#idRol').value ="";// el id del input en modalRoles y le enviamos un valor vacio
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister"); //nos dirigimos al elemento con queryselect, con classlist reemplazamos las clases
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary"); //reemplazamos las clases de los botones	
	document.querySelector('#btnText').innerHTML ="Guardar";//nos referimos al btntext del id del spam
	document.querySelector('#titleModal').innerHTML ="Nuevo Rol";//Nos referimos al titulo con innerhtml nuevo rol
	document.querySelector('#formRol').reset();//limpiar todos los campos con reset


     $('#modalFormRol').modal('show'); //muestra el modal con el id "modalformrol"
 } 
 
 
 window.addEventListener("load", function() {
    setTimeout(() => { 
	/*
		fntEditRol();
		fntDelRol();//Ejecuta la funcion*/

    }, 500);
  }, false);
  
 function fntEditRol(idrol){

   
            //Cambiamos el formato de la interfaz editar rol
            document.querySelector('#titleModal').innerHTML ="Actualizar Rol";
            document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate"); //nos dirigimos al elemento con queryselect, con classlist reemplazamos las clases
            document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info"); //reemplazamos las clases de los botones	
            document.querySelector('#btnText').innerHTML ="Actualizar";//nos referimos al btntext del id del spam
			
			
			//Obtener datos  con AJAX
			var idrol = idrol;
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP'); //validamos si estamos en un navegador chrome o firefox de lo contrario en internetexplores con microsfot
			var ajaxUrl = base_url+'/Roles/getRol/'+idrol; //devuelve la ruta y concatenamos el control roles, el metodo y el id
			request.open("GET",ajaxUrl,true);//enviamos como parametro el metodo GET que es por la cual obtendremos el valor
			request.send(); //enviar la peticion

			//ahora request va a obtener la respuesta
			request.onreadystatechange = function(){
				if(request.readyState == 4 && request.status == 200){ //quiere decir que si llego la peticion y respuesta es OK con swal allert

					//convertimos a un objeto la respuesta 
					//con json.parse parseamos lo que viene en el parametro
					var objData = JSON.parse(request.responseText);
					
					//si el objeto es verdadero 
					if(objData.status)
					{   
						//con .value seteamos el valor enviado que tenga el objeto
						document.querySelector("#idRol").value = objData.data.idrol; 
						document.querySelector("#txtnombre").value = objData.data.nombrerol;
						document.querySelector("#txtdescripcion").value = objData.data.descripcion;

						
						//validacion, si en el status es igual a 1
						if(objData.data.status == 1)
						{
							//selected -> deja seleccionado por defecto activo
							var optionSelect = '<option value="1" selected class="notblock">Activo</option>';

						}else { //si el status no es 1 coloca inactivo
							var optionSelect = '<option value="2" selected class="notblock">Inactivo</option>';
						}

						var htmlselect = `${optionSelect}
											<option value="1">Activo</option>
											<option value="2">Inactivo</option>
											`; 

					   //en la variable html colocamos el elemto con queryselector "liststatus" ese elemento corresonde a la lista de activo y inactivo de status
					   document.querySelector("#listStatus").innerHTML = htmlselect;
                       $('#modalFormRol').modal('show');
			
					}else { //si es falso muestra el mensaje error y lo del item msg
						swal("Error", objData.msg , "error");
					}

				}
			}
}


function fntDelRol(idrol){

			var idrol = idrol;

			swal({
				title: "Eliminar rol",
				text: "¿Realmente quiere eliminar el rol?",
				type: "warning",
				showCancelButton: true,
				confirmButtonText: "Si, eliminar!",
				cancelButtontext: "No, cancelar!",
				closeOnConfirm: false,
				closeOnCancel: true
			}, function(isConfirm){

				if(isConfirm){
					var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
					var ajaxUrl = base_url+'/Roles/delRol/';
					var strData = "idrol="+idrol;
					request.open("POST",ajaxUrl,true);
					request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					request.send(strData);
					request.onreadystatechange = function(){
						if(request.readyState = 4 && request.status == 200){
							var objData = JSON.parse(request.responseText);
							if(objData.status){
								swal("Eliminar!", objData.msg, "success");
								tableRoles.ajax.reload(function(){
									fntEditRol();
									fntDelRol();
								});
							} else{ 
							swal("Atencion!", objData.msg, "error");
							}
						}
					}
				}
			});
}

function fntPermisos(idrol){
	var idrol = idrol;

	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Permisos/getPermisosRol/'+idrol;
	var strData = "idrol="+idrol;
	request.open("GET",ajaxUrl,true);
	request.send(); 

	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			document.querySelector('#contentAjax').innerHTML = request.responseText; //le mandamos a su html la respuesta del permiso controlador a ese id contentajax
			$('.modalPermisos').modal('show');
			//agregamos evento submit para la funcion fntsavepermisos
			document.querySelector('#formPermisos').addEventListener('submit',fntSavePermisos,false);
		}
	}				

}


function fntSavePermisos(evnet){
    evnet.preventDefault();
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Permisos/setPermisos'; 
    var formElement = document.querySelector("#formPermisos");
    var formData = new FormData(formElement);
    request.open("POST",ajaxUrl,true);
    request.send(formData);

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                swal("Permisos de usuario", objData.msg ,"success");
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
    
}
