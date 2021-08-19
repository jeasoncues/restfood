<?php 
 $cantCarrito = 0;
 //si existe la variable de session y la cantidad de registros es mayor a 0 entonces va a recorrer con un foreach
 if(isset($_SESSION['arrCarrito']) and count($_SESSION['arrCarrito']) > 0){
    foreach($_SESSION['arrCarrito'] as $product){
		$cantCarrito = $cantCarrito + $product['cantidad']; //contamos los elementos del carrito.
	}
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title><?= $data['page_tag']; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
  <!-- Compatible con el explorador edge -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?= media() ?>/images/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/fonts/linearicons-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/vendor/slick/slick.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/vendor/MagnificPopup/magnific-popup.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tienda/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/css/style.css">
<!--===============================================================================================-->
</head>
<body class="animsition">
	
	<!-- Header -->
	<header>
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<!-- Topbar -->
			<div class="top-bar">
				<div class="content-topbar flex-sb-m h-full container">
				<?php 
				    if(isset($_SESSION['login'])){
				?>
					<div class="left-top-bar">
						Bienvenido: <?= $_SESSION['userData']['nombres'].' '.$_SESSION['userData']['apellidos']?>
					
					</div>
				<?php }
				   else{ 
					 echo $inicio = '<div class="left-top-bar">   </div>';
					  
				   } 
				
				?>

					<div class="right-top-bar flex-w h-full">
						<a href="#" class="flex-c-m trans-04 p-lr-25">
							Help & FAQs
						</a>
				    
				<?php
				
                   if(isset($_SESSION['login'])){
				?>
						<a href="<?= base_url(); ?>/cuenta" class="flex-c-m trans-04 p-lr-25">
							Mi cuenta
						</a>
				
				<?php }else{

					 echo  $cuenta = '<div class="right-top-bar flex-w h-full">
										<a href="#" class="flex-c-m trans-04 p-lr-25">
											Iniciar Sesion
										</a>';
				} ?>
					
						<?php
                            if(isset($_SESSION['login'])){
						?>
						<a href="<?= base_url(); ?>/logout" class="flex-c-m trans-04 p-lr-25">
							Salir
						</a>

						<?php } ?>
					</div>
				</div>
			</div>

			<div class="wrap-menu-desktop">
				<nav class="limiter-menu-desktop container">
					
					<!-- Logo desktop -->		
					<a href="<?= base_url(); ?>" class="logo">
						<img src="<?= media(); ?>/tienda/images/icons/rest.png" alt="Tienda Online">
					</a>

					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
							<li class="active-menu">
								<a href="<?= base_url(); ?>">Inicio</a>
							</li>

							<li>
								<a href="<?= base_url(); ?>/tienda">Tienda</a>
							</li>

							<li>
								<a href="<?= base_url(); ?>/carrito">Carrito</a>
							</li>

							<li>
								<a href="<?= base_url(); ?>/nosotros">Nosotros</a>
							</li>

							<li>
								<a href="<?= base_url(); ?>/contacto">Contacto</a>
							</li>

						</ul>
					</div>	

					<!-- Iconos del menu -->
					<div class="wrap-icon-header flex-w flex-r-m">
						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
							<i class="zmdi zmdi-search"></i>
						</div>
						
						<?php 
				          if($data['page_name'] != "carrito" and $data['page_name'] != "procesarpago"){   //si es diferente de carrito o a procesarpago que si se muestre caso contrario no se mostrara el icono de carrito
				        ?>
						<div class="cantCarrito icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="<?php echo $cantCarrito; ?>">
							<i class="zmdi zmdi-shopping-cart"></i>
						</div>
						<?php } ?>

			
					</div>
				</nav>
			</div>	
		</div>

		<!-- Vista para Mobil-->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->		
			<div class="logo-mobile">
				<a href="<?= base_url(); ?>"><img src="<?= media() ?>/tienda/images/icons/rest.png" alt="Tienda Online"></a>
			</div>

			<!-- Icon header -->
			<div class="wrap-icon-header flex-w flex-r-m m-r-15">
				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
					<i class="zmdi zmdi-search"></i>
				</div>
				
				<?php 
				    if($data['page_name'] != "carrito" and $data['page_name'] != "procesarpago"){   //si es diferente de carrito que si se muestre
				?>
				<div  class="cantCarrito icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="<?php echo $cantCarrito; ?>">
					<i class="zmdi zmdi-shopping-cart"></i>
				</div>
			   <?php } ?>
		
			</div>

			<!-- Button de menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>


		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="topbar-mobile">
				<li>
					<div class="left-top-bar">
						Bienvenido Jeason 
					</div>
				</li>

				<li>
					<div class="right-top-bar flex-w h-full">
						<a href="#" class="flex-c-m p-lr-10 trans-04">
							Help & FAQs
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							Mi cuenta
						</a>

					
						<a href="#" class="flex-c-m p-lr-10 trans-04">
							Salir
						</a>
					</div>
				</li>
			</ul>
           
			<ul class="main-menu-m">
				<li>
					<a href="<?= base_url(); ?>">Inicio</a>
				
				</li>

				<li>
					<a href="<?= base_url(); ?>/tienda">Tienda</a>
				</li>

				<li>
					<a href="<?= base_url(); ?>/carrito">Carrito</a>
				</li>

				<li>
					<a href="<?= base_url(); ?>/nosotros">Nosotros</a>
				</li>

				<li>
					<a href="<?= base_url(); ?>/contacto">Contacto</a>
				</li>
			</ul>
		</div>

		<!-- Modal Buscar -->
		<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					<img src="<?= media() ?>/tienda/images/icons/icon-close2.png" alt="CLOSE">
				</button>

				<form class="wrap-search-header flex-w p-l-15">
					<button class="flex-c-m trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>
					<input class="plh3" type="text" name="search" placeholder="Hola! ¿En qué te puedo ayudar?">
				</form>
			</div>
		</div>
	</header>

	<!-- Modal Carrito-->
<div class="wrap-header-cart js-panel-cart">
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-65 p-r-25">
			<div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					Carrito de compra 
				</span>

				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>
			
			<div id="productosCarrito" class="header-cart-content flex-w js-pscroll">
				<?php getModal('modalCarrito',$data); ?>
			
			</div>
		</div>
	</div>

	<a class="appWhatsapp" target="_blanck" href="https://api.whatsapp.com/send?phone=+51955459147&text=Hola!&nbsp;me&nbsp;pueden&nbsp;apoyar?">
      <img src="<?= media(); ?>/images/whatsapp.png" alt="Whatsapp">
    </a>