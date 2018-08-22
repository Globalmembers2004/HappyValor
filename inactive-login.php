<?php
require('common/class.translation.php');
$lang = (isset($_GET['lang'])) ? $_GET['lang'] : 'es';
$translate = new Translator($lang);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>TAMBOAPP</title>
    <link rel="stylesheet" href="styles/material.min.css"/>
    <link rel="stylesheet" href="styles/custombox-modal.min.css"/>
    <link rel="stylesheet" href="styles/common.min.css"/>
    <link rel="stylesheet" href="styles/styles.min.css"/>
</head>
<body class="red lighten-3">
    <div class="mdl-card centered padding30 modal-half mdl-shadow--2dp">
        <h2><?php $translate->__('Su cuenta no est&aacute; activada'); ?></h2>
        <p><?php $translate->__('Su cuenta a&uacute;n no ha sido activada o ha sido deshabilitada permanentemente. Escriba un correo a info@globalmembers.net en caso se trate de un error'); ?></p>
        <a href="login.php" class="mdl-button mdl-js-button mdl-js-ripple-effect right"><?php $translate->__('Iniciar sesi&oacute;n'); ?></a>
    </div>
    <script src="scripts/material.min.js" type="text/javascript"></script>
</body>
</html>