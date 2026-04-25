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
$eventoModel = new Evento($db);
$evento_id = $_GET['id'];
$usuario_id = $_SESSION['usuario_id'];

// Buscar evento
$evento = $eventoModel->buscarPorIdEUsuario($evento_id, $usuario_id);
if (!$evento) {
    die("Evento não encontrado ou acesso negado.");
}

// Buscar compras
$compras = $eventoModel->buscarCompras($evento_id);

// Cálculos de Estatísticas
$total_ingressos = count($compras);

// Inclui a view
include __DIR__ . '/../views/detalhes_evento.php';
?>