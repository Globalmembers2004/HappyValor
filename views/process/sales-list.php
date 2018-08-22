<form id="form1" name="form1" method="post">
    <input type="hidden" name="hdIdEmpresa" id="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" name="hdIdCentro" id="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0">
    <div class="page-region">
        <div id="pnlListado" class="generic-panel page gp-no-footer">
            <div class="gp-header mdl-layout--fixed-header">
                <header class="mdl-layout__header orange">
                    <div class="mdl-layout__header-row">
                        <span class="mdl-layout-title">Ventas</span>
                        <div class="mdl-layout-spacer"></div>
                        <input type="text" name="txtSearch" id="txtSearch" class="oculto" value="">
                        <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnSearch" data-type="search">
                            <i class="material-icons">&#xE8B6;</i>
                        </button>
                        <button type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnOpciones">
                            <i class="material-icons">&#xE5D4;</i>
                        </button>
                    </div>
                </header>
            </div>
            <?php include 'common/droplist-generic.php'; ?>
            <div class="mdl-layout__drawer-button">
                <!-- <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a> -->
                <a class="back-activity mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5C4;</i>
                </a>
            </div>              
            
<!--             <div class="control-inner-app mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div>
 -->            <div class="gp-body">
                <div id="gvDatos" class="gridview scrollbarra col-md-12 padding-top20" data-selected="none" data-multiselect="false" data-actionbar="generic-actionbar">
                </div>
            </div>
            <a id="btnNuevo" class="mdl-button mdl-js-button mdl-button--fab animate mdl-js-ripple-effect mdl-button--colored hide" style="bottom: 45px; right: 24px; position: absolute; z-index: 900;">
                <i class="material-icons">&#xE145;</i>
            </a>
        </div>
    </div>
</form>