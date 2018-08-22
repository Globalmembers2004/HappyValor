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
    require '../../bussiness/usuarios.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $idperfil = $sesion->get("idperfil");
    $IdEmpresa = $sesion->get("idempresa");

    $idusuario_plataforma = $sesion->get("idusuario_plataforma");

    $objData = new clsUsuario();

    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'es';

    $translate = new Translator($lang);

    $rpta = '0';
    $titulomsje = '';
    $contenidomensaje = '';

    $hdIdUsuario = isset($_POST['hdIdUsuario']) ? $_POST['hdIdUsuario'] : '0';
    $hdPregunta = isset($_POST['hdPregunta']) ? $_POST['hdPregunta'] : '1';

    if (isset($_POST['btnGuardar'])){
        $IdCentro = isset($_POST['ddlCentro']) ? $_POST['ddlCentro'] : '0';
        $IdCenCosto = isset($_POST['ddlCenCosto']) ? $_POST['ddlCenCosto'] : '0';
        $ddlTipoPersona = isset($_POST['ddlTipoPersona']) ? $_POST['ddlTipoPersona'] : '0';
        $ddlPerfil = isset($_POST['ddlPerfil']) ? $_POST['ddlPerfil'] : '0';
        $hdIdPersona = isset($_POST['hdIdPersona']) ? $_POST['hdIdPersona'] : '0';
        $txtNombre = isset($_POST['txtNombre']) ? $_POST['txtNombre'] : '';
        $txtClave = isset($_POST['txtClave']) ? $_POST['txtClave'] : '';
        $txtNombres = isset($_POST['txtNombres']) ? $_POST['txtNombres'] : '';
        $txtApellidos = isset($_POST['txtApellidos']) ? $_POST['txtApellidos'] : '';
        $txtNumeroDoc = isset($_POST['txtNumeroDoc']) ? $_POST['txtNumeroDoc'] : '';
        $txtEmail = isset($_POST['txtEmail']) ? $_POST['txtEmail'] : '';
        $txtTelefono = isset($_POST['txtTelefono']) ? $_POST['txtTelefono'] : '';
        $hdFoto = isset($_POST['hdFoto']) ? $_POST['hdFoto'] : 'no-set';

        if (empty($_FILES['archivo']['name'])) {
            $urlFoto = $hdFoto;
        }
        else {
            $upload_folder  = '../../media/images/'.$IdEmpresa.'_'.$IdCentro.'/';
            $url_folder  = 'media/images/'.$IdEmpresa.'_'.$IdCentro.'/';

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

        $objData->Registrar($hdIdUsuario, $IdEmpresa, $IdCentro, $ddlPerfil, $hdIdPersona, $ddlTipoPersona, '', $txtNombre, $txtNombres, $txtApellidos, $txtClave, 0, $txtNumeroDoc, '', 0, '', $txtEmail, $txtTelefono, $urlFoto, "cliente", $idusuario, $IdCenCosto, $rpta, $titulomsje, $contenidomensaje);
    }
    // elseif (isset($_POST['btnImportarDataPreliminar'])) {
    //     $txtCurrentPassword = isset($_POST['txtCurrentPassword']) ? $_POST['txtCurrentPassword'] : '';
    //     $txtNewPassword = isset($_POST['txtNewPassword']) ? $_POST['txtNewPassword'] : '';
    //     $txtConfirmNewPassword = isset($_POST['txtConfirmNewPassword']) ? $_POST['txtConfirmNewPassword'] : '';

    //     $objData->Usuario_ImportData($idusuario_plataforma, $IdEmpresa, $IdCentro, $hdPregunta, $idusuario, $rpta, $titulomsje, $contenidomensaje);
    // }
    elseif (isset($_POST['btnEliminarUsuario']))
        $objData->EliminarStepByStep($hdIdUsuario, $idusuario, $rpta, $titulomsje, $contenidomensaje);
    elseif (isset($_POST['btnImportarDataPreliminar'])){
        $IdCentro = $sesion->get("idcentro");
        $objData->Usuario_ImportData($idusuario_plataforma, $IdEmpresa, $IdCentro, $hdPregunta, $idusuario, $rpta, $titulomsje, $contenidomensaje);
    }
    elseif (isset($_POST['btnCambiarClave'])){
        $hdIdUsuarioClave = isset($_POST['hdIdUsuarioClave']) ? $_POST['hdIdUsuarioClave'] : '0';
        $txtNewPassword = isset($_POST['txtNewPassword']) ? $_POST['txtNewPassword'] : '';

        $objData->ActualizarUserPass($hdIdUsuarioClave, $txtNewPassword, $idusuario, $rpta, $titulomsje, $contenidomensaje);
    }
    
    $jsondata = array('rpta' => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomensaje' => $translate->__s($contenidomensaje));
    echo json_encode($jsondata);
}
?>