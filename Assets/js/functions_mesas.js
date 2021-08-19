var tableMesas;

document.addEventListener('DOMContentLoaded',function(){

    tableMesas = $('#tableMesas').DataTable({
        "aProcessing":true,
		"aServerside":true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" 
		},
		"ajax":{
			"url": " "+base_url+"/Mesas/getMesas",
		"dataSrc":""
		},
		"columns":[
			{"data":"idmesa"},
            {"data":"nombre"},
            {"data":"estado"},  
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
    
    //Validacion para la imagen
    if(document.querySelector("#foto")){
        var foto = document.querySelector("#foto");
        foto.onchange = function(e) {
            var uploadFoto =  document.querySelector("#foto").value;
            var fileimg = document.querySelector("#foto").files;
            var nav = window.URL || window.webkitURL; //ruta de la imagen
            var contactAlert = document.querySelector('#form_alert');
            if (uploadFoto != ''){
                var type = fileimg[0].type;
                var name = fileimg[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es valido.</p>';
                    if(document.querySelector('#img')){
                        document.querySelector('#img').remove(); //en caso no sea un formato permitdo lo elimina
                    }
                    document.querySelector('.delPhoto').classList.add("notBlock"); //al id delphoto le agregamos el id not block para que se oculte 
                    foto.value="";
                    return false;
                }else{
                    contactAlert.innerHTML='';
                    if(document.querySelector('#img')){
                        document.querySelector('#img').remove();
                    }
                    document.querySelector('.delPhoto').classList.remove("notBlock"); //muestra la x para eliminar imagen
                    var objeto_url = nav.createObjectURL(this.files[0]);
                    document.querySelector('.prevMesa div').innerHTML = "<img id='img' src="+objeto_url+">";
                }
            }else{
                alert("No selecciono foto");
                if(document.querySelector('#img')){
                    document.querySelector('#img').remove();
                }
            }
        }
    }

    //si existe el elemento delphoyo que corresponde a la clase del span x
    if(document.querySelector(".delPhoto")){
        var delPhoto = document.querySelector(".delPhoto");
        delPhoto.onclick = function(e){
            removePhoto(); //funcion 
        }
    }


    //Crear nueva Mesa
    var formMesa = document.querySelector("#formMesa");
        formMesa.onsubmit =  function(e){
            e.preventDefault(); //prevenimos a que se recargue la pagina

            var intIdMesa =  document.querySelector('#idMesa').value;
            var strMesa =  document.querySelector('#txtnombre').value;
            var intEstado =  document.querySelector('#listStatus').value;

            if(strMesa == ''){
                swal("Atencion", "El campo nombre es Obligatorio");
                return false;
            }
            
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Mesas/setMesas';
            
            var formData =  new FormData(formMesa);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange =  function(){

                if(request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);

                    if(objData.status){
                        $('#modalFormMesa').modal("hide");
                        formMesa.reset();
                        swal("Mesa", objData.msg, "success");
                        tableMesas.ajax.reload();
                        removePhoto();
                        
                    }else{
                        swal("Error", objData.msg, "error");
                    }
                }
            }

        }

}, false);

//Funcion para eliminar la foto de vista previa de la mesa
function removePhoto(){
    document.querySelector('#foto').value ="";
    document.querySelector('.delPhoto').classList.add("notBlock"); //agregamos la clase notblock para que se oculte
    document.querySelector('#img').remove(); //eliminamos el id img.
}




function openModal() {
    document.querySelector('#idMesa').value="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Mesa";
    document.querySelector('#formMesa').reset();
    $('#modalFormMesa').modal('show');
}