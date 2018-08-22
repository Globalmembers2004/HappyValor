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
    require '../../adata/Db.class.php';
    require '../../common/functions.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $idperfil = $sesion->get("idperfil");
    $IdEmpresa = $sesion->get("idempresa");
    $IdCentro = $sesion->get("idcentro");

    $rpta = 0;
    $titulomsje = '';
    $contenidomsje = '';

    $realIp = getRealIP();

    if (isset($_POST['btnGuardar'])) {
        if (isset($_POST['itemdetalle'])) {

        	$hdIdPrimary = isset($_POST['hdIdPrimary']) ? $_POST['hdIdPrimary'] : '0';
        	$hdIdCliente = isset($_POST['hdIdCliente']) ? $_POST['hdIdCliente'] : '0';
        	
            $txtAltura = isset($_POST['txtAltura']) ? $_POST['txtAltura'] : '0';
            $txtPeso = isset($_POST['txtPeso']) ? $_POST['txtPeso'] : '0';
            $txtIMC = isset($_POST['txtIMC']) ? $_POST['txtIMC'] : '0';
            $txtPorcentajeGrasa = isset($_POST['txtPorcentajeGrasa']) ? $_POST['txtPorcentajeGrasa'] : '0';
            $txtObservacion_Cabecera = isset($_POST['txtObservacion_Cabecera']) ? $_POST['txtObservacion_Cabecera'] : '0';

            require '../../adata/Db-OneConnect.class.php';
            require '../../bussiness/evaluacioncliente_oneconnect.php';

            $Auxrpta = '0';
            $rptaDetalle = 0;
            $Auxtitulomsje = '';
            $Auxcontenidomsje = '';

            $objData = new clsEvaluacionCliente_oneconnect();

            $conexion = $objData->_conectar();

            $objData->RegistrarMaestro($conexion, $hdIdPrimary, $IdEmpresa, $IdCentro, date('Y-m-d'), $hdIdCliente, $txtAltura, $txtPeso, $txtIMC, $txtPorcentajeGrasa, $txtObservacion_Cabecera, $idusuario, $rpta, $titulomsje, $contenidomsje);

            $objData->EliminarDetalle($conexion, $rpta, $idusuario, $rptaDetalle, $Auxtitulomsje, $Auxcontenidomsje);

            if ($rpta > 0){
                foreach ($_POST['itemdetalle'] as $itemdetalle) {
                    $objData->RegistrarDetalle($conexion, 0, $IdEmpresa, $IdCentro, $rpta, $hdIdCliente, $itemdetalle['idzonacorporal'], $itemdetalle['medida'], $itemdetalle['observaciones'], $idusuario, $rptaDetalle, $Auxtitulomsje, $Auxcontenidomsje);
                }
            }

            $objData->_desconectar($conexion);
       
       	}
	}
    elseif (isset($_POST['btnEliminar'])) {
        $hdIdCliente = $_POST['hdIdCliente'];
        $rpta = $objCliente->EliminarStepByStep($hdIdCliente, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }

	$jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>