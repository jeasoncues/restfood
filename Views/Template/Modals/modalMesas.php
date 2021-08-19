
<div class="modal fade" id="modalFormMesa" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-mg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nueva Mesa</h5>
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
                 <!--Parrafo-->
                 <p class="text-danger">Los campos con asterisco <span class="required">(*)</span> son obligatorios</p>
                 
                 <!-- fila con 6 columnas col-md-6-->
                 <div class="row">
                   <div class="col-md-6">
                        <input type="hidden" id="idMesa" name="idMesa" value="">
                        <div class="form-group">
                            <label class="control-label">Nombre <span class="required">*</span></label>
                            <input class="form-control" id="txtnombre" name="txtnombre" type="text" placeholder="Ej. Mesa 01">
                        </div>
       
                   </div>

                   
                   <div class="form-group col-md-6">
                            <label for="listStatus">Estado</label>
                            <select class="form-control" id="listStatus" name="listStatus">
                                <option value="1">Libre</option>
                                <option value="2">Ocupada</option>
                            </select> 
                    </div>

                   <div class="col-md-6">
                     <div class="photo">
                       <label for="foto">Foto (128x128)</label><!--ancho y alto para cargar imagen-->
                       <div class="prevMesa">
                       <span class="delPhoto notBlock">X</span>
                        <label for="foto"></label> <!--ancho para seleccionar foto-->
                        <div>
                          <img id="img" src="<?= media(); ?>/images/mesa3.png">
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