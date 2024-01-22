<body>
<form name=form1>
<input type=hidden name=dados value=''>
</form>
<?php
$n = $_GET['n'];
if (strlen($n)==0) $n = '2023-??-??-??-??-1';
require 'banco.php';
$campos = ['ano','mes','dia','hora','minuto','canal'];
echo "<pre>\n";
$p = explode('-',$n);
print_r($p);
$sql = "select * from videos where ";
$tem = false;
for($i=0;$i<count($p)-1;$i++) {
   if ($p[$i][0] != '?') {
      $sql .= $campos[$i]." like '".$p[$i]."' and ";
      $tem = true;
   }
}
if (!$tem) $sql = substr($sql,0,strlen($sql)-5);
if ($p[5][0] != '?')
   $sql .= $campos[$i]." like '".$p[$i]."';";
$rc = mysqli_query($link,$sql);
echo "$sql\n";
$linhas = mysqli_fetch_all($rc);
$jl = json_encode($linhas);
print_r($linhas);
echo "<script>form1.dados.value=$jl;\nlocalStorage.setItem('dados',$jl);</script>\n";
if ($rc === True) 
   echo "SUCESSO: $sql\n";
/*
videos/2023-03-15-13-10-2.ogv
nome varchar(40), ano mes dia hora minuto canal INT, tempo (20) cliente(30)
PRIMARY KEY (none,cliente)
*/
?>
</body>
