<?php
include("../../common/sesion.class.php");
require('../../common/class.translation.php');
include('../../adata/Db.class.php');
include('../../common/functions.php');
include('../../bussiness/compras.php');
include('../../bussiness/almacen.php');
include('../../bussiness/proveedores.php');

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");

$rpta = '0';
$rptaDetails = 0;
$rptaDetailsMov = 0;
$rptaMov = 0;
$validSQL = false;

$strItemsDetalle = '';
$strQueryDet = '';


if ($_POST) {
	$IdEmpresa = 1;
	$IdCentro = 1;
	$IdProveedor = 0;
	$IdPersonal = 3;
	$IdMotivo = 1;

	$realIp = getRealIP();

	$objAlmacen = new clsAlmacen();
	$objProveedor = new clsProveedor();
	$objData = new clsCompra();

	$lang = isset($_POST['lang']) ? $_POST['lang'] : 'lang';

    $translate = new Translator($lang);
    
    $Id = isset($_POST['hdIdPrimary']) ? $_POST['hdIdPrimary'] : '0';

    $ddlTipoComprobante = isset($_POST['ddlTipoComprobante']) ? $_POST['ddlTipoComprobante'] : '0';
    $ddlMoneda = isset($_POST['ddlMoneda']) ? $_POST['ddlMoneda'] : '0';
    $ddlAlmacen = isset($_POST['ddlAlmacen']) ? $_POST['ddlAlmacen'] : '0';
    $ddlFormaPago = isset($_POST['ddlFormaPago']) ? $_POST['ddlFormaPago'] : '0';
    $txtSerieComprobante = isset($_POST['txtSerieComprobante']) ? $_POST['txtSerieComprobante'] : '001';
    $txtNroComprobante = isset($_POST['txtNroComprobante']) ? $_POST['txtNroComprobante'] : '00001';
    $txtFecha = isset($_POST['txtFecha']) ? $_POST['txtFecha'] : date("Y-m-d h:i:s");
    $txtFechaRecepcion = isset($_POST['txtFechaRecepcion']) ? $_POST['txtFechaRecepcion'] : date("Y-m-d h:i:s");
    $txtDescripcionIngreso = isset($_POST['txtDescripcionIngreso']) ? $_POST['txtDescripcionIngreso'] : '';
    $hdTotalPedido = isset($_POST['hdTotalPedido']) ? $_POST['hdTotalPedido'] : '0';

    /***DATOS DE PROVEEDOR***/
    $hdIdProveedor = isset($_POST['hdIdProveedor']) ? $_POST['hdIdProveedor'] : '0';
    $hdCodigoProveedor = isset($_POST['hdCodigoProveedor']) ? $_POST['hdCodigoProveedor'] : '';
    $txtRazonSocial = isset($_POST['txtRazonSocial']) ? $_POST['txtRazonSocial'] : '';
    $txtRucEmpresa = isset($_POST['txtRucEmpresa']) ? $_POST['txtRucEmpresa'] : '';
    $txtDireccionJur = isset($_POST['txtDireccionJur']) ? $_POST['txtDireccionJur'] : '';

    $detalle = json_decode(stripslashes($_POST['detalle']));

    if ($hdCodigoProveedor != '000')
        $IdProveedor = $objProveedor->Registrar($hdIdProveedor, $IdEmpresa, $txtRazonSocial, '', '', $txtRucEmpresa, $txtDireccionJur, '', '', '', '', 'no-set', $idusuario);
    else
        $IdProveedor = $hdIdProveedor;

    $rptaKIngRCompra = 0;
    $rptaKardexIngreso = $objAlmacen->RegistrarIngresoKardex($rptaKIngRCompra, $IdEmpresa, $IdCentro, $ddlTipoComprobante, $hdIdProveedor, $ddlAlmacen, $IdMotivo, $txtSerieComprobante, fecha_mysql($txtFecha), fecha_mysql($txtFechaRecepcion), '', 'R', '', '', '', '', '', '', $idusuario);

    if ($rptaKardexIngreso > 0) {
        $rptaDetCompra = 100;
        foreach($detalle as $item){
            $rptaDetIngKardex=0; $msjeDetIngKardex='';
            $objAlmacen->RegistrarDetalleIngresoKardex($rptaKardexIngreso, $IdEmpresa, $IdCentro, $rptaDetCompra, $item->idproducto, $item->idunidadmedida, $item->codtipoproducto, $item->cantidad, '', 0, $idusuario, $rptaDetIngKardex, $msjeDetIngKardex);
        }
    }

    $jsondata = array('rpta' => $rptaKardexIngreso);
    echo json_encode($jsondata);
}
?>