<?php
session_start();
$login = $_SESSION['usuario'];
require 'funcoes.php';
$usuario = 'admin';
$existe = file('conf.dat');
$jexiste = json_encode($existe);
$admin = str_replace("\n",'',$existe[0]);
if ($_POST) {
   header("Refresh: 4; url=index.php");
   $a = $_POST['campo1'];
   $b = $_POST['campo2'];
   $c = $_POST['campo3'];
   $d = $_POST['campo4'];
   if ($a != $b) {
      show("As senhas do admin sao diferentes");
      die;
   }
   if ($a == $c) {
      show("A senha do operador precisa ser diferente do admin");
      die;
   }
   $a = base64_encode($a)."\n";
   $b = base64_encode($c)."\n";
   unlink('conf.dat');
   $arq = fopen('conf.dat','w');
   fwrite($arq,$a);
   fwrite($arq,$b);
   fclose($arq);
   show("Senhas cadastradas com sucesso!");
   die;
}
echo "<link rel=stylesheet type=text/css href=estilo.css />\n";
$t = "Oito caracteres no minimo, maiusculas, minusculas, numeros e um caracter especial";
if ($usuario == base64_decode($admin)) {
?>
<body>
<img id=ajuda class=ajuda src=oque.png onclick='ajuda(this);'>
<center>
<h1>Sistema de CFTV</h1>
<h2>Ajustes iniciais - Criação de senhas</h1>
<div id=info>
<p>No primeiro acesso será necessário a criação de senhas
para os usuarios <b>admin</b> e <b>operador</b>. As senhas 
precisam ter o mínimo de 8 caracteres e combinar letras 
maiúsculas e minúsculas, números e pelo nos um caracter especial.
Usuairo admin pode remover as gravações a partir de um
determinado críterio que ele selecionar e o usuário operador
poderá somente listar, reproduzir ou fazer download das 
gravações.</p>
<p>A privacidade de nossos clientes é assunto muito sério,
as senhas são criptografadas e armazenadas em arquivos e 
não existe possibilidade de revelar as senhas por nenhum
método, nem mesmo pelo Analista de Sistemas. Uma vez que as
senhas sejam criadas o <b>Administrador do Sistema</B> 
poderá fazer um RESET e criar novamente senhas para o 
operador e para si. Recomandos que as senhas sejam memorizadas e 
que não se crie etiquetas com as senhas e nem as deixe escrito em
locais de fácil acesso. Este sistema é propositadamente aberto
na internet para que o cliente tenha comodidade de gerenciar
as gravações onde lhe mais aprouver 
<img id=up src=up.png onclick='fecha(this);' onmousemove='borda();' onmouseout='noborda();'></p>
</div>
<form name=form1 method=post autocomplete=off onsubmit='verifica();'>
<table border=1 cellpadding=0 cellspacing=0>
<tr><th class=alto colspan=2>ADMINISTRADOR DO SISTEMA</th></tr>
<tr><td class="tdr trans">admin</td><td class=trans>
   <input class=senha type=password placeholder='Senha aqui' 
      autocomplete=off
      title="<?php echo $t;?>" name=campo1 autofocus>
   <input class=senha type=password placeholder='Confirmação' 
      autocomplete=off
      title="<?php echo $t;?>" name=campo2>
</td></tr>
<tr><th class=alto colspan=2>Operador do Sistema</th></tr>
<tr><td class="tdr trans">operador</td><td class=trans>
   <input class=senha type=password placeholder='Senha aqui' 
      onclick='veradmin();'
      autocomplete=off
      title="<?php echo $t;?>" name=campo3>
   <input class=senha type=password placeholder='Confirmação' 
      autocomplete=off onblur='verifica();'
      title="<?php echo $t;?>" name=campo4>
</td></tr>
<tr><th colspan=2 class=alto><input type=submit value='Cadastrar senhas' id=sub 
disabled /></th</tr>
</table>  
</form>
<script src=funcoes.js></script>
<?php   
} else {
?>
<center>
<h1>Sistema de CFTV</h1>
<form name=form2 method=post autocomplete=off action=index2.php>
<table border=1 cellpadding=0 cellspacing=0>
<tr><th class=alto colspan=2>LOGIN NO SISTEMA</th></tr>
<tr><td class="tdr trans"><input class=branco name=usuario 
   size=8 autofocus placeholder=Usuario autocomplete=off></td>
<td class="trans">
   <input class=senha type=password placeholder='Senha aqui' 
      class=branco autocomplete=off name=campo12>
</td></tr>
<tr><th colspan=2 class=alto><input type=submit value=Login id=sub /></th</tr>
</table>  
<input type=hidden name=existe value='<?php echo $jexiste;?>'>
</form>
</body>
<?php 
}
?>
