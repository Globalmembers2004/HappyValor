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
        	$hdIdInstructor = isset($_POST['hdIdInstructor']) ? $_POST['hdIdInstructor'] : '0';

        	$objetivo = "";

        	$txtFechaInicio = isset($_POST['txtFechaInicio']) ? fecha_mysql($_POST['txtFechaInicio']) : date('Y-m-d');
			$txtFechaFinal = isset($_POST['txtFechaFinal']) ? fecha_mysql($_POST['txtFechaFinal']) : date('Y-m-d');
			$txtImcActual = isset($_POST['txtImcActual']) ? $_POST['txtImcActual'] : '0';
			$txtImcMeta = isset($_POST['txtImcMeta']) ? $_POST['txtImcMeta'] : '0';

			$calorias_meta = 0;

            require '../../adata/Db-OneConnect.class.php';
            require '../../bussiness/rutinacliente_oneconnect.php';

            $Auxrpta = '0';
            $rptaDetalle = 0;
            $Auxtitulomsje = '';
            $Auxcontenidomsje = '';

            $objData = new clsRutinaCliente_oneconnect();

            $conexion = $objData->_conectar();


            $objData->RegistrarMaestro($conexion, $hdIdPrimary, $IdEmpresa, $IdCentro, $hdIdCliente, $objetivo, $hdIdInstructor, $txtFechaInicio, $txtFechaFinal, $txtImcActual, $txtImcMeta, $calorias_meta, $idusuario, $rpta, $titulomsje, $contenidomsje);

            $objData->EliminarDetalle($conexion, $rpta, $idusuario, $rptaDetalle, $Auxtitulomsje, $Auxcontenidomsje);

            if ($rpta > 0){
                foreach ($_POST['itemdetalle'] as $itemdetalle) {
                    $objData->RegistrarDetalle($conexion, 0, $IdEmpresa, $IdCentro, $rpta, $itemdetalle['idzonacorporal'], $itemdetalle['idequipo'], $itemdetalle['serie'], $itemdetalle['repeticion'], $itemdetalle['peso'], $itemdetalle['observaciones'], $idusuario, $rptaDetalle, $Auxtitulomsje, $Auxcontenidomsje);
                }
            }

            $objData->_desconectar($conexion);
       
       	}
	}

	$jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>