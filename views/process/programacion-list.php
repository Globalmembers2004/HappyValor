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
    <input type="hidden" id="hdPageArticulo" name="hdPageArticulo" value="1" />
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
        <div id="pnlMenu" class="page is-active generic-panel gp-no-footer mdl-layout mdl-layout--fixed-header">
            <header class="gp-header mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Men&uacute; del d&iacute;a</span>
                    <div class="mdl-layout-spacer"></div>
                    <button type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnOpciones">
                        <i class="material-icons">&#xE5D4;</i>
                    </button>
                </div>
            </header>
            <ul id="mnuOpciones" class="mnuOpciones dropdown">
                <li><a href="#" data-action="close" class="close-inner-window">Cerrar</a></li>
            </ul>
            <div class="control-inner-app mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div>
            <main class="gp-body no-overflow">
            	<div class="row all-height">
					<div class="col s12 m5 l5 all-height blue-grey lighten-5">
						<div id="pnlCalendarioIndividual" class="responsive-calendar mdl-shadow--2dp">
		                    <div class="controls white padding10">
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
		                        <div class="days grey lighten-5" data-group="days"></div>
		                    </div>
		                </div>
					</div>
					<div class="col s12 m7 l7 all-height pos-rel">
		            	<div id="gvPacksMenu" class="gridview-wrapper scrollbarra" data-selected="none" data-multiselect="false" data-actionbar="articulos-actionbar">
                            <div class="gridview pos-rel">
                            </div>
                        </div>
                        <div id="emptyInProgram" class="empty-data indigo demo-card-square mdl-card mdl-shadow--2dp centered hide">
                            <div class="mdl-card__title mdl-card--expand">
                                <h2 class="mdl-card__title-text white-text">No hay men&uacute; para hoy :(</h2></div>
                            <div class="mdl-card__supporting-text white-text">Asigne art&iacute;culos o combos haciendo click en el bot&oacute;n debajo de estas l&iacute;neas.</div>
                            <div class="mdl-card__actions">
                            <button id="btnBuscar" type="button" class="indigo darken-4 right mdl-button white-text mdl-js-button waves-effect waves-light">Buscar art&iacute;culos</button>
                            </div>
                        </div>
					</div>
            	</div>
            </main>
            <div id="btnActionMenu" class="fixed-action-btn" style="bottom: 45px; right: 24px;">
                <a class="btn-floating btn-large red waves-effec waves-lightt">
                    <i class="material-icons">&#xE3C9;</i>
                </a>
                <ul>
                    <li>
                        <span class="mobile-fab-tip">Configurar packs</span>
                        <a href="#" data-action="packs-settings" class="btn-floating blue darken-1 tooltipped" data-position="left" data-tooltip="Configurar packs">
                            <i class="material-icons">&#xE060;</i>
                        </a>
                    </li>
                    <li>
                        <span class="mobile-fab-tip">Aperturar men&uacute;</span>
                        <a href="#" data-action="open-menu" class="btn-floating red tooltipped" data-position="left" data-tooltip="Aperturar men&uacute;">
                            <i class="material-icons">&#xE255;</i>
                        </a>
                    </li>
                    <li>
                        <span class="mobile-fab-tip">Buscar art&iacute;culos</span>
                        <a href="#" data-action="search-articles" class="btn-floating green tooltipped" data-position="left" data-tooltip="Buscar art&iacute;culos">
                            <i class="material-icons">&#xE8B6;</i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div id="pnlAsignacion" class="demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <header class="mdl-layout__header mdl-layout__header--waterfall">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Articulos</span>
                    <div class="mdl-layout-spacer"></div>
                    <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnSearch" data-type="search">
                        <i class="material-icons">&#xE8B6;</i>
                    </button>
                    <button type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnOpciones">
                        <i class="material-icons">&#xE5D4;</i>
                    </button>
                </div>
            </header>
            <?php include 'common/droplist-generic.php'; ?>
            <div class="control-inner-app mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div>
            <main class="mdl-layout__content">
                <div class="page-content">
                    <section id="tabArticulo">
                        <div id="gvDatos" class="gridview-wrapper pos-rel" data-selected="none" data-multiselect="false" data-actionbar="articulos-actionbar">
                            <div class="mdl-grid gridview">
                            </div>
                        </div>
                    </section>
                    <section id="tabPack" style="display: none;">
                        <div id="gvPacks" class="gridview-wrapper" data-selected="none" data-multiselect="false" data-actionbar="articulos-actionbar">
                            <div class="gridview pos-rel">
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>
        <div id="articulos-actionbar" class="actionbar fixed-top mdl-layout">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <div class="pos-rel full-size m-search">
                        <input type="text" name="txtSearch" id="txtSearch" data-input="search" placeholder="Ingrese un criterio de b&uacute;squeda" value="" autocomplete="off">
                        <button type="button" class="helper-button margin5 height-centered mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon"><i class="material-icons">&#xE5CD;</i></button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="mdl-layout-spacer"></div>
                    <button id="btnGoToPacks" type="button" data-action="add-list" class="show-in-select mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                        <i class="material-icons">&#xE890;</i>
                    </button>
                    <button id="btnOpciones" type="button" class="btnOpciones show-in-select mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                        <i class="material-icons">&#xE5D4;</i>
                    </button>
                    <button id="btnSearchPacks" type="button" class="oculto show-in-select mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                        <i class="material-icons">&#xE8B6;</i>
                    </button>
                    <button id="btnAsignarProductos" type="button" data-action="confirm" class="oculto show-in-select mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                        <i class="material-icons">&#xE5CA;</i>
                    </button>
                </div>
            </header>
            <div class="mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5C4;</i>
                </a>
            </div>
        </div>
    </div>
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');
?>
<script src="scripts/underscore-min.js"></script>
<script src="scripts/masonry.pkgd.min.js"></script>
<script src="scripts/select2.min.js"></script>
<script src="scripts/responsive-calendar.min.js"></script>
<script src="scripts/app/process/programacion-script.min.js"></script>