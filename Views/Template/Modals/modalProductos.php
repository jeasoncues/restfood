<!--Modals es como un JOptionPane pero se abre en el centro de la pagina web-->
<!-- Modal -->
<div class="modal fade" id="modalFormProducto" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-xl"> <!--ancho del modal-->
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nueva Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--Formulario para el modal-->
        <div class="tile">
            <div class="tile-body">
                <form id="formProducto" name="formProducto" class="form-horizontal">
                 <input type="hidden" id="idProducto" name="idProducto" value="">

                 <!--Parrafo-->
                 <p class="text-danger">Los campos son obligatorios</p>
                 <!-- fila con 8 columnas col-md-8 +  col-md-4 hace un total de 12 columnas para esta fila-->
                <div class="row">
                   <div class="col-md-8">
                        <div class="form-group">
                            <label class="control-label">Nombre Producto</label>
                            <input class="form-control" id="txtnombre" name="txtnombre" type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Descripcion Producto</label>
                            <textarea class="form-control" id="txtdescripcion" name="txtdescripcion">
                            </textarea>
                        </div> 
           
                   </div>

                   <div class="col-md-4">
                    <div class="form-group">
                         <label class="control-label">Codigo <span class="required">*</span></label>
                         <input class="form-control" id="txtCodigo" name="txtCodigo" type="text" placeholder="Codigo de barra">
                         <br>
                         <!-- Barra de Codigo-->
                         <div id="divBarCode" class="notblock textcenter">
                             <div id="printCode">
                                  <svg id="barcode"></svg> <!--Codigo de barra muestra-->
                             </div>
                             <!--Boton sm para que se adapte al div, evento onclick para imprimir con js que hace referencia al id "printCode" de la barra de codigo-->
                             <button class="btn btn-success btn-sm" type="button" onClick="fntPrintBarcode('#printCode')"><i class="fas fa-print"></i> Imprimir</button> <!--a la funcion fntprintbarcode le enviamos como parametro el id printcode-->
                         </div>

                       </div>
                       <!--fila  con dos div de 6 colummnas-->
                       <div class="row">
                         <div class="form-group col-md-6">
                          <label class="control-label">Precio</label>
                          <input class="form-control" id="txtPrecio" name="txtPrecio" type="text">
                         </div>

                         <div class="form-group col-md-6">
                          <label class="control-label">Stock</label>
                          <input class="form-control" id="txtStock" name="txtStock" type="text">
                         </div>
                       </div>

                       <div class="row">
                         <div class="form-group col-md-6">
                          <label for="listCategoria">Categoria</label>
                          <select class="form-control" data-live-search="true" id="listCategoria" name="listCategoria"></select>
                         </div>

                         <div class="form-group col-md-6">
                            <label for="listStatus">Estado</label>
                            <select class="form-control" id="listStatus" name="listStatus">
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select> 
                         </div>
                       </div>

                       <div class="row">
                        <div class="form-group col-md-6"> <!--btn-lg => largo, btn-block => ocupa todo el ancho del contenedor-->
                            <button id="btnActionForm" class="btn btn-secondary btn-lg btn-block" type="submit" ><i class="fa fa-fw fa-lg fa-check-circle"></i>
                            <span id="btnText">Guardar</span></button>
                        </div>

                        <div class="form-group col-md-6">
                        <button class= "btn btn-danger btn-lg  btn-block" type = "button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</button>
                        </div>
                            
                       </div>        
                    </div>

                </div>


               <!--cargar imagenes-->
                <div class="tile-footer"> 
                   <div class="form-group col-md-12">
                    <div id="containerGallery">
                      <span>Agregar foto (440 x 545)</span> <!-- ancho y alto -->
                      <!-- btn sm => boton pequeño -->
                      <button class="btnAddImage btn btn-info btn-sm" type="button">
                       <i class="fas fa-plus"></i>
                      </button>
                    </div>
                    <hr>
                    <div id="containerImages">
                       <!-- <div id="div24"> 
                        <div class="prevImage"> Imagen para que se muestre
                          <img class="loading" src="<?= media(); ?>/images/loading.svg">
                        </div>
                        <input type="file" name="foto" id="img1" class="inputUploadfile"> carga de imagenes 
                        <label for="img1" class="btnUploadfile"> <i class="fas fa-upload"></i></label> se abre el contenedor de cargar
                        <button class="btnDeleteImage" type="button" onclick="fntDelItem('div24')"><i class="fas fa-trash-alt"></i></button>
                      </div> -->
                    </div> 
                   </div>
                       
                </div>
     
                </form>
                </div>
                </div>
          </div>
    </div>
  </div>
</div>

<!--Modals para ver Categoria-->
<!-- Modal -->
<div class="modal fade" id="modalViewProducto" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-xl"> <!--modal-xl => se hace mas grande el modal -->
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--Formulario para el modal-->
        <div class="tile">
            <div class="tile-body">
               <!--tabla para datos del producto-->
               <table class="table table-bordered">
               <tbody>
                 <tr>
                  <td>Codigo</td>
                  <td id="celCodigo"></td>
                 </tr>
                 <tr>
                    <td>Nombre:</td>
                    <td id="celNombre"></td>
                 </tr>
                 <tr>
                    <td>Precio:</td>
                    <td id="celPrecio"></td>
                 </tr>

                 <tr>
                    <td>Stock:</td>
                    <td id="celStock">Jeason</td>
                 </tr>

                 <tr>
                   <td>Categoria:</td>
                   <td id="celCategoria"></td>
                 </tr>

                 <tr>
                  <td>Estado:</td>
                  <td id="celStatus"></td>
                 </tr>

                 <tr>
                   <td>Descripcion</td>
                   <td id="celDescripcion"></td>
                 </tr>

                 <tr>
                   <td>Fotos:</td>
                   <td id="celFotos"></td>
                 </tr>

                 
                </tbody>
              </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>