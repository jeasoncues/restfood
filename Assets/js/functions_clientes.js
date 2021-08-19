var tableClientes;

//Agrega eventos 
document.addEventListener('DOMContentLoaded', function(){

	tableClientes = $('#tableClientes').DataTable({
		"aProcessing":true,
		"aServerside":true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" 
		},
		"ajax":{
			"url": " "+base_url+"/Clientes/getClientes",
		"dataSrc":""
		},
		"columns":[
			{"data":"idpersona"},
			{"data":"identificacion"},
			{"data":"nombres"},
			{"data":"apellidos"},
			{"data":"email_user"},
            {"data":"telefono"},
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
	
	
	//Nuevo Cliente
    var formCliente = document.querySelector('#formCliente');
	formCliente.onsubmit = function(e){
		e.preventDefault();
		var strIdentificacion = document.querySelector('#txtIdentificacion').value;
		var strNombre = document.querySelector('#txtNombres').value;
		var strApellido = document.querySelector('#txtApellidos').value;
		var intTelefono = document.querySelector('#txtTelefono').value;
		var strEmail = document.querySelector('#txtEmail').value;
        var strPassword = document.querySelector('#txtPassword').value;
        var strNit = document.querySelector('#txtNit').value;
        var strNomFiscal = document.querySelector('#txtNombreFiscal').value;
        var strDirFiscal= document.querySelector('#txtDirFiscal').value;

		
		if(strIdentificacion == ''  || strNombre == '' || strApellido == '' || intTelefono == '' || strEmail == '' || strNit == '' || strNomFiscal == '' || strDirFiscal == ''){
			swal("Atencion", "Todos los campos son obligatorios.", "error");
			return false;
		}

		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP'); 
		var ajaxUrl = base_url+'/Clientes/setClientes'; 
		var formData = new FormData(formCliente); 
		request.open("POST",ajaxUrl,true);
		request.send(formData); 
   
		request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200) { 
				var objData = JSON.parse(request.responseText);
				if(objData.status){ 
					$('#modalFormCliente').modal("hide"); 
					formCliente.reset();
					swal("Clientes", objData.msg,"success");
					//tableCientes.ajax.reload();
				}else {
					swal("Error", objData.msg, "error"); 
				}
			}
		}
	}
}, false);




function openModal(){
    document.querySelector('#idUsuario').value ="";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister"); 
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary"); 
	document.querySelector('#btnText').innerHTML ="Guardar";
	document.querySelector('#titleModal').innerHTML ="Nuevo Cliente";
	document.querySelector('#formCliente').reset();
     $('#modalFormCliente').modal('show'); 
}