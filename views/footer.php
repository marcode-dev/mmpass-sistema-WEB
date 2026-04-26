<footer class="footer glass animate mt-40">
    <div class="footer-container">
        <!-- Brand & Description -->
        <div class="footer-section brand-info">
            <div class="footer-brand">
                <img src="/mmpass-sistema-WEB/assets/logo.png" alt="Logo MMPass" class="footer-logo">
                <h2 class="gradient-text">MMPass</h2>
            </div>
            <p class="footer-text">
                Sistema de gestão de eventos e ingressos. Focado em performance, 
                experiência do usuário e escalabilidade corporativa.
            </p>
        </div>

        <!-- Team / Integrantes -->
        <div class="footer-section">
            <h3 class="footer-title">Equipe do Projeto</h3>
            <ul class="footer-list">
                <li><i data-lucide="user" class="icon-xs"></i> Marcos Gustavo - Scrum Master</li>
                <li><i data-lucide="user" class="icon-xs"></i> Lara Fabiano</li>
                <li><i data-lucide="user" class="icon-xs"></i> Israel Tassi</li>
                <li><i data-lucide="user" class="icon-xs"></i> Rafaela Bocchi</li>
                <li><i data-lucide="user" class="icon-xs"></i> Kauany Macedo</li>
            </ul>
        </div>

        <!-- Quick Links -->
        <div class="footer-section">
            <h3 class="footer-title">Navegação</h3>
            <ul class="footer-list">
                <li><a href="index.php?url=dashboard">Mural de Eventos</a></li>
                <li><a href="index.php?url=meus-eventos">Meus Eventos</a></li>
                <li><a href="index.php?url=cupons">Cupons de Desconto</a></li>
            </ul>
        </div>

        <!-- Social / GitHub -->
        <div class="footer-section">
            <h3 class="footer-title">Repositório</h3>
            <a href="https://github.com/marcode-dev/mmpass-sistema-WEB" target="_blank" class="footer-github-link">
                <img src="https://cdn-icons-png.flaticon.com/512/25/25231.png" alt="GitHub" class="footer-github-icon">
                <span>Ver no GitHub</span>
            </a>
            <div class="footer-meta mt-20">
                <span class="version-tag"></span>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> MMPass System. Todos os direitos reservados.</p>
    </div>
</footer>

<script>
    // Inicia os ícones do Lucide no rodapé caso não tenham sido carregados
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
