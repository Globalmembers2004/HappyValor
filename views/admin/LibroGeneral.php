 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Libro Ventas para exportar</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
      </head>  
      <body>  
           <br /><br />  
           <div class="container" style="width:900px;">  
                <h2 align="center">Libro Ventas para exportar a CSV</h2>  
                <h3 align="center">Libro Ventas para SUNAT</h3>                 
                <br />  
                <form method="post" action="export.php" align="center">  
                     <input type="submit" name="export" value="CSV Export" class="btn btn-success" />  
                </form>  
                <br />  
                <div class="table-responsive" id="employee_table">  
                     <table class="table table-bordered">  
                          <tr>  
                               <th width="5%">Tipo</th>  
                               <th width="5%">Serie</th>  
                               <th width="10%">Numero</th>  
                               <th width="35%">Cliente</th>  
                               <th width="10%">Gravado</th>  
                               <th width="10%">IGV</th>  
                               <th width="10%">Total</th>
                               <th width="5%">Serie Referencia</th>  
                               <th width="10%">Numero Referencia</th>
                          </tr>  
                     <?php  
                     while($row = mysqli_fetch_array($result))  
                     {  
                     ?>  
                          <tr>  
                               <td><?php echo $row["tipo"]; ?></td>  
                               <td><?php echo $row["serie"]; ?></td>  
                               <td><?php echo $row["numero"]; ?></td>  
                               <td><?php echo $row["cliente"]; ?></td>  
                               <td><?php echo $row["gravado"]; ?></td>  
                               <td><?php echo $row["igv"]; ?></td>  
                               <td><?php echo $row["total"]; ?></td>  
                               <td><?php echo $row["serie_referencia"]; ?></td>  
                               <td><?php echo $row["nro_referencia"]; ?></td>  
                          </tr>  
                     <?php       
                     }  
                     ?>  
                     </table>  
                </div>  
           </div>  
      </body>  
 </html>  