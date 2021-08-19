<!DOCTYPE html>
<html lang="en">
  <head>
    <!--Codificacion de caracteres especiales-->
    <meta charset="utf-8">
    <!-- Descripcion en la web-->
    <meta name="description" content="Encuentra las mejores ofertas de Restaurante Donattos en Piura">
    <!--Meta de compatibilidad con el navegador EDGE-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--Reponsi para dispositivos moviles-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Meta para el autor del sitio web-->
    <meta name="author" content="Jeason Cueva Espinoza">
    <!--Color del template-->
    <meta name="theme-color" content="#009688"> 
    <!-- Icono de la web-->
    <link rel="shorcut icon" href="<?= media(); ?>/images/favicon.ico">
    
    <title><?= $data['page_tag'] ?></title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/style.css">
    <!-- Font-icon css-->
    
  </head>
  
  <body class="app sidebar-mini">
     
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="<?=base_url();?>/dashboard"><img src="<?= media(); ?>/images/logofood.png" width="100px"></a>
  
      <!-- Sidebar toggle button-->
      <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
       
      <!-- Navbar Right Menu-->
      <ul class="app-nav">

      <li class="app-search">
          <input class="app-search__input" type="search" placeholder="Buscar">
          <button class="app-search__button"><i class="fa fa-search"></i></button>
        </li>
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-cog fa-lg"></i></a>
      
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="<?=base_url();?>/usuarios/perfil"><i class="fa fa-user fa-lg"></i> Perfil</a></li>
            <li><a class="dropdown-item" href="<?=base_url();?>/logout"><i class="fa fa-sign-out fa-lg"></i> Cerrar Sesion</a></li>
          </ul>
        </li>
      </ul>


    </header>

    <!--Requerimos el menu de navegacion-->
    <?php require_once("nav_admin.php"); ?>