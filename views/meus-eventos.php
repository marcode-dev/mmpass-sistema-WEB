<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Eventos - MMPass</title>
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

        <!-- Formulário de Publicação -->
        <div class="form-box glass animate anim-delay-1 mb-40">
            <h2 class="form-title">
                <i data-lucide="plus-circle" class="icon-purple"></i> Publicar Novo Evento
            </h2>
            <div class="event-form-container">
                <!-- Preview Area -->
                <div class="preview-area">
                    <p class="preview-label">
                        <i data-lucide="eye" class="icon-sm"></i> Visualização da Capa
                    </p>
                    <div class="preview-box">
                        <img id="imgPreview" src="" class="preview-img">
                        <div id="previewPlaceholder" class="preview-placeholder">
                            <i data-lucide="image"></i>
                            <p>Insira a URL abaixo para ver o preview</p>
                        </div>
                    </div>
                </div>

                <!-- Form Inputs -->
                <form action="index.php?url=eventos/save" method="POST" class="event-form">
                    <input type="text" name="nome" class="input-field" placeholder="Nome do Evento" required>
                    <input type="date" name="data" class="input-field" required>
                    <input type="text" name="local" class="input-field" placeholder="Localização (Ex: Blue Lagoon, Mako)" required>
                    <input type="number" step="0.01" name="preco" class="input-field" placeholder="Preço (R$)" required>
                    <input type="number" name="capacidade" class="input-field" placeholder="Capacidade Total" required min="1">
                    <input type="text" name="imagem" id="urlInput" class="input-field full-width" placeholder="Cole aqui a URL da Imagem de Capa" required oninput="updatePreview(this.value)">
                    <button type="submit" class="btn-grad full-width">Lançar Evento no Mural</button>
                </form>
            </div>
        </div>

        <div class="animate filter-section anim-delay-2">
            <div class="filter-bar">
                <h2 class="filter-title">Seus Eventos Publicados</h2>
                <div class="filter-group">
                    <div class="glass search-box">
                        <i data-lucide="search" class="icon-sm"></i>
                        <input type="text" id="filterName" class="search-input" placeholder="Buscar por nome ou local..." oninput="filterEvents()">
                    </div>
                    <select id="sortOrder" onchange="filterEvents()" class="glass sort-select">
                        <option value="newest">Mais Recentes</option>
                        <option value="oldest">Mais Antigos</option>
                        <option value="price-high">Maior Preço</option>
                        <option value="price-low">Menor Preço</option>
                        <option value="hype-high">Maior Hype</option>
                        <option value="hype-low">Menor Hype</option>
                        <option value="name-az">Nome (A-Z)</option>
                    </select>
                </div>
            </div>
        </div>

        <div id="eventList">
            <?php if(!empty($meus_eventos)): ?>
                <?php foreach($meus_eventos as $index => $me): ?>
                    <div class="evento-item glass" 
                         style="animation-delay: <?php echo 0.1 + ($index * 0.05); ?>s;"
                         data-nome="<?= strtolower(htmlspecialchars($me['nome'])) ?>"
                         data-local="<?= strtolower(htmlspecialchars($me['local'])) ?>"
                         data-preco="<?= $me['preco'] ?>"
                         data-hype="<?= $me['favoritos'][0]['count'] ?? 0 ?>"
                         data-timestamp="<?= strtotime($me['data']) ?>"
                         onclick="if(!event.target.closest('.no-click')) window.location.href='index.php?url=eventos/detalhes&id=<?= $me['id'] ?>'">
                        
                        <div class="event-item-inner">
                            <div class="event-img-container">
                                <img src="<?= $me['imagem'] ?>" class="event-img" onerror="this.src='https://via.placeholder.com/150x150/bc98e6/ffffff?text=Icon'">
                            </div>

                            <div class="event-details">
                                <div class="event-row">
                                    <div>
                                        <strong class="event-title"><?= htmlspecialchars($me['nome']) ?></strong>
                                        <div class="event-meta">
                                            <span>
                                                <i data-lucide="calendar" class="icon-sm"></i> <?= date('d/m/Y', strtotime($me['data'])) ?>
                                            </span>
                                            <span>
                                                <i data-lucide="map-pin" class="icon-sm"></i> <?= htmlspecialchars($me['local']) ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="event-price-container">
                                        <div class="hype-badge no-click m-0">
                                            <i data-lucide="flame" class="icon-sm"></i> Hype: <?= $me['favoritos'][0]['count'] ?? 0 ?>
                                        </div>
                                        <span class="gradient-text event-price">R$ <?= number_format($me['preco'], 2, ',', '.') ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="event-actions">
                            <a href="index.php?url=eventos/detalhes&id=<?= $me['id'] ?>" class="btn-manage no-click">
                                <i data-lucide="settings" class="icon-sm"></i> Gerenciar
                            </a>
                            <a href="index.php?url=eventos/delete&id=<?= $me['id'] ?>"
                               class="btn-logout-icon no-click"
                               onclick="return confirm('Tem certeza que deseja remover este evento?')">
                               <i data-lucide="trash-2" class="icon-sm"></i>
                            </a>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                <div class="glass animate no-events-placeholder">
                    <p class="text-muted">Você ainda não cadastrou nenhum evento.</p>
                </div>
            <?php endif; ?> 
            
            <div id="noResults" class="glass animate no-results-msg">
                <i data-lucide="search-x"></i>
                <p>Nenhum evento encontrado com esses critérios...</p>
            </div>
        </div>

        <script>
            function updatePreview(url) {
                const img = document.getElementById('imgPreview');
                const placeholder = document.getElementById('previewPlaceholder');
                if (url.trim() !== "") {
                    img.src = url;
                    img.style.display = 'block';
                    placeholder.style.display = 'none';
                    img.onerror = function() {
                        img.style.display = 'none';
                        placeholder.style.display = 'block';
                    };
                } else {
                    img.style.display = 'none';
                    placeholder.style.display = 'block';
                }
            }

            function filterEvents() {
                const search = document.getElementById('filterName').value.toLowerCase();
                const sort = document.getElementById('sortOrder').value;
                const list = document.getElementById('eventList');
                const noResults = document.getElementById('noResults');
                const items = Array.from(list.getElementsByClassName('evento-item'));

                let visibleCount = 0;
                items.forEach(item => {
                    const nome = item.getAttribute('data-nome');
                    const local = item.getAttribute('data-local');
                    const matches = nome.includes(search) || local.includes(search);
                    item.style.display = matches ? 'flex' : 'none';
                    if(matches) visibleCount++;
                });

                noResults.style.display = (visibleCount === 0 && items.length > 0) ? 'block' : 'none';

                const visibleItems = items.filter(i => i.style.display !== 'none');
                
                visibleItems.sort((a, b) => {
                    const priceA = parseFloat(a.getAttribute('data-preco'));
                    const priceB = parseFloat(b.getAttribute('data-preco'));
                    const timeA = parseInt(a.getAttribute('data-timestamp'));
                    const timeB = parseInt(b.getAttribute('data-timestamp'));
                    const hypeA = parseInt(a.getAttribute('data-hype')) || 0;
                    const hypeB = parseInt(b.getAttribute('data-hype')) || 0;
                    const nameA = a.getAttribute('data-nome');
                    const nameB = b.getAttribute('data-nome');

                    if (sort === 'newest') return timeB - timeA;
                    if (sort === 'oldest') return timeA - timeB;
                    if (sort === 'price-high') return priceB - priceA;
                    if (sort === 'price-low') return priceA - priceB;
                    if (sort === 'hype-high') return hypeB - hypeA;
                    if (sort === 'hype-low') return hypeA - hypeB;
                    if (sort === 'name-az') return nameA.localeCompare(nameB);
                    return 0;
                });

                visibleItems.forEach(item => list.appendChild(item));
            }
            lucide.createIcons();
        </script>
        <?php include 'footer.php'; ?>
    </div>


</body>
</html>
