<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
    $user_error = 'Access denied - direct call is not allowed...';
    trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

if ($_POST){
    require '../../common/sesion.class.php';
    require '../../common/class.translation.php';
    require '../../adata/Db.class.php';
    require '../../bussiness/perfil.php';
    
    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $idperfil = $sesion->get("idperfil");
    $IdEmpresa = $sesion->get("idempresa");
    $IdCentro = $sesion->get("idcentro");
    
    $objPerfil = new clsPerfil();

    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'es';

    $translate = new Translator($lang);

    $rpta = '0';
    $titulomsje = '';
    $contenidomensaje = '';

    $Auxrpta = '0';
    $Auxtitulomsje = '';
    $Auxcontenidomensaje = '';

    $hdIdPrimary = isset($_POST['hdIdPrimary']) ? $_POST['hdIdPrimary'] : '0';
    
    if (isset($_POST['btnGuardar'])) {
        $txtNombre = isset($_POST['txtNombre']) ? $_POST['txtNombre'] : '';
        $txtDescripcion = isset($_POST['txtDescripcion']) ? $_POST['txtDescripcion'] : '';
        $txtAbreviatura = isset($_POST['txtAbreviatura']) ? $_POST['txtAbreviatura'] : '';

        $rpta = $objPerfil->Guardar($hdIdPrimary, $IdEmpresa, $IdCentro, $txtNombre, $txtDescripcion, $txtAbreviatura, $idusuario, $rpta, $titulomsje, $contenidomensaje);

        if ($rpta > 0) {
            $listIdMenu = '';
            
            if (isset($_POST['chkMenu'])) {
                if (is_array($_POST['chkMenu'])) {
                    $listIdMenu = implode(',', $_POST['chkMenu']);
                }
            }
            
            $objPerfil->RegistrarPerfilMenu($rpta, $IdEmpresa, $IdCentro, $listIdMenu, $idusuario, $Auxrpta, $Auxtitulomsje, $Auxcontenidomensaje);
        }
    }
    elseif (isset($_POST['btnEliminar']))
        $objPerfil->Eliminar($hdIdPrimary, $rpta, $titulomsje, $contenidomensaje);

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomensaje' => $translate->__s($contenidomensaje));
    echo json_encode($jsondata);
}
?>