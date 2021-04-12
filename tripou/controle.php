<?php
require_once "usuario/controle.php";
require_once "ponto/controle.php";
require_once "roteiro/controle.php";
require_once "persistencia/controle.php";


function criaControleUsuario() {
    $persistencia = criaPersistenciaUsuario();
    $controleUsuario = new ControleUsuario($persistencia);
    return $controleUsuario;
}

function criaControlePonto() {
    $persistencia = criaPersistenciaPonto();
    $controlePonto = new ControlePonto($persistencia);
    return $controlePonto;
}

function criaControleRoteiro() {
    $persistencia = criaPersistenciaRoteiro();
    $controleRoteiro = new ControleRoteiro($persistencia);
    return $controleRoteiro;
}
?>