<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Jeason Cueva Espinoza">

    <!-- Icono de la web-->
    <link rel="shorcut icon" href="<?= media(); ?>/images/favicon.ico">
    
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
      <a class="appWhatsapp" target="_blanck" href="https://api.whatsapp.com/send?phone=+51999134381&text=Hola Rest-Food!&nbsp;,me&nbsp;pueden&nbsp;apoyar?">
        <img src="<?= media(); ?>/images/whatsapp.png" alt="Whatsapp" title="Chatea con nosotros!">
      </a>

    

      <div class="login-box">
          <form class="login-form" name="formLogin" id="formLogin" action="">
            <img src="<?= media(); ?>/images/logofood.png" class="text-center" width="250">
            <br><br><br>
      
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Iniciar Sesión</h3>
            
            <div class="form-group">
              <label class="control-label">Usuario</label>
              <input id="txtEmail" name="txtEmail" class="form-control" type="email" placeholder="Correo electrónico" autofocus>
            </div>
            <div class="form-group">
              <label class="control-label">Contraseña</label>
              <input id="txtPassword" name="txtPassword" class="form-control" type="password" placeholder="Contraseña">
            </div>
            <div class="form-group">
              <div class="text-center">
                <p class="semibold-text mb-2"><a href="#" data-toggle="flip">¿Olvidaste tu contraseña?</a></p>
              </div>
            </div>
            <div id="alertLogin" class="text-center"></div>
            <div class="form-group btn-container">
              <button type="submit" class="btn btn-success btn-block"> Iniciar Sesión</button>
            </div>
            <hr>
          </form>
          <!--Formulario para cuando le des click en olvidaste la contraseña-->
          <form id="formRecetPass" name="formRecetPass" class="forget-form" action="">
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>¿Olvidaste tu contraseña?</h3>
            <div class="form-group">
              <label class="control-label">Correo electrónico</label>
              <input id="txtEmailReset" name="txtEmailReset" class="form-control" type="email" placeholder="Correo electrónico">
            </div>
            <div class="form-group btn-container">
              <button type="submit" class="btn btn-success btn-block">Enviar</button>
            </div>
            <div class="form-group mt-3">
              <p class="semibold-text mb-0 text-center"><a href="#" data-toggle="flip"> Iniciar Sesion</a></p>
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