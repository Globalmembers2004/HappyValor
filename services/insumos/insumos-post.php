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
    require '../../bussiness/presentacion.php';
    require '../../bussiness/insumos.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $idperfil = $sesion->get("idperfil");

    $rpta = '0';
    $titulomsje = '';
    $contenidomsje = '';

    $strQueryDetPresentacion = '';
    $strItemsDetalle = '';

    $objData = new clsInsumo();
    $objPresentacion = new clsPresentacion();

    $IdEmpresa = isset($_POST['hdIdEmpresa']) ? $_POST['hdIdEmpresa'] : '1';
    $IdCentro = isset($_POST['hdIdCentro']) ? $_POST['hdIdCentro'] : '1';

    if (isset($_POST['btnGuardar'])){
        $Id = isset($_POST['hdIdPrimary']) ? $_POST['hdIdPrimary'] : '0';
        $Nombre = isset($_POST['txtNombre']) ? $_POST['txtNombre'] : '';
        $Descripcion = isset($_POST['txtDescripcion']) ? $_POST['txtDescripcion'] : '';
        $IdCategoria = isset($_POST['ddlCategoriaReg']) ? $_POST['ddlCategoriaReg'] : '0';
        $IdSubCategoria = 0;//isset($_POST['ddlSubCategoriaReg']) ? $_POST['ddlSubCategoriaReg'] : '0';
        $ddlUnidadMedidaReg = isset($_POST['ddlUnidadMedidaReg']) ? $_POST['ddlUnidadMedidaReg'] : '0';
        $txtCostoPromedio = isset($_POST['txtCostoPromedio']) ? $_POST['txtCostoPromedio'] : '0';
        $txtStockMinimo = isset($_POST['txtStockMinimo']) ? $_POST['txtStockMinimo'] : '0';
        $txtStockMaximo = isset($_POST['txtStockMaximo']) ? $_POST['txtStockMaximo'] : '0';

        $rpta = $objData->Registrar($Id, $IdEmpresa, $IdCentro, $IdCategoria, $IdSubCategoria, '00', $Nombre, $Descripcion, '00', '', $txtStockMinimo, $txtStockMaximo, 0, 0, 0, 0, $txtCostoPromedio, 0, 0, 0, 0, 0, $ddlUnidadMedidaReg, $idusuario);

        if ($rpta > 0){
            $objPresentacion->DeleteInsumoPresentacion($rpta, '00', $idusuario);

            if (isset($_POST['pre_insumo'])) {
                $strQueryDetPresentacion = 'INSERT INTO td_presentacion_insumo (tm_idempresa, tm_idcentro, tm_idinsumo, tm_idpresentacion, tm_idunidadmedida, td_medida, ta_tipoinsumo, Activo, IdUsuarioReg, FechaReg, IdUsuarioAct, FechaAct) VALUES ';
                
                foreach ($_POST['pre_insumo'] as $item) {
                    if (strlen($strItemsDetalle) > 0)
                        $strItemsDetalle .= ',';
                    
                    $strItemsDetalle .= '('.$IdEmpresa.', '.$IdCentro.', '.$rpta.', '.$item['idpresentacion'].', '.$item['idunidadmedida'].', '.$item['medida'].', \'00\', 1, '.$idusuario.', \''.date("Y-m-d h:i:s").'\', '.$idusuario.', \''.date("Y-m-d h:i:s").'\')';
                }

                if (strlen($strItemsDetalle) > 0) {
                    $strQueryDetPresentacion .= $strItemsDetalle;
                    $objPresentacion->RegistrarInsumoPresentacion($strQueryDetPresentacion);
                }
            }
            
            $titulomsje = 'Registrado correctamente';
            $contenidomsje = 'La operacion se completo satisfactoriamente';
        }
    }
    elseif (isset($_POST['btnEliminar'])) {
        $hdIdInsumo = $_POST['hdIdInsumo'];
        $rpta = $objData->EliminarStepByStep($hdIdInsumo, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnEditarStock'])) {
        $hdTipoInsumo = $_POST['hdTipoInsumo'];
        $hdIdInsumo = $_POST['hdIdInsumo'];
        $hdIdAlmacen = $_POST['hdIdAlmacen'];
        $txtSaldoInicial = $_POST['txtSaldoInicial'];
        $txtCostoUnitario = $_POST['txtCostoUnitario'];
        $txtCostoTotal = $_POST['txtCostoTotal'];
        
        $objData->RegistrarInsumoStock($IdEmpresa, $IdCentro, $hdTipoInsumo, $hdIdInsumo, $txtSaldoInicial, $txtCostoUnitario, $txtCostoTotal, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnCambiarCostoInsumo'])) {
        $hdIdInsumo = $_POST['hdIdInsumo'];
        $txtCostoReceta = $_POST['txtCostoReceta'];

        $objData->CambiarCostoReceta($hdIdInsumo, $txtCostoReceta, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnCambiarStockMinMax'])) {
        $chkInsumo = $_POST['chkInsumo'];
        if (isset($chkInsumo)){
            if (is_array($chkInsumo)) {
                $strListItems = implode(',', $chkInsumo);
                $txtStockMin_Masivo = $_POST['txtStockMin_Masivo'];
                $txtStockMax_Masivo = $_POST['txtStockMax_Masivo'];

                $objData->ActualizarStockMinMax($strListItems, $txtStockMin_Masivo, $txtStockMax_Masivo, $idusuario, $rpta, $titulomsje, $contenidomsje);
            }
        }
    }
    
    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>