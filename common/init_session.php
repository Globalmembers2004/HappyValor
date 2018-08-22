<?php
header('Content-type: text/html; charset=utf-8');
require 'common/class.translation.php';
require 'common/sesion.class.php';

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$codigo = $sesion->get("codigo");
$login = $sesion->get("login");
$nombres = $sesion->get("nombres");
$idperfil = $sesion->get("idperfil");
$tipopersona = $sesion->get("tipopersona");
$idpersona = $sesion->get("idpersona");
$idpais = $sesion->get("idpais");
$idregion = $sesion->get("idregion");
$codigoperfil = $sesion->get("codigoperfil");
$fotoUsuario = $sesion->get("foto");
$correoUsuario = $sesion->get("correo");
$datos_preliminares = $sesion->get("datos_preliminares");
$idusuario_plataforma = $sesion->get("idusuario_plataforma");
$default_lang = $sesion->get("lang");
$multicentro = $sesion->get("multicentro");
$Nombreempresa = $sesion->get("nombreempresa");
$IdEmpresa = $sesion->get("idempresa");
$IdCentro = $sesion->get("idcentro");

$app_name = "AmaFit";

$nombre_centro = $sesion->get("nombre_centro");

$lang = (isset($_GET['lang'])) ? $_GET['lang'] : 'es';
$translate = new Translator($lang);

$mode = (isset($_GET['mode'])) ? $_GET['mode'] : '';
$screenmode = (isset($_GET['screenmode'])) ? $_GET['screenmode'] : '';
$pag = (isset($_GET['pag'])) ? $_GET['pag'] : 'inicio';
$subpag = (isset($_GET['subpag'])) ? $_GET['subpag'] : "";
$op = (isset($_GET['op'])) ? $_GET['op'] : "list";

if (!$login)
    header('location: login.php');
?>