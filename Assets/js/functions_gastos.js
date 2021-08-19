var tableGastos;

document.addEventListener('DOMContentLoaded', function(){
	
	tableGastos = $('#tableGastos').DataTable({ 
		"aProcessing":true,
		"aServerside":true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" 
		},
		"ajax":{
			"url": " "+base_url+"/Gastos/getGastos",
		"dataSrc":""
		},
		"columns":[
			{"data":"codigo"},
			{"data":"nombre"},
			{"data":"precio"},
			{"data":"fecha"},
            {"data":"nombrerol"},
            {"data":"options"}
		],
		'dom': 'lBfrtip',
		'buttons': [
			 {
				"extend": "excelHtml5", 
				"text": "<i class='fas fa-file-excel'></i> Excel",
				"titleAttr": "Exportar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    "columns" : [0,1,2,3,4]
                }
			 },{
				"extend": "pdfHtml5",
				"text": "<i class='fas fa-file-pdf'></i> PDF",
				"titleAttr": "Exportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    "columns" : [0,1,2,3,4]
                }
			 }
		],
		"responsieve":"true",
		"bDestroy": true,
		"iDisplayLength": 10, 
		"order":[[0,"asc"]] 

	});


 //Nuevo Gasto
 var formGasto = document.querySelector('#formGasto');

 formGasto.onsubmit = function(e){
     e.preventDefault();
     var strNombre = document.querySelector('#txtNombre').value;
     var intPrecio = document.querySelector('#txtPrecio').value;
     var strFecha = document.querySelector('#txtFecha').value;
     var intTipousuario = document.querySelector('#listRolid').value;


     if(strNombre == '' || intPrecio == '' || strFecha == ''  || intTipousuario == ''){
         swal("Atencion", "Todos los campos son obligatorios.", "error");
         return false;
     }

     var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP'); 
     var ajaxUrl = base_url+'/Gastos/setGastos'; 
     var formData = new FormData(formGasto); 
     request.open("POST",ajaxUrl,true);
     request.send(formData); 

     request.onreadystatechange = function(){
         if(request.readyState == 4 && request.status == 200) { 
             var objData = JSON.parse(request.responseText);
             if(objData.status){ 
                 $('#modalFormGasto').modal("hide"); 
                 formGasto.reset();
                 swal("Gastos", objData.msg,"success");
                 tableGastos.ajax.reload();
             }else {
                 swal("Error", objData.msg, "error"); 
             }
         }
     }
 }
}, false);

//FUNCIONES QUE SE EJECUTAN AL MOMENTO DE ABRIR EL MODAL
window.addEventListener("load",function(){
	setTimeout(() => { 
   fntRoles();
  }, 500);
},false);


function fntRoles(){
    var ajaxUrl = base_url+'/Roles/getSelectRoles';
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#listRolid').innerHTML = request.responseText;
            document.querySelector('#listRolid').value = 1;
            $('#listRolid').selectpicker('render');
        }
    }
}


function openModal(){

	document.querySelector('#idGasto').value ="";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister"); //nos dirigimos al elemento con queryselect, con classlist reemplazamos las clases
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary"); //reemplazamos las clases de los botones	
	document.querySelector('#btnText').innerHTML ="Guardar";//nos referimos al btntext del id del spam
	document.querySelector('#titleModal').innerHTML ="Nuevo Gasto";//Nos referimos al titulo con innerhtml nuevo Usuario
	document.querySelector('#formGasto').reset();


     $('#modalFormGasto').modal('show'); 


}