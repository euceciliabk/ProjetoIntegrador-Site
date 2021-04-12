<?php
require_once "controle.php";
$controleUsuario = criaControleUsuario();
$login = $controleUsuario->getLogin();

if ($login == $ponto['quem']) {

?>

<form action="views/ponto/baixararquivo.php" method="get">
    <input type="hiden" name="quem" value="<?php echo $ponto
    ['quem']; ?>">

    <input type="hiden" name="id" value="<?php echo $ponto
    ['idponto']; ?>">

    <input type="submit" value="baixar arquivo">

</form>
<?php } ?>