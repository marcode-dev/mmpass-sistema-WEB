<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - MMPass</title>
    <link rel="stylesheet" href="/mmpass-sistema-WEB/assets/css/global.css?v=1.1">
    <link rel="stylesheet" href="/mmpass-sistema-WEB/assets/css/components.css?v=1.1">
    <link rel="stylesheet" href="/mmpass-sistema-WEB/assets/css/auth.css?v=1.3">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
    <div class="auth-wrapper">
        <div class="bubbles-container">
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
        </div>

        <div class="auth-box animate">
            <div class="auth-header">
                <img src="/mmpass-sistema-WEB/assets/logo.png" alt="Logo" class="auth-logo">
                <h1 class="gradient-text">MMPass</h1>
                <p class="text-muted">Crie sua conta na Ilha Mako</p>
            </div>

            <?php if (isset($mensagem) && $mensagem): ?>
                <div class="alert alert-erro"><?= $mensagem ?></div>
            <?php endif; ?>

            <form action="index.php?url=auth/register" method="POST" class="auth-form">
                <div class="input-with-icon">
                    <i data-lucide="user"></i>
                    <input type="text" name="nome" placeholder="Nome Completo" required>
                </div>

                <div class="input-with-icon">
                    <i data-lucide="mail"></i>
                    <input type="email" name="email" placeholder="E-mail" required>
                </div>

                <div class="input-with-icon">
                    <i data-lucide="lock"></i>
                    <input type="password" name="senha" placeholder="Senha" required>
                </div>

                <button type="submit" class="btn-grad-flet">Criar Conta</button>
            </form>

            <div class="auth-footer">
                <p>Já tem uma conta? <a href="index.php?url=login" class="gradient-text">Fazer Login</a></p>
            </div>
        </div>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>
