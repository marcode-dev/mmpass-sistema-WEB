<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Evento.php';

class DashboardController extends Controller {
    
    public function index() {
        $this->checkAuth();
        
        $eventoModel = new Evento($this->db);
        $eventos = $eventoModel->buscarTodos();
        
        // Renderiza a view /views/dashboard.php e passa os eventos
        $this->view('dashboard', ['eventos' => $eventos]);
    }

}
