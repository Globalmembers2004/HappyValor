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
    require '../../common/functions.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $idperfil = $sesion->get("idperfil");
    $IdEmpresa = isset($_POST['hdIdEmpresa']) ? $_POST['hdIdEmpresa'] : '0';
    $IdCentro = isset($_POST['hdIdCentro']) ? $_POST['hdIdCentro'] : '0';
    $IdPersonal = $sesion->get("idpersona");

    $rpta = 0;
    $titulomsje = '';
    $contenidomsje = '';

    $rpta__Deudacobrar = 0;
    $titulomsje__Deudacobrar = '';
    $contenidomsje__Deudacobrar = '';

    $Auxrpta = 0;
    $colorestado = '';

    $rptaCli = 0;
    $titulomsjeCli = '';
    $contenidomsjeCli = '';

    $IdAlmacen = 1;
    $datosVenta = '';

    $realIp = getRealIP();    

    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'es';

	$translate = new Translator($lang);

    $IdAperturaCaja = isset($_POST['hdIdAperturaCaja']) ? $_POST['hdIdAperturaCaja'] : '0';

    if (isset($_POST['btnCobrar'])) {
        if (isset($_POST['mc_articulo'])) {
            $hdIdOrden = isset($_POST['hdIdOrden']) ? $_POST['hdIdOrden'] : '0';
            $hdTipoComprobante = isset($_POST['hdTipoComprobante']) ? $_POST['hdTipoComprobante'] : '0';
            $hdMedioPago = isset($_POST['hdMedioPago']) ? $_POST['hdMedioPago'] : '0';
            $hdTipoCliente = isset($_POST['hdTipoCliente']) ? $_POST['hdTipoCliente'] : '0';
            $hdIdMoneda = isset($_POST['hdIdMoneda']) ? $_POST['hdIdMoneda'] : '1';
            
            $txtFecha = date('Y-m-d');

            $hdTotalSinImpuesto = isset($_POST['hdTotalSinImpuesto']) ? $_POST['hdTotalSinImpuesto'] : '0';
            $hdImpuesto = isset($_POST['hdImpuesto']) ? $_POST['hdImpuesto'] : '0';
            $hdTotalConImpuesto = isset($_POST['hdTotalConImpuesto']) ? $_POST['hdTotalConImpuesto'] : '0';
            $chkPagoTarjeta = isset($_POST['chkPagoTarjeta']) ? $_POST['chkPagoTarjeta'] : '0';
            $chkClienteDefault = isset($_POST['chkClienteDefault']) ? $_POST['chkClienteDefault'] : '0';

            $txtNroDocCliente = isset($_POST['txtNroDocCliente']) ? $_POST['txtNroDocCliente'] : '';
            $txtRazonSocialCliente = isset($_POST['txtRazonSocialCliente']) ? $_POST['txtRazonSocialCliente'] : '';
            $txtNombresCliente = isset($_POST['txtNombresCliente']) ? $_POST['txtNombresCliente'] : '';
            $txtApePaternoCliente = isset($_POST['txtApePaternoCliente']) ? $_POST['txtApePaternoCliente'] : '';
            $txtApeMaternoCliente = isset($_POST['txtApeMaternoCliente']) ? $_POST['txtApeMaternoCliente'] : '';
            $txtDireccionCliente = isset($_POST['txtDireccionCliente']) ? $_POST['txtDireccionCliente'] : '';
            $txtTelefonoCliente = isset($_POST['txtTelefonoCliente']) ? $_POST['txtTelefonoCliente'] : '';
            $txtEmailCliente = isset($_POST['txtEmailCliente']) ? $_POST['txtEmailCliente'] : '';
            $ddlPaisCliente = isset($_POST['ddlPaisCliente']) ? $_POST['ddlPaisCliente'] : '0';
            $ddlRegionCliente = isset($_POST['ddlRegionCliente']) ? $_POST['ddlRegionCliente'] : '0';
            
            require '../../adata/Db-OneConnect.class.php';
            require '../../bussiness/venta_oneconnect.php';

            $objVenta = new clsVenta_oneconnect();

            $conexion_venta = $objVenta->_conectar();

            $IdCliente = 0;
            
            if ($chkClienteDefault == '0') {
                $rbRegCliente = $_POST['rbRegCliente'];
                
                if ($rbRegCliente == 'NEW'){
                    $objVenta->RegistrarCliente($conexion_venta, $hdTipoCliente, '0', $IdEmpresa, $IdCentro, 1,  1, $txtNroDocCliente, $txtRazonSocialCliente, '', $txtNombresCliente, $txtApePaternoCliente, $txtApeMaternoCliente, $txtDireccionCliente, $txtTelefonoCliente, '', $txtEmailCliente, 'no-set', '', $ddlPaisCliente, $ddlRegionCliente, $idusuario, $rptaCli, $titulomsjeCli, $contenidomsjeCli);
                    
                    $IdCliente = $rptaCli;
                }
                else
                    $IdCliente = isset($_POST['hdIdCliente']) ? $_POST['hdIdCliente'] : '0';
            }
            
            $TipoCobro = $hdMedioPago == '2' ? '01' : '00';

            $objVenta->Registrar($conexion_venta, 0, $IdEmpresa, $IdCentro, $hdTipoComprobante, '', '', $hdIdMoneda, $IdCliente, $TipoCobro, $txtFecha, $txtFecha, $hdTotalSinImpuesto, $hdImpuesto, $hdTotalConImpuesto, $IdPersonal, '00', $IdAperturaCaja, $idusuario, $rpta, $titulomsje, $contenidomsje);
            
            if ($rpta > 0){
                foreach ($_POST['mc_articulo'] as $mc_articulo) {
                    $objVenta->RegistrarDetalle($conexion_venta, $rpta, $IdEmpresa, $IdCentro, $mc_articulo['idproducto'], $mc_articulo['cantidad'], $mc_articulo['precio'], 0, $mc_articulo['subtotal'], '0', $mc_articulo['tipomenudia'], $mc_articulo['idcliente'], explode(" ", $mc_articulo['fechainicio'])[0], $idusuario, $Auxrpta);
                }

                $objVenta->RegistrarVentaFormaPago($conexion_venta, $IdEmpresa, $IdCentro, $rpta, 9, $hdIdMoneda, '', $hdTotalConImpuesto, 0, '', $idusuario);

                if ($chkPagoTarjeta == '1')
                    $objVenta->RegistrarVentaFormaPago($conexion_venta, $IdEmpresa, $IdCentro, $rpta, 22, $hdIdMoneda, $ddlNombreTarjeta, $txtImporteTarjeta, 0, $txtNumeroTarjeta, $idusuario);

                if ($hdMedioPago == '2') {
                    $objVenta->RegistrarDeudaCobrar($conexion_venta, $rpta, 0, $IdEmpresa, $IdCentro, $IdCliente, $hdTotalConImpuesto, $idusuario, $rpta__Deudacobrar, $titulomsje__Deudacobrar, $contenidomsje__Deudacobrar);
                }

                //$idimpuesto = 1;

                $objVenta->RegistrarVentaImpuesto($conexion_venta, $IdEmpresa, $IdCentro, $rpta, 0, $hdImpuesto, $idusuario);

                $objVenta->ActualizarEstado($conexion_venta, $hdIdOrden, '06', $idusuario, $Auxrpta, $colorestado);

                if ($Auxrpta > 0){
                    $direccionip = getRealIP();
                    $objVenta->RegistrarMovimiento($conexion_venta, $hdIdOrden, '06', $direccionip, $idusuario, $Auxrpta);
                }
            }
            
            $datosVenta = $objVenta->Listar($conexion_venta, '4', $IdEmpresa, $IdCentro, $rpta, date('Y-m-d'), date('Y-m-d'), '', 0);
            
            $objVenta->_desconectar($conexion_venta);

            if ($chkClienteDefault == '0') {
                require '../../bussiness/usuarios.php';
                require '../../bussiness/perfil.php';
                
                $objUsuario = new clsUsuario();
                $objPerfil = new clsPerfil();
                
                $rsUsuario = $objUsuario->IfExists__UsuarioPersona('00', $IdCliente);
                $countUsuario = $rsUsuario[0]['CountUsuario'];

                if ($countUsuario == 0) {
                    $rsPerfil = $objPerfil->GetPerfil__PorCodigo('PRF00006');
                    $countPerfil = count($rsPerfil);

                    if ($countPerfil > 0) {
                        $IdPerfil_Cliente = $rsPerfil[0]['tm_idperfil'];
                        
                        if ($hdTipoCliente == 'JU'){
                            $nombres = $txtRazonSocial;
                            $apellidos = '';
                            $nrodni = '';
                            $nroruc = $NroDocIdent;

                            $nombre_completo = $nombres;

                            $_esempresa = 1;
                        }
                        else {
                            $nombres = $txtNombres;
                            $apellidos = $txtApePaterno . ' ' . $txtApeMaterno;
                            $nrodni = $NroDocIdent;
                            $nroruc = '';

                            $nombre_completo = $nombres . ' ' . $apellidos;

                            $_esempresa = 0;
                        }

                        mt_srand(time());
                        $rand = mt_rand(1000000,9999999);

                        $codigo = $IdPerfil_Cliente.$rpta.$IdEmpresa.$IdCentro.$hdIdPrimary;
                        $login = $codigo . substr($nombres, 0, 3) . substr($apellidos, 0, 3);
                        $clave = $login . $rand;

                        $user_rpta = '0';
                        $user_titulomsje = '';
                        $user_contenidomsje = '';
                        
                        $objUsuario->Registrar_Plataforma__StandAlone($rpta, $login, $clave, $_esempresa, $IdRegion, $NroDocIdent, $txtRazonSocial, $txtNombres, $apellidos, $Email, $idusuario, $user_rpta, $user_titulomsje, $user_contenidomsje);

                        if ($user_rpta > 0) {
                            $objUsuario->Registrar('0', $IdEmpresa, $IdCentro, $IdPerfil_Cliente, $rpta, '00', $NroDocIdent, $login, $nombres, $apellidos, $clave, '00', $nrodni, $nroruc, $IdPais, $Direccion, $Email, $Telefono, $urlFoto, 'CLIENTES', $user_rpta, $user_rpta, $user_titulomsje, $user_contenidomsje);

                            if ($user_rpta > 0) {
                                $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

                                $subject = '=?UTF-8?B?'.base64_encode($nombre_completo . ", tu cuenta de Tambo está casi lista!").'?=';

                                $message = '<html><head>';
                                $message .= '</head><body>';
                                $message .= '<p>Hola, ' . ucfirst($nombre_completo) . ', su cuenta de Tambo está casi lista, sólo falta un paso más para verificarla, para hacerlo haga click en el siguiente enlace: </p>';
                                $message .= '<a class="btn btn-primary btn-lg center-block" href="'.$root.'/regconfirm.php?iuser=' . $login . '&ipass=' . $clave . '" target="_blank" role="button">Ir a Tamboapp.com</a>';
                                $message .= '</div></body></html>';

                                require '../../common/PHPMailerAutoload.php';
                                require '../../common/simply_email.php';

                                $objEmail = new clsSimplyEmail();
                                $resultMail = $objEmail->EnvioEmail('info@tamboapp.com', $Email, $subject, $message, false, false);
                            }
                        }
                    }
                }
            }
        }
    }
    elseif (isset($_POST['btnAddServicioVenta'])) {
        require '../../adata/Db-OneConnect.class.php';
        require '../../bussiness/atencion_oneconnect.php';

        $direccionip = getRealIP();

        $hdIdOrden = isset($_POST['hdIdOrden']) ? $_POST['hdIdOrden'] : '0';
        $hdIdCliente = '0';

        $objAtencion = new clsAtencion_oneconnect();

        $conexion = $objAtencion->_conectar();
    
        if ($hdIdOrden == '0') {
            $objAtencion->Registrar($conexion, 0, $IdEmpresa, $IdCentro, 0, $hdIdCliente, date('Y-m-d h:i:s'), '01', '02', 0, '00', $idusuario, $rpta, $nronewatencion);

            if ($rpta > 0)
                $objAtencion->RegistrarMovimiento($conexion, $rpta, '02', $direccionip, $idusuario, $Auxrpta);

            $hdIdOrden = $rpta;
        }
        else
            $rpta = $hdIdOrden;

        if (isset($_POST['itemsservicio'])) {
            foreach ($_POST['itemsservicio'] as $itemsservicio) {
                if (isset($itemsservicio['idproducto'])) {
                    $serv_IdCliente__Servicio = $itemsservicio['serv_IdCliente__Servicio'];

                    if ($serv_IdCliente__Servicio == 0) {
                        $serv_TipoDocCliente__Servicio = $itemsservicio['serv_TipoDocCliente__Servicio'];
                        $serv_NroDocCliente__Servicio = $itemsservicio['serv_NroDocCliente__Servicio'];
                        $serv_ApePaternoCliente__Servicio = $itemsservicio['serv_ApePaternoCliente__Servicio'];
                        $serv_ApeMaternoCliente__Servicio = $itemsservicio['serv_ApeMaternoCliente__Servicio'];
                        $serv_NombresCliente__Servicio = $itemsservicio['serv_NombresCliente__Servicio'];
                        $serv_RazonSocialCliente__Servicio = $itemsservicio['serv_RazonSocialCliente__Servicio'];
                        $serv_DireccionCliente__Servicio = $itemsservicio['serv_DireccionCliente__Servicio'];
                        $serv_TelefonoCliente__Servicio = $itemsservicio['serv_TelefonoCliente__Servicio'];
                        $serv_EmailCliente__Servicio = $itemsservicio['serv_EmailCliente__Servicio'];
                        $serv_PaisCliente__Servicio = $itemsservicio['serv_PaisCliente__Servicio'];
                        $serv_RegionCliente__Servicio = $itemsservicio['serv_RegionCliente__Servicio'];

                        $objAtencion->RegistrarCliente($conexion, $serv_IdCliente__Servicio, $IdEmpresa, $IdCentro, $serv_NroDocCliente__Servicio, $serv_NombresCliente__Servicio, $serv_ApeMaternoCliente__Servicio . " " . $serv_ApeMaternoCliente__Servicio, "00", date('Y-m-d'), $serv_TelefonoCliente__Servicio, "", $serv_EmailCliente__Servicio, "", $serv_RegionCliente__Servicio, $serv_DireccionCliente__Servicio, "no-set", $idusuario, $rptaCli, $titulomsjeCli, $contenidomsjeCli);
                    }

                    $objAtencion->RegistrarDetalle($conexion, '0', $IdEmpresa, $IdCentro, $hdIdOrden, $itemsservicio['idproducto'], $serv_IdCliente__Servicio, 1, $itemsservicio['subtotal'], 1, $itemsservicio['subtotal'], $itemsservicio['descripcion'], 'CAJA_'.$hdIdOrden.'_'.$IdPersonal, '04', fecha_mysql($itemsservicio['fechainicio']), $idusuario, '', $Auxrpta);
                }
            }
        }

        // $objAtencion->ActualizarEstado($conexion, $hdIdOrden, '03', $idusuario, $Auxrpta, $colorestado);

        if ($Auxrpta > 0)
            $objAtencion->RegistrarMovimiento($conexion, $hdIdOrden, '03', $direccionip, $idusuario, $Auxrpta);

        $objAtencion->_desconectar($conexion);

        $titulomsje = 'Agregado correctamente';
    }
    elseif (isset($_POST['btnAddItemsVenta'])) {

        require '../../adata/Db-OneConnect.class.php';
        require '../../bussiness/atencion_oneconnect.php';

        $direccionip = getRealIP();

        $hdIdOrden = isset($_POST['hdIdOrden']) ? $_POST['hdIdOrden'] : '0';
        $hdIdCliente = '0';

        $objAtencion = new clsAtencion_oneconnect();

        $conexion = $objAtencion->_conectar();
    
        if ($hdIdOrden == '0') {
            $objAtencion->Registrar($conexion, 0, $IdEmpresa, $IdCentro, 0, $hdIdCliente, date('Y-m-d h:i:s'), '01', '02', 0, '00', $idusuario, $rpta, $nronewatencion);

            if ($rpta > 0)
                $objAtencion->RegistrarMovimiento($conexion, $rpta, '02', $direccionip, $idusuario, $Auxrpta);

            $hdIdOrden = $rpta;
        }
        else
            $rpta = $hdIdOrden;

        if (isset($_POST['itemsventa'])) {
            foreach ($_POST['itemsventa'] as $itemsventa) {
                if (isset($itemsventa['idproducto'])) {
                    $objAtencion->RegistrarDetalle($conexion, '0', $IdEmpresa, $IdCentro, $hdIdOrden, $itemsventa['idproducto'], $hdIdCliente, 1, $itemsventa['precio'], $itemsventa['cantidad'], $itemsventa['subtotal'], '', 'CAJA_'.$hdIdOrden.'_'.$IdPersonal, '01', date('Y-m-d'), $idusuario, '', $Auxrpta);
                }
            }
        }

        $objAtencion->ActualizarEstado($conexion, $hdIdOrden, '03', $idusuario, $Auxrpta, $colorestado);

        if ($Auxrpta > 0)
            $objAtencion->RegistrarMovimiento($conexion, $hdIdOrden, '03', $direccionip, $idusuario, $Auxrpta);

        $objAtencion->_desconectar($conexion);

        $titulomsje = 'Agregado correctamente';
    }
    else {
        require '../../adata/Db.class.php';
        require '../../bussiness/ventas.php';

        $objVenta = new clsVenta();

    	if (isset($_POST['btnRegistrarApertura'])){
            $hdFechaHoraApertura = $_POST['hdFechaHoraApertura'];
            // $fechaApertura = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $hdFechaHoraApertura);
            $fechaApertura = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $hdFechaHoraApertura)));

    	    $ddlTurnoApertura = isset($_POST['ddlTurnoApertura']) ? $_POST['ddlTurnoApertura'] : '0';
    	    $ddlMonedaApertura = isset($_POST['ddlMonedaApertura']) ? $_POST['ddlMonedaApertura'] : '0';
    	    $txtImporteApertura = isset($_POST['txtImporteApertura']) ? $_POST['txtImporteApertura'] : '0';

            $rsMovimiento = $objVenta->TipoMovCajaPorDefecto('MC001');

            $IdMovimiento = $rsMovimiento[0]['tm_idtipomovimiento_caja'];
            $DescripMovimiento = $rsMovimiento[0]['tm_descripcion'];

            $objVenta->RegistrarAperturaCaja($IdAperturaCaja,  $IdEmpresa, $IdCentro, $IdPersonal, $ddlMonedaApertura, $fechaApertura, $txtImporteApertura, 0, 0, $ddlTurnoApertura, $idusuario, $rpta, $titulomsje, $contenidomsje);
        }
        elseif (isset($_POST['btnRegistrarMovCaja'])){
            $hdIdMoneda = (isset($_POST['hdIdMoneda'])) ? $_POST['hdIdMoneda'] : '0';
            $hdTipoDataPersona = (isset($_POST['hdTipoDataPersona'])) ? $_POST['hdTipoDataPersona'] : '0';
            $hdIdPersona = (isset($_POST['hdIdPersona'])) ? $_POST['hdIdPersona'] : '0';
            $ddlTipoMovimiento = (isset($_POST['ddlTipoMovimiento'])) ? $_POST['ddlTipoMovimiento'] : '0';
            $ddlConcepto = (isset($_POST['ddlConcepto'])) ? $_POST['ddlConcepto'] : '0';
            $txtImporteMovimiento = (isset($_POST['txtImporteMovimiento'])) ? $_POST['txtImporteMovimiento'] : '0';
            $txtObservacionMovCaja = (isset($_POST['txtObservacionMovCaja'])) ? $_POST['txtObservacionMovCaja'] : '';

            $objVenta->RegistrarDetalleCaja($IdAperturaCaja, $IdEmpresa, $IdCentro, $ddlTipoMovimiento, $ddlConcepto, $hdTipoDataPersona, $hdIdPersona, $hdIdMoneda, $txtImporteMovimiento, 0, $txtObservacionMovCaja, $idusuario, $rpta, $titulomsje, $contenidomsje);
        }
        elseif (isset($_POST['btnCerrarCaja'])) {
            $hdIdMoneda = (isset($_POST['hdIdMoneda'])) ? $_POST['hdIdMoneda'] : '0';
            $txtObservacionCierreCaja = (isset($_POST['txtObservacionCierreCaja'])) ? $_POST['txtObservacionCierreCaja'] : '';

            $chkLimpiarMesas = (isset($_POST['chkLimpiarMesas'])) ? $_POST['chkLimpiarMesas'] : '0';


            $objVenta->CierreCaja($IdAperturaCaja, $IdEmpresa, $IdCentro, $IdPersonal, $hdIdMoneda, $txtObservacionCierreCaja, $chkLimpiarMesas, $idusuario, $rpta, $titulomsje, $contenidomsje);

            if ($rpta > 0) {
                require '../../bussiness/almacen.php';
                require '../../bussiness/cartadia.php';

                $hdTipoCarta = (isset($_POST['hdTipoCarta'])) ? $_POST['hdTipoCarta'] : '00';
                $hdFecha = isset($_POST['hdFecha']) ? $_POST['hdFecha'] : date('Y-m-d');

                $objCartaDia = new clsCartaDia();
                $objAlmacen = new clsAlmacen();

                $rptaKardexSalida = $objAlmacen->RegistrarSalidaKardex(0, $IdEmpresa, $IdCentro, 0, 0, '', '', $hdFecha, 0, '00', $hdFecha, $IdPersonal, '00', 1, 0, $idusuario);

                $objCartaDia->AperturarProgramacion('00', $IdEmpresa, $IdCentro, $rptaKardexSalida, $hdFecha, 1, '', $idusuario, $rpta, $titulomsje, $contenidomsje);

                $objCartaDia->AperturarProgramacion('00', $IdEmpresa, $IdCentro, $rptaKardexSalida, $hdFecha, 0, '', $idusuario, $rpta, $titulomsje, $contenidomsje);
            }
        }
    }

    $jsondata = array("rpta" => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomsje' => $translate->__s($contenidomsje), "datosVenta" => $datosVenta);
    echo json_encode($jsondata);
}
?>