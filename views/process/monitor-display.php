<input type="hidden" id="hdIdEmpresa" name="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
<input type="hidden" id="hdIdCentro" name="hdIdCentro" value="<?php echo $IdCentro; ?>" />
<div id="pnlMonitor" class="black all-height mdl-grid mdl-grid--no-spacing">
    <div class="displayMonitor mdl-cell mdl-cell--12-col all-height">
    	<div class="monitorVideo">
        	<iframe width="560" height="315" src="https://www.youtube.com/embed/videoseries?list=PLMSDRYotkyLrCBbOhsaYWnVs0R2PJuxmi&autoplay=1&loop=1" frameborder="0" allowfullscreen></iframe>
    	</div>
    	<div class="banner pos-rel">
    		<div id="pnlEspera" class="subpanel mdl-grid">

            </div>
    	</div>
    </div>
</div>
<button id="btnAmbientes" type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored mdl-js-ripple-effect place-bottom-left margin10">
    <i class="material-icons">&#xE8F0;</i>
</button>
<div id="modalAmbientes" class="modalcuatro bg-opacity-8 without-footer modal-example-content expand-phone">
    <div class="modal-example-header">
        <div class="left">
            <a href="#" title="Ocultar" class="close-modal-example white-text padding5 circle left"><i class="material-icons md-32">close</i></a>
            <h3 class="no-margin white-text left">
                Ambientes
            </h3>
        </div>
    </div>
    <div class="modal-example-body">
        <div id="gvAmbientes" class="mdl-grid scrollbarra padding20"></div>
    </div>
</div>