<div id="pnlConfiguracion" class="page generic-panel gp-no-footer mdl-layout mdl-layout--fixed-header">
    <input type="hidden" name="hdIdOrden" id="hdIdOrden" value="0">
    <input type="hidden" name="hdTipoComprobante" id="hdTipoComprobante" value="0">
    <input type="hidden" name="hdTipoCliente" id="hdTipoCliente" value="0">
    <header class="gp-header mdl-layout__header">
        <div class="mdl-layout__header-row">
            <span class="mdl-layout-title"><?php $translate->__('Configuraci&oacute;n'); ?></span>
            <div class="mdl-layout-spacer"></div>
            <button type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnOpcionesMenu">
                <i class="material-icons">&#xE5D4;</i>
            </button>
        </div>
    </header>
    <div class="control-inner-app mdl-layout__drawer-button">
        <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
            <i class="material-icons">&#xE5D2;</i>
        </a>
    </div>
    <main class="gp-body no-overflow">
    	<div class="mdl-grid mdl-grid--no-spacing all-height">
    		<div class="mdl-cell mdl-cell--3-col all-height">
    			<div class="scrollbarra padding10">
	    			<div class="collection">
                        <?php if ($codigo == 'global1971'): ?>
						<a class="collection-item" data-tab="tab12" href="?pag=settings&subpag=tipomovcaja"><?php $translate->__('Tipos de movimiento en caja'); ?></a>
						<a class="collection-item" data-tab="tab1" href="?pag=settings&subpag=moneda"><?php $translate->__('Monedas'); ?></a>
						<a class="collection-item" data-tab="tab3" href="?pag=settings&subpag=forma-pago"><?php $translate->__('Medios de pago'); ?></a>
                        <a class="collection-item" data-tab="tab4" href="?pag=settings&subpag=documentos"><?php $translate->__('Documentos de identidad'); ?></a>
                        <?php endif; ?>
					</div>
    			</div>
    		</div>
    		<div class="mdl-cell mdl-cell--9-col all-height">
    			<div class="panels"></div>
    		</div>
    	</div>
	</main>
</div>