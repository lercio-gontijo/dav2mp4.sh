<?php
if (isset($argv[1]))
   $video = $argv[1];
else
   $video = $_GET['n'];
if (strlen($video)==0) die("FALTANDO DADOS");
$p = explode('-',$video);
$ano = $p[0];
$mes = $p[1];
$dia = $p[2];
$hor = $p[3];
$min = $p[4];
$can = $p[5];
$can = intval(substr($can,0,2));

require 'banco.php';

$nome = "videos/$ano-$mes-$dia-$hor-$min-$can.mp4";

echo "PROCESSANDO $nome\n";
$sql = "select nome from videos where nome like '$nome'";
$rc = mysqli_query($link,$sql);
echo "$sql\n";
if (mysqli_num_rows($rc)>0) {
   echo "VIDEO $nome JA EXISTE\n";
   exit(0);
} else {
   $sql = "insert into videos values('$nome',$ano,$mes,$dia,$hor,$min,$can,'','lercio');";
   echo "$sql\n";
   $rc = mysqli_query($link,$sql);
}
//echo "$sql ";
if ($rc === False) 
   echo "Erro inserindo dados: $sql\n";
else 
   echo "SUCESSO: $sql\n";
?>

