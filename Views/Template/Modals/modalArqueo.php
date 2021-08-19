<!--Modals es como un JOptionPane pero se abre en el centro de la pagina web-->
<!-- Modal -->
<div class="modal fade" id="modalFormArqueo" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Arqueo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--Formulario para el modal-->
        <div class="tile">
            <div class="tile-body">
                <form id="formArqueo" name="formArqueo" class="form-horizontal">
                 <input type="hidden" id="idArqueo" name="idArqueo" value="">
                 <!--Parrafo-->
                 <p class="text-danger">Todos los datos son obligatorios.</p>
                
        

                   <did class="form-row">

                     <div class="form-group col-md-6">
                       <label for="txtFecha">Fecha</label>
                       <input type="date" class="form-control" id="txtFecha"  name="txtFecha">
                    
                     </div>
                     <div class="form-group col-md-6">
                        <label for="listTurno">Turno</label>
                       <!-- selectpicker ->Mantiene presionado-->
                       <select class="form-control selectpicker" id="listTurno" name="listTurno">
                          <option value="1">Mañana</option>
                          <option value="2">Noche</option>
                       </select>
                     </div>

                   </div>

                   <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="txtcajachica">Caja Chica</label>
                      <input type="number" class="form-control" id="txtcajachica" name="txtcachachica">
                    </div>
                   
                    <div class="form-group col-md-6">
                       <label for="listEstado">Estado</label>
                       <select class="form-control selectpicker" id="listEstado" name="listEstado">
                          <option value="1">Abierto</option>
                          <option value="2">Cerrado</option>
                       </select>
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