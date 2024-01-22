<?php
session_start();
unset($_SESSION['usuario']);
session_destroy();
$usuario = 'admin';
$conf = base64_encode($usuario);
header("Refresh: 4; url=index.php");
$dir = getcwd();
echo "<h1>$dir CORRENTE</H1>";
unlink("conf.dat");
$arq = fopen("conf.dat","w");
fwrite($arq,$conf);
fwrite($arq,"\n");

?>

