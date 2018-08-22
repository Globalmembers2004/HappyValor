<?php
$iuser = isset($_GET['iuser']) ? $_GET['iuser'] : '';
$ipass = isset($_GET['ipass']) ? $_GET['ipass'] : '';

$idusuario = "";
$username = "";
$CheckLogin = false;

require 'adata/Db.class.php';
require 'bussiness/usuarios.php';

$usuario = new clsUsuario();
$validUsuario = $usuario->loginUsuario($iuser, $ipass);
$countUsuario = count($validUsuario);

if ($countUsuario > 0){
    if ($validUsuario[0]['Activo'] == '1'){
        $idusuario = $validUsuario[0]['tm_idusuario']);
        $username = $validUsuario[0]['tm_login']);

        $CheckLogin = true;
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
    <?php if ($CheckLogin): ?>
    <form id="pnlRegister" name="pnlRegister" method="post" autocomplete="off" action="regconfirm_post.php" class="panel-login bg-opacity-7 centered">
        <input type="hidden" name="hdIdUsuario" id="hdIdUsuario" value="<?php echo $idusuario; ?>">
        <div class="generic-panel gp-no-header">
            <div class="gp-body">
                <div class="scrollbarra padding30">
                    <div class="row no-margin-bottom">
                        <h4 class="white-text align-center">Ingrese una nueva clave para ingresar</h4>
                    </div>
                    <div class="row no-margin-bottom">
                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--12-col">
                                <div class="input-field">
                                    <input type="password" class="white-text" name="clave" id="clave">
                                    <label class="white-text" for="clave">Clave</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row no-margin-bottom">
                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--12-col">
                                <div class="input-field">
                                    <input type="password" class="white-text" name="confirma_clave" id="confirma_clave">
                                    <label class="white-text" for="confirma_clave">Confirmar Clave</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row no-margin-bottom">
                        <h4 class="white-text align-center">¿Le gusta este nombre de usuario? Si no le gusta, puede cambiarlo :3 ...</h4>
                    </div>
                    <div class="row no-margin-bottom">
                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--12-col">
                                <div class="input-field">
                                    <input type="text" class="white-text" name="username" id="username" value="<?php echo $username; ?>">
                                    <label class="white-text" for="username">Usuario</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gp-footer">
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col">
                        <button id="btnRegister" name="btnRegister" type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect center-block">Confirmar datos</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php else: ?>
    <form class="panel-login bg-opacity-7 centered">
     <div class="generic-panel">
            <div class="gp-header">
                <h3 class="white-text align-center padding10">Usted no est&aacute; autiorizado a ver esta p&aacute;gina</h3>
            </div>
            <div class="gp-body">
                <div class="scrollbarra padding10">
                    <div class="row">
                        <p class="padding10 white-text align-center">
                            <strong>Su USUARIO es incorrecto o est&aacute; vencida.</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php endif; ?>
    <script src="scripts/jquery/jquery-2.1.3.min.js"></script>
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