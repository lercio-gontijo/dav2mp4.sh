<?
require 'banco.php';
#mysqli_query($link,"start transaction");
$r=mysqli_query($link,"select nome from videos");
$l=mysqli_fetch_all($r);
$v=glob("videos/*");
echo "Existem ".count($v)." videos e ".count($l)." linhas na tabela\n";
foreach($l as $linhas) {
   $video = $linhas[$i][0];
   if (!file_exists($video)) {
      mysqli_query($link,"delete from videos where nome = '$video';");
      echo "-- DELETE VIDEO NAO EXISTE $video\n";
   }
}
$r=mysqli_query($link,"select nome from videos");
$l=mysqli_fetch_all($r);
echo "Existem ".count($v)." videos e ".count($l)." linhas na tabela\n";
foreach($v as $video) {
   $comando="ffprobe -i $video -show_entries format=duration -v quiet -of csv=\"p=0\" -sexagesimal >temp.txt";
   system($comando);
   $arq = fopen("temp.txt","r");
   $dur = fgets($arq,200);
   $dur = str_replace("\n",'',$dur);
   if (strpos($dur,'.')==False) {
      mysqli_query($link,"delete from videos where nome = '$video';");
      echo "-- DELETE $video $dur\n";
      continue;
   }
   $d = explode('.',$dur);
   $dur = $d[0];
   $sql = "update videos set tempo = '$dur' where nome = '$video';";
   $r=mysqli_query($link,$sql);
   if ($rc === False) {
      $n = ['nome','ano','mes','dia','hora','minuto'];
      $ano = substr($video,7,4);
      $mes = substr($video,7,4);
      $dia = substr($video,7,4);
      $hor = substr($video,7,4);
      $min = substr($video,7,4);
      $can = intval(substr($video,7,4));
      $c = [$video,$ano,$mes,$dia,$hor,$min,$ca,$dur];
      $sql = "insert into videos values( ";
      for($i=0;$i<count($n);$i++) 
         $sql .= $n[$i]."=".$c[$i].", ";
      $sql .= "tempo='$dur', cliente='lercio');";
      $r=mysqli_query($link,$sql);
   }
   echo "$sql\n";
}
#videos/2023-05-03-13-31-2.ogv
#.....+.7....12.14.17.20.23
?>

