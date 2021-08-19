<!--Para abrir el modal-->
<?php headerAdmin($data); 

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
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/ventas"><?= $data['page_title'] ?></a></li>
        </ul>
      </div>
    



    </main>

<!--Requerimos el footer-->
<?php footerAdmin($data); ?>
    