<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $usuarioModel = new Usuario($db);

    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // Verifica se o e-mail já existe utilizando o Model
    if ($usuarioModel->emailExiste($email)) {
        header("Location: /mmpass-sistema-WEB/cadastro.php?status=existe");
        exit();
    } 

    // Realiza o cadastro utilizando o Model
    if ($usuarioModel->cadastrar($nome, $email, $senha)) {
        header("Location: /mmpass-sistema-WEB/index.php?status=cadastrado");
        exit();
    } else {
        header("Location: /mmpass-sistema-WEB/cadastro.php?status=erro");
        exit();
    }
}
?>