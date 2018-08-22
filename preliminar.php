<?php require 'common/init_session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#fcae07">
	<title>CODIGOFIT</title>
    <link rel="icon" sizes="192x192" type="image/png" href="images/favicon.png" />
    <link rel="stylesheet" href="styles/materialize.min.css"/>
    <link rel="stylesheet" href="styles/material.min.css"/>
    <link rel="stylesheet" href="styles/common.min.css"/>
    <link rel="stylesheet" href="styles/styles.min.css"/>
    <link rel="stylesheet" href="styles/login.min.css"/>
</head>
<body>
    <form id="pnlPreliminar" name="pnlPreliminar" method="post" autocomplete="off" action="registro.php" class="panel-login bg-opacity-7 centered">
        <input type="hidden" id="hdIdEmpresa" name="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
        <input type="hidden" id="hdIdCentro" name="hdIdCentro" value="<?php echo $IdCentro; ?>" />
        <div class="generic-panel">
        	<div class="gp-header">
                <h3 class="white-text align-center padding10">¡Bienvenido a Codigofit!</h3>
            </div>
            <div class="gp-body">
                <div class="scrollbarra padding10">
                	<div class="row">
                		<p class="padding10 white-text align-center">
                			<strong>¡Hola! Bienvenido a Codigofit, la mejor aplicación web de gimnasios. Usted est&aacute; a un paso de poder disfrutar de todas las herramientas que les brindamos a trav&eacute;s de esta aplciaci&oacute;n para poder hacer crecer su negocio de una forma f&aacute;cil, intuitiva y completa.</strong>
                		</p>
                		<h4 class="white-text align-center">Nuestra plataforma ya cuenta con informacióm prederteminada que le ayudar&aacute; a iniciar de una forma m&aacute;s r&aacute;pida ¿Desea descartar su importaci&oacute;n, proceder a importar la información o mejor importar m&aacute;s tarde?</h4>
                	</div>
				</div>
			</div>
			<div class="gp-footer">
				<div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--4-col">
                        <button id="btnDescartar" type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored red mdl-js-ripple-effect center-block margin10">Descartar</button>
                    </div>
                    <div class="mdl-cell mdl-cell--8-col">
                        <button id="btnImportar" type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect center-block margin10">Importar informaci&oacute;n</button>
                    </div>
                </div>
			</div>
		</div>
	</form>
    <script src="scripts/jquery/jquery-2.1.3.min.js"></script>
    <script src="scripts/app/common/preliminar.js"></script>
</body>
</html>