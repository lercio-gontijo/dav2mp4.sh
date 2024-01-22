<?php
ini_set("display_errors","1");
$canal = $_GET['canal'];
require 'banco.php';
$onde = "where canal = $canal";
$sql = "select * from videos $onde;";
$rc = mysqli_query($link,$sql);
$l = mysqli_fetch_all($rc);
$j = json_encode($l);
echo "$j";
?>

