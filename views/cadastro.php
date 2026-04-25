<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MMPass - Criar Conta</title>
    <link rel="stylesheet" href="/mmpass-sistema-WEB/assets/css/global.css?v=1.1">
    <link rel="stylesheet" href="/mmpass-sistema-WEB/assets/css/components.css?v=1.1">
    <link rel="stylesheet" href="/mmpass-sistema-WEB/assets/css/auth.css?v=1.1">
</head>
<body class="auth-body">
    <div class="auth-card glass animate">
        <h1 class="logo gradient-text">MMPass</h1>
        <h2>Criar Nova Conta</h2>

        <?php if ($mensagem != ""): ?>
            <div class="animate auth-msg erro">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>

        <form action="/mmpass-sistema-WEB/controllers/CadastroController.php" method="POST">
            <div class="form-group">
                <label>Nome Completo</label>
                <input type="text" name="nome" class="input-field" placeholder="Ex: Cleo Sertori" required>
            </div>

            <div class="form-group">
                <label>E-mail</label>
                <input type="email" name="email" class="input-field" placeholder="seuemail@email.com" required>
            </div>

            <div class="form-group mb-25">
                <label>Senha</label>
                <input type="password" name="senha" class="input-field" placeholder="********" required>
            </div>

            <button type="submit" class="btn-grad w-full">Cadastrar na Ilha</button>
        </form>

        <a href="index.php" class="gradient-text auth-link-block">
            Já possui uma conta? Voltar ao login
        </a>
    </div>
</body>
</html>