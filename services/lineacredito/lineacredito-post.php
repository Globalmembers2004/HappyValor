<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
    $user_error = 'Access denied - direct call is not allowed...';
    trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

if ($_POST){
    require "../../common/sesion.class.php";
    require '../../adata/Db.class.php';
    require '../../bussiness/lineacredito.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $idperfil = $sesion->get("idperfil");

    $rpta = 0;
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clsLineaCredito();

    $IdEmpresa = isset($_POST['hdIdEmpresa']) ? $_POST['hdIdEmpresa'] : '1';
    $IdCentro = isset($_POST['hdIdCentro']) ? $_POST['hdIdCentro'] : '1';

    if (isset($_POST['btnAplicarLineaCredito'])){
        $IdMoneda = 0;

        $hdIdLineaCredito = isset($_POST['hdIdLineaCredito']) ? $_POST['hdIdLineaCredito'] : '0';
        $hdIdCliente = isset($_POST['hdIdCliente']) ? $_POST['hdIdCliente'] : '0';
        $txtImporteLinea = isset($_POST['txtImporteLinea']) ? $_POST['txtImporteLinea'] : '';
        
        $objData->Registrar($hdIdLineaCredito, $IdEmpresa, $IdCentro, $hdIdCliente, $IdMoneda, $txtImporteLinea, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnCobrarDeuda'])){
        $hdIdDeudaCobrar = isset($_POST['hdIdDeudaCobrar']) ? $_POST['hdIdDeudaCobrar'] : '0';
        $txtFechaPago = isset($_POST['txtFechaPago']) ? $_POST['txtFechaPago'] : date('d/m/Y');
        $ddlTipoOperacion = isset($_POST['ddlTipoOperacion']) ? $_POST['ddlTipoOperacion'] : '0';
        $ddlBanco = isset($_POST['ddlBanco']) ? $_POST['ddlBanco'] : '0';
        $txtNroCuentaBancaria = isset($_POST['txtNroCuentaBancaria']) ? $_POST['txtNroCuentaBancaria'] : '';
        $txtNroOperacion = isset($_POST['txtNroOperacion']) ? $_POST['txtNroOperacion'] : '';
        $hdImagenVoucher = isset($_POST['hdImagenVoucher']) ? $_POST['hdImagenVoucher'] : 'no-set';
        $txtImportePago = isset($_POST['txtImportePago']) ? $_POST['txtImportePago'] : '0';
        $txtImporteMora = isset($_POST['txtImporteMora']) ? $_POST['txtImporteMora'] : '0';
        
        if (empty($_FILES['archivo']['name'])) {
            $urlImagenVoucher = $hdImagenVoucher;
        }
        else {
            $upload_folder  = '../../media/images/';
            $url_folder  = 'media/images/';

            $nombre_archivo = $_FILES['archivo']['name'];
            $tipo_archivo = $_FILES['archivo']['type'];
            $tamano_archivo = $_FILES['archivo']['size'];
            $tmp_archivo = $_FILES['archivo']['tmp_name'];

            $nombre_archivo = trim($nombre_archivo);
            $nombre_archivo = str_replace(' ', '', $nombre_archivo);
            $nombre_archivo = preg_replace("/[^a-zA-Z0-9.]/", "", $nombre_archivo);

            $archivador = $upload_folder.$nombre_archivo;

            if (move_uploaded_file($tmp_archivo, $archivador))
                $urlImagenVoucher = $url_folder.$nombre_archivo;
            else
                $urlImagenVoucher = $hdImagenVoucher;
        }

        $fechaPago = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $txtFechaPago)));

        if ($ddlTipoOperacion == '02') {
            $ddlBanco = '0';
            $txtNroCuentaBancaria = 0;
            $txtNroOperacion = 0;
        }

        $objData->DeudaCobrar_Amortizar($hdIdDeudaCobrar, $IdEmpresa, $IdCentro, $fechaPago, $ddlTipoOperacion, $ddlBanco, $txtNroCuentaBancaria, $txtNroOperacion, $urlImagenVoucher, $txtImporteMora, $txtImportePago, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnEliminar'])) {
        $hdIdLineaCredito = $_POST['hdIdLineaCredito'];
        $objData->EliminarStepByStep($hdIdLineaCredito, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>