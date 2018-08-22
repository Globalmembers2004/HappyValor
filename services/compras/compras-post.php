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
    // require '../../bussiness/compras.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $idperfil = $sesion->get("idperfil");
    $IdEmpresa = $sesion->get("idempresa");
    $IdCentro = $sesion->get("idcentro");

    $rpta = 0;
    $titulomsje = '';
    $contenidomsje = '';

    
    $realIp = getRealIP();
    
    // $objCompra = new clsCompra();

    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'es';

    $translate = new Translator($lang);

    if (isset($_POST['btnGuardar'])) {
        if (isset($_POST['mc_itemcompra'])) {
            require '../../adata/Db-OneConnect.class.php';
            require '../../bussiness/compra_oneconnect.php';

            $Auxrpta = '0';
            $rptaDetCompra = 0;
            $Auxtitulomsje = '';
            $Auxcontenidomsje = '';

            $objCompra = new clsCompra_oneconnect();

            $conexion_compra = $objCompra->_conectar();

            $chkIngresoPrevio = false;
            $hdIdRefCodigo = 0;
            
            $IdProveedor = 0;
            $IdPersonal = 3;

            $hdIdPrimary = isset($_POST['hdIdPrimary']) ? $_POST['hdIdPrimary'] : '0';

            $chkIngresoAutomatico = isset($_POST['chkIngresoAutomatico']) ? 1 : 0;
            // $IdAlmacen = ($chkIngresoAutomatico == 1 ? (isset($_POST['ddlAlmacen']) ? $_POST['ddlAlmacen'] : '0') : 0);

            $IdAlmacen = 0;
            
            $ddlTipoComprobante = isset($_POST['ddlTipoComprobante']) ? $_POST['ddlTipoComprobante'] : '0';
            $ddlMoneda = isset($_POST['ddlMoneda']) ? $_POST['ddlMoneda'] : '0';
            $ddlFormaPago = isset($_POST['ddlFormaPago']) ? $_POST['ddlFormaPago'] : '0';
            $txtSerieComprobante = isset($_POST['txtSerieComprobante']) ? $_POST['txtSerieComprobante'] : '001';
            $txtNroComprobante = isset($_POST['txtNroComprobante']) ? $_POST['txtNroComprobante'] : '00001';
            $txtFecha = isset($_POST['txtFecha']) ? $_POST['txtFecha'] : date("Y-m-d h:i:s");
            $hdTotalPedido = isset($_POST['hdTotalPedido']) ? $_POST['hdTotalPedido'] : '0';

            /***DATOS DE PROVEEDOR***/
            $rbRegProveedor = $_POST['rbRegProveedor'];

            $hdIdProveedor = isset($_POST['hdIdProveedor']) ? $_POST['hdIdProveedor'] : '0';
            $txtRazonSocialProveedor = isset($_POST['txtRazonSocialProveedor']) ? $_POST['txtRazonSocialProveedor'] : '';
            $txtNroDocProveedor = isset($_POST['txtNroDocProveedor']) ? $_POST['txtNroDocProveedor'] : '';
            $txtDireccionJurProveedor = isset($_POST['txtDireccionJurProveedor']) ? $_POST['txtDireccionJurProveedor'] : '';
            $txtTelefonoProveedor = isset($_POST['txtTelefonoProveedor']) ? $_POST['txtTelefonoProveedor'] : '';
            $txtEmailProveedor = isset($_POST['txtEmailProveedor']) ? $_POST['txtEmailProveedor'] : '';

            /***DATOS DE TOTALES****/
            $hdImpuesto = isset($_POST['hdImpuesto']) ? $_POST['hdImpuesto'] : '0';
            $hdTotalSinImpuesto = isset($_POST['hdTotalSinImpuesto']) ? $_POST['hdTotalSinImpuesto'] : '0';
            $hdTotalConImpuesto = isset($_POST['hdTotalConImpuesto']) ? $_POST['hdTotalConImpuesto'] : '0';

            $hdIdAperturaCaja = isset($_POST['hdIdAperturaCaja']) ? $_POST['hdIdAperturaCaja'] : '0';

            if ($rbRegProveedor == 'NEW')
                $objCompra->RegistrarProveedor($conexion_compra, '0', $IdEmpresa, $txtRazonSocialProveedor, '', '', $txtNroDocProveedor, $txtDireccionJurProveedor, '', $txtTelefonoProveedor, $txtEmailProveedor, '', 'no-set', $idusuario, $IdProveedor, $Auxtitulomsje, $Auxcontenidomsje);
            else
                $IdProveedor = $hdIdProveedor;

            $objCompra->RegistrarMaestro($conexion_compra, $hdIdPrimary, $IdEmpresa, $IdCentro, $ddlTipoComprobante, $IdProveedor, $ddlFormaPago, $ddlMoneda, $IdPersonal, $txtSerieComprobante, $txtNroComprobante, fecha_mysql($txtFecha), '00', '', $hdTotalSinImpuesto, $hdImpuesto, $hdTotalConImpuesto, $hdIdAperturaCaja, $idusuario, $rpta, $titulomsje, $contenidomsje);

            if ($rpta > 0){
                // if ($chkIngresoPrevio)
                //     $objCompra->AgregarKardexIngresoRegistroCompra($rpta, $hdIdRefCodigo, fecha_mysql($txtFecha), $idusuario, $rptaKIngRCompra, $msjeKIngRCompra);

                if ($chkIngresoAutomatico == 1){
                    // if ($ddlTipoComprobante == 11)
                    $rptaKardexIngreso = $objCompra->RegistrarIngresoKardex($conexion_compra, 0, $IdEmpresa, $IdCentro, 0, $IdProveedor, 0, '00', '', fecha_mysql($txtFecha), fecha_mysql($txtFecha), '', 'R', '', '', '', '', '', '', $idusuario);
                }

                foreach ($_POST['mc_itemcompra'] as $mc_itemcompra) {
                    $objCompra->RegistrarDetalle($conexion_compra, $IdEmpresa, $IdCentro, $rpta, $mc_itemcompra['idproducto'], $mc_itemcompra['codtipoproducto'], $mc_itemcompra['idpresentacion'], $mc_itemcompra['idunidadmedida'], 0, $mc_itemcompra['medidapre'], $mc_itemcompra['cantidad'], $mc_itemcompra['precio'], $mc_itemcompra['subtotal'], $mc_itemcompra['descripcion'], '', $chkIngresoPrevio, $idusuario, $rptaDetCompra);

                    if ($chkIngresoAutomatico == 1){
                         $objCompra->RegistrarDetalleIngresoKardex($conexion_compra, $rptaKardexIngreso, $IdEmpresa, $IdCentro, $rptaDetCompra, $mc_itemcompra['idproducto'], $mc_itemcompra['idunidadmedida'], $mc_itemcompra['idpresentacion'], $mc_itemcompra['codtipoproducto'], $mc_itemcompra['cantidad'], '', $mc_itemcompra['precio'], $mc_itemcompra['subtotal'], $idusuario, $Auxrpta, $Auxtitulomsje);
                         
                        // if ($ddlTipoComprobante == 11){
                        // if ($chkIngresoAutomatico == 1){
                        //     $objCompra->ActualizarSaldoCompra($conexion_compra, $hdIdRefCodigo, $mc_itemcompra['cantidad'], $mc_itemcompra['idproducto'], $Auxrpta, $Auxtitulomsje);
                            
                        //     $objCompra->ActualizarSaldoCompra($conexion_compra, $rpta, $mc_itemcompra['cantidad'], $mc_itemcompra['idproducto'], $Auxrpta, $Auxtitulomsje);
                        // }
                        // }
                        // else {
                        //     if ($ddlTipoComprobante == 11)
                        
                        // }
                    }
                }

                // if ($chkIngresoAutomatico){
                //     if ($ddlTipoComprobante != 11)
                //         $objCompra->AgregarKardexIngresoRegistroCompra($conexion_compra, $rpta, $rptaKardexIngreso, fecha_mysql($txtFecha), $idusuario, $Auxrpta, $Auxtitulomsje);
                // }
            }

            $objCompra->_desconectar($conexion_compra);
        }
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomsje' => $translate->__s($contenidomsje));
    echo json_encode($jsondata);
}
?>