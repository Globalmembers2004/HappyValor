<?php
require 'common/class.translation.php';
$lang = (isset($_GET['lang'])) ? $_GET['lang'] : 'es';
$translate = new Translator($lang);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>HAPPYLAND</title>
    <link rel="stylesheet" href="styles/material.min.css"/>
    <link rel="stylesheet" href="styles/materialize.min.css"/>
    <link rel="stylesheet" href="styles/custombox-modal.min.css"/>
    <link rel="stylesheet" href="styles/common.min.css"/>
    <link rel="stylesheet" href="styles/styles.min.css"/>
    <link rel="stylesheet" href="styles/login.min.css"/>
</head>
<body>
    <div class="red darken-3 white-text mdl-card centered modal-half mdl-shadow--2dp">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--12-col">
                <h2><?php $translate->__('Error de inicio de sesi&oacute;n'); ?></h2>
            </div>
        </div>
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--12-col">
                <h3 class="align-center"><?php $translate->__('Los datos de usuario o clave proporcionados son incorrectos'); ?></h3>
            </div>
        </div>
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--12-col">
                <a href="login.php" class="mdl-button mdl-js-button mdl-js-ripple-effect center-block white-text"><?php $translate->__('Iniciar sesi&oacute;n'); ?></a>
            </div>
        </div>
    </div>
    <script src="scripts/material.min.js" type="text/javascript"></script>
</body>
</html>