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
    require '../../bussiness/almacen.php';
    require '../../bussiness/cartadia.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $idperfil = $sesion->get("idperfil");
    $idpersona = $sesion->get("idpersona");

    $strListItems = '';

    $rpta = '0';
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clsCartaDia();
    $objAlmacen = new clsAlmacen();

    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'lang';

    $translate = new Translator($lang);

    $IdEmpresa = isset($_POST['hdIdEmpresa']) ? $_POST['hdIdEmpresa'] : '1';
    $IdCentro = isset($_POST['hdIdCentro']) ? $_POST['hdIdCentro'] : '1';

    if (isset($_POST['btnAperturarMenu'])) {
        $hdTipoCarta = (isset($_POST['hdTipoCarta'])) ? $_POST['hdTipoCarta'] : '03';
        $hdFecha = isset($_POST['hdFecha']) ? $_POST['hdFecha'] : date('Y-m-d');

        $rptaKardexSalida = $objAlmacen->RegistrarSalidaKardex(0, $IdEmpresa, $IdCentro, 0, 0, '', '', $hdFecha . ' ' . date('h:i:s'), 0, '00', $hdFecha. ' ' . date('h:i:s'), $idpersona, '00', 1, 0, $idusuario);

        // if ($rptaKardexSalida > 0)
        $objData->AperturarProgramacion($hdTipoCarta, $IdEmpresa, $IdCentro, $rptaKardexSalida, $hdFecha, 1, 0, $idusuario, $rpta, $titulomsje, $contenidomsje);

        $objData->AperturarProgramacion($hdTipoCarta, $IdEmpresa, $IdCentro, $rptaKardexSalida, $hdFecha, 0, 0, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnAsignarArticulos'])){
        $hdTipoCarta = isset($_POST['hdTipoCarta']) ? $_POST['hdTipoCarta'] : '03';
        //$hdIdGrupo = isset($_POST['hdIdGrupo']) ? $_POST['hdIdGrupo'] : '0';
        //$hdIdOrden = isset($_POST['hdIdOrden']) ? $_POST['hdIdOrden'] : '0';
        $hdEditMode = isset($_POST['hdEditMode']) ? $_POST['hdEditMode'] : 'EDIT';
        $hdIdCarta = isset($_POST['hdIdCarta']) ? $_POST['hdIdCarta'] : '0';
        $hdFecha = isset($_POST['hdFecha']) ? $_POST['hdFecha'] : date('Y-m-d');
        $IdMoneda = 1;
        //$detalleMenu = json_decode(stripslashes($_POST['detalleMenu']));
        
        if (isset($_POST['mc_articulo'])) {
            // if ($hdEditMode == 'EDIT') {
            //     $objData->EliminarFechaProgramacion($hdTipoCarta, $IdEmpresa, $IdCentro, $hdIdCarta, $hdFecha, $idusuario);
            // }
            foreach ($_POST['mc_articulo'] as $mc_articulo) {
                if (isset($mc_articulo['chkDetalle'])) {
                    $stock = $hdTipoCarta == '00' ? 0 : $mc_articulo['stock'];
                    
                    $rpta = $objData->RegistrarProgramacion($mc_articulo['iddetalle'], $hdTipoCarta, $IdEmpresa, $IdCentro, 0, $hdIdCarta, $mc_articulo['idproducto'], $hdFecha, $IdMoneda, $mc_articulo['precio'], $stock, $idusuario);
                }
            }
        }
        
        // foreach ($detalleMenu as $item){
        //     $rpta = $objData->RegistrarProgramacion($hdTipoCarta, $IdEmpresa, $IdCentro, $hdIdGrupo, $hdIdCarta, $item->idProducto, $item->fechaMenu, $item->orden, $item->stock, $idusuario);
        // }

        $titulomsje = 'Programación creada.';
        $contenidomsje = 'La operación se realizó exitosamente.';
    }
    elseif (isset($_POST['btnEliminarItemAsignacion'])){
        $hdIdDetalle = (isset($_POST['hdIdDetalle'])) ? $_POST['hdIdDetalle'] : '0';

        $objData->EliminarItemProgramacion($hdIdDetalle, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnGuardarCarta'])){
        $hdIdCarta = (isset($_POST['hdIdCarta'])) ? $_POST['hdIdCarta'] : '0';
        $txtNombreCarta = (isset($_POST['txtNombreCarta'])) ? $_POST['txtNombreCarta'] : '';
        
        $objData->RegistrarCarta($hdIdCarta, $IdEmpresa, $IdCentro, $txtNombreCarta, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnSetCarta'])){
        $hdIdCarta = (isset($_POST['hdIdCarta'])) ? $_POST['hdIdCarta'] : '0';
        
        $objData->ActivarCarta($hdIdCarta, $IdEmpresa, $IdCentro, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnEliminarCarta'])){
        $chkItem = $_POST['chkItemCarta'];
        
        if (isset($chkItem)){
            if (is_array($chkItem)) {
                $strListItems = implode(',', $chkItem);
                $objData->MultiDeleteCarta($strListItems, $idusuario, $rpta, $titulomsje, $contenidomsje);
            }
        }
    }
    elseif (isset($_POST['btnEliminarAsignados'])){
        
        if (isset($_POST['mc_articulo'])) {
            require '../../adata/Db-OneConnect.class.php';
            require '../../bussiness/cartadia_oneconnect.php';

            $objCartaDia_OC = new clsCartaDia_oneconnect();
            
            $hdTipoCarta = (isset($_POST['hdTipoCarta'])) ? $_POST['hdTipoCarta'] : '03';
            
            $conexion = $objCartaDia_OC->_conectar();
            
            foreach ($_POST['mc_articulo'] as $mc_articulo) {
                if (isset($mc_articulo['chkDetalle'])) {
                    $objCartaDia_OC->EliminarProgramacion($conexion, $hdTipoCarta, $mc_articulo['chkDetalle'], $idusuario, $rpta, $titulomsje, $contenidomsje);
                }
            }
        
            $objCartaDia_OC->_desconectar($conexion);
        }
    }
    
    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>