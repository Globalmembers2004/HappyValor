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
    require '../../common/functions.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    // $idperfil = $sesion->get("idperfil");

    $rpta = '0';
    $titulomsje = '';
    $contenidomsje = '';

    
    if (isset($_POST['btnGuardar'])){

        $IdEmpresa = isset($_POST['hdIdEmpresa']) ? $_POST['hdIdEmpresa'] : '1';
        $IdCentro = isset($_POST['hdIdCentro']) ? $_POST['hdIdCentro'] : '1';
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
        $ddlmes = (isset($_POST['ddlmes'])) ? $_POST['ddlmes'] : date('m');
        $ddlanno = (isset($_POST['ddlanno'])) ? $_POST['ddlanno'] : date('yyyy');
        $txtServicios = (isset($_POST['txtServicios'])) ? $_POST['txtServicios'] : '';
        $txtSueldos = (isset($_POST['txtSueldos'])) ? $_POST['txtSueldos'] : '';
        $txtotros = (isset($_POST['txtotros'])) ? $_POST['txtotros'] : '';
        $txttotal = $txtServicios + $txtSueldos + $txtotros;
        $txtutilidad = (isset($_POST['txtutilidad'])) ? $_POST['txtutilidad'] : '';
        $txtmeta = $txttotal * (1 + $txtutilidad/100);

        $ddlmes = zerofill($ddlmes);

        require '../../adata/Db-OneConnect.class.php';
        require '../../bussiness/equilibrio_oneconnect.php';

        $objData = new clsEquilibrio_oneconnect();

        $conexion = $objData->_conectar();

        $rpta = $objData->RegistrarMaestro($conexion, $hdIdPrimary, $IdEmpresa, $IdCentro, $ddlmes, $ddlanno, $txtServicios, $txtSueldos, $txtotros, $txttotal, $txtutilidad, $txtmeta, $idusuario, $rpta, $titulomsje, $contenidomsje);

        $objData->EliminarDetalle($conexion, $rpta, $idusuario, $rptaDetalle, $Auxtitulomsje, $Auxcontenidomsje);

        if ($rpta > 0){
            foreach ($_POST['itemdetalle'] as $itemdetalle) {
                $objData->RegistrarDetalle($conexion, 0, $IdEmpresa, $IdCentro, $rpta, $itemdetalle['idcliente'], $itemdetalle['codtiposervicio'], $itemdetalle['nombre'], $itemdetalle['total'], $idusuario, $rptaDetalle, $Auxtitulomsje, $Auxcontenidomsje);
            }
        }

        $objData->_desconectar($conexion);
    }
    elseif (isset($_POST['btnEliminar'])) {
        require '../../bussiness/equilibrio.php';
        $objData = new clsEquilibrio();
        
        $hdIdequilibrio = $_POST['hdIdequilibrio'];

        $rpta = $objData->EliminarStepByStep($hdIdequilibrio, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    
    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>