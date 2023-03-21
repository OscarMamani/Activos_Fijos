<?php  include ("../template/cabecera.php");
session_start();
session_destroy();
header('location:../index.php');

?>
