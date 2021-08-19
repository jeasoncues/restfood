<?php
  headerAdmin($data);
  getModal('modalProductos',$data);
?>

<!--Cuerpo de la Pagina-->
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fas fa-box"></i> <?= $data['page_title'] ?> 
          <!--Validacion para los permisos de actuaalizar-->
          <?php if($_SESSION['permisosMod']['w']){ ?>
             <!--Funcion onclick llama al metodo openModel de javascript para abrir el formulario -->
             <button class= "btn btn-secondary" type="button" onclick="openModal();"><i class="fas fa-plus-circle"></i>Nuevo</button>
          <?php } ?>
          
          </h1>
     
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/productos"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>

      <!--Tabla -->
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tableProductos">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Codigo</th>
                      <th>Nombre</th>
                      <th>Stock</th>
                      <th>Precio</th>
                      <th>Estado</th>
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


<?php footerAdmin($data); ?>
    