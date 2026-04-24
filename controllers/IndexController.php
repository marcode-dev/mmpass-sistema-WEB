<?php
session_start();

$mensagem = "";
$classe_msg = "";

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'erro') {
        $mensagem = "E-mail ou senha incorretos!";
        $classe_msg = "erro";
    } elseif ($_GET['status'] == 'cadastrado') {
        $mensagem = "Conta criada com sucesso! Faça login.";
        $classe_msg = "sucesso";
    }
}

// Inclui a view
include __DIR__ . '/../views/index.php';
?>