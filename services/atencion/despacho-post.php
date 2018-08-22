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
    require '../../bussiness/almacen.php';
    require '../../bussiness/atencion.php';
    require '../../bussiness/cartadia.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $idperfil = $sesion->get("idperfil");

    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'es';
    $translate = new Translator($lang);

    $rpta = 0;
    $titulomsje = '';
    $contenidomsje = '';
    $rptaMov = 0;
    $rptaDetailsMov = 0;
    $EstadoAtencion = '04';
    $ColorEstado = '';

    $IdAlmacen = 1;
    $IdVendedor = 1;
    $IdTipoComprobante = 1;
    $IdTipoSalida = 1;
    $IdVenta = 0;

    $objAtencion = new clsAtencion();
    $objCartaDia = new clsCartaDia();
    $objAlmacen = new clsAlmacen();

    $hdIdEmpresa = isset($_POST['hdIdEmpresa']) ? $_POST['hdIdEmpresa'] : '0';
    $hdIdCentro = isset($_POST['hdIdCentro']) ? $_POST['hdIdCentro'] : '0';
    $hdEstadoNuevo = isset($_POST['hdEstadoNuevo']) ? $_POST['hdEstadoNuevo'] : '01';
    $hdIdAtencion = isset($_POST['hdIdAtencion']) ? $_POST['hdIdAtencion'] : '0';
    $chkItem = isset($_POST['chkItem']) ? $_POST['chkItem'] : '0';
    $hdTipoAccion = isset($_POST['hdTipoAccion']) ? $_POST['hdTipoAccion'] : 'SELECTION';
    
    if ($hdTipoAccion == 'SELECTION')
        $paramsId = implode(',', $chkItem);
    else
        $paramsId = $hdIdAtencion;

    $objAtencion->ActualizarEstadoItem($hdTipoAccion, $hdEstadoNuevo, $paramsId, $idusuario, $rpta, $titulomsje, $contenidomsje);

    if ($rpta > 0){
        if ($hdTipoAccion == 'ALL' && $hdEstadoNuevo == '02')
            $EstadoAtencion = '05';
        else {
            $rsCheck = $objAtencion->CheckStateDetails('1', $hdIdAtencion, '00,01');
            $countCheck = $rsCheck[0]['countCheck'];
            
            if ($countCheck > 0)
                $EstadoAtencion = '04';
            else
                $EstadoAtencion = '05';

            // echo $countCheck;

            // if ($hdEstadoNuevo == '02'){
            //     $rptaKardexSalida = $objAlmacen->RegistrarSalidaKardex(0, $hdIdEmpresa, $hdIdCentro, $IdVenta, $IdTipoComprobante, '11X', '11X', date('Y-m-d'), $IdAlmacen, '00', date('Y-m-d'), $IdVendedor, $IdTipoSalida, 1, 0, $idusuario);

            //     if ($rptaKardexSalida > 0)
            //         $rptaAperturaMenu = $objCartaDia->AperturarProgramacion('00', $hdIdEmpresa, $hdIdCentro, 0, $rptaKardexSalida, date('Y-m-d'), -1, '', $idusuario);
            // }
        }
        
        $objAtencion->ActualizarEstado($hdIdAtencion, $EstadoAtencion, $idusuario, $idusuario, $ColorEstado);

        // if ($EstadoAtencion > 0) {
        //     $strContentOrden = '';

        //     $printer = "\\\\Pserver.php.net\\HP Photosmart-C4700-Series"); 
        //     if($ph = printer_open($printer)) { 
        //         // Get file contents 
        //         $fh = fopen($strContentOrden, "rb"); 
        //         $content = fread($fh, filesize("filename.ext")); 
        //         fclose($fh);

        //         // Set print mode to RAW and send PDF to printer 
        //         printer_set_option($ph, PRINTER_MODE, "RAW"); 
        //         printer_write($ph, $content);
        //         printer_close($ph);
        //     } 
        //     else "Couldn't connect...";
        // }
    }

    $jsondata = array('rpta' => $hdIdAtencion, 'EstadoAtencion' => $EstadoAtencion, 'ColorEstado' => $ColorEstado, 'titulomsje' => $translate->__s($titulomsje), 'contenidomsje' => $translate->__s($contenidomsje));
    echo json_encode($jsondata);
}
?>