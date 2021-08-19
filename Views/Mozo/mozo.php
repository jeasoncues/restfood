<!--Para abrir el modal-->
<?php headerAdmin($data); 
 //getModal('modal',$data);
 $arrMesas =  $data['mesas'];
?>
<!--Cuerpo de la Pagina-->
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fas fa-edit"></i> <?= $data['page_title'] ?> 

        </div>
      
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/mozo"><?= $data['page_title'] ?></a>
          </li>
        </ul>
      </div>

      <div class="row text-center">
        <div class="col-md-12">
          <div class="tile">
           <div class="tile-body">
           <?php 
             for ($i=0; $i < count($arrMesas); $i++) 
             {
           ?>
            &nbsp; &nbsp; &nbsp;
            <a href="<?= base_url()?>/pos" class="btn btn-success" type="button" onclick="openModal();">
                <img src="<?= $arrMesas[$i]['imagen'] ?>" alt="<?= $arrMesas[$i]['nombre'] ?>">
                <h2> <?= $arrMesas[$i]['nombre'] ?> </h2>
             </a>
           <?php } ?>
           </div>

           <div class="tile">
           <div class="tile-body">
           </div>
          </div>
     
      </div>

    </main>

<!--Requerimos el footer-->
<?php footerAdmin($data); ?>
    