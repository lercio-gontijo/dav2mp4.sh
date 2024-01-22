<?php
session_start();
if (!isset($_SESSION['usuario'])) 
   header("Location:index.php");
mkdir("Morto");
require 'banco.php';
require 'funcoes.php';
// videos/2023-04-13-17-36-2.ogv
if (isset($_GET['v'])) {
   header("Refresh: 1;url=index2.php");
   $video = $_GET['v'];
   $nome = substr($video,0,strlen($video)-4);
   $sql = "delete from videos where nome like '$video';";
   $rc = mysqli_query($link,$sql);
   if ($rc === False) die("Erro delete unico video: $sql\n");
   $cmd = "mv $nome.* Morto/.";
   system($cmd);
   echo "<h1>Video $video deletado</h1>\n";
   echo "<h2>$sql</h2>\n";
   die;
}
$jsql = $_POST['arquivos'];
$rc = mysqli_query($link,$jsql);
if ($rc === False) {
   show("Erro lendo bando: $jsql");
   die;
}
$arquivos = json_encode($jsql);
$linhas = mysqli_fetch_all($rc);
$t = count($linhas);
if (isset($_POST['confirma'])) {
   header("Refresh: 9;url=index2.php");
   for($i=0;$i<count($linhas);$i++) {
      $video = $linhas[$i][0];
      $nome = substr($video,0,strlen($video)-4);
      $cmd = "mv -v $nome.* Morto/.";
      system($cmd);
      echo "<br>\n";
      $sql = "delete from videos where nome like '$video';";
      $rc = mysqli_query($link,$sql);
      if ($rc === False) die("Erro delete lote de videos: $sql\n");
   }
   echo "<h1>Videos deletados</h1>";
   die;
}
echo "<link rel=stylesheet type=text/css href=estilo.css />\n";
?>
<style>
#confirma { font-color: red; font-weight: bold; margin-top: 4px; }
#par { font-family: Fixed; font-size: 22px; float: left; margin-right: 23px;}
a { font-size: 22px; 
   border: solid 2px gray;
   padding: 6px;
   text-decoration: none;
   color: black;
   background: #f5f5f5;
   border-radius: 4px;
   position: absolute;
   top: 7.2rem;
   left: 11rem;
}
</style>
<h1>Sistema de CFTV</h1>
<h2>Exclusão de gravações</h1>
<form name=form1 method=post>
<h1>Você está prestes a excluir <?php echo $t;?> gravações listadas abaixo</h1>
<input type=hidden name=arquivos value=<?php echo $arquivos;?>>
<input type=hidden name=confirma value=1>
<a href=index2.php>Desiste</a>
<button onclick='form1.submit();' id=confirma>Confirma</button><br>
</form>
<pre>
<?php
for($i=0;$i<count($linhas);$i++)
   echo "<div id=par>".$linhas[$i][0]."</div>";
?>


