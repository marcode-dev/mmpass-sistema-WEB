<?php
session_start();
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Cupom.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: /mmpass-sistema-WEB/index.php");
    exit();
}

$db = (new Database())->getConnection();
$cupomModel = new Cupom($db);

$action = $_GET['action'] ?? '';

if ($action == 'cadastrar') {
    $cupomModel->cadastrar($_POST['nome'], $_POST['desconto'], $_POST['nivel'], $_SESSION['usuario_id']);
    header("Location: /mmpass-sistema-WEB/cupons.php");
    exit();
} elseif ($action == 'editar') {
    $cupomModel->atualizar($_POST['id'], $_POST['nome'], $_POST['desconto'], $_POST['nivel']);
    header("Location: /mmpass-sistema-WEB/cupons.php");
    exit();
} elseif ($action == 'excluir') {
    $cupomModel->excluir($_GET['id']);
    header("Location: /mmpass-sistema-WEB/cupons.php");
    exit();
}

// Caso padrão: Listar
$cupons = $cupomModel->buscarPorUsuario($_SESSION['usuario_id']);
include __DIR__ . '/../views/cupons.php';
?>
