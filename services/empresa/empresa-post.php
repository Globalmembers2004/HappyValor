<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
    $user_error = 'Access denied - direct call is not allowed...';
    trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

if ($_POST){
    require '../../adata/Db.class.php';
    require '../../common/sesion.class.php';
    require '../../common/class.translation.php';
    require '../../bussiness/empresa.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    
    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'es';
    $translate = new Translator($lang);

    $rpta = 0;
    $titulomsje = '';
    $contenidomsje = '';
    $urlImagen = '';

    // $IdEmpresa = 1;
    // $IdCentro = 1;

    $objData = new clsEmpresa();

    $hdIdPrimary = $_POST['hdIdPrimary'];
    
    if (isset($_POST['btnGuardar'])){
        require '../../common/functions.php';
        
        $txtNombreComercial = $_POST['txtNombreComercial'];
        $txtRazonSocial = $_POST['txtRazonSocial'];
        $txtNumeroDoc = $_POST['txtNumeroDoc'];
        $txtDireccionFiscal = $_POST['txtDireccionFiscal'];
        $txtDescripcionComercial = $_POST['txtDescripcionComercial'];
        $txtEslogan = $_POST['txtEslogan'];
        $txtTelefono = $_POST['txtTelefono'];
        $txtEmail = $_POST['txtEmail'];
        $txtPaginaWeb = $_POST['txtPaginaWeb'];
        $txtObservaciones = $_POST['txtObservaciones'];
        $hdFoto = (isset($_POST['hdFoto'])) ? $_POST['hdFoto'] : 'no-set';

        if (empty($_FILES['archivo']['name']))
            $urlImagen = $hdFoto;
        else {
            $upload_folder  = '../../media/images/';
            $url_folder  = 'media/images/';

            if (!is_dir($upload_folder))
                mkdir($upload_folder);

            $nombre_archivo = $_FILES['archivo']['name'];
            $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
            $tipo_archivo = $_FILES['archivo']['type'];
            $tamano_archivo = $_FILES['archivo']['size'];
            $tmp_archivo = $_FILES['archivo']['tmp_name'];

            // $nombre_archivo = trim($nombre_archivo);
            // $nombre_archivo = str_replace(' ', '', $nombre_archivo);

            $original = $upload_folder.generateRandomString().'_o.'.$extension;

            $size42 = str_replace('_o', '_s42', $original);
            $size140 = str_replace('_o', '_s140', $original);
            $size225 = str_replace('_o', '_s225', $original);
            $size640 = str_replace('_o', '_s640', $original);

            if (move_uploaded_file($tmp_archivo, $original)) {
                make_thumb($original, $size42, 42);
                make_thumb($original, $size140, 140);
                make_thumb($original, $size225, 225);
                make_thumb($original, $size640, 640);

                $urlImagen = str_replace($upload_folder, $url_folder, $original);
            }
            else
                $urlImagen = $hdFoto;
        }

        $objData->Registrar($hdIdPrimary, $txtNombreComercial, $txtRazonSocial, $txtDireccionFiscal, $txtDescripcionComercial, $txtEslogan, $txtNumeroDoc, $txtEmail, $txtTelefono, $txtPaginaWeb, $txtObservaciones, $urlImagen, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnEliminar']))
        $objData->EliminarStepByStep($hdIdPrimary, $idusuario, $rpta, $titulomsje, $contenidomsje);
    
    $jsondata = array("rpta" => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomsje' => $translate->__s($contenidomsje));
    echo json_encode($jsondata);
}
?>