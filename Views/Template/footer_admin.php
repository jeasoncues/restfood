<!-- Script para sacar el contenedor de carga -->
  <script>
     setTimeout(function(){
      var contenedor = document.getElementById('contenedor_carga');

      contenedor.style.visibility = 'hidden';
      contenedor.style.opacity = '0';

   }, 2000)
    </script>

<!-- Con const => creamos la variable base_ulr -->
<script>
  const base_url = "<?= base_url(); ?>";
</script>

<!-- Essential javascripts for application to work-->
    <script src="<?= media(); ?>/js/jquery-3.3.1.min.js"></script>
    <script src="<?= media(); ?>/js/popper.min.js"></script>
    <script src="<?= media(); ?>/js/bootstrap.min.js"></script>
    <script src="<?= media(); ?>/js/main.js"></script>
    <script src="<?= media(); ?>/js/fontawesome.js"></script>
    <script src="<?= media(); ?>/js/functions_admin.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?= media(); ?>/js/plugins/pace.min.js"></script>

    <!-- Page specific javascripts desde el src ponemos codigo php para encontrar la carpeta JS con la funcion media
    que hace referencia a la carpeta ASSETS-->
    <script src="<?= media(); ?>/js/plugins/sweetalert.min.js"></script>
    <!-- Libreria para editor de texto de productos-->
    <script src="<?= media(); ?>/js/tinymce/tinymce.min.js"></script>

    <!-- Data table plugin-->
    <script src="<?= media(); ?>/js/plugins/jquery.dataTables.min.js"></script>
    <script src="<?= media(); ?>/js/plugins/dataTables.bootstrap.min.js"></script>
    <script type ="text/javascript" src="<?= media(); ?>/js/plugins/bootstrap-select.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="<?= media();?>/js/plugins/chart.js"></script>
  

    <!--Validacion para cuando nos encontremos en roles-->
    <?php if($data['page_name']== "rol_usuario"){ ?>
    <script src="<?= media(); ?>/js/functions_roles.js"></script>
    <?php    } ?>
    <!--Validacion para cuando nos encontremos en usuarios-->
    <?php if($data['page_name']== "usuarios"){ ?>
    <script src="<?= media(); ?>/js/functions_usuarios.js"></script>
    <?php    } ?>
    
    <?php if($data['page_name']== "gastos"){ ?>
    <script src="<?= media(); ?>/js/functions_gastos.js"></script>
    <?php    } ?>

    <?php if($data['page_name']== "clientes"){ ?>
    <script src="<?= media(); ?>/js/functions_clientes.js"></script>
    <?php } ?>   


    <?php if($data['page_name']== "categorias") { ?>
    <script src="<?=  media(); ?>/js/functions_categorias.js"></script>
    <?php } ?>

    <?php if($data['page_name']== "productos") {?>
    <script src="<?= media(); ?>/js/functions_productos.js"></script>
    <?php }?>


    <?php if($data['page_name']== "mozo") { ?>
    <script src="<?= media(); ?>/js/functions_venta.js"></script>
    <?php } ?>


    <?php if($data['page_name']== "mesas") { ?>
    <script src="<?= media(); ?>/js/functions_mesas.js"></script>
    <?php } ?>



    <?php if($data['page_name']== "pos"){ ?>
    <script src="<?= media(); ?>/js/functions_pos.js"></script>
    <?php } ?>


    <?php if($data['page_name']=="cajas"){ ?>
    <script src="<?= media(); ?>/js/functions_cajas.js"></script>
    <?php } ?>

    <?php if($data['page_name']=="arqueo"){ ?>
    <script src="<?= media(); ?>/js/functions_arqueo.js"></script>
    <?php } ?>


    <?php if($data['page_name']=="pedidos"){ ?>
    <script src="<?= media(); ?>/js/functions_pedidos.js"></script>
    <?php } ?>

  </body>
</html>