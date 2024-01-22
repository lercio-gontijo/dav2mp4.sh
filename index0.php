<?php
session_start();
$login = $_SESSION['usuario'];
ini_set('display_errors',1);
require 'funcoes.php';
$cliente = 'lercio';
if ($_POST) {
   if (count($_POST) == 3) {
      header("Refresh: 2; url=index2.php");
      $usuario = $_POST['usuario'];
      echo "<meta charset=UTF-8 content='width=device-width, initial-scale= 1'>\n";
      echo "<link rel=stylesheet type=text/css href=estilo.css />\n";
      echo "<h1>Usuario: $usuario em teste</h1>";
      $chave   = $_POST['campo12'];
      $existe  = $_POST['existe'];
      $p = json_decode($existe);
      $p[0] = str_replace("\n",'',$p[0]);
      $p[1] = str_replace("\n",'',$p[1]);
      $senha = base64_encode($chave);
      if ($usuario == 'admin' && $senha == $p[0]) 
         $_SESSION['usuario'] = $usuario;
      else if ($usuario == 'operador' && $senha == $p[1]) 
         $_SESSION['usuario'] = $usuario;
      else { echo "Senha invalida\n"; die; }
      echo "<h1>Usuario: $usuario OK</h1>";
   } else {
      echo "<meta charset=UTF-8 content='width=device-width, initial-scale= 1'>\n";
      echo "<link rel=stylesheet type=text/css href=estilo.css />\n";
      require 'banco.php';
      $canal      = $_POST['canal'];
      $ano        = $_POST['ano'];
      $mes        = $_POST['mes'];
      $dia        = $_POST['dia'];
      $hora       = $_POST['hora'];
      $minuto     = $_POST['minuto'];
      if (strlen($mes)) $mes = sprintf("%02d",$mes);
      if (strlen($dia)) $dia = sprintf("%02d",$dia);
      if (strlen($hora)) $hora = sprintf("%02d",$hora);
      if (strlen($minuto)) $minuto = sprintf("%02d",$minuto);
      $nome = "videos/";
      $sql = "select nome,tempo from videos where cliente = '$cliente' ";
      $nomes = ['ano','dia','mes','hora','minuto','canal'];
      $dados = [$ano,$dia,$mes,$hora,$minuto,$canal];
      $nome_dados = [$nomes,$dados];
      for($w=0;$w<count($nomes);$w++) {
         if (strlen($dados[$w])) $sql .= "and ".$nomes[$w]."= '".$dados[$w]."' ";
      }
      $rc = mysqli_query($link,$sql);
      $total = mysqli_num_rows($rc);
      $sql .= "order by nome desc limit 30";
      $rc = mysqli_query($link,$sql);
      if ($rc === False) die("Erro lendo banco de videos: ".$sql."\n");
      $linhas = mysqli_fetch_all($rc);
      if (count($linhas)>30) 
         $total = 30;
      else $total = count($linhas);
      echo "<h2>Selecao de $total gravacoes encontrados - Exibindo $total</h2>\n";
      botoes($login,$nome_dados);
      echo "<br><br>\n";
      $videos = array();
      ?> <style>a{color:blue};a:hover{text-decoration:underline};</style> <?php
      for($i=0;$i<count($linhas);$i++) {
         $video = $linhas[$i][0];
         $tempo = $linhas[$i][1];
         $videos[] = $video;
         $nome = substr($video,0,strlen($video)-4);
         $texto = titulos("$video")." $tempo ";
         if ($login == 'admin') 
            $texto .= "<a href=delete.php?v=$video>DEL</a>\n";
         echo "<div class=videobox>$texto<video class=videobox controls preload=none>\n";
         echo "<source src=$nome.mp4 type=video/mp4> \n";
         echo "<source src=$nome.ogv type=video/ogg> \n";
         echo "</video></div>\n";
      }
      echo "<form name=formdel method=post action=delete.php>\n";
      if ($login == 'admin' && count($videos) > 0) {
         $jvideos = json_encode($videos);
         echo "<input type=hidden name=arquivos\n value=$jvideos />\n";
         echo "<input type=submit id=del onclick='formdel.submit();' value='Deletar selecionados' />\n";
      }
      echo "</form>\n";
   }
   die;
} 
   
if ($login == 'admin' || $login == 'operador') {
   require 'banco.php';
   $nome_dados = array();
   echo "<meta charset=UTF-8 content='width=device-width, initial-scale= 1'>\n";
   echo "<link rel=stylesheet type=text/css href=estilo.css />\n";
   echo "<script src=funcoes.js></script>\n";
   echo "<center>\n";
   echo "<br><h2>Mostrando os 12 ultimos videos mais recentes</h2>\n";
   $sql = "select nome,tempo from videos where cliente = '$cliente' ";
   $sql .= "order by nome desc limit 12;";
   $rc = mysqli_query($link,$sql);
   $linhas = mysqli_fetch_all($rc);
   botoes($login,$nome_dados);
   ?> <style>a{color:blue};a:hover{text-decoration:underline};</style> <?php
   echo "<br><br>\n";
   for($i=0;$i<count($linhas);$i++) {
      $video = $linhas[$i][0];
      $tempo = $linhas[$i][1];
      $nome = substr($video,0,strlen($video)-4);
      $texto = titulos($video)." $tempo ";
      if ($login == 'admin')
         $texto .= "<a href=delete.php?v=$video>DEL</a>\n";
      echo "<div class=videobox>$texto<video class=videobox controls preload=none>\n";
      echo "<source src=$nome.mp4 type=video/mp4> \n";
      echo "<source src=$nome.ogv type=video/ogg> \n";
      echo "</video>\n";
      echo "</div>\n";
   }
   die;
} 
?>
