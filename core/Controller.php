<?php

class Controller {
    protected $db;

    public function __construct() {
        require_once __DIR__ . '/../config/Database.php';
        $this->db = (new Database())->getConnection();
    }

    /**
     * Renderiza uma view da pasta /views
     */
    protected function view($name, $data = []) {
        extract($data);
        $viewPath = __DIR__ . '/../views/' . $name . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("Erro: View '{$name}' não encontrada.");
        }
    }

    /**
     * Protege a rota: Verifica se o usuário está logado
     */
    protected function checkAuth() {
        if (!isset($_SESSION['usuario_id'])) {
            $this->redirect('index.php?url=login');
        }
    }

    /**
     * Redireciona para uma rota do sistema
     */
    protected function redirect($url) {
        // Se a barra inicial for omitida e não for index.php, assume que é uma rota
        header("Location: /mmpass-sistema-WEB/" . $url);
        exit();
    }
}
