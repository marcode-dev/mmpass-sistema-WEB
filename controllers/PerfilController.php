<?php
session_start();
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Evento.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /Sistema_MMPass/index.php");
    exit;
}

$db = (new Database())->getConnection();
$evento = new Evento($db);

// Busca eventos do usuário
$meus_eventos = $evento->buscarPorUsuario($_SESSION['usuario_id']);

// Inclui a view
include __DIR__ . '/../views/perfil.php';
?>