<?php
function show($str) {
   echo "<pre><h1>";
   print_r($str);
   echo "</pre></h1>";
}
function titulos($str) {
   $texto = substr($str,7,strlen($str)-4);
   $p = explode('-',$texto);
   $ano     = $p[0];
   $mes     = $p[1];
   $dia     = $p[2];
   $hora    = $p[3];
   $minuto  = $p[4];
   $canal   = intval(substr($p[5],0,2));
   $texto = sprintf("%s/%s/%s %s:%s Canal: %02d",
      $dia,$mes,$ano,$hora,$minuto,$canal);
   return($texto);
} // videos/1-2023-03-25-22-58.mp4

$canais = array();
require 'banco.php';
$arquivos = array();
$rc = mysqli_query($link,"select nome from videos");
$linhas = mysqli_fetch_all($rc);
for($i=0;$i<count($linhas)-1;$i++)
   $arquivos[] = "videos/";$linhas[$i][0];
$total = count($arquivos);

function getarray($campo) {
   require 'banco.php';
   $cliente = 'lercio';
   $onde = "where cliente = '$cliente' order by $campo";
   $rc = mysqli_query($link,"select distinct $campo from videos $onde;");
   $l = mysqli_fetch_all($rc);
   for($i=0;$i<count($l);$i++)
      $nomes[] = $l[$i][0];
   return $nomes;
}
function botoes($login,$nome_dados) {
   echo "<link rel=stylesheet type=text/css href=estilo.css />\n";
   date_default_timezone_set('America/Sao_Paulo');
   require 'banco.php';
   $cliente = 'lercio';
   if (count($nome_dados)>0) {
      $nomes = $nome_dados[0];
      $dados = $nome_dados[1];
      $h1 = "Selecao ";
      $sql = "select count(*) from videos where cliente = '$cliente' ";
      for($i=0;$i<count($nomes);$i++) {
         if (strlen($dados[$i])) {
            $sql .= "and ".$nomes[$i]." like '".$dados[$i]."' ";
            $h1 .= $nomes[$i]."=".$dados[$i]." ";
         }
      }
   } else $sql = "select count(*) from videos;";
   $anos    = getarray('ano');
   $meses   = getarray('mes');
   $dias    = getarray('dia');
   $horas   = getarray('hora');
   $minutos = getarray('minuto');
   $canais  = getarray('canal');
   rsort($anos);
   rsort($meses);
   rsort($dias);
   rsort($horas);
   rsort($minutos);
   $rc = mysqli_query($link,$sql);
   $l = mysqli_fetch_row($rc);
   $total = $l[0];
   echo "<h1>Sistema de CFTV</h1>\n";
   if (!isset($h1)) $h1 = "Selecao de $total gravacoes - ";
   echo "<h2>$h1 Login $login <a href=logoff.php>Logoff</a></h2>\n";
   echo "<form name=form1 method=post>\n";
   $s = "onchange='selecao(this);'";
   echo "<select name=ano $s><option value=''>Ano\n";
   for($i=0;$i<count($anos);$i++) 
      echo "<option value=$anos[$i]>$anos[$i]\n";
   echo "</select>";
   echo "<select name=mes $s><option value=''>Meses\n";
   for($i=0;$i<count($meses);$i++) 
      echo "<option value=$meses[$i]>$meses[$i]\n";
   echo "</select>";
   echo "<select name=dia $s><option value=''>Dias\n";
   for($i=0;$i<count($dias);$i++) 
      echo "<option value=$dias[$i]>$dias[$i]\n";
   echo "</select>";
   echo "<select name=hora $s><option value=''>Horas\n";
   for($i=0;$i<count($horas);$i++) 
      echo "<option value=$horas[$i]>$horas[$i]\n";
   echo "</select>";
   echo "<select name=minuto $s><option value=''>Minutos\n";
   for($i=0;$i<count($minutos);$i++) 
      echo "<option value=$minutos[$i]>$minutos[$i]\n";
   echo "</select>";
   echo "<select name=canal $s><option value=''>Canais\n";
   for($i=0;$i<count($canais);$i++) 
      echo "<option value=$canais[$i]>Canal $canais[$i]\n";
   echo "</select>";
   echo "<input type=submit value=Enviar />\n";
   if ($login == 'admin') 
      echo "<a href=cria.php>Reset passwords</a>\n";
   echo "</form>\n";
}
?>
