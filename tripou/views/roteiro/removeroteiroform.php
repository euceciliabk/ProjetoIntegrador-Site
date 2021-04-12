<?php
require_once "controle.php";
$controleUsuario = criaControleUsuario();
$login = $controleUsuario->getLogin();

if ($login == $roteiro['quem']) {


?>

<form action="views/roteiro/removeroteiroaction.php" method="post">
quem:<input type="hiden" name="quem" value="<?php echo $roteiro['quem']; ?>">

idpontos:<input type="hiden" name="ponto" value="<?php echo implode(', ', $roteiro['idpontos']); ?>">

idroteiro:<input type="hiden" name="roteiro" value="<?php echo $roteiro['idroteiro']; ?>">

    <input type="submit" value="remover">

</form>
<?php } ?>