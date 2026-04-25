<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Cupom.php';

class CouponController extends Controller {

    public function index() {
        $this->checkAuth();
        $cupomModel = new Cupom($this->db);
        $cupons = $cupomModel->buscarPorUsuario($_SESSION['usuario_id']);
        
        $this->view('cupons', ['cupons' => $cupons]);
    }

    public function save() {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('index.php?url=cupons');

        $cupomModel = new Cupom($this->db);
        $cupomModel->cadastrar($_POST['nome'], $_POST['desconto'], $_POST['nivel'], $_SESSION['usuario_id']);
        
        $this->redirect('index.php?url=cupons');
    }

    public function update() {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('index.php?url=cupons');

        $cupomModel = new Cupom($this->db);
        $cupomModel->atualizar($_POST['id'], $_POST['nome'], $_POST['desconto'], $_POST['nivel']);
        
        $this->redirect('index.php?url=cupons');
    }

    public function delete() {
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $cupomModel = new Cupom($this->db);
            $cupomModel->excluir($id);
        }
        $this->redirect('index.php?url=cupons');
    }
}
