<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
    $user_error = 'Access denied - direct call is not allowed...';
    trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

if ($_POST){
	$rpta = 0;
	$titulomsje = '';
	$contenidomsje = '';
    $colorestado = '';

    $Auxrpta = 0;

    require '../../common/sesion.class.php';
    require '../../adata/Db-OneConnect.class.php';
    require '../../common/functions.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $idperfil = $sesion->get("idperfil");
    $idpersona = $sesion->get("idpersona");

    // $listOrdenes = isset($_POST['listOrdenes']) ? $_POST['listOrdenes'] : '0';

    $hdIdEmpresa = isset($_POST['hdIdEmpresa']) ? $_POST['hdIdEmpresa'] : '0';
    $hdIdCentro = isset($_POST['hdIdCentro']) ? $_POST['hdIdCentro'] : '0';
    $hdIdAmbiente = isset($_POST['hdIdAmbiente']) ? $_POST['hdIdAmbiente'] : '0';
    $hdIdMesa = isset($_POST['hdIdMesa']) ? $_POST['hdIdMesa'] : '0';
    $hdTipoMesa = isset($_POST['hdTipoMesa']) ? $_POST['hdTipoMesa'] : '00';
    $hdIdCliente = isset($_POST['hdIdCliente']) ? $_POST['hdIdCliente'] : '0';

    $direccionip = getRealIP();

    if (isset($_POST['btnNuevaOrden'])) {
        $hdIdAtencion = isset($_POST['hdIdAtencion']) ? $_POST['hdIdAtencion'] : '0';

        require '../../bussiness/atencion_oneconnect.php';
        $objAtencion = new clsAtencion_oneconnect();

        $nronewatencion = '';

        $conexion = $objAtencion->_conectar();
    	
        $objAtencion->Registrar($conexion, $hdIdAtencion, $hdIdEmpresa, $hdIdCentro, $hdIdAmbiente, $hdIdCliente, date('Y-m-d h:i:s'), '01', '02', $hdIdMesa, $hdTipoMesa, $idusuario, $rpta, $nronewatencion);

        if ($rpta > 0)
            $objAtencion->RegistrarMovimiento($conexion, $rpta, '02', $direccionip, $idusuario, $Auxrpta);

        $objAtencion->_desconectar($conexion);
    	
        $titulomsje = 'Agregado correctamente';
    	$contenidomsje = $nronewatencion;
    }
    elseif (isset($_POST['btnAddArticles'])) {
        require '../../bussiness/atencion_oneconnect.php';
        $objAtencion = new clsAtencion_oneconnect();

        $conexion = $objAtencion->_conectar();

        $hdIdAtencion = isset($_POST['hdIdAtencion']) ? $_POST['hdIdAtencion'] : '0';
        $hdTipoMenuDia = isset($_POST['hdTipoMenuDia']) ? $_POST['hdTipoMenuDia'] : '00';
        $txtCantidad = isset($_POST['txtCantidad']) ? $_POST['txtCantidad'] : '0';
        $txtObservacion = isset($_POST['txtObservacion']) ? $_POST['txtObservacion'] : '';

        $hdIdArticulo = isset($_POST['hdIdArticulo']) ? $_POST['hdIdArticulo'] : '0';
        $hdCantidad = isset($_POST['hdCantidad']) ? $_POST['hdCantidad'] : '0';
        $hdPrecio = isset($_POST['hdPrecio']) ? $_POST['hdPrecio'] : '0';
        $hdSubTotal = isset($_POST['hdSubTotal']) ? $_POST['hdSubTotal'] : '0';

        $IdMoneda = 1;

        if ($hdTipoMenuDia == '03')
            $array_articulos = $_POST['mc_menuarticulo'];
        else
            $array_articulos = $_POST['mc_articulo'];

        // if (isset($array_articulos)) {
        //     foreach ($array_articulos as $mc_articulo) {
        //         if (isset($mc_articulo['idproducto'])) {
        //             $lista_subarticulos = ($hdTipoMenuDia == '03') ? $mc_articulo['lista_subarticulos'] : '';
        //             $cantidad = ($hdTipoMenuDia == '03') ? $txtCantidad : $mc_articulo['cantidad'];
        //             $observacion = ($hdTipoMenuDia == '03') ? $txtObservacion : $mc_articulo['observacion'];

        //             $objAtencion->RegistrarDetalle($conexion, '0', $hdIdEmpresa, $hdIdCentro, $hdIdAtencion, $mc_articulo['idproducto'], $IdMoneda, $mc_articulo['precio'], $cantidad, $mc_articulo['subtotal'], '', $observacion, $hdTipoMenuDia, $idusuario, $lista_subarticulos, $Auxrpta);
        //         }
        //     }
        // }

        $objAtencion->RegistrarDetalle($conexion, '0', $hdIdEmpresa, $hdIdCentro, $hdIdAtencion, $hdIdArticulo, $IdMoneda, $hdPrecio, $hdCantidad, $hdSubTotal, '', "", "01", $idusuario, "", $Auxrpta);
        
        $objAtencion->_desconectar($conexion);

        $rpta = $Auxrpta;
        
        if ($Auxrpta > 0) {
            $titulomsje = 'Agregado correctamente';
            $contenidomsje = 'La operación se completó satisfactoriamente';
        }
    }
    elseif (isset($_POST['btnConfirmOrder'])) {
        require '../../bussiness/atencion_oneconnect.php';
        $objAtencion = new clsAtencion_oneconnect();

        $conexion = $objAtencion->_conectar();
        
        $hdIdAtencion = isset($_POST['hdIdAtencion']) ? $_POST['hdIdAtencion'] : '0';

        $objAtencion->ActualizarEstado($conexion, $hdIdAtencion, '03', $idusuario, $rpta, $colorestado);

        if ($rpta > 0) {
            $objAtencion->RegistrarMovimiento($conexion, $hdIdAtencion, '03', $direccionip, $idusuario, $Auxrpta);
            
            $titulomsje = 'Enviado correctamente';
            $contenidomsje = $colorestado;
        }

        $objAtencion->_desconectar($conexion);
    }
    elseif (isset($_POST['btnRemoveOrder'])) {
        require '../../bussiness/atencion_oneconnect.php';
        $objAtencion = new clsAtencion_oneconnect();

        $conexion = $objAtencion->_conectar();

        $hdIdAtencion = isset($_POST['hdIdAtencion']) ? $_POST['hdIdAtencion'] : '0';

        $objAtencion->Eliminar($conexion, $hdIdAtencion, $idusuario, $rpta, $titulomsje, $contenidomsje);

        $objAtencion->_desconectar($conexion);
    }
    elseif (isset($_POST['btnAgruparMesas'])) {
        $chkMesa = $_POST['chkMesa'];
        if (isset($chkMesa)){
            if (is_array($chkMesa)) {
                $strListItems = implode(',', $chkMesa);
                
                require '../../bussiness/atencion_oneconnect.php';
                $objAtencion = new clsAtencion_oneconnect();

                $conexion = $objAtencion->_conectar();

                $objAtencion->AgruparMesas($conexion, '0', $hdIdEmpresa, $hdIdCentro, $hdIdAmbiente, $idpersona, $strListItems, $idusuario, $rpta, $titulomsje, $contenidomsje);

                $objAtencion->_desconectar($conexion);
            }
        }
    }
    elseif (isset($_POST['btnSepararMesas'])) {
        $chkGrupos = $_POST['chkGrupos'];
        if (isset($chkGrupos)){
            if (is_array($chkGrupos)) {
                $strListItems = implode(',', $chkGrupos);
                
                require '../../bussiness/atencion_oneconnect.php';
                $objAtencion = new clsAtencion_oneconnect();

                $conexion = $objAtencion->_conectar();

                $objAtencion->SepararMesas($conexion, $hdIdEmpresa, $hdIdCentro, $strListItems, $idusuario, $rpta, $titulomsje, $contenidomsje);

                $objAtencion->_desconectar($conexion);
            }
        }
    }
    elseif (isset($_POST['btnRemoveArticles'])) {
        $hdIdArticuloOrden = isset($_POST['hdIdArticuloOrden']) ? $_POST['hdIdArticuloOrden'] : '0';

        require '../../bussiness/atencion_oneconnect.php';

        $objAtencion = new clsAtencion_oneconnect();

        $conexion = $objAtencion->_conectar();

        $objAtencion->EliminarArticulo($conexion, $hdIdArticuloOrden, $rpta);
        
        $objAtencion->_desconectar($conexion);
    }
    elseif (isset($_POST['btnCambiarEstado'])) {
        
        if (isset($_POST['chkMesa'])) {
            require '../../adata/Db.class.php';
            require '../../bussiness/mesas.php';

            $hdEstadoMesa = isset($_POST['hdEstadoMesa']) ? $_POST['hdEstadoMesa'] : '00';

            $objMesa = new clsMesa();

            
            if (isset($_POST['chkMesa'])) {
                $listMesas = is_array($_POST['chkMesa']) ? implode(',', $_POST['chkMesa']) : $_POST['chkMesa'];
                $objMesa->ActualizarEstadoMesas($hdIdEmpresa, $hdIdCentro, '00', $hdEstadoMesa, $listMesas, $idusuario, $rpta, $titulomsje, $contenidomsje);
            }

            if (isset($_POST['chkGrupos'])) {
                $listGrupos = is_array($_POST['chkGrupos']) ? implode(',', $_POST['chkGrupos']) : $_POST['chkGrupos'];
                $objMesa->ActualizarEstadoMesas($hdIdEmpresa, $hdIdCentro, '01', $hdEstadoMesa, $listGrupos, $idusuario, $rpta, $titulomsje, $contenidomsje);
            }


        }
    }

    $jsondata = array("rpta" => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>