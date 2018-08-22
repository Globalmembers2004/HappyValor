<?php
if ($_POST){
    require '../../common/sesion.class.php';
    require '../../adata/Db.class.php';
    require '../../bussiness/centro.php';

    $sesion = new sesion();
    $objCentro = new clsCentro();
    
    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'es';

    $hdIdCentro = $_POST['hdIdCentro'];
    $sesion->set('idcentro', $hdIdCentro);

    $rsCentro = $objCentro->Listar('2', $hdIdCentro, '');
    $nombre_centro = (count($rsCentro) > 0) ? $rsCentro[0]['tm_nombre'] : 'Centro sin especificar';

    $sesion->set('nombre_centro', $nombre_centro);
    
    header('location: ../../index.php?lang=' . $lang);
}
?>
