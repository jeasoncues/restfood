
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <!-- Imagen del avatar -->
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?= media(); ?>/images/avatar.png" alt="User Image">
        <div>
         <!--Nombre de Usuario logeado extraido de la base de datos-->
          <p class="app-sidebar__user-name"><?= $_SESSION['userData']['nombres']; ?></p>
          <!-- Rol de Usuario-->
          <p class="app-sidebar__user-designation"><?= $_SESSION['userData']['nombrerol']; ?></p>

        </div>
      </div>
      <ul class="app-menu">
          
        <?php if(!empty($_SESSION['permisos'][1]['r'])){ ?>
        <li>
          <a class="app-menu__item" href="<?= base_url(); ?>/dashboard">
            <i class="app-menu__icon fa fa-home"></i>
            <span class="app-menu__label">Inicio</span>
          </a>
        </li>
        <?php } ?> 

        <?php if(!empty($_SESSION['permisos'][2]['r']) || !empty($_SESSION['permisos'][11]['r'])){ ?>
        <li class="treeview">
           <a class="app-menu__item" href="#" data-toggle="treeview">
             <i class="app-menu__icon fa fa-users" aria-hidden="true"></i>
             <span class="app-menu__label">Usuarios</span>
             <i class="treeview-indicator fa fa-angle-right">
             </i>
           </a>
           <ul class="treeview-menu">
           <?php if(!empty($_SESSION['permisos'][2]['r'])){ ?>
            <li><a class="treeview-item" href="<?= base_url(); ?>/usuarios"><i class="icon fa fa-circle-o"></i> Usuarios</a></li>
           <?php } ?>

           <?php if(!empty($_SESSION['permisos'][11]['r'])){ ?>
            <li><a class="treeview-item" href="<?= base_url(); ?>/roles"><i class="icon fa fa-circle-o"></i> Roles</a></li>
           <?php } ?>
           
           </ul>
        </li>
        <?php } ?>


        <?php if(!empty($_SESSION['permisos'][8]['r'])) { ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/gastos">
             <i class="app-menu__icon fa fa-edit" aria-hidden="true"></i>
             <span class="app-menu__label">Gastos</span>
            </a>
        </li>
        <?php } ?> 

        <?php if(!empty($_SESSION['permisos'][7]['r'])){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/cajas">
             <i class="app-menu__icon fas  fa-cash-register " aria-hidden="true"></i>
             <span class="app-menu__label"> Caja</span>
            </a>
        </li>
        <?php } ?>

        <?php if(!empty($_SESSION['permisos'][9]['r'])){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/ventas">
             <i class="app-menu__icon fa fa-th-list" aria-hidden="true"></i>
             <span class="app-menu__label">Ventas</span>
            </a>
        </li>
        <?php } ?>

        
        <?php if(!empty($_SESSION['permisos'][3]['r'])){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/clientes">
             <i class="app-menu__icon fa fa-user" aria-hidden="true"></i>
             <span class="app-menu__label">Clientes</span>
            </a>
        </li>
        <?php } ?>

        

   
        <?php if(!empty($_SESSION['permisos'][10]['r']) || !empty($_SESSION['permisos'][12]['r'])){ ?>
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-archive" aria-hidden="true"></i>
                <span class="app-menu__label">Tienda</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <?php if(!empty($_SESSION['permisos'][10]['r'])){ ?>
                <li><a class="treeview-item" href="<?= base_url(); ?>/productos"><i class="icon fa fa-circle-o"></i> Productos</a></li>
                <?php } ?>
                <?php if(!empty($_SESSION['permisos'][12]['r'])){ ?>
                <li><a class="treeview-item" href="<?= base_url(); ?>/categorias"><i class="icon fa fa-circle-o"></i> Categorías</a></li>
                <?php } ?>
                <?php if(!empty($_SESSION['permisos'][14]['r'])){ ?>
                <li><a class="treeview-item" href="<?= base_url(); ?>/mesas"><i class="icon fa fa-circle-o"></i> Mesas</a></li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>
        
        <?php if(!empty($_SESSION['permisos'][13]['r'])){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/cocina">
             <i class="app-menu__icon fa fa-edit" aria-hidden="true"></i>
             <span class="app-menu__label">Cocina</span>
            </a>
        </li>
        <?php }?>

        <?php if(!empty($_SESSION['permisos'][15]['r'])){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/mozo">
             <i class="app-menu__icon fa fa-edit" aria-hidden="true"></i>
             <span class="app-menu__label">Mozo</span>
            </a>
        </li>
        <?php }?>
        


        <?php if(!empty($_SESSION['permisos'][5]['r'])){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/pedidos">
             <i class="app-menu__icon fa fa-shopping-cart" aria-hidden="true"></i>
             <span class="app-menu__label">Pedidos</span>
            </a>
        </li>
        <?php }?>



        <?php if(!empty($_SESSION['permisos'][4]['r'])){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/reportes">
             <i class="app-menu__icon fa fa-file-text" aria-hidden="true"></i>
             <span class="app-menu__label">Reportes</span>
            </a>
        </li>
        <?php } ?>

        <li>
          <a class="app-menu__item" href="<?= base_url(); ?>/logout">
           <i class="app-menu__icon fa fa-sign-out" aria-hidden="true"></i>
           <span class="app-menu__label">Cerrar Sesion</span>
          </a>
        </li>
      </ul>
    </aside>