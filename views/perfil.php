<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - MMPass</title>
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
                <img src="/mmpass-sistema-WEB/assets/logo.png" alt="Logo MMPass" class="footer-logo">
                <h1 class="gradient-text">MMPass</h1>
            </a>

            <nav class="header-nav">
                <a href="index.php?url=dashboard" class="nav-link">
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
                <a href="index.php?url=perfil" class="user-profile-summary active">
                    <div class="user-avatar-sm">
                        <?= strtoupper(substr($nome, 0, 1)) ?>
                    </div>
                    <span><?= explode(' ', $nome)[0] ?></span>
                </a>
                <a href="index.php?url=logout" class="btn-logout-icon" title="Sair do Portal">
                    <i data-lucide="log-out" class="icon-sm"></i>
                </a>
            </div>
        </div>

        <div class="profile-layout animate anim-delay-1">
            <div class="profile-card glass">
                <div class="profile-header">
                    <div class="profile-avatar-large">
                        <?= strtoupper(substr($nome, 0, 1)) ?>
                    </div>
                    <div class="profile-titles">
                        <h2 class="gradient-text"><?= htmlspecialchars($nome) ?></h2>
                        <p class="text-muted">Gestor de Eventos MMPass</p>
                    </div>
                </div>

                <?php if (isset($mensagem)): ?>
                    <div class="alert alert-<?= $classe_msg ?> animate mb-30"><?= $mensagem ?></div>
                <?php endif; ?>

                <!-- Seção: Informações Básicas -->
                <section class="profile-section" id="info-section">
                    <div class="section-header-row mb-20">
                        <h3 class="section-subtitle">
                            <i data-lucide="user-cog" class="icon-sm icon-purple"></i> Informações Básicas
                        </h3>
                        <button type="button" class="btn-text-edit" onclick="toggleEdit('info')">
                            <i data-lucide="edit-3" class="icon-xs"></i> <span>Editar Informações</span>
                        </button>
                    </div>
                    
                    <form action="index.php?url=perfil/update" method="POST" class="profile-form" id="info-form">
                        <div class="form-grid">
                            <div class="input-group">
                                <label>Nome Completo</label>
                                <input type="text" name="nome" value="<?= htmlspecialchars($nome) ?>" class="input-field is-readonly" id="input-nome" readonly>
                            </div>
                            <div class="input-group">
                                <label>E-mail Principal</label>
                                <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" class="input-field is-readonly" id="input-email" readonly>
                            </div>
                        </div>
                        <div class="form-actions mt-20" style="display: none;" id="info-actions">
                            <button type="submit" class="btn-grad">Salvar Alterações</button>
                            <button type="button" class="btn-text" onclick="toggleEdit('info')">Cancelar</button>
                        </div>
                    </form>
                </section>

                <hr class="section-divider">

                <!-- Seção: Segurança -->
                <section class="profile-section" id="security-section">
                    <h3 class="section-subtitle mb-15">
                        <i data-lucide="shield-check" class="icon-sm icon-purple"></i> Segurança da Conta
                    </h3>
                    
                    <div class="security-status-card mb-20" id="security-summary">
                        <div class="status-info">
                            <p class="text-main">Sua conta está protegida</p>
                            <span class="text-muted" style="font-size: 12px;">Última alteração de senha: Há 15 dias</span>
                        </div>
                        <button type="button" class="btn-outline-sm" onclick="toggleEdit('security')">
                            Alterar Senha
                        </button>
                    </div>

                    <form action="index.php?url=perfil/update-password" method="POST" class="profile-form" id="security-form" style="display: none;">
                        <div class="form-grid">

                            <div class="input-group full-width mb-15">
                                <label>Senha Atual</label>
                                <input type="password" name="senha_atual" class="input-field" placeholder="Digite sua senha atual" required>
                            </div>
                            <div class="input-group">
                                <label>Nova Senha</label>
                                <input type="password" name="nova_senha" class="input-field" placeholder="Pelo menos 6 caracteres" required>
                            </div>
                            <div class="input-group">
                                <label>Confirmar Nova Senha</label>
                                <input type="password" name="confirma_senha" class="input-field" placeholder="Repita a nova senha" required>
                            </div>
                        </div>
                        <div class="form-actions mt-20">
                            <button type="submit" class="btn-outline">Definir Nova Senha</button>
                            <button type="button" class="btn-text" onclick="toggleEdit('security')">Cancelar</button>
                        </div>
                    </form>
                </section>

                <hr class="section-divider">

                <!-- Seção: Zona de Perigo -->
                <section class="profile-section danger-zone">
                    <h3 class="section-subtitle mb-15" style="color: #f87171;">
                        <i data-lucide="alert-triangle" class="icon-sm"></i> Zona de Perigo
                    </h3>
                    <p class="text-muted mb-20">Ao excluir sua conta, todos os seus eventos e dados serão removidos permanentemente.</p>
                    <a href="index.php?url=perfil/delete" 
                       class="btn-delete-full"
                       onclick="return confirm('ATENÇÃO: Você tem certeza que deseja excluir sua conta permanentemente?')">
                        Excluir Minha Conta Permanentemente
                    </a>
                </section>
            </div>
        </div>

        <?php include 'footer.php'; ?>
    </div>

    <script>
        function toggleEdit(section) {
            if (section === 'info') {
                const inputs = ['input-nome', 'input-email'];
                const actions = document.getElementById('info-actions');
                const editBtn = document.querySelector('#info-section .btn-text-edit');
                
                const isReadonly = document.getElementById('input-nome').readOnly;
                
                inputs.forEach(id => {
                    const el = document.getElementById(id);
                    el.readOnly = !isReadonly;
                    el.classList.toggle('is-readonly');
                });
                
                actions.style.display = isReadonly ? 'flex' : 'none';
                editBtn.style.display = isReadonly ? 'none' : 'flex';
                
            } else if (section === 'security') {
                const form = document.getElementById('security-form');
                const summary = document.getElementById('security-summary');
                const isHidden = form.style.display === 'none';
                
                form.style.display = isHidden ? 'block' : 'none';
                summary.style.display = isHidden ? 'none' : 'flex';
            }

        }

        lucide.createIcons();
    </script>
</body>
</html>

