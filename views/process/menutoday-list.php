<?php
$IdEmpresa = 1;
$IdCentro = 1;
?>
<form id="form1" name="form1" method="post" class="validado">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdIdEmpresa" name="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" id="hdIdCentro" name="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <input type="hidden" id="hdPageActual" name="hdPageActual" value="1" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdPageCarta" name="hdPageCarta" value="1" />
    <input type="hidden" id="hdPageProd" name="hdPageProd" value="1" />
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0" />
    <input type="hidden" id="hdIdGrupo" name="hdIdGrupo" value="0" />
    <input type="hidden" id="hdIdOrden" name="hdIdOrden" value="0" />
    <input type="hidden" id="hdFecha" name="hdFecha" value="<?php echo date('Y-m-d'); ?>" />
    <input type="hidden" id="hdTipoCarta" name="hdTipoCarta" value="00" />
    <input type="hidden" id="hdEstadoApertura" name="hdEstadoApertura" value="00" />
    <input type="hidden" id="hdEstadoFavorito" name="hdEstadoFavorito" value="0" />
    <input type="hidden" name="hdCurrentYear" id="hdCurrentYear" value="<?php echo date('Y'); ?>" />
    <input type="hidden" name="hdCurrentMonth" id="hdCurrentMonth" value="<?php echo date('m'); ?>" />
    <div class="page-region">
        <div id="pnlListado" class="page is-active generic-panel gp-no-footer mdl-layout">
            <header class="gp-header mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Men&uacute; del d&iacute;a</span>
                    <div class="mdl-layout-spacer"></div>
                    <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnOpcionesMenu">
                        <i class="material-icons">&#xE5D4;</i>
                    </button>
                </div>
            </header>
            <ul id="mnuOpcionesMenu" class="dropdown">
                <li><a href="#" data-action="close" class="close-inner-window">Cerrar</a></li>
            </ul>
            <div class="control-inner-app mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div>
            <div class="gp-body no-overflow">
                <div id="pnlCalendarioIndividual" class="responsive-calendar">
                    <div class="controls padding10">
                        <a class="left mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon padding10" data-go="prev"><h1><i class="material-icons">&#xE5CB;</i></h1></a>
                        <h2><span data-head-year></span> <span data-head-month></span></h2>
                        <a class="right mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon padding10" data-go="next"><h1><i class="material-icons">&#xE5CC;</i></h1></a>
                        <div class="clear"></div>
                    </div>
                    <div class="day-headers">
                        <div class="day header white-text"><?php $translate->__('Lun'); ?></div>
                        <div class="day header white-text"><?php $translate->__('Mar'); ?></div>
                        <div class="day header white-text"><?php $translate->__('Mie'); ?></div>
                        <div class="day header white-text"><?php $translate->__('Jue'); ?></div>
                        <div class="day header white-text"><?php $translate->__('Vie'); ?></div>
                        <div class="day header white-text"><?php $translate->__('Sab'); ?></div>
                        <div class="day header white-text"><?php $translate->__('Dom'); ?></div>
                    </div>
                    <div class="days-container">
                        <div class="days" data-group="days"></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="pnlListaCartas" class="page generic-panel gp-no-footer">
            <div class="gp-header mdl-layout mdl-layout--fixed-header">
                <header class="mdl-layout__header mdl-layout__header--waterfall">
                    <div class="mdl-layout__header-row">
                        <span class="mdl-layout-title">Carta</span>
                        <div class="mdl-layout-spacer"></div>
                        <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnSearch" data-type="search">
                            <i class="material-icons">&#xE8B6;</i>
                        </button>
                        <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnOpcionesCarta">
                            <i class="material-icons">&#xE5D4;</i>
                        </button>
                    </div>
                </header>
                <ul id="mnuOpcionesCarta" class="dropdown">
                    <li><a href="#" data-action="close" class="close-inner-window">Cerrar</a></li>
                </ul>
                <div class="control-inner-app mdl-layout__drawer-button">
                    <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                        <i class="material-icons">&#xE5D2;</i>
                    </a>
                </div>
            </div>
            <div class="gp-body">
                <div id="gvCarta" class="scrollbarra" data-selected="none" data-multiselect="false" data-actionbar="generic-actionbar">
                    <ul class="collection gridview">
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="appbar">
        <button id="btnEliminar" name="btnEliminar" type="button" class="cancel metro_button oculto float-right">
            <h2><i class="icon-remove"></i></h2>
        </button>
        <button id="btnGuardarCambios" type="button" class="metro_button oculto float-right">
            <h2><i class="icon-checkmark"></i></h2>
        </button>
        <button id="btnAsignar" name="btnAsignar" type="button" class="metro_button oculto float-right">
            <h2><i class="icon-checkmark"></i></h2>
        </button>
        <button id="btnSelectYearMonth" type="button" class="metro_button float-right">
            <h2><i class="icon-calendar"></i></h2>
        </button>
        <button id="btnBuscarArticulos" type="button" class="metro_button oculto float-right">
            <h2><i class="icon-search"></i></h2>
        </button>
        <button id="btnBackToPrevious" type="button" class="metro_button oculto float-left">
            <h2><i class="icon-arrow-left-3"></i></h2>
        </button>
        <button id="btnSelectAll" type="button" class="metro_button oculto float-left">
            <h2><i class="icon-checkbox"></i></h2>
        </button>
        <button id="btnLimpiarSeleccion" type="button" class="metro_button oculto float-left">
            <h2><i class="icon-undo"></i></h2>
        </button>
        <button id="btnAperturarMenu" name="btnAperturarMenu" type="button" class="metro_button oculto float-right">
            <h2><i class="icon-thumbs-up"></i></h2>
        </button>
        <button id="btnClearCarta" type="button" class="metro_button oculto oculto float-left">
            <h2><i class="icon-undo"></i></h2>
        </button>
        <button id="btnSetCarta" type="button" class="metro_button oculto float-left">
            <h2><i class="icon-lightning"></i></h2>
        </button>
        <button id="btnEliminarCarta" type="button" class="metro_button oculto float-right">
            <h2><i class="icon-remove"></i></h2>
        </button>
        <button id="btnEditarCarta" type="button" class="metro_button oculto float-right">
            <h2><i class="icon-pencil"></i></h2>
        </button>
        <button id="btnNuevaCarta" type="button" class="metro_button oculto float-right">
            <h2><i class="icon-plus-2"></i></h2>
        </button>
        <div class="clear"></div>
    </div> -->
    <div id="pnlRegistroCarta" class="modal-dialog modal-example-content">
        <div class="modal-example-header">
            <div class="left">
                <a href="#" title="<?php $translate->__('Ocultar'); ?>" class="close-modal-example fg-dark padding5 circle waves-effect waves-light left"><i class="material-icons md-18">close</i></a>
                <h4 class="no-margin fg-dark left">
                     Registro de carta
                </h4>
            </div>
        </div>
        <div class="modal-example-body">
            <input type="hidden" name="hdIdCarta" id="hdIdCarta" value="0" />
            <div class="padding20">
                <div class="row">
                    <div class="input-field full-size">
                      <input id="txtNombreCarta" name="txtNombreCarta" type="text" class="validate">
                      <label class="active" for="txtNombreCarta">Nombre de carta</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnGuardarCarta" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Aplicar
            </button>
        </div>
    </div>
    <a id="btnNuevo" class="btn-floating btn-large waves-effect waves-light red" style="bottom: 45px; right: 42px; position: absolute; z-index: 900;">
        <i class="large material-icons">add</i>
    </a>
    <?php include 'common/generic-actionbar.php'; ?>
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');
?>
<script src="scripts/underscore-min.js"></script>
<script src="scripts/select2.min.js"></script>
<script src="scripts/responsive-calendar.min.js"></script>
<script src="scripts/app/process/menutoday-script.min.js"></script>