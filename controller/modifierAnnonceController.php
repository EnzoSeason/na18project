<?php session_start();
//var_dump($_SESSION);var_dump($_POST);
$today = getdate();
var_dump($today);
echo $today['year'].'-'.$today['mon'].'-'.$today['mday'];
?>