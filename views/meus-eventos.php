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
                        <img id="imgPreview" src="" class="preview-img" style="display: none;">
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
                    <input type="text" name="imagem" id="urlInput" class="input-field full-width" placeholder="URL da Imagem de Capa (Opcional)" oninput="updatePreview(this.value)">
                    <button type="submit" class="btn-grad full-width">Lançar Evento no Mural</button>
                </form>
            </div>
        </div>

        <div class="animate filter-section anim-delay-2">
            <div class="filter-bar">
                <h2 class="filter-title">Gerenciamento de Eventos</h2>
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

            <div class="tabs-container">
                <button class="tab-btn active" id="tabActive" onclick="switchTab('active')">
                    <i data-lucide="play-circle" class="icon-xs"></i> Eventos Ativos
                </button>
                <button class="tab-btn" id="tabClosed" onclick="switchTab('closed')">
                    <i data-lucide="check-circle" class="icon-xs"></i> Encerrados
                </button>
            </div>
        </div>

        <div id="eventList">
            <!-- Seção de Eventos Ativos -->
            <div id="activeSection" class="tab-content active">
                <div class="events-grid" id="activeGrid">
                    <?php if(!empty($eventos_ativos)): ?>
                        <?php foreach($eventos_ativos as $index => $me): ?>
                            <div class="evento-item glass" 
                                 style="animation-delay: <?php echo 0.1 + ($index * 0.05); ?>s;"
                                 data-id="<?= $me['id'] ?>"
                                 data-nome="<?= strtolower(htmlspecialchars($me['nome'])) ?>"
                                 data-local="<?= strtolower(htmlspecialchars($me['local'])) ?>"
                                 data-preco="<?= $me['preco'] ?>"
                                 data-hype="<?= $me['favoritos'][0]['count'] ?? 0 ?>"
                                 data-timestamp="<?= strtotime($me['data']) ?>"
                                 data-data="<?= $me['data'] ?>"
                                 data-capacidade="<?= $me['capacidade'] ?>"
                                 data-imagem="<?= htmlspecialchars($me['imagem']) ?>"
                                 data-status="ativo"
                                 onclick="if(!event.target.closest('.no-click')) window.location.href='index.php?url=eventos/detalhes&id=<?= $me['id'] ?>'">
                                
                                <div class="event-item-inner">
                                    <div class="event-img-container">
                                        <?php $imagem = !empty($me['imagem']) ? $me['imagem'] : '/mmpass-sistema-WEB/assets/default-event.png'; ?>
                                        <img src="<?= $imagem ?>" class="event-img" onerror="this.src='/mmpass-sistema-WEB/assets/default-event.png'">
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
                                    <button onclick="openEditModal(this.closest('.evento-item'))" class="btn-manage no-click">
                                        <i data-lucide="edit-3" class="icon-sm"></i> Editar
                                    </button>
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
                            <p class="text-muted">Nenhum evento ativo no momento.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Seção de Eventos Encerrados -->
            <div id="closedSection" class="tab-content">
                <div class="events-grid closed-events-grid" id="closedGrid">
                    <?php if(!empty($eventos_encerrados)): ?>
                        <?php foreach($eventos_encerrados as $index => $me): ?>
                            <div class="evento-item glass closed-item" 
                                 style="animation-delay: <?php echo 0.1 + ($index * 0.05); ?>s;"
                                 data-id="<?= $me['id'] ?>"
                                 data-nome="<?= strtolower(htmlspecialchars($me['nome'])) ?>"
                                 data-local="<?= strtolower(htmlspecialchars($me['local'])) ?>"
                                 data-preco="<?= $me['preco'] ?>"
                                 data-hype="<?= $me['favoritos'][0]['count'] ?? 0 ?>"
                                 data-timestamp="<?= strtotime($me['data']) ?>"
                                 data-data="<?= $me['data'] ?>"
                                 data-capacidade="<?= $me['capacidade'] ?>"
                                 data-imagem="<?= htmlspecialchars($me['imagem']) ?>"
                                 data-status="encerrado"
                                 onclick="if(!event.target.closest('.no-click')) window.location.href='index.php?url=eventos/detalhes&id=<?= $me['id'] ?>'">
                                
                                <div class="event-item-inner">
                                    <div class="event-img-container">
                                        <?php $imagem = !empty($me['imagem']) ? $me['imagem'] : '/mmpass-sistema-WEB/assets/default-event.png'; ?>
                                        <img src="<?= $imagem ?>" class="event-img" style="filter: grayscale(1); opacity: 0.6;" onerror="this.src='/mmpass-sistema-WEB/assets/default-event.png'">
                                    </div>

                                    <div class="event-details">
                                        <div class="event-row">
                                            <div>
                                                <strong class="event-title" style="color: var(--text-muted);"><?= htmlspecialchars($me['nome']) ?></strong>
                                                <div class="event-meta">
                                                    <span>
                                                        <i data-lucide="calendar" class="icon-sm"></i> <?= date('d/m/Y', strtotime($me['data'])) ?>
                                                    </span>
                                                    <span class="badge-closed">Encerrado</span>
                                                </div>
                                            </div>
                                            <div class="event-price-container">
                                                <span class="event-price" style="background: none; color: var(--text-muted);">R$ <?= number_format($me['preco'], 2, ',', '.') ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="event-actions">
                                    <button onclick="openEditModal(this.closest('.evento-item'))" class="btn-manage no-click">
                                        <i data-lucide="edit-3" class="icon-sm"></i> Editar
                                    </button>
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
                            <p class="text-muted">Você não possui eventos encerrados.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if(empty($eventos_ativos) && empty($eventos_encerrados)): ?>
                <div class="glass animate no-events-placeholder">
                    <p class="text-muted">Nenhum evento cadastrado no sistema.</p>
                </div>
            <?php endif; ?> 
            
            <div id="noResults" class="glass animate no-results-msg" style="display: none;">
                <i data-lucide="search-x"></i>
                <p>Nenhum evento encontrado com esses critérios...</p>
            </div>
        </div>

        <script>
            function updatePreview(url) {
                const img = document.getElementById('imgPreview');
                const placeholder = document.getElementById('previewPlaceholder');
                const fallback = '/mmpass-sistema-WEB/assets/default-event.png';

                if (url.trim() !== "") {
                    img.src = url;
                    img.style.display = 'block';
                    placeholder.style.display = 'none';
                    img.onerror = () => img.src = fallback;
                } else {
                    img.style.display = 'none';
                    placeholder.style.display = 'block';
                }
            }

            function switchTab(type) {
                const activeBtn = document.getElementById('tabActive');
                const closedBtn = document.getElementById('tabClosed');
                const activeSection = document.getElementById('activeSection');
                const closedSection = document.getElementById('closedSection');

                if (type === 'active') {
                    activeBtn.classList.add('active');
                    closedBtn.classList.remove('active');
                    activeSection.classList.add('active');
                    closedSection.classList.remove('active');
                } else {
                    activeBtn.classList.remove('active');
                    closedBtn.classList.add('active');
                    activeSection.classList.remove('active');
                    closedSection.classList.add('active');
                }
                filterEvents();
            }

            // Funções Modal de Edição
            function openEditModal(item) {
                const id = item.getAttribute('data-id');
                const nome = item.querySelector('.event-title').innerText;
                const local = item.getAttribute('data-local');
                const data = item.getAttribute('data-data');
                const preco = item.getAttribute('data-preco');
                const capacidade = item.getAttribute('data-capacidade');
                const imagem = item.getAttribute('data-imagem');

                document.getElementById('edit_id').value = id;
                document.getElementById('edit_nome').value = nome;
                document.getElementById('edit_data').value = data;
                document.getElementById('edit_local').value = local;
                document.getElementById('edit_preco').value = preco;
                document.getElementById('edit_capacidade').value = capacidade;
                document.getElementById('edit_imagem').value = (imagem.includes('default-event.png')) ? '' : imagem;
                
                updateEditPreview(imagem);

                document.getElementById('editModal').classList.add('active');
            }

            function closeEditModal() {
                document.getElementById('editModal').classList.remove('active');
            }

            function updateEditPreview(url) {
                const img = document.getElementById('editImgPreview');
                const fallback = '/mmpass-sistema-WEB/assets/default-event.png';
                if (url && url.trim() !== "") {
                    img.src = url;
                    img.onerror = () => img.src = fallback;
                } else {
                    img.src = fallback;
                }
            }

            function filterEvents() {
                const search = document.getElementById('filterName').value.toLowerCase();
                const sort = document.getElementById('sortOrder').value;
                const activeGrid = document.getElementById('activeGrid');
                const closedGrid = document.getElementById('closedGrid');
                const noResults = document.getElementById('noResults');

                const items = Array.from(document.getElementsByClassName('evento-item'));
                const activeTab = document.querySelector('.tab-btn.active').id === 'tabActive' ? 'ativo' : 'encerrado';

                let visibleInTab = 0;

                items.forEach(item => {
                    const status = item.getAttribute('data-status');
                    const nome = item.getAttribute('data-nome');
                    const local = item.getAttribute('data-local');
                    const matches = nome.includes(search) || local.includes(search);
                    
                    // Só mostrar se bater com a busca E estiver na aba certa
                    item.style.display = (matches && status === activeTab) ? 'flex' : 'none';
                    
                    if(matches && status === activeTab) visibleInTab++;
                });

                // Mostrar "sem resultados" se houver eventos na aba mas nenhum condizer com a busca
                // Ou se a aba estiver realmente vazia (o PHP já cuida do placeholder no grid)
                const itemsInThisTab = items.filter(i => i.getAttribute('data-status') === activeTab).length;
                noResults.style.display = (itemsInThisTab > 0 && visibleInTab === 0) ? 'block' : 'none';


                // Ordenação por grade
                const sortGrid = (grid) => {
                    if (!grid) return;
                    const gridItems = Array.from(grid.getElementsByClassName('evento-item'))
                        .filter(i => i.style.display !== 'none');

                    gridItems.sort((a, b) => {
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

                    gridItems.forEach(item => grid.appendChild(item));
                };

                sortGrid(activeGrid);
                sortGrid(closedGrid);
            }
            lucide.createIcons();
        </script>
        <?php include 'footer.php'; ?>
    </div>

    <!-- Modal de Edição (Slide-over) -->
    <div id="editModal" class="side-modal">
        <div class="side-modal-overlay" onclick="closeEditModal()"></div>
        <div class="side-modal-content glass">
            <div class="side-modal-header">
                <h3><i data-lucide="edit-3" class="icon-purple"></i> Editar Evento</h3>
                <button class="btn-close-modal" onclick="closeEditModal()">
                    <i data-lucide="x"></i>
                </button>
            </div>

            <form action="index.php?url=eventos/update" method="POST" class="side-modal-form">
                <input type="hidden" name="id" id="edit_id">
                
                <div class="input-group-vertical">
                    <label>Nome do Evento</label>
                    <input type="text" name="nome" id="edit_nome" class="input-field" required>
                </div>

                <div class="input-group-vertical">
                    <label>Data</label>
                    <input type="date" name="data" id="edit_data" class="input-field" required>
                </div>

                <div class="input-group-vertical">
                    <label>Localização</label>
                    <input type="text" name="local" id="edit_local" class="input-field" required>
                </div>

                <div class="form-row-2">
                    <div class="input-group-vertical">
                        <label>Preço (R$)</label>
                        <input type="number" step="0.01" name="preco" id="edit_preco" class="input-field" required>
                    </div>
                    <div class="input-group-vertical">
                        <label>Capacidade</label>
                        <input type="number" name="capacidade" id="edit_capacidade" class="input-field" required min="1">
                    </div>
                </div>

                <div class="input-group-vertical">
                    <label>URL da Imagem</label>
                    <input type="text" name="imagem" id="edit_imagem" class="input-field" oninput="updateEditPreview(this.value)">
                </div>

                <div class="edit-preview-box">
                    <img id="editImgPreview" src="/mmpass-sistema-WEB/assets/default-event.png" class="preview-img">
                </div>

                <button type="submit" class="btn-grad full-width mt-20">Salvar Alterações</button>
            </form>
        </div>
    </div>


</body>
</html>
