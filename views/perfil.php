<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - MMPass</title>
    <link rel="stylesheet" href="/Sistema_MMPass/assets/css/style.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .profile-card {
            padding: 40px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 25px;
        }
        .avatar {
            width: 80px;
            height: 80px;
            background: var(--primary-grad);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            box-shadow: var(--shadow);
        }
        .evento-item {
            padding: 20px 30px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.3s;
        }
        .evento-item:hover {
            transform: scale(1.01);
            background: white;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <a href="dashboard.php" class="btn-outline animate" style="margin-bottom: 30px; display: inline-flex; align-items: center; gap: 8px; border: none; padding-left: 0;">
            <i data-lucide="chevron-left"></i> Voltar ao Mural
        </a>

        <div class="profile-card glass animate">
            <div class="avatar"><i data-lucide="user"></i></div>
            <div>
                <h2 style="font-size: 2rem;">Olá, <span class="gradient-text"><?= htmlspecialchars($_SESSION['usuario_nome']) ?></span>!</h2>
                <p style="color: var(--text-muted);">Gerencie suas publicações na Ilha Mako.</p>
            </div>
        </div>

        <h2 style="margin: 40px 0 20px; font-size: 1.5rem;" class="animate">Meus Eventos Publicados</h2>

        <?php if(!empty($meus_eventos)): ?>
            <?php foreach($meus_eventos as $index => $me): ?>
                <div class="evento-item glass animate" style="animation-delay: <?php echo 0.1 + ($index * 0.05); ?>s;">
                    <div>
                        <strong style="font-size: 1.2rem; color: #b388eb; display: block;"><?= htmlspecialchars($me['nome']) ?></strong>
                        <small style="color: var(--text-muted); font-size: 14px; display: flex; align-items: center; gap: 8px;">
                            <span><i data-lucide="calendar" style="width: 14px; position: relative; top: 2px;"></i> <?= date('d/m/Y', strtotime($me['data'])) ?></span>
                            <span>| <i data-lucide="map-pin" style="width: 14px; position: relative; top: 2px;"></i> <?= htmlspecialchars($me['local']) ?></span>
                        </small>
                    </div>

                    <div style="display: flex; gap: 10px;">
                        <a href="detalhes_evento.php?id=<?= $me['id'] ?>" class="btn-grad" style="padding: 10px 20px; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                            <i data-lucide="bar-chart-3" style="width: 16px;"></i> Analisar
                        </a>

                        <a href="/Sistema_MMPass/controllers/EventoController.php?action=excluir&id=<?= $me['id'] ?>"
                           class="btn-outline"
                           style="padding: 10px 20px; font-size: 14px; border-color: #ff6b6b; color: #ff6b6b; display: flex; align-items: center; gap: 5px;"
                           onclick="return confirm('Tem certeza que deseja remover este evento?')">
                           <i data-lucide="trash-2" style="width: 16px;"></i> Excluir
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="glass animate" style="text-align: center; padding: 60px; border: 2px dashed #e2e8f0; background: transparent;">
                <p style="color: var(--text-muted); margin-bottom: 20px;">Você ainda não cadastrou nenhum evento.</p>
                <a href="dashboard.php" class="btn-grad">Começar Agora</a>
            </div>
        <?php endif; ?>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>