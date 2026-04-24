<?php
session_start();

$mensagem = "";
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'existe') {
        $mensagem = "Este e-mail já está cadastrado!";
    } elseif ($_GET['status'] == 'erro') {
        $mensagem = "Erro ao realizar cadastro. Tente novamente.";
    }
}

// Inclui a view
include __DIR__ . '/../views/cadastro.php';
?>