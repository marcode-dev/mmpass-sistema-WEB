<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Evento.php';

class EventController extends Controller {

    public function list() {
        $this->checkAuth();
        $eventoModel = new Evento($this->db);
        if (!empty($_SESSION['usuario_admin'])) {
            $meus_eventos = $eventoModel->buscarTodos();
        } else {
            $meus_eventos = $eventoModel->buscarPorUsuario($_SESSION['usuario_id']);
        }
        
        $hoje = date('Y-m-d');
        $eventos_ativos = [];
        $eventos_encerrados = [];

        foreach ($meus_eventos as $evento) {
            $data_evento = date('Y-m-d', strtotime($evento['data']));
            if ($data_evento >= $hoje) {
                $eventos_ativos[] = $evento;
            } else {
                $eventos_encerrados[] = $evento;
            }
        }

        $this->view('meus-eventos', [
            'eventos_ativos' => $eventos_ativos,
            'eventos_encerrados' => $eventos_encerrados
        ]);
    }

    public function details() {
        $this->checkAuth();
        $evento_id = $_GET['id'] ?? null;
        if (!$evento_id) $this->redirect('index.php?url=meus-eventos');

        $eventoModel = new Evento($this->db);
        $evento = $eventoModel->buscarPorId($evento_id);
        
        if (!$evento) die("Evento não encontrado.");

        if ($evento['usuario_id'] != $_SESSION['usuario_id'] && empty($_SESSION['usuario_admin'])) {
            $this->redirect('index.php?url=meus-eventos');
        }

        $compras = $eventoModel->buscarCompras($evento_id);

        // Buscar descontos reais se houver IDs de cupom (O ID é armazenado na coluna 'desconto')
        $coupon_ids = array_filter(array_unique(array_column($compras, 'desconto')));
        $cupons_map = [];
        if (!empty($coupon_ids)) {
            $ids_str = implode(',', $coupon_ids);
            $cupons_data = $this->db->get("cupons", "id=in.(" . $ids_str . ")");
            if (is_array($cupons_data) && !isset($cupons_data['error'])) {
                foreach ($cupons_data as $cp) {
                    $cupons_map[$cp['id']] = $cp['desconto%'] ?? 0;
                }
            }
        }

        // Aplicar os descontos reais em cada ingresso para que o cálculo seguinte funcione
        if (is_array($compras)) {
            foreach ($compras as &$c) {
                if ($c['desconto'] > 0) {
                    $c['desconto'] = $cupons_map[$c['desconto']] ?? 0;
                }
            }
            unset($c);
        }

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
        // Financeiro Inicial
        $preco_unitario = (float)($evento['preco'] ?? 0);
        $receita_bruta = $total_ingressos * $preco_unitario;

        // Cálculo de Descontos
        $desconto_total = 0;
        if (is_array($compras)) {
            foreach ($compras as $c) {
                $valor_desconto = ($preco_unitario * ($c['desconto'] / 100));
                $desconto_total += $valor_desconto;
            }
        }

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
            'desconto_total' => $desconto_total,
            'status_texto' => $status_texto,
            'status_class' => $status_class
        ]);

    }

    public function save() {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('index.php?url=meus-eventos');

        $imagem = !empty($_POST['imagem']) ? $_POST['imagem'] : '/mmpass-sistema-WEB/assets/default-event.png';

        $eventoModel = new Evento($this->db);
        $eventoModel->cadastrar(
            $_POST['nome'],
            $_POST['data'],
            $_POST['local'],
            $_POST['preco'],
            $imagem,
            $_POST['capacidade'],
            $_SESSION['usuario_id']
        );

        $this->redirect('index.php?url=meus-eventos');
    }

    public function update() {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('index.php?url=meus-eventos');

        $id = $_POST['id'];

        $eventoModel = new Evento($this->db);
        $evento = $eventoModel->buscarPorId($id);
        
        if (!$evento || ($evento['usuario_id'] != $_SESSION['usuario_id'] && empty($_SESSION['usuario_admin']))) {
            $this->redirect('index.php?url=meus-eventos');
        }

        $imagem = !empty($_POST['imagem']) ? $_POST['imagem'] : '/mmpass-sistema-WEB/assets/default-event.png';

        $dados = [
            "nome" => $_POST['nome'],
            "data" => $_POST['data'],
            "local" => $_POST['local'],
            "preco" => $_POST['preco'],
            "capacidade" => $_POST['capacidade'],
            "imagem" => $imagem
        ];

        $eventoModel->atualizar($id, $dados);

        $this->redirect('index.php?url=meus-eventos');
    }

    public function delete() {
        $this->checkAuth();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $eventoModel = new Evento($this->db);
            $evento = $eventoModel->buscarPorId($id);
            if ($evento && ($evento['usuario_id'] == $_SESSION['usuario_id'] || !empty($_SESSION['usuario_admin']))) {
                $eventoModel->excluir($id, $_SESSION['usuario_id']);
            }
        }
        $this->redirect('index.php?url=meus-eventos');
    }
}
