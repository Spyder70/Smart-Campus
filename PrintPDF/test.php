<?php
$clean="140.00";
$clean = ltrim($clean, '0');
  //remove decimal point if an integer ie. 140. becomes 140
  $clean = rtrim($clean, '.');
  echo $clean;
?>
