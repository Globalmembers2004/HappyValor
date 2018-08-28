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
    // require '../../common/functions.php';
    require '../../bussiness/informes.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $idperfil = $sesion->get("idperfil");

    $rpta = '0';
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clsInformes();

    if (isset($_POST['btnGuardar'])){
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
        $ddlPeriodo1 = (isset($_POST['ddlPeriodo1'])) ? $_POST['ddlPeriodo1'] : 0;
        $ddlPeriodo2 = (isset($_POST['ddlPeriodo2'])) ? $_POST['ddlPeriodo2'] : 0;
        $objData->Listar($ddlPeriodo1, $ddlPeriodo2);
          header('Content-Type: text/csv; charset=utf-8');  
          header('Content-Disposition: attachment; filename=data.csv');  
          $output = fopen("php://output", "w");  
          fputcsv($output, array('periodo', 'centroCosto', 'TipoFamilia', 'Producto', 'cantidad', 'costo','valor'));
          $query = "SELECT * from SUMINISTROS";  
          $result = mysqli_query($connect, $query);  
          while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))  
          {  
               fputcsv($output, $row);  
          }  
          fclose($output);  
    }  

    elseif (isset($_POST['btnEliminar'])) {
        $hdIdInventario = $_POST['hdIdInventario'];
        $rpta = $objData->EliminarStepByStep($hdIdInventario, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    
    // $jsondata = array('rpta' => 1, 'titulomsje' => $titulomsje, 'contenidomsje' => "CSV Importado");
    // //$jsondata = array('rpta' => $rpta_im);
    // echo json_encode($jsondata);
}
?>