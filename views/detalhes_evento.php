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
                <?php $imagem = !empty($evento['imagem']) ? $evento['imagem'] : '/mmpass-sistema-WEB/assets/default-event.png'; ?>
                <img src="<?= $imagem ?>" class="hero-bg-img" onerror="this.src='/mmpass-sistema-WEB/assets/default-event.png'">
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
        <!-- Painel Financeiro (Dashboard Bar) -->
        <div class="glass animate anim-delay-4 finance-bar mt-30">
            <div class="finance-bar-item">
                <span class="mini-stat-label">Receita Bruto</span>
                <span class="val text-purple">R$ <?= number_format($receita_bruta, 2, ',', '.') ?></span>
            </div>
            
            <div class="finance-bar-divider"></div>

            <div class="finance-bar-item">
                <span class="mini-stat-label">Descontos</span>
                <span class="val text-pink" style="color: #f6a5c1;">- R$ <?= number_format($desconto_total, 2, ',', '.') ?></span>
            </div>

            <div class="finance-bar-divider"></div>

            <div class="finance-bar-item">
                <span class="mini-stat-label">Comissão (%)</span>
                <div class="flex-center-start gap-10">
                    <input type="number" id="lucroPercent" value="10" min="0" max="100" class="input-ultra-mini" oninput="updateFinance()">
                    <span class="text-muted" style="font-size: 10px;">%</span>
                </div>
            </div>

            <div class="finance-bar-divider"></div>

            <div class="finance-bar-item">
                <span class="mini-stat-label">Abatimento</span>
                <label class="toggle-switch">
                    <input type="checkbox" id="aplicarDesconto" onchange="updateFinance()">
                    <span class="slider"></span>
                </label>
            </div>

            <div class="finance-bar-divider"></div>

            <div class="finance-bar-item">
                <span class="mini-stat-label">Lucro Líquido</span>
                <span class="val text-green" style="color: #4fd1c5;">R$ <span id="lucroTotal">0,00</span></span>
            </div>
        </div>

        <script>
            function updateFinance() {
                const bruta = <?= (float)$receita_bruta ?>;
                const desconto = <?= (float)$desconto_total ?>;
                const aplicarDesconto = document.getElementById('aplicarDesconto').checked;
                
                let baseCalculo = bruta;
                if (aplicarDesconto) baseCalculo -= desconto;

                const percent = document.getElementById('lucroPercent').value / 100;
                const lucro = baseCalculo * percent;
                document.getElementById('lucroTotal').innerText = lucro.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
            }
            document.getElementById('lucroPercent').addEventListener('input', updateFinance);
            updateFinance();
        </script>



        <div class="table-controls animate anim-delay-4 mt-40">
            <div class="glass search-box-wide">
                <i data-lucide="search" class="icon-sm"></i>
                <input type="text" id="ticketSearch" placeholder="Pesquisar por comprador ou e-mail..." onkeyup="filterTable()">
            </div>
        </div>

        <div class="table-container glass animate anim-delay-4">
            <table id="ticketsTable">
                <thead>
                    <tr>
                        <th onclick="sortTable(0, 'number')" class="th-sortable" style="width: 50px;">ID <i data-lucide="chevrons-up-down"></i></th>
                        <th onclick="sortTable(1, 'string')" class="th-sortable">Comprador <i data-lucide="chevrons-up-down"></i></th>
                        <th onclick="sortTable(2, 'string')" class="th-sortable">E-mail <i data-lucide="chevrons-up-down"></i></th>
                        <th onclick="sortTable(3, 'string')" class="th-sortable" style="width: 100px;">Status <i data-lucide="chevrons-up-down"></i></th>
                        <th onclick="sortTable(4, 'number')" class="th-sortable text-right" style="width: 80px;">% Desc <i data-lucide="chevrons-up-down"></i></th>
                        <th onclick="sortTable(5, 'number')" class="th-sortable text-right" style="width: 100px;">$ Desc <i data-lucide="chevrons-up-down"></i></th>
                        <th onclick="sortTable(6, 'date')" class="th-sortable text-right" style="width: 140px;">Consumado <i data-lucide="chevrons-up-down"></i></th>
                    </tr>
                </thead>
                <tbody id="ticketsBody">
                    <?php if(is_array($compras)): ?>
                        <?php foreach($compras as $c): ?>
                        <tr>
                            <td class="td-muted">#<?= $c['id'] ?></td>
                            <td class="td-bold"><?= htmlspecialchars($c['comprador_nome']) ?></td>
                            <td class="td-muted"><?= htmlspecialchars($c['comprador_email']) ?></td>
                            <td>
                                <?php if($c['usado']): ?>
                                    <span class="status-badge used">Utilizado</span>
                                <?php else: ?>
                                    <span class="status-badge available">Disponível</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-right text-muted-sm"><?= $c['desconto'] ?>%</td>
                            <td class="text-right text-muted-sm">R$ <?= number_format($evento['preco'] * ($c['desconto'] / 100), 2, ',', '.') ?></td>
                            <td class="td-muted text-right" data-date="<?= strtotime($c['data_compra']) ?>"><?= date('d/m/Y H:i', strtotime($c['data_compra'])) ?></td>
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

        <script>
            lucide.createIcons();

            function sortTable(n, type) {
                const tbody = document.getElementById("ticketsBody");
                let rows = Array.from(tbody.rows);
                
                const currentDir = tbody.getAttribute('data-sort-dir-' + n) === 'asc' ? 'desc' : 'asc';
                
                rows.sort((a, b) => {
                    let cellA = a.cells[n];
                    let cellB = b.cells[n];
                    let valA, valB;

                    if (type === 'number') {
                        valA = parseFloat(cellA.innerText.replace(/[^\d.-]/g, "")) || 0;
                        valB = parseFloat(cellB.innerText.replace(/[^\d.-]/g, "")) || 0;
                    } else if (type === 'date') {
                        valA = parseInt(cellA.getAttribute('data-date')) || 0;
                        valB = parseInt(cellB.getAttribute('data-date')) || 0;
                    } else {
                        valA = cellA.innerText.toLowerCase().trim();
                        valB = cellB.innerText.toLowerCase().trim();
                    }

                    if (valA === valB) return 0;
                    if (currentDir === 'asc') return valA > valB ? 1 : -1;
                    return valA < valB ? 1 : -1;
                });

                // Clear and append
                while (tbody.firstChild) tbody.removeChild(tbody.firstChild);
                rows.forEach(row => tbody.appendChild(row));
                
                // Clear other directions
                for(let i=0; i<7; i++) tbody.removeAttribute('data-sort-dir-' + i);
                tbody.setAttribute('data-sort-dir-' + n, currentDir);
            }

            function filterTable() {
                const search = document.getElementById('ticketSearch').value.toLowerCase();
                const tbody = document.getElementById('ticketsBody');
                const rows = tbody.getElementsByTagName('tr');

                for (let i = 0; i < rows.length; i++) {
                    const name = rows[i].cells[1].innerText.toLowerCase();
                    const email = rows[i].cells[2].innerText.toLowerCase();
                    const id = rows[i].cells[0].innerText.toLowerCase();

                    if (name.includes(search) || email.includes(search) || id.includes(search)) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
                }
            }
        </script>
</body>
</html>
