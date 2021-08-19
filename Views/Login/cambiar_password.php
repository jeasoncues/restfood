<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Jeason Cueva Espinoza">
    <!--Color del template-->
    <meta name="theme-color" content="#009688"> 
    <!-- Icono de la web-->
    <link rel="shorcut icon" href="<?= media(); ?>/images/iconFrmDonatos.ico">
    
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/style.css">

    <title><?= $data['page_tag']; ?></title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    
    <section class="login-content">
      <div class="logo">
        <h1><?= $data['page_title1']; ?></h1>
      </div>
    
      <div class="login-box flipped">
        <!--Formulario para cuando le des click en olvidaste la contraseña-->
        <form id="formCambiarPass" name="formCambiarPass" class="forget-form" action="">
         <input type="hidden" id="idUsuario" name="idUsuario" value="<?= $data['idpersona']; ?>" required>
         <input type="hidden" id="txtEmail" name="txtEmail" value="<?= $data['email']; ?>" required>
         <input type="hidden" id="txtToken" name="txtToken" value="<?= $data['token']; ?>" required>
          <h3 class="login-head"><i class="fas fa-key"></i> Cambiar contraseña</h3>
          <div class="form-group">
            <input id="txtPassword" name="txtPassword" class="form-control" type="password" placeholder="Nueva contraseña" required>
          </div>

          <div class="form-group">
            <input id="txtPasswordConfirm" name="txtPasswordConfirm" class="form-control" type="password" placeholder="Confirmar contraseña" required>
          </div>

          <div class="form-group btn-container">
            <button type="submit" class="btn btn-secondary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>REINICIAR</button>
          </div>
        </form>
      </div>
    </section>
    <script>
        const base_url = "<?= base_url(); ?>";
    </script>
    
    
    <!-- Essential javascripts for application to work-->
    <script src="<?= media(); ?>/js/jquery-3.3.1.min.js"></script>
    <script src="<?= media(); ?>/js/popper.min.js"></script>
    <script src="<?= media(); ?>/js/bootstrap.min.js"></script>
    <script src="<?= media(); ?>/js/fontawesome.js"></script>
    <script src="<?= media(); ?>/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?= media(); ?>/js/plugins/pace.min.js"></script>
    <script src="<?= media(); ?>/js/plugins/sweetalert.min.js"></script>

    <!--Validacion para el js del login-->
    <?php if($data['page_name']== "login"){ ?>
    <script src="<?= media(); ?>/js/functions_login.js"></script>
    <?php    } ?>
  </body>
</html>