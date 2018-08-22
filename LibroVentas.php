<?php 
require_once 'functions/conexion.php';
require_once 'functions/getAllListsAndVideos.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Exportar Libro Ventas</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>
<body>
<div class="container">
  <div class="page-header text-left">
    <h1>Libro de Ventas</h1>
  </div>
  <a href="createExcel.php" target="_blank">Descargar informe en excel</a>
   <div class="row">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Periodo</th>
          <th>Contador</th>
          <th>Contador1</th>
          <th>Fecha</th>
          <th>Otro</th>
          <th>Tipo</th>
          <th>Serie</th>
          <th>Numero</th>
          <th>Numero1</th>
          <th>Doc</th>
          <th>Documento</th>
          <th>Cliente</th>
          <th>ISC</th>
          <th>Gravado</th>
          <th>Ope.Exoneradas</th>
          <th>IGV</th>
          <th>Ot.Operaciones</th>
          <th>Op.Inafectas</th>
          <th>Op.Gravadas</th>
          <th>Descuentos</th>
          <th>Otros 1</th>
          <th>Otros 2</th>
          <th>Otros 3</th>
          <th>Total</th>
          <th>Moneda</th>
          <th>TC</th>
          <th>Fecha Referencia</th>
          <th>Tipo Referencia</th>
          <th>Serie Referencia</th>
          <th>Número Referencia</th>
          <th>Docum. 1</th>
          <th>Docum. 2</th>
          <th>Docum. 3</th>
          <th>Estado</th>
          <th>Fin</th>
        </tr>
      </thead>
      <tbody>
      <?php 
      $informe = getAllListsAndVideos();
      while($row = $informe->fetch_array(MYSQLI_ASSOC))
      {
        echo '<tr>';
        echo "<td>$row[periodo]</td>";
        echo "<td>$row[contador]</td>";
        echo "<td>$row[contador1]</td>";
        echo "<td>$row[fecha]</td>";
        echo "<td>$row[otro]</td>";
        echo "<td>$row[tipo]</td>";
        echo "<td>$row[serie]</td>";
        echo "<td>$row[numero]</td>";
        echo "<td>$row[numero1]</td>";
        echo "<td>$row[doc]</td>";
        echo "<td>$row[documento]</td>";
        echo "<td>$row[cliente]</td>";
        echo "<td>$row[isc]</td>";
        echo "<td>$row[gravado]</td>";
        echo "<td>$row[opeexo]</td>";
        echo "<td>$row[igv]</td>";
        echo "<td>$row[otroope]</td>";
        echo "<td>$row[opeina]</td>";
        echo "<td>$row[opegra]</td>";
        echo "<td>$row[descue]</td>";
        echo "<td>$row[otros1]</td>";
        echo "<td>$row[otros2]</td>";
        echo "<td>$row[otros3]</td>";
        echo "<td>$row[total]</td>";
        echo "<td>$row[moneda]</td>";
        echo "<td>$row[tc]</td>";
        echo "<td>$row[fecha_referencia]</td>";
        echo "<td>$row[tip_referencia]</td>";
        echo "<td>$row[serie_referencia]</td>";
        echo "<td>$row[nro_referencia]</td>";
        echo "<td>$row[uno]</td>";
        echo "<td>$row[dos]</td>";
        echo "<td>$row[tres]</td>";
        echo "<td>$row[estado]</td>";
        echo "<td>$row[fin]</td>";

        echo '</tr>';
      }
      ?>
      </tbody>
    </table>
  </div> 
</div>
</body>
</html>