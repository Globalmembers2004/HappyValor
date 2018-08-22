<?php 
function getConnexion()
{
  $mysqli = new Mysqli('localhost', 'adescorp_valoriz', 're3fq.x(p8=}', 'adescorp_valorizacion');
  if($mysqli->connect_errno) exit('Error en la conexión: ' . $mysqli->connect_errno);
  $mysqli->set_charset('utf8');
  return $mysqli;
}