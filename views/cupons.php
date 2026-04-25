<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Cupons - MMPass</title>
    <link rel="stylesheet" href="/mmpass-sistema-WEB/assets/css/global.css?v=1.1">
    <link rel="stylesheet" href="/mmpass-sistema-WEB/assets/css/components.css?v=1.1">
    <link rel="stylesheet" href="/mmpass-sistema-WEB/assets/css/dashboard.css?v=1.1">
    <link rel="stylesheet" href="/mmpass-sistema-WEB/assets/css/cupons.css?v=1.1">
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
                <a href="index.php?url=meus-eventos" class="nav-link">
                    <i data-lucide="calendar" class="icon-sm"></i> Meus Eventos
                </a>
                <a href="index.php?url=cupons" class="nav-link active">
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

        <div class="form-box glass animate anim-delay-1 coupon-form-box">
            <h2 class="form-title">
                <i data-lucide="plus-circle" class="icon-purple"></i> Criar Novo Cupom
            </h2>
            <form action="index.php?url=cupons/save" method="POST" class="event-form" id="couponForm">
                <input type="hidden" name="id" id="cupomId">
                <input type="text" name="nome" id="cupomNome" class="input-field" placeholder="Nome do Cupom (Ex: MAKO20)" required>
                <input type="number" name="desconto" id="cupomDesconto" class="input-field" placeholder="Desconto (%) de 0 a 100" min="0" max="100" required>
                <select name="nivel" id="cupomNivel" class="input-field" required>
                    <option value="" disabled selected>Selecione o Nível Necessário</option>
                    <option value="Bronze">Bronze</option>
                    <option value="Prata">Prata</option>
                    <option value="Ouro">Ouro</option>
                    <option value="Diamante">Diamante</option>
                </select>
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn-grad" style="flex: 2;">Salvar Cupom</button>
                    <button type="button" id="btnCancel" class="btn-outline" style="flex: 1; display: none;" onclick="resetForm()">Cancelar</button>
                </div>
            </form>
        </div>

        <h2 class="section-title animate">
            Seus Cupons Ativos <i data-lucide="tags" class="icon-pink"></i>
        </h2>

        <div class="coupon-grid">
            <?php if(is_array($cupons)): ?>
                <?php foreach($cupons as $index => $c): 
                    // Normalização defensiva para lidar com diferentes nomes de colunas
                    $nivel = $c['nivel'] ?? $c['nível'] ?? 'Bronze';
                    $desconto = $c['desconto'] ?? $c['desconto%'] ?? 0;
                ?>
                    <div class="coupon-card glass animate" style="animation-delay: <?= 0.2 + ($index * 0.05) ?>s">
                        <div class="coupon-badge badge-<?= strtolower($nivel) ?>"><?= $nivel ?></div>
                        <p class="text-muted" style="font-size: 14px;"><?= htmlspecialchars($c['nome']) ?></p>
                        <div class="discount-val gradient-text"><?= $desconto ?>%</div>
                        <p class="text-muted" style="font-size: 12px;">Para usuários nível <?= ucfirst($nivel) ?></p>
                        
                        <div class="coupon-actions">
                            <button class="btn-edit-icon" onclick='editCupom(<?= json_encode($c) ?>)'>
                                <i data-lucide="edit-3" class="icon-sm"></i>
                            </button>
                            <a href="index.php?url=cupons/delete&id=<?= $c['id'] ?>" 
                               class="btn-logout-icon" onclick="return confirm('Excluir este cupom?')">
                                <i data-lucide="trash-2" class="icon-sm"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if(!is_array($cupons) || empty($cupons)): ?>
                <div class="glass animate no-results-msg" style="display: block; grid-column: 1 / -1;">
                    <i data-lucide="ticket" style="width: 40px; height: 40px; opacity: 0.3; margin-bottom: 10px;"></i>
                    <p class="text-muted">Nenhum cupom cadastrado ainda.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function editCupom(cupom) {
            const nivel = cupom.nivel || cupom['nível'];
            const desconto = cupom.desconto || cupom['desconto%'];

            document.getElementById('cupomId').value = cupom.id;
            document.getElementById('cupomNome').value = cupom.nome;
            document.getElementById('cupomDesconto').value = desconto;
            document.getElementById('cupomNivel').value = nivel;
            
            document.getElementById('couponForm').action = "index.php?url=cupons/update";
            document.getElementById('btnCancel').style.display = 'block';
            document.getElementById('couponForm').scrollIntoView({ behavior: 'smooth' });
        }

        function resetForm() {
            document.getElementById('cupomId').value = "";
            document.getElementById('cupomNome').value = "";
            document.getElementById('cupomDesconto').value = "";
            document.getElementById('cupomNivel').value = "";
            
            document.getElementById('couponForm').action = "index.php?url=cupons/save";
            document.getElementById('btnCancel').style.display = 'none';
        }

        lucide.createIcons();
    </script>
</body>
</html>
