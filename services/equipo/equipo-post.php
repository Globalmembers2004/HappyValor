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
    require '../../bussiness/equipo.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    // $idperfil = $sesion->get("idperfil");

    $rpta = '0';
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clsEquipo();

    
    if (isset($_POST['btnGuardar'])){
        $urlFoto = '';
        $IdEmpresa = isset($_POST['hdIdEmpresa']) ? $_POST['hdIdEmpresa'] : '1';
        $IdCentro = isset($_POST['hdIdCentro']) ? $_POST['hdIdCentro'] : '1';
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
        $txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : '';
        $ddlAmbiente = (isset($_POST['ddlAmbiente'])) ? $_POST['ddlAmbiente'] : '';
        $ddlZonacorporal = (isset($_POST['ddlZonacorporal'])) ? $_POST['ddlZonacorporal'] : '';
        $txtCodigo = (isset($_POST['txtCodigo'])) ? $_POST['txtCodigo'] : '';
        $ddlTipoEquipo = (isset($_POST['ddlTipoEquipo'])) ? $_POST['ddlTipoEquipo'] : '';
        $txtCantidad = (isset($_POST['txtCantidad'])) ? $_POST['txtCantidad'] : '';
        $txtVideo = (isset($_POST['txtVideo'])) ? $_POST['txtVideo'] : '';
        $hdFoto = (isset($_POST['hdFoto'])) ? $_POST['hdFoto'] : 'no-set';

        if (empty($_FILES['archivo']['name'])) {
            $urlFoto = $hdFoto;
        }
        else {
            $upload_folder  = '../../media/avatar/'.$IdEmpresa.'_'.$IdCentro.'/';
            $url_folder  = 'media/avatar/'.$IdEmpresa.'_'.$IdCentro.'/';

            if (!is_dir($upload_folder))
                mkdir($upload_folder);

            $nombre_archivo = $_FILES['archivo']['name'];
            $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
            $tipo_archivo = $_FILES['archivo']['type'];
            $tamano_archivo = $_FILES['archivo']['size'];
            $tmp_archivo = $_FILES['archivo']['tmp_name'];

            $original = $upload_folder.generateRandomString().'_o.'.$extension;

            $size42 = str_replace('_o', '_s42', $original);
            $size255 = str_replace('_o', '_s255', $original);
            $size640 = str_replace('_o', '_s640', $original);

            if (move_uploaded_file($tmp_archivo, $original)) {
                make_thumb($original, $size42, 42);
                make_thumb($original, $size255, 255);
                make_thumb($original, $size640, 640);

                $urlFoto = str_replace($upload_folder, $url_folder, $original);
            }
            else {
                $urlFoto = $hdFoto;
            }
        }

        $rpta = $objData->Registrar($hdIdPrimary, $IdEmpresa, $IdCentro, $txtNombre, $ddlAmbiente, $ddlZonacorporal, $txtCodigo, $ddlTipoEquipo, $txtCantidad, $txtVideo, $urlFoto, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnEliminar'])) {
        
        $hdIdEquipo = $_POST['hdIdEquipo'];

        $rpta = $objData->EliminarStepByStep($hdIdEquipo, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    
    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>