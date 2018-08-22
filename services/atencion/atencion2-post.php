<?php
include("../../common/sesion.class.php");
require('../../common/class.translation.php');
include('../../adata/Db.class.php');
include('../../common/functions.php');
include('../../bussiness/tabla.php');
include('../../bussiness/clientes.php');
include('../../bussiness/ventas.php');
include('../../bussiness/atencion.php');
include('../../bussiness/almacen.php');
include('../../bussiness/numeracionventa.php');

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$rpta = '0';
$titulomsje = '';
$contenidomensaje = '';

$rptaVenta = 0;
$titulomsjeVenta = '';
$contenidomensajeVenta = '';

$rptaRegistro = 0;
$rptaDetails = 0;
$rptaDetailsMov = 0;
$validSQL = false;
$countExistDetailsVent = 0;

$strItemsDetalleVenta = '';
$strQueryDetVenta = '';
$strQueryUpdateDetalleVenta = '';
$strListMesas = '';

if ($_POST){
    $IdEmpresa = 1;
    $IdCentro = 1;
    $IdPais = 1;
    $IdAmbiente = 1;
    $IdAlmacen = 1;
    $IdTerminal = 1;
    $IdCliente = 0;
    $IdVendedor = 1;
    $IdPersonal = 1;
    $IdUnidadMedida = 6;
    $flagComplete = false;

    $realIp = getRealIP();    

    $objTabla = new clsTabla();
    $objAtencion = new clsAtencion();
    $objVenta = new clsVenta();
    $objCliente = new clsCliente();
    $objAlmacen = new clsAlmacen();
    $objNumVenta = new clsNumeracionVenta();

    $hdTipoSave = isset($_POST['hdTipoSave']) ? $_POST['hdTipoSave'] : '00';
    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'lang';
    $hdTipoSeleccion = isset($_POST['hdTipoSeleccion']) ? $_POST['hdTipoSeleccion'] : '00';
    $hdEstadoAtencion = isset($_POST['hdEstadoAtencion']) ? $_POST['hdEstadoAtencion'] : '01';
    $hdTipoUbicacion = isset($_POST['hdTipoUbicacion']) ? $_POST['hdTipoUbicacion'] : '00';
    $hdIdMesa = isset($_POST['hdIdMesa']) ? $_POST['hdIdMesa'] : '0';
    $strListMesas = isset($_POST['strListMesas']) ? $_POST['strListMesas'] : '0';
    $Id = isset($_POST['hdIdPrimary']) ? $_POST['hdIdPrimary'] : '0';
    $IdAmbiente = isset($_POST['hdIdAmbiente']) ? $_POST['hdIdAmbiente'] : '0';
    $IdVenta = isset($_POST['hdIdVenta']) ? $_POST['hdIdVenta'] : '0';
    
    $translate = new Translator($lang);

    if ($hdTipoSave == '00'){
        $rptaRegistro = $objAtencion->Registrar($Id, $IdEmpresa, $IdCentro, $IdAmbiente, date('Y-m-d'), $hdTipoUbicacion, $strListMesas, $idusuario);

        if ($rptaRegistro > 0){
            if ($hdTipoSeleccion == '00'){
                $objAtencion->RegistrarAtencionMesa('UNION', $IdEmpresa, $IdCentro, $rptaRegistro, $strListMesas, $idusuario);

                $flagComplete = true;
            }
            elseif ($hdTipoSeleccion == '01'){
                $detallePedido = json_decode(stripslashes($_POST['detallePedido']));
                
                $objAtencion->EliminarDetalle($rptaRegistro, $idusuario);
                
                foreach($detallePedido as $item){
                    $objAtencion->RegistrarDetalle(0, $IdEmpresa, $IdCentro, $rptaRegistro, $item->idProducto, $item->idMoneda, $item->precio, $item->cantidad, $item->subTotal, $item->nombreProducto, $item->codTipoMenuDia, $idusuario, $item->itemsProducto);
                }

                $flagComplete = true;
            }
            elseif ($hdTipoSeleccion == '04') {
                $ddlTipoComprobante = isset($_POST['ddlTipoComprobante']) ? $_POST['ddlTipoComprobante'] : '0';
                $ddlTipoCobro = isset($_POST['ddlTipoCobro']) ? $_POST['ddlTipoCobro'] : '0';
                $ddlMoneda = isset($_POST['ddlMoneda']) ? $_POST['ddlMoneda'] : '0';
                $hdIdCliente = isset($_POST['hdIdCliente']) ? $_POST['hdIdCliente'] : '1';
                $hdIdPersonal = isset($_POST['hdIdPersonal']) ? $_POST['hdIdPersonal'] : '1';
                $txtSerieComprobante = isset($_POST['txtSerieComprobante']) ? $_POST['txtSerieComprobante'] : '001';
                $txtNroComprobante = isset($_POST['txtNroComprobante']) ? $_POST['txtNroComprobante'] : '00001';
                $txtFechaVenta = isset($_POST['txtFechaVenta']) ? $_POST['txtFechaVenta'] : date("Y-m-d h:i:s");
                $hdTotalPedido = isset($_POST['hdTotalPedido']) ? $_POST['hdTotalPedido'] : '0';

                $txtImporteRecibido = isset($_POST['txtImporteRecibido']) ? $_POST['txtImporteRecibido'] : '0';
                $ddlNombreTarjeta = isset($_POST['ddlNombreTarjeta']) ? $_POST['ddlNombreTarjeta'] : '0';
                $ddlMonedaTarjeta = isset($_POST['ddlMonedaTarjeta']) ? $_POST['ddlMonedaTarjeta'] : '0';
                $txtCodigoRecibo = isset($_POST['txtCodigoRecibo']) ? $_POST['txtCodigoRecibo'] : '0';
                $txtComisionTarjeta = isset($_POST['txtComisionTarjeta']) ? $_POST['txtComisionTarjeta'] : '0';
                $txtImporteTarjeta = isset($_POST['txtImporteTarjeta']) ? $_POST['txtImporteTarjeta'] : '0';

                $hdIdCliente = isset($_POST['hdIdCliente']) ? $_POST['hdIdCliente'] : '';
                $hdCodigoCliente = isset($_POST['hdCodigoCliente']) ? $_POST['hdCodigoCliente'] : '';
                $hdTipoCliente = isset($_POST['hdTipoCliente']) ? $_POST['hdTipoCliente'] : '';
                $hdIdDocIdent = isset($_POST['hdIdDocIdent']) ? $_POST['hdIdDocIdent'] : '';
                $txtApePaterno = isset($_POST['txtApePaterno']) ? $_POST['txtApePaterno'] : '';
                $txtApeMaterno = isset($_POST['txtApeMaterno']) ? $_POST['txtApeMaterno'] : '';
                $txtNombres = isset($_POST['txtNombres']) ? $_POST['txtNombres'] : '';
                $txtRazonSocial = isset($_POST['txtRazonSocial']) ? $_POST['txtRazonSocial'] : '';
                $txtNroDocNatural = isset($_POST['txtNroDocNatural']) ? $_POST['txtNroDocNatural'] : '';
                $txtRucEmpresa = isset($_POST['txtRucEmpresa']) ? $_POST['txtRucEmpresa'] : '';
                $txtDireccionNat = isset($_POST['txtDireccionNat']) ? $_POST['txtDireccionNat'] : '';
                $txtDireccionJur = isset($_POST['txtDireccionJur']) ? $_POST['txtDireccionJur'] : '';

                $NroDocIdent = ($hdTipoCliente == 'JU') ? $txtRucEmpresa : $txtNroDocNatural;
                $Direccion = ($hdTipoCliente == 'JU') ? $txtDireccionJur : $txtDireccionNat;

                $hdImpuesto = isset($_POST['hdImpuesto']) ? $_POST['hdImpuesto'] : '0';
                $hdTotalSinImpuesto = isset($_POST['hdTotalSinImpuesto']) ? $_POST['hdTotalSinImpuesto'] : '0';
                $hdTotalConImpuesto = isset($_POST['hdTotalConImpuesto']) ? $_POST['hdTotalConImpuesto'] : '0';

                $detalleVenta = json_decode(stripslashes($_POST['detalleVenta']));

                if ($hdCodigoCliente == '000')
                    $IdCliente = $objCliente->Registrar($hdTipoCliente, $hdIdCliente, $IdEmpresa, $IdCentro, 1, $hdIdDocIdent, $NroDocIdent, $txtRazonSocial, '', $txtNombres, $txtApePaterno, $txtApeMaterno, $Direccion, '', '', '', 'no-set', '', $IdPais, $idusuario);
                else
                    $IdCliente = $hdIdCliente;
                
                $objVenta->Registrar($IdVenta, $IdEmpresa, $IdCentro, $ddlTipoComprobante, $txtSerieComprobante, $txtNroComprobante, $ddlMoneda, $IdCliente, $ddlTipoCobro, fecha_mysql($txtFechaVenta), fecha_mysql($txtFechaVenta), $hdTotalSinImpuesto, $hdImpuesto, $hdTotalConImpuesto, $hdIdPersonal, '00', $idusuario, $rptaVenta, $titulomsjeVenta, $contenidomensajeVenta);

                if ($rptaVenta > 0){
                    $objVenta->EliminarDetalle($rptaVenta, $idusuario);

                    foreach($detalleVenta as $item){
                        $objVenta->RegistrarDetalle($rptaVenta, $item->idProducto, $item->cantidad, $item->precio, $IdUnidadMedida, $item->subTotal, 0, $idusuario);
                    }

                    if ($txtImporteRecibido != '0')
                        $rptaEfectivo = $objVenta->RegistrarVentaFormaPago($IdEmpresa, $IdCentro, $rptaVenta, 9, $ddlMoneda, 0, $txtImporteRecibido, 0, '', $idusuario);

                    if ($txtImporteTarjeta != '0')
                        $rptaTarjeta = $objVenta->RegistrarVentaFormaPago($IdEmpresa, $IdCentro, $rptaVenta, 22, $ddlMonedaTarjeta, $ddlNombreTarjeta, $txtImporteTarjeta, $txtComisionTarjeta, $txtCodigoRecibo, $idusuario);

                    if ($hdImpuesto > 0)
                        $rptaImpuesto = $objVenta->RegistrarVentaImpuesto($IdEmpresa, $IdCentro, $rptaVenta, 1, $importe, $idusuario);

                    $rptaNumVenta = $objNumVenta->ActualizarNumeracion($IdTerminal, $ddlTipoComprobante, $txtSerieComprobante, $txtNroComprobante + 1, $idusuario);

                    $flagComplete = true;
                }
            }
        }

        if ($flagComplete){
            $objAtencion->ActualizarEstado($rptaRegistro, $hdEstadoAtencion, $idusuario);
            $objAtencion->RegisrarMovimiento($rptaRegistro, $hdEstadoAtencion, date('Y-m-d'), $realIp, $idusuario);
        }
    }
    elseif ($hdTipoSave == '01'){
        if ($hdTipoSeleccion == '03')
            $rptaRegistro = $objAtencion->SepararMesa($Id, $IdEmpresa, $IdCentro, $idusuario);
    }
    
    $stateColor = $objTabla->GetSpecificValue('ta_colorleyenda', 'ta_estadoatencion', $hdEstadoAtencion);
    $jsondata = array("rpta" => $rptaRegistro, "stateColor" => $stateColor, 'estadoAtencion' => $hdEstadoAtencion, 'rptaVenta' => $rptaVenta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomensaje' => $translate->__s($contenidomensaje), 'titulomsjeVenta' => $translate->__s($titulomsjeVenta), 'contenidomensajeVenta' => $contenidomensajeVenta);
    echo json_encode($jsondata);
}
?>