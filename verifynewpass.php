<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#3F51B5">
	<title>CODIGOFIT - Sistema de Gestión y Asesoría para tu Gimnasio</title>
    <link rel="icon" sizes="192x192" type="image/png" href="images/favicon.png" />
    <link rel="stylesheet" href="styles/materialize.min.css"/>
    <link rel="stylesheet" href="styles/material.min.css"/>
    <link rel="stylesheet" href="styles/common.min.css"/>
    <link rel="stylesheet" href="styles/styles.min.css"/>
    <link rel="stylesheet" href="styles/login.min.css"/>
</head>
<body>
    <form id="pnlNewPass" name="pnlNewPass" method="POST" enctype="multipart/form-data" autocomplete="off" action="services/usuarios/login.php" class="panel-login bg-opacity-7 centered">
        <input style="display:none" type="text" name="fakeusernameremembered" class="fake-autofill-fields no-opacity" />
        <input style="display:none" type="password" name="fakepasswordremembered" class="fake-autofill-fields no-opacity" />
        <div class="grid expand-phone padding30">
            <div class="row">
                <div class="logo pos-rel">
                    <img src="images/logo-main.png" class="centered mdl-shadow--4dp " width="300px" height="100px" alt="Logo">
                </div>
            </div>
            <div class="row">
                <h3 class="white-text align-center">Sistema de Gestión y Asesoría para tu Gimnasio</h3>
            </div>
            <div class="row pos-rel no-margin padding-left20 padding-right20">
                <div class="input-field">
                    <input type="text" class="white-text" name="login" id="login">
                    <label class="white-text" for="login">Usuario</label>
                </div>
            </div>
            <div class="row pos-rel no-margin padding-left20 padding-right20">
                <div class="mdl-grid mdl-grid--no-spacing">
                    <div class="mdl-cell mdl-cell--6-col pos-rel">
                        <div class="input-field padding-right10">
                            <input type="password" class="white-text" name="clave" id="clave">
                            <label class="white-text" for="clave">Clave</label>
                        </div>
                        <button id="btnShowPass__Clave" type="button" class="mdl-button mdl-js-button mdl-button--icon white-text place-bottom-right margin20">
                            <i class="material-icons">&#xE417;</i>
                        </button>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col pos-rel">
                        <div class="input-field padding-left10">
                            <input type="password" class="white-text" name="confirma_clave" id="confirma_clave">
                            <label class="white-text" for="confirma_clave">Confirmar Clave</label>
                        </div>
                        <button id="btnShowPass__Confirm" type="button" class="mdl-button mdl-js-button mdl-button--icon white-text place-bottom-right margin20">
                            <i class="material-icons">&#xE417;</i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row align-center no-margin">
                <button id="btnConfirmNewPass" name="btnConfirmNewPass" type="submit" lang="es" class="mdl-button mdl-js-button mdl-js-ripple-effect yellow darken-1 black-text margin10">
                    Confirmar nueva clave
                </button>
                <button id="btnGoToRegister" type="button" name="btnGoToRegister" lang="es" class="mdl-button mdl-js-button mdl-js-ripple-effect orange darken-1 black-text margin10">
                    Regístrate!
                </button>
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
    <script src="scripts/materialize.min.js"></script>
    <script src="scripts/material.min.js"></script>
    <script src="scripts/functions-jquery.js"></script>
    <script src="scripts/app/common/login.min.js"></script>
</body>
</html>