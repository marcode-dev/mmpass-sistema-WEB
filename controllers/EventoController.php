<?php
session_start();
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Evento.php';

$db = (new Database())->getConnection();
$evento = new Evento($db);
$action = $_GET['action'] ?? '';

if ($action == 'cadastrar') {
    $evento->cadastrar(
        $_POST['nome'],
        $_POST['data'],
        $_POST['local'],
        $_POST['preco'],
        $_POST['imagem'],
        $_POST['capacidade'], // Novo campo
        $_SESSION['usuario_id']
    );
    header("Location: /mmpass-sistema-WEB/meus-eventos.php");

} elseif ($action == 'excluir') {
    $id = $_GET['id'];
    $evento->excluir($id, $_SESSION['usuario_id']);
    header("Location: /mmpass-sistema-WEB/meus-eventos.php");
    exit();
}
?>