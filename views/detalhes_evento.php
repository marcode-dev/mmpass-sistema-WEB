<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estatísticas - <?= htmlspecialchars($evento['nome']) ?></title>
    <link rel="icon" type="image/png" href="/mmpass-sistema-WEB/assets/logo.png">
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
                <a href="index.php?url=perfil" class="user-profile-summary">
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

        <div class="event-hero animate mb-40">
            <div class="event-hero-banner glass">
                <img src="<?= $evento['imagem'] ?>" class="hero-bg-img" onerror="this.src='https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=1200'">
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <div class="hero-badge">
                        <i data-lucide="bar-chart-big" class="icon-sm"></i> Gestão de Ingressos
                    </div>
                    <h1 class="hero-title"><?= htmlspecialchars($evento['nome']) ?></h1>
                    <div class="hero-meta">
                        <span><i data-lucide="calendar" class="icon-sm"></i> <?= date('d/m/Y', strtotime($evento['data'])) ?></span>
                        <span><i data-lucide="map-pin" class="icon-sm"></i> <?= htmlspecialchars($evento['local']) ?></span>
                    </div>
                </div>
            </div>
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
                    <i data-lucide="users" class="icon-sm"></i> Ocupação
                </p>
                <h2 class="text-main"><?= $taxa_venda ?>%</h2>
                <p class="td-muted" style="font-size: 0.8rem;">Capacidade: <?= $evento['capacidade'] ?></p>
            </div>
            <div class="stat-card glass anim-delay-3">
                <p class="stat-card-label">
                    <i data-lucide="check-circle" class="icon-sm"></i> Status
                </p>
                <h2 class="<?= $status_class ?>"><?= $status_texto ?></h2>
            </div>
            <div class="stat-card glass anim-delay-4">
                <p class="stat-card-label">
                    <i data-lucide="flame" class="icon-sm" style="color: #ed8936;"></i> Hype
                </p>
                <h2 style="color: #ed8936;"><?= $evento['favoritos'][0]['count'] ?? 0 ?></h2>
                <p class="td-muted" style="font-size: 0.8rem;">Favoritados</p>
            </div>
        </div>


        <!-- Controle de Fluxo / Entrada -->
        <div class="glass animate anim-delay-3 progress-section">
            <div class="progress-info">
                <span><i data-lucide="log-in" class="icon-sm icon-purple"></i> Taxa de Entrada</span>
                <span class="gradient-text"><?= $taxa_entrada ?>%</span>
            </div>
            <div class="progress-container-bg">
                <div class="progress-bar-fill" style="width: <?= $taxa_entrada ?>%"></div>
            </div>
            
            <div class="stats-grid-mini">
                <div class="mini-stat-card">
                    <span class="mini-stat-label">Já Entraram</span>
                    <span class="mini-stat-value"><?= $pessoas_entraram ?></span>
                </div>
                <div class="mini-stat-card">
                    <span class="mini-stat-label">Aguardando</span>
                    <span class="mini-stat-value"><?= $pessoas_faltam ?></span>
                </div>
                <div class="mini-stat-card">
                    <span class="mini-stat-label">Total Esperado</span>
                    <span class="mini-stat-value"><?= $total_ingressos ?></span>
                </div>
            </div>
        </div>
        
        <!-- Painel Financeiro -->
        <div class="glass animate anim-delay-4 finance-section mt-30">
            <div class="finance-grid">
                <div class="finance-item">
                    <span class="mini-stat-label">Preço Unitário</span>
                    <span class="mini-stat-value">R$ <?= number_format($evento['preco'], 2, ',', '.') ?></span>
                </div>
                <div class="finance-item">
                    <span class="mini-stat-label">Receita Bruta</span>
                    <span class="mini-stat-value text-purple">R$ <?= number_format($receita_bruta, 2, ',', '.') ?></span>
                </div>
                <div class="finance-item border-left">
                    <span class="mini-stat-label">Comissão Empresa (%)</span>
                    <div class="flex-center-start gap-10">
                        <input type="number" id="lucroPercent" value="10" min="0" max="100" class="input-mini">
                        <span class="text-muted">%</span>
                    </div>
                </div>
                <div class="finance-item">
                    <span class="mini-stat-label">Lucro Líquido</span>
                    <span class="mini-stat-value text-green" style="color: #4fd1c5;">R$ <span id="lucroTotal">0,00</span></span>
                </div>
            </div>
        </div>

        <script>
            function updateFinance() {
                const bruta = <?= (float)$receita_bruta ?>;
                const percent = document.getElementById('lucroPercent').value / 100;
                const lucro = bruta * percent;
                document.getElementById('lucroTotal').innerText = lucro.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
            }
            document.getElementById('lucroPercent').addEventListener('input', updateFinance);
            updateFinance();
        </script>



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
        <?php include 'footer.php'; ?>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>
