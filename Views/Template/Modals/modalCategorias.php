<!--Modals es como un JOptionPane pero se abre en el centro de la pagina web-->
<!-- Modal -->
<div class="modal fade" id="modalFormCategoria" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nueva Categoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--Formulario para el modal-->
        <div class="tile">
            <div class="tile-body">
                <form id="formCategoria" name="formCategoria" class="form-horizontal">
                 <input type="hidden" id="idCategoria" name="idCategoria" value="">
                 <!--Parrafo-->
                 <p class="text-danger">Los campos con asterisco <span class="required">(*)</span> son obligatorios</p>
                 
                 <!-- fila con 6 columnas col-md-6-->
                 <div class="row">
                   <div class="col-md-6">
                        <input type="hidden" id="idCategoria" name="idCategoria" value="">
                        <div class="form-group">
                            <label class="control-label">Nombre <span class="required">*</span></label>
                            <input class="form-control" id="txtnombre" name="txtnombre" type="text" placeholder="Nombre Categoria">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Descripcion <span class="required">*</span></label>
                            <textarea class="form-control" id="txtdescripcion" name="txtdescripcion" rows="2" placeholder="Descripcion de la Categoria">
                            </textarea>
                        </div> 

                        <div class="form-group">
                            <label for="exampleSelect1">Estado <span class="required">*</span></label>
                            <select class="form-control" id="listStatus" name="listStatus">
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>    
                        </div>                   
                   </div>

                   <div class="col-md-6">
                     <div class="photo">
                       <label for="foto">Foto (570x380)</label><!--ancho y alto para cargar imagen-->
                       <div class="prevPhoto">
                       <span class="delPhoto notBlock">X</span>
                        <label for="foto"></label> <!--ancho para seleccionar foto-->
                        <div>
                          <img id="img" src="<?= media(); ?>/images/portada_categoria.png">
                        </div>
                       </div>
                       <div class="upimg">
                        <input type="file" name="foto" id="foto">
                       </div>
                       <div id="form_alert"></div> <!-- en caso la imagen no sea formato png jpg jpeg-->
                     </div>
                   </div>
                 </div>
               
                    <div class="tile-footer"> 
                       <button id="btnActionForm" class="btn btn-secondary" type="submit" ><i class="fa fa-fw fa-lg fa-check-circle"></i>
                       <span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                       <button class= "btn btn-danger" type = "button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</button>
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
<div class="modal fade" id="modalViewCategoria" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos de la Categoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--Formulario para el modal-->
        <div class="tile">
            <div class="tile-body">
               <!--tabla para datos de la categoria-->
               <table class="table table-bordered">
               <tbody>
                 <tr>
                  <td>ID:</td>
                  <td id="celId"></td>
                 </tr>
                 <tr>
                    <td>Nombre:</td>
                    <td id="celNombre"></td>
                 </tr>
                 <tr>
                    <td>Descripcion:</td>
                    <td id="celDescripcion"></td>
                 </tr>
             

                 <tr>
                    <td>Estado:</td>
                    <td id="celStatus">Jeason</td>
                 </tr>

                 <tr>
                   <td>Foto:</td>
                   <td id="celFoto"></td>
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