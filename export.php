<?php  
      //export.php  
 if(isset($_POST["export"]))  
 {  
      // $connect = mysqli_connect("localhost", "root", "", "happyland");  
      $connect = mysqli_connect("localhost", "atinperu_happyland", "re3fq.x(p8=}", "atinperu_happyland");      
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=data.csv');  
      $output = fopen("php://output", "w");  
      fputcsv($output, array('periodo', 'contador', 'contador1', 'fecha', 'otro', 'tipo','serie', 'numero', 'numero1', 'doc', 'documento', 'cliente','isc', 'gravado', 'opeexo', 'igv', 'otroope', 'opeina','opegra', 'descue', 'otros1', 'otros2', 'otros3', 'total','moneda', 'tc','fecha_referencia', 'tip_referencia', 'serie_referencia', 'nro_referencia','uno', 'dos','tres', 'estado', 'fin'));  
      $query = "SELECT * from regventas";  
      $result = mysqli_query($connect, $query);  
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);  
 }  
 ?>  