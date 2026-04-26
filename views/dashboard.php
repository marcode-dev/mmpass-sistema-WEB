<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MMPass - Mural de Eventos</title>
    <link rel="icon" type="image/png" href="/mmpass-sistema-WEB/assets/logo.png">
    <link rel="stylesheet" href="/mmpass-sistema-WEB/assets/css/global.css?v=1.1">
    <link rel="stylesheet" href="/mmpass-sistema-WEB/assets/css/components.css?v=1.1">
    <link rel="stylesheet" href="/mmpass-sistema-WEB/assets/css/dashboard.css?v=1.1">
    <link rel="stylesheet" href="/mmpass-sistema-WEB/assets/css/perfil.css?v=1.1">
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
                <a href="index.php?url=dashboard" class="nav-link active">
                    <i data-lucide="layout-grid" class="icon-sm"></i> Mural
                </a>
                <a href="index.php?url=meus-eventos" class="nav-link">
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

        <!-- Banner de Boas-vindas -->
        <div class="welcome-banner glass animate mb-40">
            <div class="avatar"><i data-lucide="sparkles"></i></div>
            <div>
                <h2>Olá, <span class="gradient-text"><?= htmlspecialchars($_SESSION['usuario_nome']) ?></span>!</h2>
                <p class="text-muted">Explore os eventos ativos na Ilha Mako hoje.</p>
            </div>
        </div>


        <h2 class="section-title animate">
            Eventos em Destaque <i data-lucide="sparkles" class="icon-pink"></i>
        </h2>
        <div class="grid">
            <?php if(is_array($eventos)): ?>
                <?php foreach($eventos as $index => $ev): ?>
                    <div 
                        class="card glass card-clickable" 
                        style="animation-delay: <?php echo 0.2 + ($index * 0.05); ?>s;"
                        data-nome="<?= strtolower(htmlspecialchars($ev['nome'])) ?>"
                        data-local="<?= strtolower(htmlspecialchars($ev['local'])) ?>"
                        data-preco="<?= $ev['preco'] ?>"
                        data-timestamp="<?= strtotime($ev['data']) ?>"
                        onclick="if(!event.target.closest('.no-click')) window.location.href='index.php?url=eventos/detalhes&id=<?= $ev['id'] ?>'"
                    >
                        <img src="<?= $ev['imagem'] ?>" onerror="this.src='https://via.placeholder.com/400x250/bc98e6/ffffff?text=Mako+Island'">
                        <div class="card-content">
                            <h3><?= htmlspecialchars($ev['nome']) ?></h3>
                            <p class="card-info mt-5">
                                <i data-lucide="map-pin" class="icon-sm"></i> <?= htmlspecialchars($ev['local']) ?>
                            </p>
                            <p class="card-info">
                                <i data-lucide="calendar" class="icon-sm"></i> <?= date('d/m/Y', strtotime($ev['data'])) ?>
                            </p>
                            <div class="hype-badge">
                                <i data-lucide="flame" class="icon-sm"></i> Hype: <?= $ev['favoritos'][0]['count'] ?? 0 ?>
                            </div>
                            <div class="price-badge">R$ <?= number_format($ev['preco'], 2, ',', '.') ?></div>
                            
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php include 'footer.php'; ?>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>
