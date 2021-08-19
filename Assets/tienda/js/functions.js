$(".js-select2").each(function(){
    $(this).select2({
        minimumResultsForSearch: 20,
        dropdownParent: $(this).next('.dropDownSelect2')
    });
});

$('.parallax100').parallax100();

$('.gallery-lb').each(function() { // the containers for all your galleries
    $(this).magnificPopup({
        delegate: 'a', // the selector for gallery item
        type: 'image',
        gallery: {
            enabled:true
        },
        mainClass: 'mfp-fade'
    });
});

$('.js-addwish-b2').on('click', function(e){
    e.preventDefault();
});

$('.js-addwish-b2').each(function(){
    var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
    $(this).on('click', function(){
        swal(nameProduct, "Me encanta", "success");

        $(this).addClass('js-addedwish-b2');
        $(this).off('click');
    });
});

$('.js-addwish-detail').each(function(){
    var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

    $(this).on('click', function(){
        swal(nameProduct, "Me encanta ", "success");

        $(this).addClass('js-addedwish-detail');
        $(this).off('click');
    });
});

/*---------------------------------------------*/

$('.js-addcart-detail').each(function(){ //parent -> para obtener datos
    var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
    $(this).on('click', function(){ //this dar click
        //capturamos datos del producto 
        let id = this.getAttribute('id'); //en su atributo id obtiene el valor
        let cant = document.querySelector('#cant-product').value; //la variable cant obtiene el valor del id cant-product
        
        if(isNaN(cant) || cant  < 1){ //isNaN -> si no es un numero y la cantidad debe ser mayor que 1
            swal("","La cantidad debe ser 1 o más", "error");
            return; //se detiene el proceso
        }//de lo contrario enviamos datos por AJAX
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP'); //implementamos ajax
        let ajaxUrl =  base_url+'/Tienda/addCarrito'; //metodo addCarrito
        let formData = new FormData(); //FORMULARIO JS
        formData.append('id',id); //AGREGAMOS COMO VALOR EL ID
        formData.append('cant',cant); //AGREGAMOS COMO VALOR CANT

        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState != 4) return;
            if(request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.status){
                    document.querySelector("#productosCarrito").innerHTML = objData.htmlCarrito;
                   
                /* HAY DOS FORMAS DE APLICAR EL AGREGAR EL CARRITO. ESTA ES 1 
                    document.querySelectorAll(".cantCarrito")[0].setAttribute("data-notify",objData.cantCarrito); //queryselectorall porque es una clase y tiene mas de un elemento,le seteamos lo que trae al icono del carrito.
                    document.querySelectorAll(".cantCarrito")[1].setAttribute("data-notify",objData.cantCarrito);
                */
                //SEGUNDA FORMA con un ciclo foreach que va a extraeer todos los elemento que tiene esa clase cantcarrito.
                    const cants =  document.querySelectorAll(".cantCarrito");
                    cants.forEach(element => { //element va a encotnrar el primer elmento el segundo, etc
                        element.setAttribute("data-notify",objData.cantCarrito) // al atributo data-nofitify le coloca el objeto que trae el cantCarrito la cantidad de productos.
                    });
                    swal(nameProduct, "¡Se agrego al carrito!", "success");
                }else{
                    swal("", objData.msg , "error");
                }
              
            }
            return false;
        }

        swal(nameProduct, "Se agrego al carrito!", "success");
    });
});

$('.js-pscroll').each(function(){
    $(this).css('position','relative');
    $(this).css('overflow','hidden');
    var ps = new PerfectScrollbar(this, {
        wheelSpeed: 1,
        scrollingThreshold: 1000,
        wheelPropagation: false,
    });

    $(window).on('resize', function(){
        ps.update();
    })
});

 /*==================================================================
    [ +/- CANTIDAD DE PRODUCTO ]*/
    //disminuir cantidad
    $('.btn-num-product-down').on('click', function(){
        let numProduct = Number($(this).next().val());
        let idpr = this.getAttribute('idpr');
        //cantidad minima 1
        if(numProduct > 1) $(this).next().val(numProduct - 1);
        let cant = $(this).next().val(); //dirigigiendonos al siguiente elemento que sigue despues del this que seria el input de cantidad  donde extraemos el valor ocn val.
        fntUpdateCant(idpr,cant);
    });
    
    //aumentar cantidad
    $('.btn-num-product-up').on('click', function(){
        let numProduct = Number($(this).prev().val());
        let idpr = this.getAttribute('idpr');
        $(this).prev().val(numProduct + 1);
        let cant = $(this).prev().val(); //dirigigiendonos al  elemento anterior con prev y capturamos valores con val.
        fntUpdateCant(idpr,cant);
    });

    //Actualizar producto
    if(document.querySelector(".num-product")){ //validacion si existe el elemento num-product que pertenece al input se ejecutrara lo de abajo
        let inputCant =  document.querySelectorAll(".num-product"); //variable inputcant que es igual a queryselectorall porque hay varios campos y obtenemos todos los elemento que tengan esa clase
        inputCant.forEach(function(inputCant) { //enviamos como parametro el inputcant 
            inputCant.addEventListener('keyup', function(){ //le agregamos el evento keyup cuando presionemos la tecla se ejecuta toda la funcion de abajo
                let idpr =  this.getAttribute('idpr'); //obtenemos el valor del atributo de donde estemos escribiendo
                let cant =  this.value; //obtiene el valor y se lo asigna a la variable cant
                fntUpdateCant(idpr,cant); //funcion que recibe como parametro el idproducto y cantidad.
            });
        });
    }


    //Agregar cliente
    if(document.querySelector("#formRegister")){
        let formRegister = document.querySelector("#formRegister");
        formRegister.onsubmit = function(e) {
            e.preventDefault();
            let strNombre = document.querySelector('#txtNombres').value;
            let strApellido = document.querySelector('#txtApellidos').value;
            let strEmail = document.querySelector('#txtEmailCliente').value;
            let intTelefono = document.querySelector('#txtTelefono').value;
    
            if(strApellido == '' || strNombre == '' || strEmail == '' || intTelefono == '' )
            {
                swal("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }
    
            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) { 
                if(elementsValid[i].classList.contains('is-invalid')) { 
                    swal("Atención", "Por favor verifique los campos en rojo." , "error");
                    return false;
                } 
            } 
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Tienda/registro'; 
            let formData = new FormData(formRegister);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        window.location.reload(false);
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }
    



    //funcion para metodo de pago
    //validamos si existe el metodo de la clase del div.
if(document.querySelector(".methodpago")){
    let optmetodo = document.querySelectorAll(".methodpago"); // la variable se dirige a la clase methodpago
    optmetodo.forEach(function(optmetodo) { //se ejecuta la funcion
       optmetodo.addEventListener('click', function(){ //al momento que se le da click a la opcion se ejecuta la funcion.
        if(this.value == "Paypal"){
            document.querySelector("#divpaypal").classList.remove("notblock"); //muestra mensaje y oculta el select que tiene el notblock.
            document.querySelector("#divtipopago").classList.add("notblock");
            document.querySelector("#msgtransferencia").classList.add("notblock");
            document.querySelector("#msgyape").classList.add("notblock");
            document.querySelector("#msgplin").classList.add("notblock");
            document.querySelector("#btnComprar").classList.add("notblock");
        }else if(this.value == "Yape"){
            document.querySelector("#msgyape").classList.remove("notblock");
            document.querySelector("#divpaypal").classList.add("notblock"); //agregarle al msgpaypal la clase notblock de ocultar
            document.querySelector("#msgtransferencia").classList.add("notblock");
            document.querySelector("#divtipopago").classList.add("notblock");
            document.querySelector("#msgplin").classList.add("notblock");
            document.querySelector("#btnComprar").classList.remove("notblock");

        }else if(this.value == "plin"){
            document.querySelector("#msgplin").classList.remove("notblock");
            document.querySelector("#msgyape").classList.add("notblock");
            document.querySelector("#msgtransferencia").classList.add("notblock");
            document.querySelector("#divtipopago").classList.add("notblock");
            document.querySelector("#divpaypal").classList.add("notblock");
            document.querySelector("#btnComprar").classList.remove("notblock");
        
        }else if(this.value == "transferencia"){
            document.querySelector("#msgtransferencia").classList.remove("notblock");
            document.querySelector("#divpaypal").classList.add("notblock");
            document.querySelector("#msgyape").classList.add("notblock");
            document.querySelector("#divtipopago").classList.add("notblock");
            document.querySelector("#msgplin").classList.add("notblock");
            document.querySelector("#btnComprar").classList.remove("notblock");

        
        }else{ // de lo contrario si no es paypal muestra el select de contra entrega.
            document.querySelector("#divpaypal").classList.add("notblock");
            document.querySelector("#msgyape").classList.add("notblock");
            document.querySelector("#msgtransferencia").classList.add("notblock");
            document.querySelector("#divtipopago").classList.remove("notblock");
            document.querySelector("#msgplin").classList.add("notblock");
            document.querySelector("#btnComprar").classList.remove("notblock");
        }
       });
    });
}






//funcion para eliminar productos desde el modal del carrito
function fntdelItem(element){ //element -> lo que estamos recibiendo como parametro
    //option 1 =  Modal
   //option 2 =  vista carrito
   let option = element.getAttribute("op"); //obtenemos la opcion que tiene el atributo "op"
   let idpr = element.getAttribute("idpr"); //atributo encriptado "idpr"
   if(option == 1 || option == 2 ){

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP'); //implementamos ajax
    let ajaxUrl =  base_url+'/Tienda/delCarrito'; //metodo delCarrito
    let formData = new FormData(); //FORMULARIO JS
    formData.append('id',idpr);
    formData.append('option',option); 

    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange = function(){
        if(request.readyState != 4) return;
        if(request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                if(option == 1){ //eliminamos productos desde el modal.
                    document.querySelector("#productosCarrito").innerHTML = objData.htmlCarrito;
                    
                    const cants =  document.querySelectorAll(".cantCarrito");
                    cants.forEach(element => { //element va a encotnrar el primer elmento el segundo, etc
                        element.setAttribute("data-notify",objData.cantCarrito) // al atributo data-nofitify le coloca el objeto que trae el cantCarrito la cantidad de productos.
                    });
                }else{ 
                    element.parentNode.parentNode.remove(); //con parentNode subimos un nivel para diriginos a su padre nos dirigimos al tr para seleccionar toda la fila, y con remove elinamos la fila al elemento que le hemos dado click
                    document.querySelector("#subTotalCompra").innerHTML = objData.subTotal; //le colocamos lo que viene en el subtotal a la clase subtotalcompra
                    document.querySelector("#totalCompra").innerHTML = objData.total;

                    //validacion para saber si tenemos productos en el carrito desde la tabla si es igual a 1 quiere decir que ya no tenemos productos porque el primer elemento pertenece a los encabezados.
                    if(document.querySelectorAll("#tblCarrito tr").length == 1){
                        window.location.href = base_url; //redireccionamos a la pagina principal
                    }

                }
            
            }else{
                swal("", objData.msg , "error");
            }
          
        }
        return false;
    }

   }
}

//Actualizar cantidad del producto del carrito.
function fntUpdateCant(pro,cant){
   if(cant <= 0){ //si la cantidad es menor a 0 ocultamos el boton de procesar pago
     document.querySelector("#btnComprar").classList.add("notblock"); //al id btncomprar le agregamos la clase notblock para ocultar el boton
   }else{
       document.querySelector("#btnComprar").classList.remove("notblock"); //removemos la clase notblock para que se muestre el boton.
       let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
       let ajaxUrl = base_url+'/Tienda/updCarrito';
       let formData = new FormData(); //nuevo formulario
       //agregamos campos del lado de js id, cantidad
       formData.append('id',pro);
       formData.append('cantidad',cant);
       request.open("POST",ajaxUrl,true); //abrimos conexion de tipo post enviandolo por la variable ajaxurl
       request.send(formData);

       request.onreadystatechange = function(){
           if(request.readyState != 4) return; //la peticion no devuelve nada y termina el proceso
           if(request.status == 200){ //si recibe peticion.
             let objData =  JSON.parse(request.responseText); //convertimos a objeto el formato json que recibimos
             if(objData.status){
                 let colSubtotal =  document.getElementsByClassName(pro)[0]; //nos dirigimos a la clase que corresponde al idproducto.
                 colSubtotal.cells[4].textContent = objData.totalProducto;//de esta fila se dirige a la columna 4 en textcontent coloca el ojeto en total producto.
                 document.querySelector("#subTotalCompra").innerHTML = objData.subTotal; //a la clase subtotalcompra le asignamos lo que trae en ajax el objeto del colsubtotal.
                 document.querySelector("#totalCompra").innerHTML = objData.total;
             }else{
                 swal("", objData.msg , "error");

             }
               
           }
       }
   }
   return false; //finaliza proceso
}

  //Validacion para saber si ingresa la direccion y el distrito 

if(document.querySelector("#txtDireccion")){ //validacion si existe el elemento num-product que pertenece al input se ejecutrara lo de abajo
    let direccion =  document.querySelector("#txtDireccion"); //variable direccion que es igual a queryselectorall porque hay varios campos y obtenemos todos los elemento que tengan esa clase
   
        direccion.addEventListener('keyup', function(){ //le agregamos el evento keyup cuando presionemos la tecla se ejecuta toda la funcion de abajo
            let dir =  this.value; //obtenemos el valor que se esta escribiendo
            fntViewPago();
        });
}

if(document.querySelector("#txtCiudad")){ 
    let ciudad =  document.querySelector("#txtCiudad");
   
        ciudad.addEventListener('keyup', function(){ //le agregamos el evento keyup cuando presionemos la tecla se ejecuta toda la funcion de abajo
            let ciu = this.value;
            fntViewPago();
        });
}

if(document.querySelector("#condiciones")){ 
    let opt=  document.querySelector("#condiciones");
   
        opt.addEventListener('click', function(){ //le agregamos el evento keyup cuando presionemos la tecla se ejecuta toda la funcion de abajo
            let opcion = this.checked; //obtenemos el estado del input
            if(opcion){
                document.querySelector('#optMetodoPago').classList.remove("notblock");
            }else{
                document.querySelector('#optMetodoPago').classList.add("notblock");
            }
        });
}

//Funcion de la vista de Pagos
function fntViewPago() {
    //obtenemos los valores de las cajas de texto.
    let direccion =  document.querySelector("#txtDireccion").value;
    let ciudad =  document.querySelector("#txtCiudad").value;

    if(direccion == "" || ciudad == ""){
        document.querySelector('#divMetodoPago').classList.add("notblock");
    }else{
        document.querySelector('#divMetodoPago').classList.remove("notblock");
    }

}


//validacion para comprar por contraentrega o los demas pagos
if(document.querySelector("#btnComprar")){
    let btnPago = document.querySelector("#btnComprar");
    //le agregamos el evento de click a esa variable 
    btnPago.addEventListener('click',function() {
        
        //CAPTURAMOS DATOS QUE VIENEN COMO VALOR EN LA CAJA DE TEXTO
        let direccion =  document.querySelector("#txtDireccion").value;
        let ciudad = document.querySelector("#txtCiudad").value;
        let inttipopago = document.querySelector("#listtipopago").value;
        if(txtDireccion == "" || txtCiudad == "" || inttipopago == ""){
            swal("", "Complete datos de envío", "error");
            return;
        }else{
      
            /* implementar ajax */
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url +'/Tienda/procesarVenta'; // metodo para procesar venta
            let formData = new FormData(); //creamos un formulario de tipo dato y colocamos los campos de abajo.
            formData.append('direccion', direccion);
            formData.append('ciudad',ciudad);
            formData.append('inttipopago',inttipopago);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState != 4) return; 
                if(request.status == 200){
                    let objData = JSON.parse(request.responseText); //la variable la convertimos a objeto de request.responsetext
                    if(objData.status){
                        window.location =  base_url+'/tienda/confirmarpedido/'; //redireccionamos a la confirmacion de pedido.
                    }else{
                    swal("", objData.msg , "error");
                    }
                 }

              }
            }

    },false);
}
