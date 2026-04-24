<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MMPass - Criar Conta</title>
    <link rel="stylesheet" href="/Sistema_MMPass/assets/css/style.css">
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: radial-gradient(circle at top left, #d4f1e8, transparent), 
                        radial-gradient(circle at bottom right, #f7d9f1, var(--bg-grad));
        }
        .login-card {
            width: 100%;
            max-width: 440px;
            padding: 40px;
            text-align: center;
        }
        .logo { font-size: 42px; margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="login-card glass animate">
        <h1 class="logo gradient-text">MMPass</h1>
        <h2 style="color: var(--text-muted); font-size: 1.2rem; margin-bottom: 30px; font-weight: 400;">Criar Nova Conta</h2>

        <?php if ($mensagem != ""): ?>
            <div class="animate" style="margin-bottom: 20px; padding: 12px; border-radius: 12px; font-size: 14px; background: #fff5f5; color: #c53030;">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>

        <form action="/Sistema_MMPass/controllers/CadastroController.php" method="POST">
            <div style="text-align: left; margin-bottom: 15px;">
                <label style="font-size: 14px; font-weight: 600; color: #4a5568; margin-left: 5px;">Nome Completo</label>
                <input type="text" name="nome" class="input-field" placeholder="Ex: Cleo Sertori" required style="margin-top: 5px;">
            </div>

            <div style="text-align: left; margin-bottom: 15px;">
                <label style="font-size: 14px; font-weight: 600; color: #4a5568; margin-left: 5px;">E-mail</label>
                <input type="email" name="email" class="input-field" placeholder="seuemail@email.com" required style="margin-top: 5px;">
            </div>

            <div style="text-align: left; margin-bottom: 25px;">
                <label style="font-size: 14px; font-weight: 600; color: #4a5568; margin-left: 5px;">Senha</label>
                <input type="password" name="senha" class="input-field" placeholder="********" required style="margin-top: 5px;">
            </div>

            <button type="submit" class="btn-grad" style="width: 100%;">Cadastrar na Ilha</button>
        </form>

        <a href="index.php" class="gradient-text" style="display: block; margin-top: 25px; font-size: 14px; text-decoration: none; font-weight: 600;">
            Já possui uma conta? Voltar ao login
        </a>
    </div>
</body>
</html>