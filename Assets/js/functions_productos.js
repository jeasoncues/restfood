
//Importar libreria de la barra de codigos para el producto escribiendo la ruta en el src, comilla invertida sirve para escribir la variable base_url de las rutas.
document.write(`<script src="${base_url}/Assets/js/plugins/JsBarcode.all.min.js"></script>`);

//Variable para la tabla productos
let tableProductos;

//Para que el modal funcione correctamente cuando quiera configurar el editor de texto
$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});

//agregamos los eventos al momento que se cargue el modal
window.addEventListener("load",function(){
    setTimeout(() => {

            //MOSTRAR TABLA DE PRODUCTOS
    tableProductos = $('#tableProductos').DataTable({
		"aProcessing":true,
		"aServerside":true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" 
		},
		"ajax":{
			"url": " "+base_url+"/Productos/getProductos",
		"dataSrc":""
		},
		"columns":[
			{"data":"idproducto"},
			{"data":"codigo"},
			{"data":"nombre"},
            {"data":"stock"},
            {"data":"precio"},
            {"data":"status"},
            {"data":"options"}
        ],
        //centrar las columnas 
        "columnDefs": [
                         { 'className': "textcenter", "targets": [3]}, //la columna 3 se alinea en el centro
                         { 'className': "textright", "targets": [4]}, //la columna 4 se alinea hacia la derecha
                         { 'className': "textcenter", "targets": [5]}, //la columna 5 se alinea en el centro
                      ],
		'dom': 'lBfrtip',
		'buttons': [
			 {
				"extend": "excelHtml5", 
				"text": "<i class='fas fa-file-excel'></i> Excel",
				"titleAttr": "Exportar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    //indicamos las columnas que vamos a exportar
                    "columns":  [0, 1, 2, 3, 4, 5]

                }
			 },{
				"extend": "pdfHtml5",
				"text": "<i class='fas fa-file-pdf'></i> PDF",
				"titleAttr": "Exportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    //indicamos las columnas que vamos a exportar
                    "columns": [0, 1, 2, 3, 4, 5]
                }
			 }
		],
		"responsieve":"true",
		"bDestroy": true,
		"iDisplayLength": 10, 
		"order":[[0,"asc"]] 

    });

     //Nuevo Producto
     var formProducto = document.querySelector("#formProducto");
     formProducto.onsubmit = function(e) {
         e.preventDefault(); /* Previene a que se recargue la pagina*/
        
         var strNombre = document.querySelector('#txtnombre').value;
         var intCodigo  = document.querySelector('#txtCodigo').value;
         var strPrecio = document.querySelector('#txtPrecio').value;
         var intStock = document.querySelector('#txtStock').value;
         
         /*validacion si las variables son vacias muestra la alerta de error*/
         if(strNombre  == '' || intCodigo == '' || strPrecio == '' || intStock == '')
         {
             swal("Atencion", "Todos los campos son obligatorios.", "error");
             return false; /* Detiene el proceso*/
         }
         //validacion para el codigo de barras para que sea mayor de 5 digitos
         if(intCodigo.length < 5){
             swal("Atencion", "El codigo de barras debe ser mayor que 5 digitos." , "error");
             return false;
         }
         tinyMCE.triggerSave(); //pasamos todo el editor del texarea para enviar por ajax todo lo escrito ahi

         
         /* Validacion con un fin simplificado para XMLHttp para crear si estamos en google chrome
          de lo contrario new Active si estamos en internet explore edge*/
         var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
         var ajaxUrl = base_url+'/Productos/setProductos';

         var formData = new FormData(formProducto); /*Crea un objeto*/
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
                     $('#modalFormProducto').modal("hide");
                     formProducto.reset(); //Limpiar los campos
                     swal("Producto", objData.msg ,"success"); //Libreria swal enviando mensaje con "msg" depende el texto
                     document.querySelector('#idProducto').value = objData.idproducto; //elemento que retorna desde el controlador 
                     tableProductos.ajax.reload();

                 }else{//Si no es verdadero
                     swal("Error", objData.msg ,"errorinsertProducto"); //Mensaje de error
                 }
             }
         }

     }
     
    
    //si existe el elemento para cagar imagenes
    if(document.querySelector(".btnAddImage")){
         let btnAddImage =  document.querySelector(".btnAddImage"); //a la variable le mandamos el elemento
         btnAddImage.onclick = function(e){//evento a la variable
            let key = Date.now(); //retorna la fecha y la hora, va variando cada ves que se genere.
            let newElement =  document.createElement("div"); //creamos un elemento al div para que genere un id 
            newElement.id= "div"+key; //numero unico para el id del div 
            newElement.innerHTML = `
            <div class="prevImage"></div>
            <input type="file" name="foto" id="img${key}" class="inputUploadfile"> 
            <label for="img${key}" class="btnUploadfile"> <i class="fas fa-upload"></i></label>
            <button class="btnDeleteImage" type="button" onclick="fntDelItem('#div${key}')"><i class="fas fa-trash-alt"></i></button>`;

            document.querySelector("#containerImages").appendChild(newElement); //envia todo lo de la variable al id del contenedor
            document.querySelector("#div"+key+" .btnUploadfile").click(); 
            fntInputFile();
         
           }
       }
     
    fntInputFile(); //ejecute la funcion de enviar imagenes
    fntCategorias(); //ejecute la funcion de categorias
    
  }, 500);
}, false);

//Evento para el input de la barra de codigo
if(document.querySelector("#txtCodigo")){ //validacion para saber si existe el id del input del codigo
    let inputCodigo = document.querySelector("#txtCodigo"); //creamos variable de tipo let que se dirige al input del codigo
    inputCodigo.onkeyup =  function(){ //evento onkeyup  significa que cuando debemos click se genere la funcion de abajo.
        if(inputCodigo.value.length >= 5){ //la cantidad de digitos del codigo es mayor que 5 se refiere al divbarcode 
            document.querySelector('#divBarCode').classList.remove("notblock"); //quitamos la clase notblock con remove
            fntBarcode(); //funcion para generar el codigo de barra
        }else{
            document.querySelector('#divBarCode').classList.add("notblock");//en caso no tenga los 5 digitos lo oculta
        }
    };
}


//Editor de Texto de productos
tinymce.init({
  selector: '#txtdescripcion',
  width: "100%", //ancho del editor 100%
    height: 400,  //alto   
    statubar: true, //visualizar la barra de estado
    plugins: [ //plugins enlaces, imagenes, vista previa.
        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor"
    ],
    //elementos de la bara de herramientas
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",

});


//funcion para que se envien las imagenes
function fntInputFile(){
    let inputUploadfile = document.querySelectorAll(".inputUploadfile");
    inputUploadfile.forEach(function(inputUploadfile) { //cargamos todos los elementos de la clase
        inputUploadfile.addEventListener('change', function(){ //le agregamos el evento change
          
            //carga imagen funcion
            let idProducto = document.querySelector("#idProducto").value; //para saber a que producto le mandamos la imagen
            let parentId =  this.parentNode.getAttribute("id"); //HACE REFERENCIA AL BOTON QUE LE ESTAMOS DANDO CLICK PARA AGREGAR IMAGEN, PARENTNODE HACE REFERENCIA AL EVENTO PADRE DEL ELEMENTO ID.
            let idFile = this.getAttribute("id"); //OBTIENE EL ID PARA ESTA VARIABLE
            let uploadFoto = document.querySelector("#"+idFile).value; //SE DIRIGE AL SELECTOR DE TIPO ID Y CONCATENAMOS ALA VARIABLE IDFILE ENVIANDO VALOR
            let fileimg = document.querySelector("#"+idFile).files; //SE DIRIGE AL SELECTOR DE TIPO ID Y CONCATENA LA VARIABLE IDFILE Y CON FILES OBTIENE LA FOTO
            let prevImg = document.querySelector("#"+parentId+" .prevImage");//SE DIRIGE A LA CLASE PREVIMAGE PARA VISUALIZAR LA IMAGEN.
            let nav = window.URL || window.webkitURL; //DEPENDE DEL NAVEGADOR DONDE NOS ENCONTREMOS
            if(uploadFoto !=''){ //quiere decir que si se esta seleccionando una foto
                let type = fileimg[0].type; //tipo de archivo
                let name = fileimg[0].name; //nombre de la foto
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){
                    prevImg.innerHTML = "Archivo no valido";
                    uploadFoto.value = "";
                    return false;
                }else{
                    let objeto_url =  nav.createObjectURL(this.files[0]);//hacemos referencia al input file obteniendo los valores del archivo
                    prevImg.innerHTML = `<img class="loading" src="${base_url}/Assets/images/loading.svg">`; //donde se mostrara la imagen y cargamos con innerhtml el loading.
                    
                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = base_url+'/Productos/setImage'; //ruta para hacer la peticion
                    let formData =  new FormData(); 
                    formData.append('idproducto',idProducto); //agregamos al formulario con append el campo idproducto donde le vamos agregar como valor el idProducto
                    formData.append("foto", this.files[0]); //le agregamos otro elemento con nombre foto que tiene como contenido de tipo file para que se envien las fotos.
                    request.open("POST",ajaxUrl,true);
                    request.send(formData); //envio de datos.

                    request.onreadystatechange = function(){

                        if(request.readyState != 4) return;
                        /*Obtenemos la informacion*/
                        if(request.readyState == 4 && request.status == 200){
                            let objData = JSON.parse(request.responseText);
                            if(objData.status){
                                prevImg.innerHTML = `<img src="${objeto_url}">`;
                                document.querySelector("#"+parentId+" .btnDeleteImage").setAttribute("imgname",objData.imgname); //nos dirigimos al boton de eliminar y con setattribute le mandamos una tributo y enviamos como valor lo que estamos devolviendo desde el controlador
                                document.querySelector("#"+parentId+" .btnUploadfile").classList.add("notblock"); //agregamos a la clase btnuploadfile que hace la carga y agregamos la clase list not block para que se oculte
                                document.querySelector("#"+parentId+" .btnDeleteImage").classList.remove("notblock"); //para que se muestre el boton de eliminar.
                            }else{
                                swal("Error", objData.msg , "error");
                            }
                            
                        }
                    }
                }

            }
                  

        });

    });

}



function fntViewProducto(idProducto){

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Productos/getProducto/'+idProducto; //enviamos parametro que recibe.
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {   
                let htmlImage = ""; //variable para imagenes.
                let objProducto = objData.data; //la varibale objproducto hace referencia al objdata.data
                //validacion para el estado activo o inactivo
                let estadoProducto = objProducto.status == 1 ? 
                '<span class="badge badge-success">Activo</span>' :
                '<span class="badge badge-danger">Inactivo</span>';
                document.querySelector("#celCodigo").innerHTML = objProducto.codigo;
                document.querySelector("#celNombre").innerHTML = objProducto.nombre;
                document.querySelector("#celPrecio").innerHTML = objProducto.precio;
                document.querySelector("#celStock").innerHTML = objProducto.stock;
                document.querySelector("#celCategoria").innerHTML = objProducto.categoria;
                document.querySelector("#celStatus").innerHTML = estadoProducto;
                document.querySelector("#celDescripcion").innerHTML = objProducto.descripcion;

                //validacion para saber si existen imagenes
                if(objProducto.images.length > 0){ //length nos permite contar si hay datos en este caso imagenes
                   let objProductos = objProducto.images;
                   //recorremos donde la variable p es igual a 0, p es menor que la cantidad de registros que tenga el array de objproducto.
                   for (let p = 0; p < objProductos.length; p++){ 
                       //concatenamos con el signo "+"
                      htmlImage += `<img src="${objProductos[p].url_image}"></img>`; //ingresamos en el src al array en la posicion que se encuentra con la url de la imagen.
                   }
                }
                document.querySelector("#celFotos").innerHTML = htmlImage; //le seteamos la imagen al id celfotos
                $('#modalViewProducto').modal('show');
            }else{
                swal("Error", objData.msg, "error")
            }
        }
    }
}


function fntEditProducto(idProducto){

    //Cambiamos de apariencia al modal
    document.querySelector('#titleModal').innerHTML = "Actualizar Producto";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Productos/getProducto/'+idProducto; //enviamos parametro que recibe.
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {   
                let htmlImage = "";
                let objProducto = objData.data; //la varibale objproducto hace referencia al objdata.data
                //Seteamos a las cajas de texto lo que obtenemos del array objdata
                document.querySelector("#idProducto").value = objProducto.idproducto;
                document.querySelector("#txtnombre").value = objProducto.nombre;
                document.querySelector("#txtdescripcion").value = objProducto.descripcion;
                document.querySelector("#txtCodigo").value = objProducto.codigo;
                document.querySelector("#txtPrecio").value = objProducto.precio;
                document.querySelector("#txtStock").value = objProducto.stock;
                document.querySelector("#listCategoria").value = objProducto.categoriaid;
                document.querySelector("#listStatus").value = objProducto.status;

                //Seteamos lo que tenemos el textarea de la descripcion mediante la libreria TINYMCE
                tinymce.activeEditor.setContent(objProducto.descripcion);
                //Renderizamos los select para categoria y status
                $('#listCategoria').selectpicker('render');
                $('#listStatus').selectpicker('render');
                //funcion del generador de la barra de codigo
                fntBarcode();

                //validacion para mostrar las imagenes 
                if(objProducto.images.length > 0){ //ve cuantos elementos tiene el array
                    let objProductos = objProducto.images;
                    for (let p = 0; p < objProductos.length; p++) {
                        let key = Date.now()+p; //date.now => genera la fecha y la hora en un numero para que no se repita
                        htmlImage += `<div id="div${key}">
                           <div class="prevImage">
                           <img src="${objProductos[p].url_image}"></img> 
                           </div>
                           <button type="button" class="btnDeleteImage" onclick="fntDelItem('#div${key}')" imgname="${objProductos[p].img}">
                           <i class="fas fa-trash-alt"></i></button></div>`;
                    }
                }
                //al id containerimages seteamos las imagenes de la variable htmlImage
                document.querySelector("#containerImages").innerHTML = htmlImage;

                //eliminar la clase notblock para que se muestre la barra de codigo
                document.querySelector("#divBarCode").classList.remove("notblock");

                $('#modalFormProducto').modal('show');
                 
            }else{
                swal("Error", objData.msg, "error")
            }
        }
    }   
    
}


//funcion para extraer las categorias
function fntCategorias(){
        var ajaxUrl = base_url+'/Categorias/getSelectCategorias';
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true); //abrimos conexion con metodo GET donde extraemos la url. 
        request.send();

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){ //si devuelve informacion
                document.querySelector('#listCategoria').innerHTML = request.responseText; //nos dirigimos al html que tiene el elemento a los que nos va a devolver
                document.querySelector('#listCategoria').value = 10;
                $('#listCategoria').selectpicker('render'); //hacemos uso de jquery utilizando selectpicker para que se muestren todas las opciones aplicando el buscador.
            }
        }
    
}

//Funcion para generar codigo de barra
function fntBarcode(){
    let codigo = document.querySelector("#txtCodigo").value; //esta variable codigo hace referencia al input y capturamos el valor
    JsBarcode("#barcode", codigo); //funcion donde coloca el codigo de barra y el valor del codigo. 

}

//Funcion para imprimir la barra del codigo.
function fntPrintBarcode(area){ //enviamos como parametro el area
    let elemntArea =  document.querySelector(area); 
    let vprint = window.open(' ', 'popimpr', 'height=400,width=600'); //abre una nueva ventana indicando su alto y ancho
    vprint.document.write(elemntArea.innerHTML);//escribir o colocar lo que tenemos en la variable elemntarea en su html que corresponde al codigo de barra
    vprint.document.close();//cierra
    vprint.print();//evento de imprimir
    vprint.close();
}


function openModal() {
    document.querySelector('#idProducto').value="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Producto";
    document.querySelector('#formProducto').reset();
    $('#modalFormProducto').modal('show');
}