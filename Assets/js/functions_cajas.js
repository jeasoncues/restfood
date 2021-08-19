document.addEventListener('DOMContentLoaded',function(){

//CREAR ARQUEO
var formArqueo = document.querySelector("#formArqueo");
    formArqueo.onsubmit = function(e){

        
        e.preventDefault(); //prevenimos a que se recargue la pagina

        var strFecha =  document.querySelector('#txtFecha').value;
        var intTurno =  document.querySelector('#listTurno').value;
        var intCajaChica =  document.querySelector('#txtcajachica').value;
        var intCajaCierre =  document.querySelector('#txtcajacierre').value;
        var intEstado = document.querySelector('#listEstado').value;

        if(strFecha == '' || intCajaChica == '' || intEstado == ''){
            swal("Atencion", "El campo de fecha y caja chica es obligatorio", "error");
           
            return false;
        }
        
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'/Cajas/setCaja';
        
        var formData =  new FormData(formArqueo);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange =  function(){

            if(request.readyState == 4 && request.status == 200){
                var objData = JSON.parse(request.responseText);

                if(objData.status){
                    $('#modalFormArqueo').modal("hide");
                    formArqueo.reset();
                    swal("Arqueo", objData.msg, "success");
                    /*var boton =  document.querySelector("#boton");
                    function cambiar(){
                        boton.innerHTML = "Abierto";
                        boton.style.background = "green";
                        boton.style.border = "green";
                    }
                    boton.onclick = cambiar;*/
                       
                    window.location = base_url+'/posventa';
                    
                }else{
                    swal("Error", objData.msg, "error");
                }
            }
        }
    }

}, false);

    

function openModal() {
    document.querySelector('#idArqueo').value="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Abrir Caja";
    document.querySelector('#formArqueo').reset();
    $('#modalFormArqueo').modal('show');
}