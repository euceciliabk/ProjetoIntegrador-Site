<pre>
<?php
chdir("../../");
require_once "persistencia/postgres/conexao.php";
echo "persistencia/postgres/conexao.php\n";
$conexao = getConexao();
var_dump($conexao);

require_once "persistencia/postgres/usuario.php";
echo "persistencia/postgres/usuario.php\n";
$persistenciaUsuario = new PersistenciaUsuario();
var_dump($persistenciaUsuario);

$result = $persistenciaUsuario->criaTabelaUsuarios();
var_dump($result);

$result = $persistenciaUsuario->insereUsuario('alice', '123');
var_dump($result);

$result = $persistenciaUsuario->getSenha('alice');
var_dump($result);

require_once "persistencia/postgres/mensagem.php";
echo "persistencia/postgres/mensagem.php";

$persistenciaMensagem = new PersistenciaMensagem();
var_dump($persistenciaMensagem);

$result = $persistenciaMensagem->criaTabelaMensagens();
var_dump($result);

$mensagem = criaMensagem('teste', 'alice', '2020-12-25 12:34:56');
$result = $persistenciaMensagem->salvaMensagem($mensagem);
var_dump($result);

$result = $persistenciaMensagem->carregaMensagens();
var_dump($result);

$result = $persistenciaMensagem->removeMensagem($mensagem);
var_dump($result);

$result = $persistenciaMensagem->carregaMensagens();
var_dump($result);

?>
</pre>