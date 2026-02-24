<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Logo -->
	  		<div class="img bg-wrap text-center py-4" style="background-image: url(/estacionamento/Sistema/partes/sidebar/images/bg_1.jpg);">
	  			<div class="user-logo">
	  				<div class="img" style="background-image: url('<?php echo $_SESSION['FotoLogin'] ? $_SESSION['FotoLogin'] : '/estacionamento/Sistema/img/logo.png'; ?>');"></div>
	  				<h3><?php echo($_SESSION['NomeLogin']) ?> <!--ParkWay Systems--></h3>
	  			</div>
	  		</div>

    <!-- Sidebar -->
    <div class="sidebar sidebar-style">
      <!--
      <!- Sidebar user panel (optional) ->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php //echo fotoUsuario($_SESSION['idLogin']); ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php //echo nomeUsuario($_SESSION['idLogin']); ?></a>
        </div>
      </div>
      -->

      <!-- Sidebar Menu -->      
      <?php echo montaMenu($_SESSION['menu-n1'],$_SESSION['menu-n2']);?>      
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>