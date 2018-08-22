<?php
require_once("common/sesion.class.php");
$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$login = $sesion->get("login");
$login = $sesion->get("login");
$sesion->termina_sesion();
$login = false;
header("location: login.php");
?>