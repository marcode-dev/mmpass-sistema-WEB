<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MMPass - Login</title>
    <link rel="stylesheet" href="/Sistema_MMPass/assets/css/style.css">
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: radial-gradient(circle at top right, #f7d9f1, transparent), 
                        radial-gradient(circle at bottom left, #d4f1e8, var(--bg-grad));
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 50px 40px;
            text-align: center;
        }
        .logo { font-size: 48px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="login-card glass animate">
        <h1 class="logo gradient-text">MMPass</h1>
        <p style="color: var(--text-muted); margin-bottom: 35px; font-size: 1.1rem;">Portal da Ilha Mako</p>

        <?php if ($mensagem != ""): ?>
            <div class="animate" style="margin-bottom: 20px; padding: 12px; border-radius: 12px; font-size: 14px; 
                <?php echo $classe_msg == 'erro' ? 'background: #fff5f5; color: #c53030;' : 'background: #f0fff4; color: #2f855a;'; ?>">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>

        <form action="/Sistema_MMPass/controllers/LoginController.php" method="POST">
            <div style="text-align: left; margin-bottom: 20px;">
                <label style="font-size: 14px; font-weight: 600; color: #4a5568; margin-left: 5px;">E-mail</label>
                <input type="email" name="email" class="input-field" placeholder="seuemail@email.com" required style="margin-top: 8px;">
            </div>
            
            <div style="text-align: left; margin-bottom: 30px;">
                <label style="font-size: 14px; font-weight: 600; color: #4a5568; margin-left: 5px;">Senha</label>
                <input type="password" name="senha" class="input-field" placeholder="********" required style="margin-top: 8px;">
            </div>

            <button type="submit" class="btn-grad" style="width: 100%;">Entrar na Ilha</button>
        </form>

        <p style="margin-top: 30px; font-size: 14px; color: var(--text-muted);">
            Novo por aqui? <a href="cadastro.php" class="gradient-text" style="text-decoration: none; font-weight: 700;">Crie sua conta</a>
        </p>
    </div>
</body>
</html>