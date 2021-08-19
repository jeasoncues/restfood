<!--Modals es como un JOptionPane pero se abre en el centro de la pagina web-->
<!-- Modal -->
<div class="modal fade" id="modalFormMesa" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-xl"> <!--ancho del modal-->
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Pedidos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--Formulario para el modal-->
        <div class="tile">
            <div class="tile-body">
                <form id="formMesa" name="formMesa" class="form-horizontal">
                 <input type="hidden" id="idMesa" name="idMesa" value="">
                 <!-- fila con 8 columnas col-md-8 +  col-md-4 hace un total de 12 columnas para esta fila-->
                <div class="row">
                   
                   <div class="col-md-6">
                        <div class="form-group">
                            <label for="listClientes">Elegir Cliente</label>
                            <select class="form-control" data-live-search="true" id="listClientes" name="listClientes">
                            </select> 
                        </div>
                        <div class="form-group">
                          <label for="listCajeros">Elegir Cajero</label>
                          <select class="form-control" data-live-search="true" id="listCajeros" name="listCajeros" type="text">
                          </select>
                        </div>
                          
                        <div class="form-group">
                            <label for="listProductos">Elegir Producto</label>
                            <select class="form-control" data-live-search="true" id="txtProductos" name="txtProductos" type="text" placeholder="Lector de productos">
                            </select>

                        </div> 

                   </div>   

                       <div class="row">
                       <div class="col-md-12">
                          <div class="tile">
                          <div class="tile-body">
                              <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="tablePedidosMesa">
                                      <thead>
                                      <tr>
                                       <th>Productos seleccionados</th>
                                       <th>Precio Venta Final</th>
                                       <th>Cantidad</th>
                                       <th>Total Venta</th>
                                      </tr>
                       
                                      </thead>
                                      <tbody>
                                        
                                      </tbody>
                                  
                                </table>
                              </div>
                            </div>
                          </div>
                       </div>
                       
                       </div>

                       <div class="col-md-6">
                         
                        <div class="row">
                        <div class="form-group col-md-6"> <!--btn-lg => largo, btn-block => ocupa todo el ancho del contenedor-->
                            <button id="btnActionForm" class="btn btn-success btn-lg btn-block" type="submit" ><i class="fa fa-fw fa-lg fa-check-circle"></i>
                            <span id="btnText">Enviar Pedido</span></button>
                        </div>

                        <div class="form-group col-md-6">
                        <button class= "btn btn-danger btn-lg  btn-block" type = "button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar Pedido</button>
                        </div>
                            
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