<?php 
function getVentas()
{
  $mysqli = getConnexion();
  $query = 'SELECT * FROM `destino`';
  return $mysqli->query($query);
}