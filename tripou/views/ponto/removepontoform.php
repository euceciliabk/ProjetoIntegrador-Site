<?php
require_once "controle.php";
$controleUsuario = criaControleUsuario();
$login = $controleUsuario->getLogin();

if ($login == $ponto['quem']) {

?>

<form action="views/ponto/removepontoaction.php" method="post">
    <input type="hiden" name="quem" value="<?php echo $ponto
    ['quem']; ?>">

    <input type="hiden" name="quando" value="<?php echo $ponto
    ['quando']; ?>">

    <input type="submit" value="remover">

</form>
<?php } ?>