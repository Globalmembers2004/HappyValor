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
    require '../../bussiness/suministro.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $idperfil = $sesion->get("idperfil");

    $rpta = '0';
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clsSuministro();

    if (isset($_POST['btnGuardar'])){
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';

        $ddlTabla = (isset($_POST['ddlTabla'])) ? $_POST['ddlTabla'] : 0;
        $ddlPeriodo = (isset($_POST['ddlPeriodo'])) ? $_POST['ddlPeriodo'] : 0;
        $txtDescripcion = (isset($_POST['txtDescripcion'])) ? $_POST['txtDescripcion'] : 1;

        $txtSearch = (isset($_POST['txtSearch'])) ? $_POST['txtSearch'] : '0';

        $csv = (isset($_FILES['txtFile']["name"])) ? $_FILES['txtFile']["name"] : '0';
        $filename = (isset($_FILES['txtFile']["tmp_name"])) ? $_FILES['txtFile']["tmp_name"] : '0';

        if($_FILES["txtFile"]["size"] > 0)
        {
            $file = file_get_contents($filename);
            $lines = explode("\n", $file);
            $array = array();
            $rpta_im = array();

            switch ($ddlTabla) {
                case 'tmp_productos':
                    $rpta_im[] = $objData->BorrarTabla('tmp_productos');
                    foreach ($lines as $line) {
                        $array = str_getcsv($line);
                        if ($array[0] <>''){
                            $rpta_im[] = $objData->ImportarProducto($array[0],$array[1],$array[2]);
                        }
                    }
                    $rpta_im[] = $objData->AdicionarProducto();
                    break;
                case 'tmp_familia':
                    $rpta_im[] = $objData->BorrarTabla('tmp_familia');
                    foreach ($lines as $line) {
                        $array = str_getcsv($line);
                        if ($array[0] <>''){
                            $rpta_im[] = $objData->ImportarFamilia($array[0],$array[1]);
                        }
                    }
                    $rpta_im[] = $objData->AdicionarFamilia();
                    break;
                case 'tmp_centrocosto':
                    $rpta_im[] = $objData->BorrarTabla('tmp_centrocosto');
                    foreach ($lines as $line) {
                        $array = str_getcsv($line);
                        if ($array[0] <>''){
                            $rpta_im[] = $objData->ImportarCentroCosto($array[0],$array[1]);
                        }
                    }
                    $rpta_im[] = $objData->AdicionarCentroCosto();
                    break;
                case 'tmp_costo_producto':
                    $rpta_im[] = $objData->BorrarTabla('tmp_costoproducto');
                    foreach ($lines as $line) {
                        $array = str_getcsv($line);
                        if ($array[0] <>''){
                            $rpta_im[] = $objData->ImportarCostoProducto($array[0],$array[1],$ddlPeriodo);
                        }
                    }
                    $rpta_im[] = $objData->AdicionarCosto($ddlPeriodo);
                    break;
                case 'tmp_inventario':
                    $rpta_im[] = $objData->BorrarTabla('tmp_inventario');
                    foreach ($lines as $line) {
                        $array = str_getcsv($line);
                        if ($array[0] <>''){
                            $rpta_im[] = $objData->ImportarInventario($array[0],$array[1],$ddlPeriodo,$array[2]);
                        }
                    }
                    $rpta_im[] = $objData->AdicionarInventario($ddlPeriodo);
                    break;
            }
            /*
            $file = fopen($filename, "r");
            while (($getData = fgetcsv($file, 10000, ";")) !== FALSE)
            {
                $rpta_im = $getData;
                $rpta_im[] = $objData->Importar($getData[0],$getData[1],$getData[2]);
            }
            fclose($file);
            */
        }

        //$rpta = $objData->Registrar();
    }
    elseif (isset($_POST['btnEliminar'])) {
        $hdIdInventario = $_POST['hdIdInventario'];
        $rpta = $objData->EliminarStepByStep($hdIdInventario, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    
    $jsondata = array('rpta' => 1, 'titulomsje' => $titulomsje, 'contenidomsje' => "CSV Importado");
    //$jsondata = array('rpta' => $rpta_im);
    echo json_encode($jsondata);
}
?>