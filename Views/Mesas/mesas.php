<?php 
  headerAdmin($data);
  getModal('modalMesas',$data);
?>

<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fas fa-edit"></i> <?= $data['page_title'] ?> 
          </h1>
 
        </div>
      

        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/mesas"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body"> ¿Que tál <?= $_SESSION['userData']['nombres'];?>? Agrega una mesa aqui, mucha suerte.   
            <!--Funcion onclick llama al metodo openModel de javascript para abrir el formulario -->
            <button class= "btn btn-success" type="button" onclick="openModal();"><i class="fas fa-plus-circle"></i> Agregar Mesa</button>
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
                <table class="table table-hover table-bordered" id="tableMesas">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nombre</th>
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


<?php 
  
  footerAdmin($data);
 
?>