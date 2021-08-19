<!--Para abrir el modal-->
<?php headerAdmin($data); 
   getModal('modalGastos',$data);
?>
<!--Cuerpo de la Pagina-->
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fas fa-edit"></i> <?= $data['page_title'] ?> 
          </h1>
 
        </div>
      

        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/gastos"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body"> ¿Que tál <?= $_SESSION['userData']['nombres'];?>? Agrega un gasto aqui, mucha suerte.   
            <!--Funcion onclick llama al metodo openModel de javascript para abrir el formulario -->
            <button class= "btn btn-success" type="button" onclick="openModal();"><i class="fas fa-plus-circle"></i> Agregar Gasto</button>
            </div>
          </div>
        </div>
      </div>

      <!--Tabla -->
      
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tableGastos">
                  <thead>
                    <tr>
                      <th>Codigo</th>
                      <th>Nombre</th>
                      <th>Precio</th>
                      <th>Fecha</th>
                      <th>Rol</th>
                      <th>Acciones</th>
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
    </main>

<!--Requerimos el footer-->
<?php footerAdmin($data); ?>
    