function veradmin() {
   var a = form1.campo1.value;
   var b = form1.campo2.value;
   var c = form1.campo3.value;
   var d = form1.campo4.value;
   if (a != b) {
      alert("As senhas do admin são diferentes")
      return false;
   }
   if (a == c) {
      alert("A senha do operador precisa ser diferente da senha admin");
      return false;
   }
}

function verifica() {
   var a = form1.campo1.value;
   var b = form1.campo2.value;
   var c = form1.campo3.value;
   var d = form1.campo4.value;
   if (a != b) {
      alert("As senhas do admin são diferentes")
      return false;
   }
   if (a == c) {
      alert("A senha do operador precisa ser diferente da senha admin");
      return false;
   }
   if (c != d) {
      alert("As senhas do operador são diferentes");
      return false;
   }
   if (!checkpass(a)) {
      alert("A senha do admin n�o éuma senha forte");
      return false;  
   }
   if (!checkpass(c)) {
      alert("A senha do operador nao e uma senha forte");
      return false;  
   }
   document.getElementById('sub').disabled = false;
}

function checkpass(senha) {
   let padrao = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})');
   if (padrao.test(senha)) 
      return true;
   else return false;
}

function ajuda(objeto) {
   objeto.style.display = 'none';
   document.getElementById('info').style.display = 'block';
}

function fecha(objeto) {
   document.getElementById('info').style.display = 'none';
   document.getElementById('ajuda').style.display = 'inline';
}

function borda() {
   document.getElementById('info').style.border = 'solid 1px';
}

function noborda() {
   document.getElementById('info').style.border = 'none';
}

