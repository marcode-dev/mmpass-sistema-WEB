<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Usuario.php';

class ProfileController extends Controller {
    
    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?url=login");
            exit;
        }
    }


    public function index() {
        $id = $_SESSION['usuario_id'];
        
        // Buscar dados frescos do banco para garantir que nome e email apareçam
        $response = $this->db->get("usuarios", "id=eq." . $id . "&limit=1");
        $user = $response[0] ?? null;

        if ($user) {
            $_SESSION['usuario_nome'] = $user['nome'];
            $_SESSION['usuario_email'] = $user['email'];
        }

        $this->view('perfil', [
            'nome' => $_SESSION['usuario_nome'] ?? '',
            'email' => $_SESSION['usuario_email'] ?? ''
        ]);
    }


    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_SESSION['usuario_id'];
            $nome = trim($_POST['nome'] ?? '');
            $email = trim($_POST['email'] ?? '');

            $usuarioModel = new Usuario($this->db);
            if ($usuarioModel->atualizar($id, $nome, $email)) {
                $_SESSION['usuario_nome'] = $nome;
                $_SESSION['usuario_email'] = $email;
                $msg = "Perfil atualizado com sucesso!";
                $classe = "sucesso";
            } else {
                $msg = "Erro ao atualizar perfil.";
                $classe = "erro";
            }

            $this->view('perfil', [
                'nome' => $_SESSION['usuario_nome'],
                'email' => $_SESSION['usuario_email'],
                'mensagem' => $msg,
                'classe_msg' => $classe
            ]);
        }
    }

    public function updatePassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_SESSION['usuario_id'];
            $senha_atual = $_POST['senha_atual'] ?? '';
            $nova_senha = $_POST['nova_senha'] ?? '';
            $confirma_senha = $_POST['confirma_senha'] ?? '';

            $usuarioModel = new Usuario($this->db);
            
            // Buscar dados atuais para verificar senha
            $response = $this->db->get("usuarios", "id=eq." . $id . "&limit=1");
            $user = $response[0] ?? null;

            if ($user && password_verify($senha_atual, $user['senha'])) {
                if ($nova_senha === $confirma_senha && strlen($nova_senha) >= 6) {
                    $hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                    if ($usuarioModel->atualizarSenha($id, $hash)) {
                        $msg = "Senha atualizada com sucesso!";
                        $classe = "sucesso";
                    } else {
                        $msg = "Erro técnico ao atualizar senha.";
                        $classe = "erro";
                    }
                } else {
                    $msg = "As novas senhas não coincidem ou são muito curtas.";
                    $classe = "erro";
                }
            } else {
                $msg = "Senha atual incorreta.";
                $classe = "erro";
            }

            $this->view('perfil', [
                'nome' => $_SESSION['usuario_nome'],
                'email' => $_SESSION['usuario_email'],
                'mensagem' => $msg,
                'classe_msg' => $classe
            ]);
        }
    }

    public function delete() {
        $id = $_SESSION['usuario_id'];
        $usuarioModel = new Usuario($this->db);
        
        if ($usuarioModel->deletar($id)) {
            session_destroy();
            header("Location: index.php?url=login&status=excluido");
            exit;
        } else {
            $this->view('perfil', [
                'nome' => $_SESSION['usuario_nome'],
                'email' => $_SESSION['usuario_email'],
                'mensagem' => "Erro ao excluir conta.",
                'classe_msg' => "erro"
            ]);
        }
    }
}

