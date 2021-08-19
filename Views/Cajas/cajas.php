<!--Para abrir el modal-->
<?php headerAdmin($data); 
 getModal('modalArqueo',$data);
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
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/cajas"><?= $data['page_title'] ?></a>
          </li>
        </ul>
      </div>

      <div class="card text-center text-white bg-dark mb-3" style="width: 18rem;">
        <img class="card-img-top" src="<?= media(); ?>/images/tienda.jfif" alt="Card image cap">
        <div class="card-header">

    
        <button id="boton" class= "btn btn-danger" type="button" onclick="openModal();"> Cerrado </button>
        </div>
      </div>
  
      <br>
      <br><br><br><br><br><br><br><br><br><br>
      <div class="text-right">
      <img src="<?= media(); ?>/images/caja.png" alt="">
      </div>
    
      
    </main>
    


<!--Requerimos el footer-->
<?php  footerAdmin($data); ?>
    