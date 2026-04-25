<?php
session_start();
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Evento.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /mmpass-sistema-WEB/index.php");
    exit;
}

$db = (new Database())->getConnection();
$evento = new Evento($db);

// Busca todos os eventos utilizando o Model
$eventos = $evento->buscarTodos();

// Inclui a view
include __DIR__ . '/../views/dashboard.php';
?>