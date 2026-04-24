<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estatísticas - <?= htmlspecialchars($evento['nome']) ?></title>
    <link rel="stylesheet" href="/Sistema_MMPass/assets/css/style.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .stats-container { display: flex; gap: 20px; margin-bottom: 30px; }
        .stat-card { flex: 1; padding: 25px; text-align: center; }
        .stat-card h2 { font-size: 2rem; margin-top: 10px; }
        
        .table-container {
            border-radius: var(--radius);
            overflow: hidden;
            margin-top: 30px;
        }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 20px; text-align: left; }
        th { background: rgba(188, 152, 230, 0.1); color: #b388eb; font-weight: 700; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; }
        td { border-bottom: 1px solid rgba(0,0,0,0.02); }
        tr:last-child td { border: none; }
    </style>
</head>
<body>
    <div class="main-container">
        <a href="perfil.php" class="btn-outline animate" style="margin-bottom: 30px; display: inline-flex; align-items: center; gap: 8px; border: none; padding-left: 0;">
            <i data-lucide="chevron-left"></i> Voltar ao Perfil
        </a>

        <div class="animate">
            <h1 style="margin-bottom: 10px; display: flex; align-items: center; gap: 10px;">
                <i data-lucide="bar-chart-big" style="color: #bc98e6;"></i> Gestão de Ingressos
            </h1>
            <h2 class="gradient-text" style="font-size: 2.2rem; margin-bottom: 40px;"><?= htmlspecialchars($evento['nome']) ?></h2>
        </div>

        <div class="stats-container animate" style="animation-delay: 0.1s;">
            <div class="stat-card glass">
                <p style="color: var(--text-muted); font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i data-lucide="ticket" style="width: 18px;"></i> Ingressos Vendidos
                </p>
                <h2 class="gradient-text"><?= $total_ingressos ?></h2>
            </div>
            <div class="stat-card glass" style="animation-delay: 0.15s;">
                <p style="color: var(--text-muted); font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i data-lucide="check-circle" style="width: 18px;"></i> Status do Evento
                </p>
                <h2 style="color: #4fd1c5;">Ativo</h2>
            </div>
            <div class="stat-card glass" style="animation-delay: 0.2s;">
                <p style="color: var(--text-muted); font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i data-lucide="banknote" style="width: 18px;"></i> Preço Unitário
                </p>
                <h2 style="color: var(--text-main);">R$ <?= number_format($evento['preco'], 2, ',', '.') ?></h2>
            </div>
        </div>

        <div class="table-container glass animate" style="animation-delay: 0.3s;">
            <table>
                <thead>
                    <tr>
                        <th>Comprador</th>
                        <th>E-mail de Contato</th>
                        <th>Data da Transação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($compras as $c): ?>
                    <tr>
                        <td style="font-weight: 600;"><?= htmlspecialchars($c['comprador_nome']) ?></td>
                        <td style="color: var(--text-muted);"><?= htmlspecialchars($c['comprador_email']) ?></td>
                        <td style="color: var(--text-muted);"><?= date('d/m/Y H:i', strtotime($c['data_compra'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($compras)): ?>
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 40px; color: var(--text-muted);">
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