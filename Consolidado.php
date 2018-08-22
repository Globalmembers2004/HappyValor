<?php 
require_once 'functions/conexion.php';
require_once 'functions/getVentas.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Consolidado Ventas</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>
<body>
<div class="container">
  <div class="page-header text-left">
    <h1>Información migrada de Acepta para Starsoft</h1>
  </div>
  <a href="createExcel1.php" target="_blank">Descargar informe en excel</a>
   <div class="row">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Cuenta</th>
          <th>Periodo</th>
          <th>Subdiario</th>
          <th>Comprobante</th>
          <th>Fecha de registro</th>
          <th>Tipo de anexo</th>
          <th>Código Cliente</th>
          <th>Tipo Documento</th>
          <th>Nro Documento</th>
          <th>Nro Documento Final</th>
          <th>Fecha Documento</th>
          <th>Tipo Doc. Ref.</th>
          <th>Nro. Doc. Ref.</th>
          <th>IGV</th>
          <th>ISC</th>
          <th>Otros Trib.</th>
          <th>Tasa IGV</th>
          <th>Importe</th>
          <th>Conv tc</th>
          <th>TC</th>
          <th>Glosa</th>
          <th>Glosa Mov</th>
          <th>Anulado</th>
          <th>D-H</th>
          <th>RUC Cliente</th>
          <th>Razon Social</th>
          <th>Centro de Costo</th>
          <th>Fecha Venc</th>
          <th>Fecha Doc ref</th>
          <th>Exportacion</th>
          <th>Nro. File</th>
          <th>Exonerado</th>
          <th>Otros Cargos</th>
        </tr>
      </thead>
      <tbody>
      <?php 
      $informe = getVentas();
      while($row = $informe->fetch_array(MYSQLI_ASSOC))
      {
        echo '<tr>';
        echo "<td>$row[cuenta]</td>";
        echo "<td>$row[annomes]</td>";
        echo "<td>$row[subdiario]</td>";
        echo "<td>$row[comprobante]</td>";
        echo "<td>$row[fecha_registro]</td>";
        echo "<td>$row[tipo_anexo]</td>";
        echo "<td>$row[cod_cliente]</td>";
        echo "<td>$row[tipo_doc]</td>";
        echo "<td>$row[nro_doc]</td>";
        echo "<td>$row[nro_doc_final]</td>";
        echo "<td>$row[fecha_doc]</td>";
        echo "<td>$row[tipo_doc_ref]</td>";
        echo "<td>$row[nro_doc_ref]</td>";
        echo "<td>$row[igv]</td>";
        echo "<td>$row[valor_isc]</td>";
        echo "<td>$row[otros_trib]</td>";
        echo "<td>$row[tasa_igv]</td>";
        echo "<td>$row[importe]</td>";
        echo "<td>$row[conv_tc]</td>";
        echo "<td>$row[tc]</td>";
        echo "<td>$row[glosa]</td>";
        echo "<td>$row[glosa_mov]</td>";
        echo "<td>$row[anulado]</td>";
        echo "<td>$row[debe_haber]</td>";
        echo "<td>$row[ruc_cliente]</td>";
        echo "<td>$row[raz_social]</td>";
        echo "<td>$row[cen_costo]</td>";
        echo "<td>$row[fec_vencimiento]</td>";
        echo "<td>$row[fec_doc_ref]</td>";
        echo "<td>$row[exportacion]</td>";
        echo "<td>$row[nro_file]</td>";
        echo "<td>$row[exonerado]</td>";
        echo "<td>$row[otr_cargos]</td>";
        echo '</tr>';
      }
      ?>
      </tbody>
    </table>
  </div> 
</div>
</body>
</html>