<?php
 
 //accedemos al array pedido y luego al arrray orden para que obtenga todos sus datos lo mismo para detalle
 $orden = $data['pedido']['orden'];
 $detalle = $data['pedido']['detalle'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden</title>
    <style type="text/css">
      p{
          font-family: arial; /*tipo de letra*/
          letter-spacing: 1px; /*espacio de una letra a otra letra*/
          color: #7f7f7f; /*color de letra*/
          font-size: 12px; /*tamaño letra*/
      }

      hr{
          border:0;
          border-top: 1px solid #CCC;
      }

      h3{
        font-family: arial;
        margin: 0; /*margen 0 en los 4 lados*/
      }

      h4{
          font-family: arial;
          margin: 0;
      }

      table{
          width: 100%; /*ancho*/
          max-width: 600px; /*ancho maximo de cada una de las tablas de 600 px pero cuando la tabla sea inferior tomara el 100%*/
          margin: 10px auto; /*margen arriba y abajo 10px y a los lados auto para que se centre*/
          border: 1px solid #CCC;
          border-spacing: 0; /*ocultamos los border por defecto que trae la tabla*/
      }

      table tr td, table tr th{
          padding: 5px 10px;  /*5px arriba y abajo, a los lados 10*/
          font-family: arial;
          font-size: 12px;
      }

      #detalleOrden tr td{
          border: 1px solid #CCC;
      }
     
       /*Encabezados del detalle*/
      .table-active{
          background-color: #CCC;
      }

      .text-center{
         text-align: center;
      }

      .text-right{
          text-align: right;
      }

      /*media query para version movil*/
      @media screen and (max-width: 470px) {
          .logo{
              width: 90px;
          }

          p, table tr td, table tr th{
              font-size: 9px;
          }
      }
    
    </style>
</head>
<body>
    <div>
        <br>
        <p class="text-center">Se ha generado una orden, a continuacion encontrarás los datos.</p>
        <br>
        <hr>
        <br>
        <table>
            <tr>
                <!--Columnas le damos el mismo ancho de 33.33%-->
                <td width="33.33%">
                    <img class="logo" src="<?= media(); ?>/tienda/images/icons/rest.png" alt="logo">
                </td>
                <td width="33.33%">
                    <div class="text-center">
                        <p>
                            <h3><strong> <?= NOMBRE_EMPRESA_PEDIDO ?> </strong></h3>
                        
                            <br>
                           <?= DIRECCION ?> <br>
                            Telefono: <?= TELEFONOEMPRESA ?> <br>
                            Email: <?= EMAIL_EMPRESA ?>
                        </p>
                    </div>
                </td>

                <!-- DATOS DE LA ORDEN -->
                <td width="33.33%">
                  <div class="text-right">
                      <p>
                          <!--Strong negrita-->
                          No. Pedido: <strong><?= $orden['idpedido'] ?></strong><br>
                          Fecha: <?= $orden['fecha'] ?> <br>

                          <!-- validacion para saber si es pago por paypal o por contraentrega
                           si el id es igual a 1 es por paypal.
                          -->
                          <?php
                            if($orden['tipopagoid'] == 1){
                          ?>
                          Método Pago: <?= $orden['tipopago'] ?> <br>
                          Transacción: <?= $orden['idtransaccionpaypal'] ?>
                          <!-- si el pago no fue por paypal de lo contrario mostrara esto-->
                          <?php }else{ ?>
                            Método Pago: Pago contra entrega <br>
                            Tipo Pago: <?= $orden['tipopago'] ?>
                          <?php } ?>
                      </p>
                  </div>
                </td>
            </tr>
        </table>

        <table>
            <!--DATOS DEL CLIENTE LOGEADO Y LA DIRECCION SERA OBTENIDA DEL PEDIDO.-->
            <!-- tr => filas-->
            <tr>
                <td width="140">
                    Nombre:
                </td>
                <td><?= $_SESSION['userData']['nombres'].' '.$_SESSION['userData']['apellidos'] ?></td>
            </tr>
            <tr>
                <td>Teléfono</td>
                <td><?= $_SESSION['userData']['telefono'] ?></td>
            </tr>
            <tr>
                <td>Dirección de envío:</td>
                <td><?= $orden['direccion_envio'] ?></td>
            </tr>
        </table>

        <table>
            
            <!-- Encabezado-->
            <thead class="table-active">
                <tr>
                    <!--Columnas -->
                    <th>Descripción</th>
                    <th class="text-right">Precio</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-right">Importe</th>
                </tr>
            </thead>
            
            <!--Detalle del pedido-->
            <tbody id="detalleOrden">
                <!-- validacion para saber cuantos pedidos hicimos -->
                <!-- si es mayor que 0 armaremos todo este html -->
                <?php 
                   if(count($detalle) > 0){
                      $subtotal = 0;
                      //recorremos los productos
                      foreach ($detalle as $producto) {
                          //a la variable le damos formato y lo que viene en el elemento precio
                          $precio = formatoMoney($producto['precio']);
                          //multiplicaremos el precio por la cantidad para obtener el importe
                          $importe = formatoMoney($producto['precio'] *  $producto['cantidad']);
                          $subtotal = $subtotal + $importe;
                   
                ?>
                <tr>
                    <td><?= $producto['producto']?></td>
                    <td class="text-right"><?= SMONEY.' '.$precio  ?></td>
                    <td class="text-center"><?= $producto['cantidad'] ?></td>
                    <td class="text-right"><?= SMONEY.' '.$importe ?></td>
                </tr>
                <?php }
                   } 
                ?>
            </tbody>
            
            <!--Footer de la tabla-->
            <tfoot>
                <tr>
                    <!--th => para que se resalte el titulo-->
                    <!-- colspan="3" ==> indicamos que ocupara 3 columnas y la 4ta columna sera ocupada por el td-->
                    <th colspan="3" class="text-right">Subtotal:</th>
                    <td class="text-right"><?= SMONEY.' '.formatoMoney($subtotal) ?></td>
                </tr>
                <tr>
                    <th colspan="3" class="text-right">Envío:</th>
                    <td class="text-right"><?= SMONEY.' '.formatoMoney($orden['costo_envio']); ?></td>
                </tr>
                <tr>
                    <th colspan="3" class="text-right">Total:</th>
                    <td class="text-right"><?= SMONEY.' '.formatoMoney($orden['monto']); ?></td>
                </tr>
            </tfoot>
        </table>
        <div class="text-center">
            <p>Si tienes preguntas sobre tu pedido, <br>pongase en contacto con nombre, teléfono y Email.</p>
            <h4>¡Gracias por tu compra!</h4>

        </div>
    </div>
    
</body>
</html>