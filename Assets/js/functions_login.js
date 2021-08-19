// Login Page Flipbox control
$('.login-content [data-toggle="flip"]').click(function() {
    $('.login-box').toggleClass('flipped');
    return false;
});
//Capturara datos del formulario
document.addEventListener('DOMContentLoaded', function(){//Documentos al momento de cargar

    if(document.querySelector("#formLogin")){//id del formulario login si existe agregamos el evento

        //variable let indica que va a ser utilizado unicamente dentro de esta funcion
        let formLogin = document.querySelector("#formLogin");
        formLogin.onsubmit = function(e) { //se le agrega el evento onsubmt
            e.preventDefault(); //al parametro le enviamos prevent previene a que se recargue la pagina al momento de darle click al boton de tipo submit

            let strEmail = document.querySelector('#txtEmail').value; //value obtiene el valor de los campos
            let strPassword = document.querySelector('#txtPassword').value;

            if(strEmail == "" || strPassword == "") //validacion en caso de que los campos esten vacios mostrar alerta con swal
            {   
                //Libreria swal, "titulo", "mensaje", "tipo de alerta"
                swal("Por favor", "Escribe usuario y contraseña.", "error");
                return false;
            }else{ //en caso no esten vacios los campos enviamos datos al controlador
                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url+'/Login/loginUser'; //enviamos la url y concatenamos
                var formData = new FormData(formLogin);//obtenemos todos los campos y enviamos por la variable formlogin
                request.open("POST", ajaxUrl,true);
                request.send(formData);      
                request.onreadystatechange = function(){
                    if(request.readyState != 4) return; //si la peticion es diferente de 4 no hace nada

                    if(request.status == 200){ //si fue exitosa la peticion
                        var objData = JSON.parse(request.responseText);

                        if(objData.status) //si es verdadero quiere decir que si hizo login
                        {
                            //window.location = base_url+'/dashboard'; //redirecciona a esa url
                            //recargamos la pagina
                            window.location.reload(false);

                        }else{//de lo contrario hay algun error
                            swal("Atencion", objData.msg, "error"); //mandamos mensaje en formato json
                            document.querySelector('#txtPassword').value = ""; //nos dirigimos al campo del password y .value =" " =>limpiamos el campo
                        }

                    }else{ //la peticion no funciono
                        swal("Atencion", "Error en el proceso", "error");

                    }
                    return false;
                }    

            }

        }

    }

    if(document.querySelector("#formRecetPass")){ //nos dirigimos al id del formulario de recuperar contraseña
        let formRecetPass = document.querySelector("#formRecetPass");//variable formrecet que va a ser igual al id obtenido del formulario
        formRecetPass.onsubmit = function(e){
            e.preventDefault();//prevenir que se recargue la pagina

            let strEmail =  document.querySelector('#txtEmailReset').value; //variable stremail obteniendo el id del campo de texto y con .value obtenemos los datos que van en el campo
            if(strEmail == "") //si esta vacio el campo 
            {
                swal("Por favor", "Escribe tu correo electronico.", "error");//alerta
                return false;//para que termine el proceso
            }else{ //si es que en el campo hay valores

                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

                var ajaxUrl = base_url+'/Login/resetPass';
                var formData =  new FormData(formRecetPass);
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                request.onreadystatechange = function(){//recibir informacion del request.

                    if(request.readyState != 4) return; //no devuelve nada.
                    if(request.status == 200){
                        var objData = JSON.parse(request.responseText);
                        if(objData.status)//si el staatus es vedadero quiere decir que si se envio el token al correo
                        {
                            swal({
                                title: "",
                                text: objData.msg, //atributo msg
                                type: "success",
                                confirmButtonText: "Aceptar",
                                closeOnConfirm: false,
                            }, function(isConfirm){
                                if (isConfirm){
                                    window.location = base_url; //redirecciona a la ruta raiz del proyecto. 

                                }
                            });
                        }else{
                            swal("Atencion", objData.msg, "error");
                        }
                    }else{
                        swal("Atencion", "Error en el proceso", "error");
                    }
                    return false;

                }
 
            }
        }
        //para cambiar password
        if(document.querySelector("#formCambiarPass")){
            let formCambiarPass = document.querySelector("#formCambiarPass");
            formCambiarPass.onsubmit = function(e){
                e.preventDefault();

                let strPassword = document.querySelector('#txtPassword').value;
                let strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;
                let idUsuario = document.querySelector('#idUsuario').value;

                if(strPassword == "" || strPasswordConfirm == "")
                {
                    swal("Por favor", "Escribe la nueva contraseña." , "error");
                    return false;//evitar que el proceso continue
                }else{
                    //.length contar la cantidad de caracteres
                    if(strPassword.length < 5){
                        swal("Atencion", "La contraseña debe tener un minimo de 5 caracteres.", "info");
                        return false;
                    }//contraseña si tiene 5 caracteres
                    if(strPassword != strPasswordConfirm){
                        swal("Atencion", "Las contraseñas no son iguales.", "error");
                        return false;
                    }

                    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    var ajaxUrl = base_url+'/Login/setPassword';//Metodo setpassword para actualizar contraseña
                    var formData =  new FormData(formCambiarPass);
                    request.open("POST",ajaxUrl,true);
                    request.send(formData);
                    //validacion 
                    request.onreadystatechange = function(){
                        if(request.readyState != 4) return;
                        if(request.status == 200){
                            var objData = JSON.parse(request.responseText);

                            if(objData.status)
                            {
                                swal({
                                    title: "",
                                    text: objData.msg,
                                    type: "success",
                                    confirmButtonText: "Iniciar Sesion",
                                    closeOnConfirm: false,
                                }, function(isConfirm){ //se cierra cuando le des click en confirmacion
                                    if (isConfirm){
                                        window.location = base_url+'/login';
                                    }

                                });
                            }else{
                                swal("Atencion", objData.msg, "error");
                            }
                        }else{
                            // en caso de errores del servidor
                            swal("Atencion", "Error en el proceso", "error");
                        }
                    }
  
                }
            }
        }
        
    }

}, false);