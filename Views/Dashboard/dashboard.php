
<!--Requerimos el header-->
<?php  headerDashboard($data);
?>
<!--Cuerpo de la Pagina-->
     
    <main class="app-content">
    
      <div class="app-title">
        <div>
          <h1><i class=""></i> <?= $data['page_title'] ?> </h1>

      
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard"><?= $data['page_title1'] ?></a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">¡Bienvenido <?= $_SESSION['userData']['nombres'];?> a una nueva era en la plataforma digital!</div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-6">
           <div class="tile">
             <h4><?= $_SESSION['userData']['nombres'];?> , ¿Quieres que tu restaurante sea parte de nuestra Tienda Virtual?, completa este formulario y nos contactamos contigo.</h4>

             <hr>
             <form id="formRegister">
                                       <div class="row"> <!--fila-->
                                           <!-- 6 columnas del contener-->
                                           <div class="col col-md-6 form-group">
                                               <label for="txtNombre">Nombre</label>
                                               <!-- valid sirve para validar-->
                                               <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" required="">
                                           </div>
                                           <div class="col col-md-6 form-group">
                                               <label for="txtApellido">Apellido</label>
                                               <input type="text" class="form-control valid validText" id="txtApellido" name="txtApellido" required="">
                                           </div>
                                       </div>
                                       <div class="row"> <!-- valid sea numerico, onkeypress=> cuando presionamos la tecla se ejecuta la funcion controltag verficiando que sea un numero.-->
                                           <div class="col col-md-6 form-group">
                                               <label for="txtTelefono">Teléfono</label>
                                               <input type="text" class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" required="" onkeypress="return controlTag(event);">
                                           </div>
                                           <div class="col col-md-6 form-group">
                                               <label for="txtEmailCliente">Email</label>
                                               <input type="email" class="form-control valid validEmail" id="txtEmailCliente" name="txtEmailCliente" required="">
                                           </div>
                                       </div>
                                       <button type="submit" class="btn btn-success"> <i class="fa fa-fw fa-lg fa-check-circle"></i>Registrate</button>
                                   </form>
           </div>
        </div>

        <div class="col-md-3">
           <div class="tile text-center">
             <img src="<?= media(); ?>/images/descarga.png">
             <br>
             <hr>
             <a href="<?= base_url() ?>" target="_blanck">www.restfood.com</a>
           </div>
        </div>

        <div class="col-md-3">
           <div class="tile text-center">
             <img src="<?= media(); ?>/images/logo1.png">
                          <hr>
             <h2>Rest Food Delivery</h2>
             <p>Version Prueba - 1 mes gratuito</p>

           </div>
        </div>


      </div>
      </div>
     
     
      <div class="row">
        <div class="col-md-3">
          <div class="widget-small warning"><i class="icon fa fa-users fa-3x"></i>
            <div class="info">
              <h4>Usuarios</h4>
              <p><b>20</b></p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="widget-small info"><i class="icon fa fa-users fa-3x"></i>
            <div class="info">
              <h4>Clientes</h4>
              <p><b>20</b></p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="widget-small warning"><i class="icon fa fa-files-o fa-3x"></i>
            <div class="info">
              <h4>Reportes</h4>
              <p><b>10</b></p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="widget-small danger"><i class="icon fas fa-money-check-alt"></i>
            <div class="info">
              <h4>Gastos</h4>
              <p><b>500</b></p>
            </div>
          </div>
        </div>
      </div>


        <div class="row">
        <div class="col-md-3">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-money-check-alt"></i>
            <div class="info">
              <h4>Ventas</h4>
              <p><b>1000</b></p>
            </div>
          </div>
        </div>
        
        <div class="col-md-3">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-cart-arrow-down"></i>
            <div class="info">
              <h4>Pedidos Online</h4>
              <p><b>03</b></p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-utensils"></i>
            <div class="info">
              <h4>Pedidos en Cocina</h4>
              <p><b>03</b></p>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-cc-paypal"></i>
           <div class="info">
             <h4>Pagos por PayPal<h4>
             <p><b>02</b></p>
           </div>
          </div>
        
        </div>
      </div>
     
      
     
      

      

      
   
      
       
    </main>

    </main>

<!--Requerimos el footer-->
<?php footerAdmin($data); ?>
    