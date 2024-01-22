<?php
$f = glob("videos/*.mp4");
# videos/04-06-23-54-2.-2023.mp4
# videos/2024-01-19-15-52-2.mp4
# .....+....1....+....2....+
require 'banco.php';
for($i=0;$i<count($f);$i++) {
   $tmp = $f[$i];
   $ano = substr($tmp,7,4);
   $mes = substr($tmp,12,2);
   $dia = substr($tmp,15,2);
   $hor = substr($tmp,18,2);
   $min = substr($tmp,21,2);
   $can = substr($tmp,24,1);
   $sql = "select cliente from videos where nome = '$tmp'";
   $rc = mysqli_query($link,$sql);
   if (mysqli_num_rows($rc) > 0) continue;
   $sql = "insert into videos values('$tmp',$ano,$mes,$dia,$hor,$min,$can,'','lercio');";
   $rc = mysqli_query($link,$sql);
   if ($rc === false) die("ERRO: $sql\n");
   echo "$sql\n";
}

?>
