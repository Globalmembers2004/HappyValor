<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

$rpta = 0;

if ($_POST){
    require 'common/sesion.class.php';
    require 'adata/Db.class.php';
    require 'bussiness/usuarios.php';

    $titulomsje = '';
    $contenidomsje = '';

    $Auxrpta = 0;
    $Auxtitulomsje = '';
    $Auxcontenidomsje = '';

    $idusuario_registrador = 1;

    $sesion = new sesion();
    $usuario = new clsUsuario();

    $chkTipoPersona = isset($_POST['chkTipoPersona']) ? $_POST['chkTipoPersona'] : 0;
    $ddlRegion = $_POST['ddlRegion'];
    $nrodocumento = $_POST['nrodocumento'];
    $username = $_POST['username'];
    $business_name = $_POST['business_name'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $clave = $_POST['clave'];
    $confirma_clave = $_POST['confirma_clave'];
    $hdIdRecomendador = isset($_POST['hdIdRecomendador']) ? $_POST['hdIdRecomendador'] : '0';

    $usuario->Registrar_Plataforma($username, $clave, $chkTipoPersona, $ddlRegion, $nrodocumento, $business_name, $firstname, $lastname, $email, $idusuario_registrador, $rpta, $titulomsje, $contenidomsje);

    if ($rpta > 0) {

        if ($hdIdRecomendador != '0') {
            require 'bussiness/recomendacion.php';
            $objRecomendacion = new clsRecomendacion();

            $objRecomendacion->Registrar(0, '00', $rpta, $hdIdRecomendador, $Auxrpta, $Auxtitulomsje, $Auxcontenidomensaje);
        }

        $subject = ucfirst($firstname) . ', bievenid@ a Codigofit!';

        $message = '<html><head>';
        $message .= '</head><body>';
        $message .= '<p>Hola ' . ucfirst($firstname) . ', te damos la bienvenida a nuestra plataforma de gimnasios. .</p>';
        $message .= '<p>Bienvenid@ ' . ucfirst($firstname) . '!!!';
        $message .= '</div></body></html>';

        $embeddedFiles = false;

        require 'common/PHPMailerAutoload.php';
        require 'common/simply_email.php';

        $objEmail = new clsSimplyEmail();
        $resultMail = $objEmail->EnvioEmail('info@tamboapp.com', $email, $subject, $message, false, $embeddedFiles);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#3F51B5">
    <title>CODIGOFIT</title>
    <link rel="icon" sizes="192x192" type="image/png" href="images/favicon.png" />
    <link rel="stylesheet" href="styles/materialize.min.css"/>
    <link rel="stylesheet" href="styles/material.min.css"/>
    <link rel="stylesheet" href="styles/common.min.css"/>
    <link rel="stylesheet" href="styles/styles.min.css"/>
    <link rel="stylesheet" href="styles/login.min.css"/>
</head>
<body>
    <div class="panel-login bg-opacity-7 centered">
        <div class="generic-panel">
            <div class="gp-header">
                <h3 class="white-text align-center padding10">¡Usted se ha registrado satisfactoriamente!</h3>
            </div>
            <div class="gp-body">
                <p class="align-center white-text padding20">
                    <strong>Usted se ha registrado satisfactoriamente en Codigofit. Para poder disfrutar de todos los beneficios que brindamos s&iacute;rvase realizar el pago correspondiente a la siguiente cuenta:</strong>
                </p>
                <h4 class="align-center no-margin white-text">BCP Cuenta Ahorros - Soles: </h4>
                <h4 class="align-center no-margin white-text">C&oacute;digo Interbancario: </h4>
                <h4 class="align-center no-margin white-text"></h4>
                <p class="align-center white-text padding20">
                    <strong>y enviar copia de su voucher de dep&oacute;sito a la siguiente direcci&oacute;n de correo electr&oacute;nico:</strong>
                </p>
                <h4 class="align-center white-text">info@codigofit.net.</h4>
                <h3 class="white-text align-center padding20">Gracias por su comprensi&oacute;n.</h3>
            </div>
            <div class="gp-footer align-center">
                <a href="index.php" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored red mdl-js-ripple-effect margin10">Regresar</a>
            </div>
        </div>
    </div>
</body>
</html>