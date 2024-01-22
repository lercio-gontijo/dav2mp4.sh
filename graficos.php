<?php
echo "<pre>";
require 'banco.php';
$rc = mysqli_query($link,"select * from videos");
$linhas = mysqli_fetch_all($rc);
$mes1 = $linhas[0][2];
$mesa = array();
for($i=0,$j=0;$i<count($linhas);$i++) {
   $mes = $linhas[$i][2];
   if ($mes > $mesa[count($mesa)-1]) {
      $mesa[] = $mes;
   }
}
print_r($mesa);
for($i=0;$i<count($mesa);$i++) {
   $sql = "select distinct dia from videos where mes = '".$mesa[$i]."';";
   echo "$sql\n";
   $rc = mysqli_query($link,$sql);
   $linhas = mysqli_fetch_all($rc);
   $mesa[$i] = array();
   for($j=0;$i<count($linhas);$j++) {
      $mesa[$i][] = $linhas[$j][0];
   }
   print_r($mesa);
}
print_r($mesa);
?>


