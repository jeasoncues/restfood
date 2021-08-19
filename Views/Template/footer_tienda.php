
<!-- Footer - parte de abajo -->
<footer class="bg3 p-t-75 p-b-32">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Categorias
					</h4>

					<ul>
						<li class="p-b-10">
							<a href="" class="stext-107 cl7 hov-cl1 trans-04">
								Ceviches
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Chicharron
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Sudados
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Otros Platos
							</a>
						</li>
					</ul>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Información
					</h4>

					<ul>
						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								¿Quienes Somos?
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Terminos y Condiciones
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Privacidad y Seguridad
							</a>
						</li>
					</ul>
				</div>

				
				<div class="col-sm-6 col-lg-3 p-b-50">
				
					<h4 class="stext-301 cl0 p-b-30"> 
						Contacto
					</h4>

					<p class="stext-107 cl7 size-201">
					    San Jose Calle 11 - 001 <br>
						Tel. (+51) 999 134 381
					</p>

					<div class="p-t-27"> <!-- target blanck hace que se muestre en otra pestaña-->
						<a href="https://www.facebook.com/Rest-Food-106218571401767" target="_blanck"class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-facebook"></i>
						</a>

						<a href="" target="_blanck" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-instagram"></i>
						</a>

					</div>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Suscribete
					</h4>

					<form>
						<div class="wrap-input1 w-full p-b-4">
							<input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email" placeholder="restfood@gmail.com">
							<div class="focus-input1 trans-04"></div>
						</div>

						<div class="p-t-18">
							<button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
								Suscribirme
							</button>
						</div>
					</form>
				</div>
			</div>
           
		   <!-- Iconos de pago-->
			<div class="p-t-40">
				<div class="flex-c-m flex-w p-b-18">
					<a href="#" class="m-all-1">
						<img src="<?= media() ?>/tienda/images/icons/icon-pay-01.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="<?= media() ?>/tienda/images/icons/icon-pay-02.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="<?= media() ?>/tienda/images/icons/icon-pay-03.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="<?= media() ?>/tienda/images/icons/icon-pay-04.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="<?= media() ?>/tienda/images/icons/yape1.jpg" width="35px" height="25px"  alt="ICON-PAY">
					</a>
				</div>


                <!--Derechos de autor-->
				<p class="stext-107 cl6 txt-center">
					
                <?=  NOMBRE_EMPRESA; ?> | <?= WEB_EMPRESA; ?> | ©Copyright
				</p>
			</div>
		</div>
	</footer>


	<!-- ICONO QUE ENVIA A LA PARTE SUPERIOR-->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>
   

   <!-- VARIABLE PARA LA RUTA Y LA MONEDA-->
	<script>
	  const base_url = "<?= base_url(); ?>";
	  const smony = "<?= SMONEY; ?>";
	</script>

	

<!--===============================================================================================-->	
	<script src="<?= media() ?>/tienda/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/bootstrap/js/popper.js"></script>
	<script src="<?= media() ?>/tienda/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?= media() ?>/tienda/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/slick/slick.min.js"></script>
	<script src="<?= media() ?>/tienda/js/slick-custom.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/parallax100/parallax100.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>

<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/isotope/isotope.pkgd.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/sweetalert/sweetalert.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>

<!--===============================================================================================-->
	<script src="<?= media() ?>/tienda/js/main.js"></script>

<!-- Agregamos script del admin administrativo para validacion de campos-->
<script src="<?= media() ?>/js/functions_admin.js"></script>
<!--Agregando script del login administrativo-->
<script src="<?= media() ?>/js/functions_login.js"></script>	

<!--Agregando script para el carrito-->
	<script src="<?= media() ?>/tienda/js/functions.js"></script>



</body>
</html>