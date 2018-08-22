<?php
include("bussiness/menu.php");
$i = 0;

$objData = new clsMenu();

$rowMenu = $objData->ListMenuPerfil('HOME', $IdEmpresa, $IdCentro, $idperfil, 0, '00');
$countMenu = count($rowMenu);
?>
<div class="demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header mdl-layout__header--waterfall">
        <div class="mdl-layout__header-row">
            <span class="mdl-layout-title">CodigoFit</span>
            <div class="mdl-layout-spacer"></div>
            <button type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnOpciones">
                <i class="material-icons">&#xE5D4;</i>
            </button>
        </div>
    </header>
    <div id="control-app" class="mdl-layout__drawer-button">
        <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
            <i class="material-icons">&#xE5D2;</i>
        </a>
    </div>
    <main class="mdl-layout__content">
        <div class="page-content">
            <div id="AppMain" class="mdl-grid">
                <?php
                if ($countMenu > 0):
                    while($i < $countMenu):
                ?>
                <div id="tile<?php echo $rowMenu[$i]['tm_idmenu']; ?>" data-id="<?php echo $rowMenu[$i]['tm_idmenu']; ?>" class="mdl-card pos-rel mdl-shadow--2dp mdl-cell mdl-cell--2-col mdl-cell--2-col-tablet mdl-cell--2-col-phone opcion <?php echo $rowMenu[$i]['tm_iconbgcolor']; ?> white-text" data-url="<?php echo $rowMenu[$i]['tm_uri']; ?>" data-role="tile">
                    <i class="material-icons centered"><?php echo $rowMenu[$i]['tm_iconuri']; ?></i>
                    <h5 class="tile-label place-bottom-left padding5 margin5"><?php echo $rowMenu[$i]['tm_titulo']; ?></h5>
                </div>
                <?php
                        ++$i;
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </main>
    <div class="list-sites"></div>
    <div id="modalRecents" class="modalcuatro bg-opacity-8 modal-example-content expand-phone">
        <div class="modal-example-header">
            <div class="left">
                <a href="#" title="Ocultar" class="close-modal-example white-text padding5 circle left"><i class="material-icons md-32">close</i></a>
                <h3 class="no-margin white-text left">
                    Sitios recientes
                </h3>
            </div>
        </div>
        <div class="modal-example-body">
            <div class="list-activewin">
                <div class="view mdl-grid scrollbarra"></div>
            </div>
        </div>
        <div class="modal-example-footer">
            <a id="lnkShowDesktop" href="#" title="Volver a inicio" class="white-text padding5 circle right"><i class="material-icons md-32">&#xE88A;</i></a>
            <a id="lnkCloseAll" href="#" title="Cerrar todo" class="white-text padding5 circle left"><i class="material-icons md-32">clear_all</i></a>
        </div>
    </div>
</div>
<div id="charmOptions" class="control-center home">
    <div class="scrollbarra">
        <div class="container-user">
            <button id="btnChangeUser" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--fab button-img-user no-padding mdl-shadow--4dp" type="button"><img src="<?php echo $fotoUsuario == 'no-set' ? 'images/dish-icon.png' : $fotoUsuario; ?>" class="circle" alt="" width="80" height="80"></button>
            <div class="info-user place-bottom-left-right padding10">
                <div data-iduser="<?php echo $idusuario; ?>">
                    <h4 class="text-shadow white-text"><?php echo $login; ?></h4>
                    <div class="demo-avatar-dropdown">
                        <span class="white-text text-shadow"><?php echo $correoUsuario; ?></span>
                        <button id="accbtn" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon right white-text">
                          <i class="material-icons" role="presentation">arrow_drop_down</i>
                          <span class="visuallyhidden">Accounts</span>
                        </button>
                        <ul id="mnuAccountOptions" class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="accbtn">
                          <li class="mdl-menu__item" data-action="account">hello@example.com</li>
                          <li class="mdl-menu__item" data-action="account">info@example.com</li>
                          <li class="mdl-menu__item" data-action="add-account"><i class="material-icons">add</i>Agregar otra cuenta...</li>
                          <li class="mdl-menu__item" data-action="logout" data-url="logout.php"><i class="material-icons">&#xE879;</i>Cerrar sesi&oacute;n</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <ul id="menuModulo" class="list-options">
        </ul>
        <ul id="menuBottomSettings" class="list-options">
            <li class="divider"></li>
            <li><a class="grey-text text-darken-4" data-action="home" href="#"><i class="material-icons icon">&#xE88A;</i><span class="text">Inicio</span></a></li>
            <li><a class="grey-text text-darken-4" data-action="recents" href="#"><i class="material-icons icon">&#xE889;</i><span class="text">Sitios recientes</span></a></li>
            <li><a class="grey-text text-darken-4" data-action="settings" href="#"><i class="material-icons icon">&#xE8B8;</i><span class="text">Configuraci&oacute;n</span></a></li>
            <li><a class="grey-text text-darken-4" data-action="help" href="#"><i class="material-icons icon">&#xE887;</i><span class="text">Ayuda</span></a></li>
        </ul>
    </div>
</div>