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

        // Cálculos de Entrada
        $pessoas_entraram = 0;
        foreach($compras as $c) {
            if($c['usado']) $pessoas_entraram++;
        }
        $pessoas_faltam = $total_ingressos - $pessoas_entraram;
        
        // Taxa de Entrada (%)
        $taxa_entrada = ($total_ingressos > 0) ? round(($pessoas_entraram / $total_ingressos) * 100, 1) : 0;

        // Relação Vendas / Capacidade
        $capacidade = $evento['capacidade'] ?? 0;
        $taxa_venda = ($capacidade > 0) ? round(($total_ingressos / $capacidade) * 100, 1) : 0;

        // Financeiro Inicial
        $preco_unitario = (float)($evento['preco'] ?? 0);
        $receita_bruta = $total_ingressos * $preco_unitario;

        // Status Dinâmico
        $hoje = date('Y-m-d');
        $data_evento = date('Y-m-d', strtotime($evento['data']));
        $status_texto = ($data_evento >= $hoje) ? 'Ativo' : 'Encerrado';
        $status_class = ($data_evento >= $hoje) ? 'status-active' : 'status-closed';

        $this->view('detalhes_evento', [
            'evento' => $evento,
            'compras' => $compras,
            'total_ingressos' => $total_ingressos,
            'pessoas_entraram' => $pessoas_entraram,
            'pessoas_faltam' => $pessoas_faltam,
            'taxa_entrada' => $taxa_entrada,
            'taxa_venda' => $taxa_venda,
            'receita_bruta' => $receita_bruta,
            'status_texto' => $status_texto,
            'status_class' => $status_class
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
