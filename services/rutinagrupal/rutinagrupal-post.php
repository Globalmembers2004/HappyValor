<?php
include("../../common/sesion.class.php");
require('../../common/class.translation.php');
include('../../adata/Db.class.php');
include('../../common/functions.php');
include('../../bussiness/rutinagrupal.php');

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$rpta = '0';
$titulomsje = '';
$contenidomsje = '';

$Id = 0;
$Codigo = '';
$Nombre = '';
$IdCargo = 0;
$IdArea = 0;
$Turno = '';
$IdSubCategoria = 0;

$objData = new clsrutinagrupal();
$urlLogo = '';

if ($_POST){
    if (isset($_POST['btnGuardar'])){

        $IdEmpresa = isset($_POST['hdIdEmpresa']) ? $_POST['hdIdEmpresa'] : '1';
        $IdCentro = isset($_POST['hdIdCentro']) ? $_POST['hdIdCentro'] : '1';   
        $idusuario = isset($_POST['idusuario']) ? $_POST['idusuario'] : '1'; 
        $Id = isset($_POST['hdIdPrimary']) ? $_POST['hdIdPrimary'] : '0';
        $txtNombreRutina = isset($_POST['txtNombreRutina']) ? $_POST['txtNombreRutina'] : '';
        $txtMinutos = isset($_POST['txtMinutos']) ? $_POST['txtMinutos'] : '';
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

        $rpta = $objData->Registrar($Id, $IdEmpresa, $IdCentro, $txtNombreRutina, $txtMinutos, $urlFoto, $idusuario);

        $titulomsje = 'Registrado correctamente';
        $contenidomsje = 'La operacion se completo satisfactoriamente';
    }
    elseif (isset($_POST['btnEliminar'])) {

        $hdIdrutinagrupal = $_POST['hdIdrutinagrupal'];
        
        $rpta = $objData->EliminarStepByStep($hdIdrutinagrupal, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>