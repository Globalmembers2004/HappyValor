<?php
$folder = isset($_GET['folder']) ? $_GET['folder'] : '';
?>
<form id="upload" class="bg-darkTeal" method="post" action="upload.php" enctype="multipart/form-data">
	<input type="hidden" name="hdSaveData" id="hdSaveData" value="<?php echo $savedata; ?>">
	<input type="hidden" name="hdIdConfigPunto" id="hdIdConfigPunto" value="<?php echo $idconfigpunto; ?>">
	<input type="hidden" name="hdIdLogo" id="hdIdLogo" value="<?php echo $idlogo; ?>">
	<input type="hidden" name="hdOrigenSubida" id="hdOrigenSubida" value="<?php echo $origensubida; ?>">
	<input type="hidden" name="hdFolder" id="hdFolder" value="<?php echo $folder; ?>">
	<div class="generic-panel gp-no-footer">
		<div class="gp-header">
			<div id="drop">
				Drop aqu&iacute; :3
				<a>Examinar</a>
				<input type="file" name="upl" multiple />
			</div>
		</div>
		<div class="gp-body">
			<div class="scrollbarra">
				<ul></ul>
			</div>
		</div>
	</div>
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');
include('common/bootstrap-js.php');
?>
<script src="scripts/jquery.knob.min.js"></script>
<script src="scripts/jquery.iframe-transport.min.js"></script>
<script src="scripts/jquery.fileupload.min.js"></script>
<script src="scripts/uploader.min.js"></script>