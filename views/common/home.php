<div class="demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header mdl-layout__header--waterfall light-blue darken-2 ">
        <div class="mdl-layout__header-row">
            <?php if ($tipopersona == "00"): ?>
            <span class="mdl-layout-title"><?php echo $app_name; ?></span>
            <?php else: ?>
            <span class="mdl-layout-title"><?php echo $Nombreempresa; ?></span>
            <?php endif; ?>
            <div class="mdl-layout-spacer"></div>
            <button type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnOpciones">
                <i class="material-icons">&#xE5D4;</i>
            </button>
        </div>
    </header>
    <div id="control-app" class="mdl-layout__drawer-button tooltipped" data-placement="right" data-toggle="tooltip" title="Opciones de la aplicaci&oacute;n">
        <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
            <i class="material-icons">&#xE5D2;</i>
        </a>
    </div>
    <main class="mdl-layout__content">
        <div class="page-content">
            <?php if ($tipopersona == "00"): ?>
            <div id="AppMain" class="mdl-grid fill-height-or-more all-height">
                <div id="tile45" data-id="45" class="mdl-card pos-rel mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--2-col-phone opcion orange white-text" data-url="?pag=cliente&subpag=horariocliente&idcliente=<?php echo $idpersona; ?>horarioscliente" data-role="tile">
                    <i class="material-icons centered">&#xE8B5;</i>
                    <h4 class="tile-label align-center place-bottom-left-right padding10">Horario</h4>
                </div>
                <div id="tile6" data-id="6" class="mdl-card pos-rel mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--2-col-phone opcion orange white-text" data-url="?pag=cliente&subpag=clasescliente&idcliente=<?php echo $idpersona; ?>" data-role="tile">
                    <i class="material-icons centered">&#xE8DF;</i>
                    <h4 class="tile-label align-center place-bottom-left-right padding10">Separaci&oacute;n de clases</h4>
                </div>
                <div id="tile48" data-id="48" class="mdl-card pos-rel mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--2-col-phone opcion orange white-text" data-url="?pag=cliente&subpag=evaluacioncliente&idcliente=<?php echo $idpersona; ?>" data-role="tile">
                    <i class="material-icons centered">&#xE24B;</i>
                    <h4 class="tile-label align-center place-bottom-left-right padding10">Evaluaci&oacute;n</h4>
                </div>
                <div id="tile25" data-id="25" class="mdl-card pos-rel mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--2-col-phone opcion orange white-text" data-url="?pag=cliente&subpag=rutinacliente&idcliente=<?php echo $idpersona; ?>" data-role="tile">
                    <i class="material-icons centered">&#xEB43;</i>
                    <h4 class="tile-label align-center place-bottom-left-right padding10">Rutinas</h4>
                </div>
                <div id="tile47" data-id="47" class="mdl-card pos-rel mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--2-col-phone opcion orange white-text" data-url="?pag=cliente&subpag=dietacliente&idcliente=<?php echo $idpersona; ?>" data-role="tile">
                    <i class="material-icons centered">&#xE556;</i>
                    <h4 class="tile-label align-center place-bottom-left-right padding10">Dietas</h4>
                </div>
                <div id="tile26" data-id="26" class="mdl-card pos-rel mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--2-col-phone opcion orange white-text" data-url="?pag=cliente&subpag=usuariocliente&idcliente=<?php echo $idpersona; ?>" data-role="tile">
                    <i class="material-icons centered">&#xE853;</i>
                    <h4 class="tile-label align-center place-bottom-left-right padding10">Cuenta</h4>
                </div>
            </div>
            <?php else: ?>
            <div id="AppMain" class="mdl-grid">
            </div>
            <?php endif; ?>
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
                    <h5 class="text-shadow white-text">CENTRO: <?php echo $nombre_centro; ?></h5>
                </div>
            </div>
        </div>
        <ul id="menuModulo" class="list-options">
        </ul>
        <ul id="menuBottomSettings" class="list-options">
            <li class="divider"></li>
            <?php if ($screenmode != 'cliente'): ?>
            <li><a class="grey-text text-darken-4" data-action="home" href="#"><i class="material-icons icon">&#xE88A;</i><span class="text">Inicio</span></a></li>
            <?php if ($multicentro == 1): ?>
            <li><a class="grey-text text-darken-4" data-action="center" href="#"><i class="material-icons icon">&#xEB3F;</i><span class="text">Sedes</span></a></li>
            <?php endif; ?>
            <li><a class="grey-text text-darken-4" data-action="recents" href="#"><i class="material-icons icon">&#xE889;</i><span class="text">Sitios recientes</span>
            </a></li>
            <?php endif; ?>
            <li><a class="grey-text text-darken-4" data-action="settings" href="#"><i class="material-icons icon">&#xE8B8;</i><span class="text">Configuraci&oacute;n</span></a></li>
            <li><a class="grey-text text-darken-4" data-action="help" href="#"><i class="material-icons icon">&#xE887;</i><span class="text">Ayuda</span></a></li>
            <li><a class="grey-text text-darken-4" data-action="logout" href="logout.php"><i class="material-icons icon">&#xE879;</i><span class="text">Cerrar sesi&oacute;n</span></a></li>
        </ul>
    </div>
</div>
<?php if ($tipopersona != "00"): ?>
<div id="modalCentros" class="modalcuatro bg-opacity-8 modal-example-content expand-phone">
    <form id="formCentros" name="formCentros" method="POST" action="services/home/home-post.php">
        <input type="hidden" name="hdIdCentro" id="hdIdCentro" value="<?php echo $IdCentro; ?>">
        <input type="hidden" name="lang" id="lang" value="<?php echo $lang; ?>">
        <div class="modal-example-header">
            <div class="left">
                <a href="#" title="Ocultar" class="close-modal-example white-text padding5 circle left"><i class="material-icons md-32">close</i></a>
                <h3 class="no-margin white-text left">
                    Sedes
                </h3>
            </div>
        </div>
        <div class="modal-example-body">
            <div id="gvCentros" class="mdl-grid scrollbarra padding20"></div>
        </div>
        <div class="modal-example-footer">
            <button id="btnSetCentro" type="submit" class="mdl-button mdl-js-button mdl-js-ripple-effect btn-primary right">
                Seleccionar sede
            </button>
        </div>
    </form>
</div>
<?php endif; ?>