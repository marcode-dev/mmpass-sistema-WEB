<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estatísticas - <?= htmlspecialchars($evento['nome']) ?></title>
    <link rel="stylesheet" href="/mmpass-sistema-WEB/assets/css/global.css?v=1.1">
    <link rel="stylesheet" href="/mmpass-sistema-WEB/assets/css/components.css?v=1.1">
    <link rel="stylesheet" href="/mmpass-sistema-WEB/assets/css/dashboard.css?v=1.1">
    <link rel="stylesheet" href="/mmpass-sistema-WEB/assets/css/detalhes.css?v=1.1">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
    <div class="main-container">
        <!-- Header -->
        <div class="header glass animate">
            <a href="index.php?url=dashboard" class="header-brand">
                <img src="/mmpass-sistema-WEB/assets/logo.png" alt="Logo MMPass" class="header-logo">
                <h1 class="gradient-text">MMPass</h1>
            </a>

            <nav class="header-nav">
                <a href="index.php?url=dashboard" class="nav-link">
                    <i data-lucide="layout-grid" class="icon-sm"></i> Mural
                </a>
                <a href="index.php?url=meus-eventos" class="nav-link active">
                    <i data-lucide="calendar" class="icon-sm"></i> Meus Eventos
                </a>
                <a href="index.php?url=cupons" class="nav-link">
                    <i data-lucide="ticket" class="icon-sm"></i> Cupons
                </a>
            </nav>

            <div class="header-actions">
                <a href="index.php?url=meus-eventos" class="user-profile-summary">
                    <div class="user-avatar-sm">
                        <?= strtoupper(substr($_SESSION['usuario_nome'], 0, 1)) ?>
                    </div>
                    <span><?= explode(' ', $_SESSION['usuario_nome'])[0] ?></span>
                </a>
                <a href="index.php?url=logout" class="btn-logout-icon" title="Sair do Portal">
                    <i data-lucide="log-out" class="icon-sm"></i>
                </a>
            </div>
        </div>

        <a href="index.php?url=meus-eventos" class="btn-outline animate back-link">
            <i data-lucide="chevron-left" class="icon-sm"></i> Voltar aos Meus Eventos
        </a>

        <div class="animate">
            <h1 class="mb-10 flex-center-start gap-10">
                <i data-lucide="bar-chart-big" class="icon-purple"></i> Gestão de Ingressos
            </h1>
            <h2 class="gradient-text h2-large mb-40"><?= htmlspecialchars($evento['nome']) ?></h2>
        </div>

        <div class="stats-container animate anim-delay-1">
            <div class="stat-card glass">
                <p class="stat-card-label">
                    <i data-lucide="ticket" class="icon-sm"></i> Ingressos Vendidos
                </p>
                <h2 class="gradient-text"><?= $total_ingressos ?></h2>
            </div>
            <div class="stat-card glass anim-delay-2">
                <p class="stat-card-label">
                    <i data-lucide="check-circle" class="icon-sm"></i> Status do Evento
                </p>
                <h2 class="status-active">Ativo</h2>
            </div>
            <div class="stat-card glass anim-delay-3">
                <p class="stat-card-label">
                    <i data-lucide="banknote" class="icon-sm"></i> Preço Unitário
                </p>
                <h2 class="text-main">R$ <?= number_format($evento['preco'], 2, ',', '.') ?></h2>
            </div>
        </div>

        <div class="table-container glass animate anim-delay-4">
            <table>
                <thead>
                    <tr>
                        <th>Comprador</th>
                        <th>E-mail de Contato</th>
                        <th>Código</th>
                        <th>Status</th>
                        <th>Data da Transação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(is_array($compras)): ?>
                        <?php foreach($compras as $c): ?>
                        <tr>
                            <td class="td-bold"><?= htmlspecialchars($c['comprador_nome']) ?></td>
                            <td class="td-muted"><?= htmlspecialchars($c['comprador_email']) ?></td>
                            <td class="ticket-code"><?= htmlspecialchars($c['codigo']) ?></td>
                            <td>
                                <?php if($c['usado']): ?>
                                    <span class="status-badge used">Utilizado</span>
                                <?php else: ?>
                                    <span class="status-badge available">Disponível</span>
                                <?php endif; ?>
                            </td>
                            <td class="td-muted"><?= date('d/m/Y H:i', strtotime($c['data_compra'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <?php if(empty($compras)): ?>
                    <tr>
                        <td colspan="5" class="no-data-msg">
                            Nenhum ingresso vendido para este evento ainda.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>
