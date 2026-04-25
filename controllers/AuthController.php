<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Usuario.php';

class AuthController extends Controller {

    public function showLogin() {
        if (isset($_SESSION['usuario_id'])) {
            $this->redirect('index.php?url=dashboard');
        }

        $mensagem = "";
        $classe_msg = "";

        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'erro') {
                $mensagem = "E-mail ou senha incorretos!";
                $classe_msg = "erro";
            } elseif ($_GET['status'] == 'cadastrado') {
                $mensagem = "Conta criada com sucesso! Faça login.";
                $classe_msg = "sucesso";
            }
        }

        $this->view('index', ['mensagem' => $mensagem, 'classe_msg' => $classe_msg]);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('index.php?url=login');

        $usuario = new Usuario($this->db);
        $usuario->email = $_POST['email'];
        $usuario->senha = $_POST['senha'];

        $dadosUsuario = $usuario->login();

        if ($dadosUsuario) {
            $_SESSION['usuario_id'] = $dadosUsuario['id'];
            $_SESSION['usuario_nome'] = $dadosUsuario['nome'];
            $this->redirect('index.php?url=dashboard');
        } else {
            $this->redirect('index.php?url=login&status=erro');
        }
    }

    public function showRegister() {
        $mensagem = "";
        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'existe') {
                $mensagem = "Este e-mail já está cadastrado!";
            } elseif ($_GET['status'] == 'erro') {
                $mensagem = "Erro ao realizar cadastro. Tente novamente.";
            }
        }
        $this->view('cadastro', ['mensagem' => $mensagem]);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('index.php?url=cadastro');

        $usuarioModel = new Usuario($this->db);
        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        if ($usuarioModel->emailExiste($email)) {
            $this->redirect('index.php?url=cadastro&status=existe');
        }

        if ($usuarioModel->cadastrar($nome, $email, $senha)) {
            $this->redirect('index.php?url=login&status=cadastrado');
        } else {
            $this->redirect('index.php?url=cadastro&status=erro');
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        $this->redirect('index.php?url=login');
    }
}
