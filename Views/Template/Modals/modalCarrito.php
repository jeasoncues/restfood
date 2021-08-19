<!--Archivo para mostrar productos del carrito-->
<?php
 $total = 0;
 //si existe esta variable de session arrcarrito y la cantidad de registros es mayor que 0 entonces si procedemos a armar todo lo de abajo.
 if(isset($_SESSION['arrCarrito']) and count($_SESSION['arrCarrito']) > 0) {
?>
<ul class="header-cart-wrapitem w-full">
  <?php 
    foreach ($_SESSION['arrCarrito'] as $producto) {
		//calcular el total de venta de los productos
		$total = $total + $producto['cantidad'] * $producto['precio']; //cantidad por precio sumandole el total.
		//encriptamos el id del producto
		$idProducto = openssl_encrypt($producto['idproducto'],METHODENCRIPT,KEY);

  ?>
	<li class="header-cart-item flex-w flex-t m-b-12">
	  <!--idpr => para obtener el id del producto, op otro atributo que  va a servir para eliminar. onclick que enviamos evento que servira para eliminar. -->
		<div class="header-cart-item-img" idpr="<?= $idProducto ?>" op="1" onclick="fntdelItem(this)">
			<img src="<?= $producto['imagen'] ?>" alt="<?= $producto['producto'] ?>">
		</div>

		<div class="header-cart-item-txt p-t-8">
			<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
				<?= $producto['producto'] ?>
		</a>

		<span class="header-cart-item-info">
				<?= $producto['cantidad'].' x '.SMONEY.formatoMoney($producto['precio']) ?>
		</span>
		</div>
	</li>
	<?php  } ?>
</ul>
				
<div class="w-full">
		<div class="header-cart-total w-full p-tb-40">
			Total: <?= SMONEY.formatoMoney($total); ?>
		</div>

		<div class="header-cart-buttons flex-w w-full">
			<a href="<?= base_url() ?>/carrito" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
				Ver Carrito
			</a>

			<a href="<?= base_url() ?>/carrito/procesarpago" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
				Procesar pago
			</a>
		</div>
</div>
<?php } ?>