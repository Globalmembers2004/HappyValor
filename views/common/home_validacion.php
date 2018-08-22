<?php
include("bussiness/menu.php");

$IdMenu = '0';
$Titulo = '';
$Cabecera = '';
$Descripcion = '';
$Icono = '';
$URLMenu = '';
$Tamanho = '';
$i = 0;

$objData = new clsMenu();

$lang = isset($_POST['lang']) ? $_POST['lang'] : 'lang';

$translate = new Translator($lang);
$rowMenu = $objData->ListMenuPerfil('HOME', $idperfil, 0, '00');
$countMenu = count($rowMenu);

$allheight = '';

if ($idperfil != '61')
  $allheight = ' all-height';
?>
<div class="wrapper<?php echo $allheight; ?>">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Cin</b>adsac</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Cin</b>adsac</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <?php if ($idperfil == '61'): ?>
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <h4 id="title_app" class="place-top-left padding-left70 white-text"></h4>
      <?php endif; ?>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php echo $login; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                <p>
                  <?php echo $login; ?>
                  <!-- <small>Member since Nov. 2012</small> -->
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <!-- <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Editar perfil</a>
                </div> -->
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Cerrar sesi&oacute;n</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
</div>