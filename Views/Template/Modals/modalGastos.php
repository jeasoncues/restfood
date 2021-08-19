<!--Modals es como un JOptionPane pero se abre en el centro de la pagina web-->
<!-- Modal -->
<div class="modal fade" id="modalFormGasto" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Gasto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--Formulario para el modal-->
        <div class="tile">
            <div class="tile-body">
                <form id="formGasto" name="formGasto" class="form-horizontal">
                 <input type="hidden" id="idGasto" name="idGasto" value="">
                 <!--Parrafo-->
                 <p class="text-danger">Todos los datos son obligatorios.</p>
                
                 
                   
                   <div class="form-row"><!--tenemos dos columnas  nombre y apellidos-->
                     <div class="form-group col-md-6"><!--ocupa 6 columnas-->
                        <label for="txtNombre">Nombre</label><!--posicionamiento con el for-->
                        <input type="text" class="form-control" id="txtNombre" name="txtNombre">
                     </div>
                     <div class="form-group col-md-6"><!--ocupa 6 columnas-->
                        <label for="txtPrecio">Precio</label><!--posicionamiento con el for-->
                        <input type="text" class="form-control" id="txtPrecio" name="txtPrecio" >
                     </div>
                   </div>

                   <did class="form-row">

                     <div class="form-group col-md-6">
                       <label for="txtFecha">Fecha</label>
                       <input type="date" class="form-control" id="txtFecha"  name="txtFecha">
                    
                     </div>
                     <div class="form-group col-md-6">
                       <label for="listRolid">Tipo usuario</label>
                       <!-- data-live-search="true" ->Buscador-->
                       <select class="form-control" data-live-search="true"  id="listRolid" name="listRolid" >
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