<?php
if ($_POST){
    require 'common/sesion.class.php';
    require 'adata/Db.class.php';
    require 'bussiness/usuarios.php';

	$rpta = 0;
    $titulomsje = '';
    $contenidomsje = '';

    $sesion = new sesion();
    $usuario = new clsUsuario();

    $idusuario = $_POST['hdIdUsuario'];
    $clave = $_POST['clave'];
    $confirma_clave = $_POST['confirma_clave'];

    $usuario->ActualizarUserPass($idusuario, $clave, $idusuario, $rpta, $titulomsje, $contenidomsje);

    if ($rpta > 0) {
    	$validUsuario = $usuario->loginUsuario($username, $password);

	    if (count($validUsuario) > 0){
	        if ($validUsuario[0]['Activo'] == '1'){
	            $codigoperfil = $validUsuario[0]['codigoperfil'];

	            $sesion->set("idusuario", $validUsuario[0]['tm_idusuario']);
	            $sesion->set("login", $validUsuario[0]['tm_login']);
	            $sesion->set("nombres", $validUsuario[0]['tm_nombres'] . ' ' . $validUsuario[0]['tm_apellidos']);
	            $sesion->set("idperfil", $validUsuario[0]['tm_idperfil']);
	            $sesion->set("codigoperfil", $codigoperfil);
	            $sesion->set("foto", $validUsuario[0]['tm_foto']);
	            $sesion->set("correo", $validUsuario[0]['tm_email']);
	            $sesion->set("codigo", $validUsuario[0]['tm_codigo']);
	            $sesion->set("idpersona", $validUsuario[0]['tm_idpersona']);
	            $sesion->set("codigo", $validUsuario[0]['tm_codigo']);
	            $sesion->set("idempresa", $validUsuario[0]['tm_idempresa']);
	            $sesion->set("idcentro", $validUsuario[0]['tm_idcentro']);
	            $sesion->set("datos_preliminares", $validUsuario[0]['datos_preliminares']);
	            $sesion->set("idusuario_plataforma", $validUsuario[0]['idusuario_plataforma']);
	            $sesion->set("default_lang", $validUsuario[0]['tm_idioma']);
	        }
	    }
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
    <title>CODIGOFT</title>
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
                    <strong>Usted se ha registrado satisfactoriamente en Codigofit.</strong>
                </p>
            </div>
            <div class="gp-footer align-center">
                <a href="index.php" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored red mdl-js-ripple-effect margin10">¡Haga su pedido ya!</a>
            </div>
        </div>
    </div>
</body>
</html>