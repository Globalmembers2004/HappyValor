<?php
if ($_POST){
    require '../../common/sesion.class.php';
    require '../../adata/Db.class.php';
    require '../../bussiness/usuarios.php';

    $rpta = 0;
    $titulomsje = '';
    $contenidomsje = '';

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

    $usuario->Registrar_Plataforma($username, $clave, $chkTipoPersona, $ddlRegion, $nrodocumento, $business_name, $firstname, $lastname, $email, $idusuario_registrador, $rpta, $titulomsje, $contenidomsje);
}
?>