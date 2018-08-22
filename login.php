<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#3F51B5">
	<title>HAPPYLAND</title>
    <link rel="icon" sizes="192x192" type="image/ico" href="images/favicon.ico" />
    <link rel="stylesheet" href="plugins/materialize/css/materialize.css"/>
    <link rel="stylesheet" href="styles/material.min.css"/>
    <link rel="stylesheet" href="styles/common.min.css"/>
    <link rel="stylesheet" href="styles/styles.min.css"/>
    <link rel="stylesheet" href="styles/login.min.css"/>
</head>
<body>
    <div class="full-size all-height bg-opacity-5 centered">
        <form id="pnlLogin" name="pnlLogin" method="POST" enctype="multipart/form-data" autocomplete="off" action="services/usuarios/login.php" class="panel-login centered">
            <input style="display:none" type="text" name="fakeusernameremembered" class="fake-autofill-fields no-opacity" />
            <input style="display:none" type="password" name="fakepasswordremembered" class="fake-autofill-fields no-opacity" />
            <div class="grid expand-phone padding30">
                <div class="row">
                    <div class="logo pos-rel">
                        <img src="images/logo-main.png" class="centered" width="300px" height="61px" alt="Logo">
                    </div>
                </div>
                <div class="row">
                    <h3 class="white-text align-center">Módulo de Valorización</h3>
                </div>
                <div class="row pos-rel no-margin padding-left20 padding-right20">
                    <div class="input-field">
                        <input type="text" class="white-text" name="login" id="login"  placeholder="Usuario">
<!--                         <label class="white-text" for="login">Usuario</label>    -->                 	
                    </div>
                </div>
                <div class="row pos-rel no-margin padding-left20 padding-right20">
                    <div class="input-field">
                        <input type="password" class="white-text" name="password" id="password"  placeholder="Clave">
<!--                         <label class="white-text" for="password">Contrase&ntilde;a</label>
 -->                    </div>
                    <button id="btnShowPass" type="button" class="mdl-button mdl-js-button mdl-button--icon white-text place-top-right margin-right20">
                        <i class="material-icons">&#xE417;</i>
                    </button>
                </div>
                <div class="row align-center no-margin">
                    <button id="btnLogin" name="btnLogin" type="submit" lang="es" class="mdl-button mdl-js-button mdl-js-ripple-effect yellow darken-1 black-text margin10">
                        Iniciar sesión
                    </button>
                </div>
<!--                 <div class="row align-center no-margin">
                    <a href="recoverypass.php" class="white-text text-underline">No recuerdo mi contraseña</a>
                </div>
 -->            </div>
        </form>
    </div>
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
    <script src="scripts/app/common/login.min.js"></script>
</body>
</html>