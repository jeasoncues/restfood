<?php
 headerTienda($data);
 $subtotal = 0;
 $total = 0;
 foreach ($_SESSION['arrCarrito'] as $producto) {
    $subtotal += $producto['precio'] * $producto['cantidad'];
 }
 $total =  $subtotal + COSTOENVIO;
?>

<!-- APi de PayPal -->
<!-- currenci => le agregamos la variable gloabl CURRENCY que sera el tipo de moneda-->
<script
    src="https://www.paypal.com/sdk/js?client-id=<?= IDCLIENTE ?>&currency=<?= CURRENCY ?>"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.
</script>

<!-- Renderizamos los botones de la Api de PayPal con su respectivo id. -->
<!-- Enviar cantidad a pagar a la api de paypal-->
<script>
  paypal.Buttons({
    createOrder: function(data, actions) {
      // mostramos el total en la api de pago de paypal
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: '<?= $total; ?>'
          },
          description: "Compra de articulos en <?= NOMBRE_EMPRESA ?> por <?= SMONEY.$total ?>"
        }]
      });
    },
    //detalles de la compra por paypal
    onApprove: function(data, actions) {
      // funcion de transaccion , datos de la transaccion nombre de la persona, fecha y hora, cantidad, tipo de moneda.
      return actions.order.capture().then(function(details) {

        //ENVIAR INFORMACION POR AJAX
        let base_url = "<?= base_url(); ?>"; 
        /* obtenemos los valores que se escriben en las cajas de texto */
        let direccion = document.querySelector("#txtDireccion").value;
        let ciudad =  document.querySelector("#txtCiudad").value;
        let inttipopago = 1; /* valor por defecto 1 que es PayPal */

        /* implementar ajax */
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url +'/Tienda/procesarVenta'; // metodo para procesar venta
        let formData = new FormData(); //creamos un formulario de tipo dato y colocamos los campos de abajo.
        formData.append('direccion', direccion);
        formData.append('ciudad',ciudad);
        formData.append('inttipopago',inttipopago);
        formData.append('datapay',JSON.stringify(details)); /*convertimos la informacion que viene de la api a JSON y le colocamos al elemento 'datapay' */
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
          if(request.readyState != 4) return; 
          if(request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                 window.location =  base_url+"/tienda/confirmarpedido/"; //redireccionamos a la confirmacion de pedido.
            }else{
              swal("", objData.msg , "error");
            }
          }
        }
      });
    }
  }).render('#paypal-btn-container'); /*renderizamos los botones de api de paypal */
</script>

<!-- Modal de terminos de condiciones-->
<div class="modal fade" id="modalTerminos" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- Tamaño del modal-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Términos y Condiciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>La plataforma de RESTFOOD es una herramienta tecnológica que, haciendo uso de internet, facilita la intermediación entre repartidores independientes  y los Usuarios que requieren del servicio de reparto mediante el uso de una plataforma tecnológica (en adelante, la “Aplicación”) entendiéndose dicha operación a los efectos de los presentes Términos y Condiciones como el  “Servicio de Reparto”, el cual esejecutado a través de un contrato de mandato, donde el RestFood delivery actúa como mandatario  y el Usuario funge como mandante en la presente relación. RESTFOOD actúa en todo momento como tercero intermediario entre RestFood delivery y Usuarios. Asimismo, usted reconoce que RESTFOOD no presta servicios de reparto, mensajería, transporte ni logística. Bajo ninguna circunstancia los RestFood delivery serán considerados empleados por RESTFOOD ni por ninguno de sus afiliados. </p>
        <br>
 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- modal cuenta bancaria-->
<div class="modal fade" id="modalcuentabancaria" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
   <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title"><strong>Nuestros detalles bancarios</strong></h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
     <br>
      <div class="text-center">
        <p>Banco: <strong> Caja Piura </strong></p>
        <p>Ahorro corriente: <strong> 210-01-1308249 </strong></p>
        <p>CCI: <strong> 80100121001130824995</strong></p>
        <hr>
      </div>
      <div class="text-center">
       <hr>
       <p>Banco: <strong> Banco de Crédito del Perú</strong></p>
       <p>Ahorro corriente: <strong> 291-02-1239283 </strong></p>
       <p>CCI: <strong> 723712831293291392</strong></p>

      </div>
    </div>
    <div class="modal-footer">
     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
   </div>
  </div>
</div>

<br><br><br>
<hr>

	<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="<?=  base_url() ?>" class="stext-109 cl8 hov-cl1 trans-04">
				Inicio
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				<?= $data['page_title']; ?>
			</span>
		</div>
    </div>
    <br>

		<div class="container">
			<div class="row">
				<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <!-- estilos de border con la clase bord10 y sus margenes.-->
					<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-25 m-r--38 m-lr-0-xl">
                     <div>
                      <!-- validacion para saber si existe la variable de session -->
                        <?php
                             if(isset($_SESSION['login'])){//si existe mostramos todo el html de direccion de envio.
                        ?>
						<div>
                            <!--CAMPOS PARA DIRECCION DE ENVIO-->
                            <label for="tipopago">Dirección de envío</label>
                            <div class="bor8 bg0 m-b-12 ">
                                <input id="txtDireccion" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="state" placeholder="Dirección de envío">
                            </div>
                            <div class="bor8 bg0 m-b-22">
                                <input id="txtCiudad" class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" placeholder="Distrito">
                            </div>
                        </div>

                        
                        <?php }else{ ?>

                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#login" role="tab" aria-controls="nav-home" aria-selected="true">Iniciar Sesion</a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#registro" role="tab" aria-controls="nav-profile" aria-selected="false">Crear Cuenta</a>
                                    
                                </div>
                            </nav>
                            <div class="tab-content" id="mytabContent">
                                <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="nav-home-tab">
                                   <br>
                                   <!-- formulario de login -->
                                   <form id="formLogin">
                                    <div class="form-group">
                                        <label for="txtEmail">Usuario</label>
                                        <input type="email" class="form-control" id="txtEmail" name="txtEmail">
                                    </div>
                                    <div class="form-group">
                                        <label for="txtPassword">Contraseña</label>
                                        <input type="password" class="form-control" id="txtPassword" name="txtPassword">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="registro" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <br>
                                   <!-- formulario de registro-->
                                   <form id="formRegister">
                                       <div class="row"> <!--fila-->
                                           <!-- 6 columnas del contener-->
                                           <div class="col col-md-6 form-group">
                                               <label for="txtNombres">Nombre</label>
                                               <!-- valid sirve para validar-->
                                               <input type="text" class="form-control valid validText" id="txtNombres" name="txtNombres">
                                           </div>
                                           <div class="col col-md-6 form-group">
                                               <label for="txtApellidos">Apellido</label>
                                               <input type="text" class="form-control valid validText" id="txtApellidos" name="txtApellidos">
                                           </div>
                                       </div>
                                       <div class="row"> <!-- valid sea numerico, onkeypress=> cuando presionamos la tecla se ejecuta la funcion controltag verficiando que sea un numero.-->
                                           <div class="col col-md-6 form-group">
                                               <label for="txtTelefono">Teléfono</label>
                                               <input type="text" class="form-control valid validNumber" id="txtTelefono" name="txtTelefono"  onkeypress="return controlTag(event);">
                                           </div>
                                           <div class="col col-md-6 form-group">
                                               <label for="txtEmailCliente">Email</label>
                                               <input type="email" class="form-control valid validEmail" id="txtEmailCliente" name="txtEmailCliente">
                                           </div>
                                       </div>
                                       <button type="submit" class="btn btn-primary">Registrate</button>
                                   </form>
                                </div>
                            </div>
                            
                        <?php } ?>
                        </div>
					</div> 
				</div>

 
				<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
					<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
						<h4 class="mtext-109 cl2 p-b-30">
							Resumen
						</h4>

						<div class="flex-w flex-t bor12 p-b-13">
							<div class="size-208">
								<span class="stext-110 cl2">
									Subtotal:
								</span>
							</div>

							<div class="size-209">
								<span id="subTotalCompra" class="mtext-110 cl2">
                                   <?= SMONEY.formatoMoney($subtotal) ?>
								</span>
                            </div>

                            <div class="size-208">
								<span class="stext-110 cl2">
									Envío:
								</span>
							</div>

							<div class="size-209">
								<span class="mtext-110 cl2">
                                <?= SMONEY.formatoMoney(COSTOENVIO) ?>
								</span>
                            </div>
                            
                            
						</div>

						<div class="flex-w flex-t p-t-27 p-b-33">
							<div class="size-208">
								<span class="mtext-101 cl2">
									Total:
								</span>
							</div>

							<div class="size-209 p-t-1">
								<span id="totalCompra" class="mtext-110 cl2">
                                    <!-- SUMAMOS EL SUBTOTAL + EL COSTO DE ENVIO -->
									<?=  SMONEY.formatoMoney($total) ?>
								</span>
							</div>
                        </div>
                        <hr>
                        
                         <!-- validacion para saber si existe la variable de session -->
                         <?php
                             if(isset($_SESSION['login'])){ //si existe mostramos todo el html de direccion de envio.
                         ?>
                    <div id="divMetodoPago" class="notblock"> 
                      <!-- ocultar y desactivar para que se muestre los metodos de pago-->
                       <div id="divCondiciones">
                         <input type="checkbox" id="condiciones">
                         <label for="condiciones"> Aceptar </label>
                         <a href="#" data-toggle="modal" data-target="#modalTerminos"> Términos y Condiciones</a>
                       </div>
    
                      
                       <div id="optMetodoPago" class="notblock">
                         <hr>
                       
                        <h4 class="mtext-109 cl2 p-b-30">
                          Metodo de pago
                        </h4>

                        <div class="divmetodopago">
                          <div>
                            <label for="paypal">
                               <input type="radio" id="paypal" class="methodpago" name="payment-method" checked="" value="Paypal">
                               <img src="<?= media() ?>/images/img-paypal.jpg" alt="Icono de PayPal" class="ml-space-sm" width="74" height="20">
                            </label>
                          </div>

                          <div>
                            <label for="yape">
                               <input type="radio" id="yape" class="methodpago" name="payment-method" value="Yape">
                               <span>Yape</span>
                               <img src="<?= media() ?>/images/yape.png" alt="Icono de yape" class="ml-space-sm">
                            </label>
                          </div>

                          <div>
                              <label for="plin">
                                  <input type="radio" id="plin" class="methodpago" name="payment-method" value="plin">
                                  <span>Plin</span>
                                  <img src="<?= media() ?>/images/plin.png" alt="Icono de plin" class="ml-space-sm" height="30">
                              </label>
                          </div>

                          <div>
                              <label for="transferencia">
                                  <input type="radio" id="transferencia" class="methodpago" name="payment-method" value="transferencia">
                                  <span>Transferencia bancaria directa</span>
                              </label>
                          </div>
               
                          <div>
                             <label for="contraentrega">
                               <input type="radio" id="contraentrega" class="methodpago" name="payment-method" value="CT">
                               <span>Contra Engrega</span>
                             </label>
                          </div>
                          <div id="divtipopago" class="notblock">
                             <label for="listtipopago">Tipo de pago</label>
                             <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                               <select id="listtipopago" class="js-select2" name="time">
                                  <!-- validacion de los tipos de pago si es mayor que 0 quiere decir que si hay registros -->
                                  <?php 
                                     if(count($data['tiposPago']) > 0){
                                        //recorremos los tipos de pago
                                        foreach ($data['tiposPago'] as $tipopago) { 
                                            //si idtipopago es diferente de 1, 2 , 3, 6 mostramos las demas opciones que serian efectivo, tarjetas
                                            if($tipopago['idtipopago'] != 1 && $tipopago['idtipopago'] != 2 && $tipopago['idtipopago'] != 3 && $tipopago['idtipopago'] != 6){
                                  ?> 
                                    <!-- los tipos de pago que se mostraran en el select con su nombre -->
                                     <option value="<?= $tipopago['idtipopago']?>"><?= $tipopago['tipopago']?></option>
                                  <?php  
                                            }
                                       } 
                                    } 
                                  ?>
                               </select>
                                <div class="dropDownSelect2"></div>
                             </div>
                          </div>
                          
                          <!-- Mensajes de tipo de pagos-->
                          <div id="msgtransferencia" class="notblock">
                            <p>Realiza tu pago directamente en nuestra <a href="#" data-toggle="modal" data-target="#modalcuentabancaria">cuenta bancaria</a>. Por favor, envíanos el voucher de transferencia o depósito junto con tu número de pedido a nuestro whatsapp +(51) 999134381. Tu pedido no se procesará hasta que se haya recibido el importe en nuestra cuenta.</p>
                          </div>

                          <div id="msgyape" class="notblock">
                              <hr>  
                              <p>Escanee nuestro código QR o agregue nuestro número movil +(51) 999134381 a sus contactos y realice el pago con Yape.</p>
                              <p>Luego envienos a nuestro whatsapp la captura del pago, para proceder a enviar el pedido.</p>
                              <br>
                              <div class="text-center">
                               <img src="<?= media();?>/images/QR-YAPE.jpg" alt="yape">
                              </div>
                          </div>

                          <div id="msgplin" class="notblock">
                              <hr>
                              <p>Escanee nuestro código QR o agregue nuestro número de celular a sus contactos y realice el pago con Plin.</p>
                          </div>
                          <div id="divpaypal">
                            <div>
                                <br>
                                <p class="text-center">Para completar la transacción, te enviaremos a los servidores seguros de PayPal.</p>
                                <br>
                            </div>
                            <div id="paypal-btn-container"></div>
                          </div>
                        </div>
                    
                        <hr>
                        <br>
                      
                        <!-- tipo submit para que se ejecute la accion-->
                        <button type="submit" id="btnComprar" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer notblock">
                          Procesar Pedido
                        </button>
                     </div>
                     </div>
               <?php } ?>
					</div>
				</div>
			</div>
		</div>

<?php 
   footerTienda($data); 
?>

