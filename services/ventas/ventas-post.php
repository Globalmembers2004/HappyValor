<?php
include("../../common/sesion.class.php");
require('../../common/class.translation.php');
include('../../adata/Db.class.php');
include('../../common/functions.php');
include('../../bussiness/clientes.php');
include('../../bussiness/ventas.php');

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$rpta = '0';
$rptaDetails = 0;
$validSQL = false;


$rptaRegistroV = 0;
$titulomsjeV = '';
$contenidomsjeV = '';

$strItemsDetalle = '';
$strQueryDet = '';

if ($_POST){
    $IdEmpresa = 1;
    $IdCentro = 1;
    $IdPersonal = 3;
    $realIp = getRealIP();
    $objCliente = new clsCliente();
    $objData = new clsVenta();

    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'es';

    $translate = new Translator($lang);

    $hdIdPrimary = isset($_POST['hdIdPrimary']) ? $_POST['hdIdPrimary'] : '0';
    
    $ddlTipoComprobante = isset($_POST['ddlTipoComprobante']) ? $_POST['ddlTipoComprobante'] : '0';
    $txtSerieComprobante = isset($_POST['txtSerieComprobante']) ? $_POST['txtSerieComprobante'] : '001';
    $txtNroComprobante = isset($_POST['txtNroComprobante']) ? $_POST['txtNroComprobante'] : '00001';
    $ddlMoneda = isset($_POST['ddlMoneda']) ? $_POST['ddlMoneda'] : '0';
    $ddlFormaPago = isset($_POST['ddlFormaPago']) ? $_POST['ddlFormaPago'] : '0';
    $txtFecha = isset($_POST['txtFecha']) ? $_POST['txtFecha'] : date("Y-m-d h:i:s");
    /***DATOS DE CLIENTE***/
    $hdIdCliente = isset($_POST['hdIdCliente']) ? $_POST['hdIdCliente'] : '0';
    $txtNombres = isset($_POST['txtNombres']) ? $_POST['txtNombres'] : '';
    $txtApePaterno = isset($_POST['txtApePaterno']) ? $_POST['txtApePaterno'] : '';
    $txtApeMaterno = isset($_POST['txtApeMaterno']) ? $_POST['txtApeMaterno'] : '';
    $txtNroDocNatural = isset($_POST['txtNroDocNatural']) ? $_POST['txtNroDocNatural'] : '';
    $txtDireccionNat = isset($_POST['txtDireccionNat']) ? $_POST['txtDireccionNat'] : '';
    $txtRazonSocial = isset($_POST['txtRazonSocial']) ? $_POST['txtRazonSocial'] : '';
    $txtRucEmpresa = isset($_POST['txtRucEmpresa']) ? $_POST['txtRucEmpresa'] : '';
    $txtDireccionJur = isset($_POST['txtDireccionJur']) ? $_POST['txtDireccionJur'] : '';
    /***DATOS DE TOTALES****/
    $hdImpuesto = isset($_POST['hdImpuesto']) ? $_POST['hdImpuesto'] : '0';
    $hdTotalSinImpuesto = isset($_POST['hdTotalSinImpuesto']) ? $_POST['hdTotalSinImpuesto'] : '0';
    $hdTotalConImpuesto = isset($_POST['hdTotalConImpuesto']) ? $_POST['hdTotalConImpuesto'] : '0';
    /***DATOS DE LA TARJETA****/
    $ddlMonedaTarjeta = isset($_POST['ddlMonedaTarjeta']) ? $_POST['ddlMonedaTarjeta'] : '0';
    $txtTipoCambioEfectivo = isset($_POST['txtTipoCambioEfectivo']) ? $_POST['txtTipoCambioEfectivo'] : '0';
    $ddlNombreTarjeta = isset($_POST['ddlNombreTarjeta']) ? $_POST['ddlNombreTarjeta'] : '0';
    $txtComisionTarjeta = isset($_POST['txtComisionTarjeta']) ? $_POST['txtComisionTarjeta'] : '0';
    $txtCodigoRecibo = isset($_POST['txtCodigoRecibo']) ? $_POST['txtCodigoRecibo'] : '0';
    $txtImporteTarjeta = isset($_POST['txtImporteTarjeta']) ? $_POST['txtImporteTarjeta'] : '0';
    $detalle = json_decode(stripslashes($_POST['detalle']));
    $tipocliente = 'NA';
    $idimpuesto = '1';
    if ($hdIdCliente == '0'){
        $objCliente->Registrar($tipocliente, $hdIdCliente, $IdEmpresa, $IdCentro, 1,  1, $txtNroDocNatural, $txtRazonSocial, '', $txtNombres, $txtApePaterno, $txtApeMaterno, $txtDireccionNat, '', '', '', 'no-set', '', '', $idusuario, $rptaC, $titulomsjeC, $contenidomsjeC);
        $IdCliente = $rptaC;
    }else{
        $IdCliente = $hdIdCliente;
    }

    $objData->Registrar($hdIdPrimary, $IdEmpresa, $IdCentro, $ddlTipoComprobante, $txtSerieComprobante, $txtNroComprobante, $ddlMoneda, $hdIdCliente, $ddlFormaPago, fecha_mysql($txtFecha), fecha_mysql($txtFecha), $hdTotalSinImpuesto, $hdImpuesto, $hdTotalConImpuesto, $IdPersonal, '00', $idusuario, $rptaRegistroV, $titulomsjeV, $contenidomsjeV);

    if ($rptaRegistroV > 0){
        foreach($detalle as $item){
            $rptaDetVenta = $objData->RegistrarDetalle($rptaRegistroV, $item->idproducto, $item->cantidad, $item->precio, $item->idunidadmedida , $item->subtotal, '0', $idusuario); 
        }
        $rptaFP = $objData->RegistrarVentaFormaPago($IdEmpresa, $IdCentro, $rptaRegistroV, $ddlFormaPago, $ddlMonedaTarjeta, $ddlNombreTarjeta, $txtImporteTarjeta, $txtComisionTarjeta, $txtCodigoRecibo, $idusuario); 
        $rptaVI = $objData->RegistrarVentaImpuesto($IdEmpresa, $IdCentro, $rptaRegistroV, $idimpuesto, $hdImpuesto, $idusuario);
    }

    $jsondata = array('rpta' => $rptaRegistroV, 'titulomsje' => $translate->__s($titulomsjeV), 'contenidomsje' => $translate->__s($contenidomsjeV));
    echo json_encode($jsondata);
}
?>