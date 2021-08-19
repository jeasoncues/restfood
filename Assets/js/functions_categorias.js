var tableCategorias;
//cargamos eventos al momentos de que se abra el documento
document.addEventListener('DOMContentLoaded', function(){
    
    //MOSTRAR TABLA DE CATEGORIAS
    tableCategorias = $('#tableCategorias').DataTable({
		"aProcessing":true,
		"aServerside":true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" 
		},
		"ajax":{
			"url": " "+base_url+"/Categorias/getCategorias",
		"dataSrc":""
		},
		"columns":[
			{"data":"idcategoria"},
			{"data":"nombre"},
			{"data":"descripcion"},
            {"data":"status"},
            {"data":"options"}
		],
		'dom': 'lBfrtip',
		'buttons': [
			 {
				"extend": "excelHtml5", 
				"text": "<i class='fas fa-file-excel'></i> Excel",
				"titleAttr": "Exportar a Excel",
				"className": "btn btn-success"
			 },{
				"extend": "pdfHtml5",
				"text": "<i class='fas fa-file-pdf'></i> PDF",
				"titleAttr": "Exportar a PDF",
				"className": "btn btn-danger"
			 }
		],
		"responsieve":"true",
		"bDestroy": true,
		"iDisplayLength": 10, 
		"order":[[0,"asc"]] 

	})

    if(document.querySelector("#foto")){  //validacion para saber si existe el id foto si existe ejecuta todo el script
        var foto = document.querySelector("#foto"); //variable foto que hacer referencia al id foto
        foto.onchange = function(e) { //el evento onchange se ejecuta cuando cambia de valor del input 
            var uploadFoto = document.querySelector("#foto").value; //upload foto hace referencia al id y captura el valor
            var fileimg = document.querySelector("#foto").files;
            var nav = window.URL || window.webkitURL; //ruta de la imagen
            var contactAlert = document.querySelector('#form_alert');//id para alerta
            if(uploadFoto !=''){
                var type = fileimg[0].type; //captura el tipo de archivo que se carga
                var name = fileimg[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){ //contenedor de imagenes, si es diferente a estos formatos mostrara una alerta
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';
                    if(document.querySelector('#img')){
                        document.querySelector('#img').remove();//remueve en caso no sea un formato permitido
                    }
                    document.querySelector('.delPhoto').classList.add("notBlock");
                    foto.value="";
                    return false;
                }else{  //si es un formato permitido para la imagen
                        contactAlert.innerHTML='';
                        if(document.querySelector('#img')){ 
                            document.querySelector('#img').remove();
                        }
                        document.querySelector('.delPhoto').classList.remove("notBlock"); //remueve la clase notBlock y muestra la X para que la imagen se pueda eliminar
                        var objeto_url = nav.createObjectURL(this.files[0]); //nuevo objeto de la ruta del archivo seleccionado en la posicion 0
                        document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src="+objeto_url+">"; //hace referencia de la clase y en su html crea un nuevo elemento de img , en src se manda la ruta temporal que se creo 
                    }
            }else{
                alert("No selecciono foto"); //muestra en caso de que no se selecciono la foto 
                if(document.querySelector('#img')){
                    document.querySelector('#img').remove();
                }
            }
        }
    }
    
    //si existe el elemtno delPhoto que corresponde a la clase del span X 
    if(document.querySelector(".delPhoto")){
        var delPhoto = document.querySelector(".delPhoto"); //crea variable dirigiendose a la clase delphoto
        delPhoto.onclick = function(e) { //le agrega el evento onclick
            removePhoto();//ejecuta la funcion de remove
        }
    }


    //Envio de datos por AJAX
    //Nueva Categoria
    var formCategoria = document.querySelector("#formCategoria");
		formCategoria.onsubmit = function(e) {
			e.preventDefault(); /* Previene a que se recargue la pagina*/
			
			var intIdCategoria = document.querySelector('#idCategoria').value;
			/*Hace referencia a las cajas de texto ('#txtnombre') y el value captura el valor que esta escribiendo ahi*/
			var strNombre = document.querySelector('#txtnombre').value;
			var strDescripcion = document.querySelector('#txtdescripcion').value;
			var intStatus = document.querySelector('#listStatus').value;
			
            /*validacion si las variables son vacias muestra la alerta de error*/
            //la imagen no es obligatoria.
			if(strNombre  == '' || strDescripcion == '' || intStatus == '')
			{
				swal("Atencion", "Todos los campos son obligatorios.", "error");
				return false; /* Detiene el proceso*/
            }
            
			/* Validacion con un fin simplificado para XMLHttp para crear si estamos en google chrome
			 de lo contrario new Active si estamos en internet explore edge*/
			 var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = base_url+'/Categorias/setCategoria';


			
			var formData = new FormData(formCategoria); /*Crea un objeto*/
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
						$('#modalFormCategoria').modal("hide");
						formCategoria.reset(); //Limpiar los campos
                        swal("Categoria", objData.msg ,"success"); //Libreria swal enviando mensaje con "msg" depende el texto
                        removePhoto(); //para que la imagen se limpie.
						tableCategorias.ajax.reload();

					}else{//Si no es verdadero
						swal("Error", objData.msg ,"error"); //Mensaje de error
					}
				}
			}

		}

}, false);

//funcion para eliminar la foto de vista previa de la categoria
function removePhoto(){
    document.querySelector('#foto').value =""; //hace referencia al id foto y el valor lo pone en vacio porque elimina la foto de vista previa
    document.querySelector('.delPhoto').classList.add("notBlock"); //a la clase delPhoto le agrega la otra clase notblock para que se oculte
    document.querySelector('#img').remove(); //removemos del id img .
}


//Funcion para ver una categoria
function fntViewCategoria(idcategoria){
 
	var idcategoria =  idcategoria;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl =  base_url+'/Categorias/getCategoria/'+idcategoria;
	request.open("GET",ajaxUrl,true);
	request.send();

	request.onreadystatechange =  function(){
		if(request.readyState == 4 && request.status == 200){
			var objData = JSON.parse(request.responseText);
			if(objData.status)
			{   
				//si la variable estado del campo status de categoria es igual a 1 mostrara activo caso contrario si 2 inactivo.
				var estado = objData.data.status == 1 ? 
				'<span class="badge badge-success">Activo</span>' : 
				'<span class="badge badge-danger">Inactivo</span>';

				document.querySelector("#celId").innerHTML = objData.data.idcategoria;
				document.querySelector("#celNombre").innerHTML = objData.data.nombre;
				document.querySelector("#celDescripcion").innerHTML = objData.data.descripcion;
				document.querySelector("#celStatus").innerHTML = estado;
				//mostramos la ruta de la imagen
				document.querySelector("#celFoto").innerHTML = '<img src="'+objData.data.url_portada+'"></img>';
				$('#modalViewCategoria').modal('show');
			}else{
				swal("Error", objData.msg , "error");
			}
		}
	}
}


function openModal() {
    document.querySelector('#idCategoria').value="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Categoria";
    document.querySelector('#formCategoria').reset();
    $('#modalFormCategoria').modal('show');
}