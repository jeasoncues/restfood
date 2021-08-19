<!--Modals es como un JOptionPane pero se abre en el centro de la pagina web-->
<!-- Modal -->
<div class="modal fade" id="modalFormUsuario" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--Formulario para el modal-->
        <div class="tile">
            <div class="tile-body">
                <form id="formUsuario" name="formUsuario" class="form-horizontal">
                 <input type="hidden" id="idUsuario" name="idUsuario" value="">
                 <!--Parrafo-->
                 <p class="text-danger">Todos los datos son obligatorios.</p>
                 
                   <div class="form-row">
                     <div class="form-group col-md-6"><!--ocupa 6 columnas-->
                        <label for="txtIdentificacion">Identificacion</label><!--posicionamiento con el for-->
                        <input type="text" class="form-control" id="txtIdentificacion" name="txtIdentificacion">
                     </div>
                   </div>
                 
                   
                   <div class="form-row"><!--tenemos dos columnas  nombre y apellidos-->
                     <div class="form-group col-md-6"><!--ocupa 6 columnas-->
                        <label for="txtNombre">Nombres</label><!--posicionamiento con el for-->
                        <input type="text" class="form-control" id="txtNombres" name="txtNombres">
                     </div>
                     <div class="form-group col-md-6"><!--ocupa 6 columnas-->
                        <label for="txtApellidos">Apellidos</label><!--posicionamiento con el for-->
                        <input type="text" class="form-control" id="txtApellidos" name="txtApellidos" >
                     </div>
                   </div>



                   <div class="form-row"><!--tenemos dos columnas  nombre y apellidos-->
                     <div class="form-group col-md-6"><!--ocupa 6 columnas-->
                        <label for="txtTelefono">Telefono</label><!--posicionamiento con el for-->
                        <input type="text" class="form-control" id="txtTelefono" name="txtTelefono" >
                     </div>
                     <div class="form-group col-md-6"><!--ocupa 6 columnas-->
                        <label for="txtApellidos">Email</label><!--posicionamiento con el for-->
                        <input type="email" class="form-control" id="txtEmail" name="txtEmail">
                     </div>
                   </div>

                   <did class="form-row">
                     <div class="form-group col-md-6">
                       <label for="listRolid">Tipo usuario</label>
                       <!-- data-live-search="true" ->Buscado-->
                       <select class="form-control" data-live-search="true"  id="listRolid" name="listRolid" >
                       </select>
                     </div>
                     <div class="form-group col-md-6">
                       <label for="listStatus">Status</label>
                       <!-- selectpicker ->Mantiene presionado-->
                       <select class="form-control selectpicker" id="listStatus" name="listStatus">
                          <option value="1">Activo</option>
                          <option value="2">Inactivo</option>
                       </select>
                     </div>
                    </div>

                    <div class="form-row">
                     <div class="form-group col-md-6"><!--ocupa 6 columnas-->
                        <label for="txtPassword">Password</label><!--posicionamiento con el for-->
                        <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                     </div>
                   </div>
 
                    <div class="tile-footer"> 
                       <button id="btnActionForm" class="btn btn-success" type="submit" ><i class="fa fa-fw fa-lg fa-check-circle"></i>
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

<!--Modals para ver Usuario-->
<!-- Modal -->
<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!--Formulario para el modal-->
        <div class="tile">
            <div class="tile-body">
               <!--tabla para datos del usuario-->
               <table class="table table-bordered">
               <tbody>
                 <tr>
                    <td>Identificación:</td>
                    <td id="celIdentificacion">02632434:</td>
                 </tr>
                 <tr>
                    <td>Nombres:</td>
                    <td id="celNombre">Jeason</td>
                 </tr>
                 <tr>
                    <td>Apellidos:</td>
                    <td id="celApellido">Jeason</td>
                 </tr>
                 <tr>
                    <td>Telefono:</td>
                    <td id="celTelefono">Jeason</td>
                 </tr>
                 <tr>
                    <td>Email:</td>
                    <td id="celEmail">Jeason</td>
                 </tr>
                 <tr>
                    <td>Tipo Usuario:</td>
                    <td id="celTipoUsuario">Jeason</td>
                 </tr>
                 <tr>
                    <td>Estado:</td>
                    <td id="celEstado">Jeason</td>
                 </tr>
                 <tr>
                    <td>Fecha Registro:</td>
                    <td id="celFechaRegistro">Jeason</td>
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