<?php
session_start();
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();

    $usuario = new Usuario($db);
    $usuario->email = $_POST['email'];
    $usuario->senha = $_POST['senha'];

    $dadosUsuario = $usuario->login();

    if ($dadosUsuario) {
      
        $_SESSION['usuario_id'] = $dadosUsuario['id'];
        $_SESSION['usuario_nome'] = $dadosUsuario['nome'];
        
   
        header("Location: /mmpass-sistema-WEB/dashboard.php");
        exit();
    } else {
        header("Location: /mmpass-sistema-WEB/index.php?status=erro");
        exit();
    }
}