<?php
require_once "usuario.php";
require_once "ponto.php";
require_once "roteiro.php";

function criaPersistenciaUsuario() {
    return new PersistenciaUsuario();
}

function criaPersistenciaPonto() {
    return new PersistenciaPonto();
}

function criaPersistenciaRoteiro() {
    return new PersistenciaRoteiro();
}
?>