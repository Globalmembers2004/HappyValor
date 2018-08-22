<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

$rpta = 0;
$estado_mensaje = 'GET';
$mensaje = "";

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

    $email = isset($_POST['email']) ? $_POST['email'] : '';

    $usuario = new clsUsuario();
    $result = $usuario->IfExists__UsuarioEmail($email);

    if (count($result) > 0) {
        $idusuario = $result[0]['tm_idusuario'];

        $subject = "Recuperar contraseña de su cuenta de Código Fit";

        $message = '<html><head>';
        $message .= '</head><body>';
        $message .= '<p>Hola, para recuperar tu clave sólo da click en el siguiente enlace: <br>';
        $message .= '<a class="btn btn-primary" href="https://codigofit.net/changepassord.php?idusuario='.$idusuario.'">https://codigofit.net/changepassord.php?idusuario='.$idusuario.'</a></p>';
        $message .= '<br>';
        $message .= '</div></body></html>';

        $embeddedFiles = false;

        require 'common/PHPMailerAutoload.php';
        require 'common/simply_email.php';

        $objEmail = new clsSimplyEmail();
        $resultMail = $objEmail->EnvioEmail('info@codigofit.net', $email, $subject, $message, false, $embeddedFiles);

        $mensaje = "Enviado correctamente";
        $estado_mensaje = 'SUCCESS';
    }
    else {
        $estado_mensaje = 'INVALID_EMAIL';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#fcae07">
	<title>CODIGOFIT</title>
    <link rel="icon" sizes="192x192" type="image/png" href="images/favicon.png" />
    <link rel="stylesheet" href="plugins/materialize/css/materialize.min.css"/>
    <link rel="stylesheet" href="styles/material.min.css"/>
    <link rel="stylesheet" href="styles/common.min.css"/>
    <link rel="stylesheet" href="styles/styles.min.css"/>
    <link rel="stylesheet" href="styles/login.min.css"/>
</head>
<body>
    <form id="modalBlocker" class="overlay-blocker" name="pnlPreliminar" method="post" autocomplete="off">
        <div class="Aligner all-height">
            <div class="Aligner-item Aligner-item--fixed bg-opacity-5 padding20">
                <div class="Demo">
                    <?php if ($estado_mensaje == 'GET'): ?>
                    <div class="row">
                        <h3 class="white-text align-center padding10">Recupere su contrase&ntilde;a</h3>
                    </div>
                    <div class="row">
                        <p class="padding10 white-text align-center">
                            <strong>¿Olvid&oacute; su clave? Ingrese el correo electr&oacute;nico con el cual se registr&oacute; para poder enviarle un link con el cual puede generar una nueva clave.</strong>
                        </p>
                    </div>
                    <div class="row pos-rel no-margin padding-left20 padding-right20">
                        <div class="input-field">
                            <input type="email" class="white-text" name="email" id="email">
                            <label class="white-text" for="email">Correo electr&oacute;nico</label>
                        </div>
                    </div>
                    <div class="row align-center">
                        <button id="btnRecuperarClave" type="submit" class="btn blue waves-effect">Enviar correo de recuperaci&oacute;n</button>
                    </div>
                    <div class="row align-center">
                        <a href="login.php" class="btn green waves-effect">Volver a iniciar sesi&oacute;n</a>
                    </div>
                    <?php elseif ($estado_mensaje == 'INVALID_EMAIL'): ?>
                    <div class="row">
                        <h3 class="white-text center">Su email no pertenece ni está asociado a ninguna cuenta de CodigoFit</h3>
                    </div>
                    <div class="row">
                        <p class="white-text">
                            Proporcione un correo registrado en nuestra central. Muchas gracias por su comprensi&oacute;n.
                        </p>
                    </div>
                    <div class="row align-center">
                        <a href="recoverypass.php" class="btn btn-primary waves-effect">Volver a enviar</a>
                    </div>
                    <?php else: ?>
                    <div class="row">
                        <h3 class="white-text center">Correo validado satisfactoriamente</h3>
                    </div>
                    <div class="row">
                        <p class="white-text">
                            Vaya a la bandeja de entrada del correo electr&oacute;nico proporcionado para acceder a la opci&oacute;n de cambio de clave, luego de ello podr&aacute; iniciar sesi&oacute;n en nuestra plataforma con la nueva clave.
                        </p>
                    </div>
                    <div class="row align-center">
                        <a href="login.php" class="btn btn-primary waves-effect">Entendido</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </form>
    <script src="scripts/jquery/jquery-2.1.3.min.js"></script>
    <script src="plugins/jquery-ui/js/jquery-ui.min.js"></script>
    <script src="scripts/jquery/jquery.widget.min.js"></script>
    <script src="scripts/jquery/jquery.mousewheel.min.js"></script>
    <script src="plugins/jquery-validate/jquery.validate.min.js"></script>
    <script src="plugins/jquery-validate/additional-methods.min.js"></script>
    <script src="plugins/jquery-validate/localization/messages_es.min.js"></script>
    <script src="plugins/materialize/js/materialize.min.js"></script>
    <script src="scripts/material.min.js"></script>
    <script src="scripts/functions-jquery.js"></script>

</body>
</html>