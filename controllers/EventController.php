<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Evento.php';

class EventController extends Controller {

    public function list() {
        $this->checkAuth();
        $eventoModel = new Evento($this->db);
        $meus_eventos = $eventoModel->buscarPorUsuario($_SESSION['usuario_id']);
        
        $this->view('meus-eventos', ['meus_eventos' => $meus_eventos]);
    }

    public function details() {
        $this->checkAuth();
        $evento_id = $_GET['id'] ?? null;
        if (!$evento_id) $this->redirect('index.php?url=meus-eventos');

        $eventoModel = new Evento($this->db);
        $evento = $eventoModel->buscarPorIdEUsuario($evento_id, $_SESSION['usuario_id']);
        
        if (!$evento) die("Acesso negado.");

        $compras = $eventoModel->buscarCompras($evento_id);
        $total_ingressos = is_array($compras) ? count($compras) : 0;

        $this->view('detalhes_evento', [
            'evento' => $evento,
            'compras' => $compras,
            'total_ingressos' => $total_ingressos
        ]);
    }

    public function save() {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('index.php?url=meus-eventos');

        $eventoModel = new Evento($this->db);
        $eventoModel->cadastrar(
            $_POST['nome'],
            $_POST['data'],
            $_POST['local'],
            $_POST['preco'],
            $_POST['imagem'],
            $_POST['capacidade'],
            $_SESSION['usuario_id']
        );

        $this->redirect('index.php?url=meus-eventos');
    }

    public function delete() {
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $eventoModel = new Evento($this->db);
            $eventoModel->excluir($id, $_SESSION['usuario_id']);
        }
        $this->redirect('index.php?url=meus-eventos');
    }
}
