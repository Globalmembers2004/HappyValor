<?php 
function getAllListsAndVideos()
{
  $mysqli = getConnexion();
  $query = 'SELECT * FROM `regventas` ';
  return $mysqli->query($query);
}