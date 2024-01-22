Este bash-script precisa que você crie uma chave criptografada pública e copie para o servidor onde deve ter o arquivo info.php e uma tabela mysql que este
Programa usa. 

ssh-keygen -t rsa
ssh-copy-id -i ~/.ssh/id_rsa.pub user1@$ip

O programa info.php que fica no servidor no meu caso teotonios.com.br/cftv faz require em 'banco.php' que deve ter as suas credenciais para o MySql
O programa index.php exibe uma tela de login inicial onde o usuário cria senhas para admin e usuario com privilégios diferentes, o admin pode remover
os arquivos de vídeo um por um ou selecionando em um critério que o programa vai compor auto através dos arquivos que houverem para serem exibidos.

O usuário 'usuario' pode somente ver/listar os vídeos ou fazer download dos que desejar.

O compartamento de HTML VIDEO é diferente do Firefox para o Chrome e é possível fazer Downloads de vídeos em FULLHD.

Não irei colocar aqui o arquivo banco.php por medida de segurança

Críticas e sugestões são sempre bem vindas!
lercio.gontijo@gmail.com ou lercio@teotonios.com.br

Espero que estes programas sejam úteis 

