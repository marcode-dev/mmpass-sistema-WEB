<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MMPass - Mural de Eventos</title>
    <link rel="stylesheet" href="/Sistema_MMPass/assets/css/style.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            margin-bottom: 30px;
        }
        .form-box {
            padding: 30px;
            margin-bottom: 50px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }
        .card {
            background: white;
            transition: 0.3s;
            overflow: hidden;
            border: 1px solid #edf2f7;
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card-content {
            padding: 20px;
        }
        .price-badge {
            background: var(--primary-grad);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 700;
            display: inline-block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="header glass animate">
            <h1 class="gradient-text" style="font-size: 2rem; display: flex; align-items: center; gap: 10px;">
                <i data-lucide="waves"></i> MMPass
            </h1>
            <div style="display: flex; gap: 15px; align-items: center;">
                <a href="perfil.php" class="btn-outline" style="display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="user" style="width: 18px;"></i> Meu Perfil
                </a>
                <a href="logout.php" style="color: #ff6b6b; font-weight: 700; text-decoration: none; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                    Sair <i data-lucide="log-out" style="width: 18px;"></i>
                </a>
            </div>
        </div>

        <div class="form-box glass animate" style="animation-delay: 0.1s;">
            <h2 style="margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <i data-lucide="plus-circle" style="color: #bc98e6;"></i> Publicar Novo Evento
            </h2>
            <form action="/Sistema_MMPass/controllers/EventoController.php?action=cadastrar" method="POST" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <input type="text" name="nome" class="input-field" placeholder="Nome do Evento" required>
                <input type="date" name="data" class="input-field" required>
                <input type="text" name="local" class="input-field" placeholder="Localização (Ex: Blue Lagoon, Mako)" required>
                <input type="number" step="0.01" name="preco" class="input-field" placeholder="Preço (R$)" required>
                <input type="text" name="imagem" class="input-field" placeholder="URL da Imagem de Capa" required style="grid-column: span 2;">
                <button type="submit" class="btn-grad" style="grid-column: span 2;">Lançar Evento no Mural</button>
            </form>
        </div>

        <h2 style="margin-bottom: 25px; font-size: 1.8rem; display: flex; align-items: center; gap: 10px;" class="animate">
            Eventos em Destaque <i data-lucide="sparkles" style="color: #f7a4c7;"></i>
        </h2>
        <div class="grid">
            <?php foreach($eventos as $index => $ev): ?>
                <div class="card glass animate" style="animation-delay: <?php echo 0.2 + ($index * 0.05); ?>s;">
                    <img src="<?= $ev['imagem'] ?>" onerror="this.src='https://via.placeholder.com/400x250/bc98e6/ffffff?text=Mako+Island'">
                    <div class="card-content">
                        <h3 style="margin-bottom: 5px;"><?= htmlspecialchars($ev['nome']) ?></h3>
                        <p style="color: var(--text-muted); font-size: 14px; display: flex; align-items: center; gap: 5px;">
                            <i data-lucide="map-pin" style="width: 14px;"></i> <?= htmlspecialchars($ev['local']) ?>
                        </p>
                        <p style="color: var(--text-muted); font-size: 14px; display: flex; align-items: center; gap: 5px;">
                            <i data-lucide="calendar" style="width: 14px;"></i> <?= date('d/m/Y', strtotime($ev['data'])) ?>
                        </p>
                        <div class="price-badge">R$ <?= number_format($ev['preco'], 2, ',', '.') ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>