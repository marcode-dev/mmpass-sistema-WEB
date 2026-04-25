<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MMPass - Login</title>
    <link rel="stylesheet" href="/mmpass-sistema-WEB/assets/css/global.css?v=1.1">
    <link rel="stylesheet" href="/mmpass-sistema-WEB/assets/css/components.css?v=1.1">
    <link rel="stylesheet" href="/mmpass-sistema-WEB/assets/css/auth.css?v=1.1">
</head>
<body class="auth-body">
    <div class="auth-card glass animate">
        <h1 class="logo gradient-text">MMPass</h1>
        <p class="auth-subtitle">Portal da Ilha Mako</p>

        <?php if ($mensagem != ""): ?>
            <div class="animate auth-msg <?= $classe_msg == 'erro' ? 'erro' : 'sucesso' ?>">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>

        <form action="/mmpass-sistema-WEB/controllers/LoginController.php" method="POST">
            <div class="form-group">
                <label>E-mail</label>
                <input type="email" name="email" class="input-field" placeholder="seuemail@email.com" required>
            </div>
            
            <div class="form-group mb-30">
                <label>Senha</label>
                <input type="password" name="senha" class="input-field" placeholder="********" required>
            </div>

            <button type="submit" class="btn-grad w-full">Entrar na Ilha</button>
        </form>

        <p class="auth-footer">
            Novo por aqui? <a href="cadastro.php" class="gradient-text auth-link">Crie sua conta</a>
        </p>
    </div>
</body>
</html>