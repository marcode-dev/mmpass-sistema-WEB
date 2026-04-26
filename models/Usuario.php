<?php
class Usuario {
    private $api;
    private $table_name = "usuarios";

    public $email;
    public $senha;

    public function __construct($api) {
        $this->api = $api;
    }

    public function login() {
        $response = $this->api->get($this->table_name, "email=eq." . urlencode($this->email) . "&limit=1");
        
        if ($response && count($response) > 0) {
            $user = $response[0];
            if (password_verify($this->senha, $user['senha'])) {
                return $user;
            }
        }
        return false;
    }

    public function cadastrar($nome, $email, $senha) {
        $data = [
            "nome" => $nome,
            "email" => $email,
            "senha" => $senha
        ];
        
        $response = $this->api->post($this->table_name, $data);
        return $response !== false;
    }

    public function emailExiste($email) {
        $response = $this->api->get($this->table_name, "email=eq." . urlencode($email) . "&select=id&limit=1");
        return ($response && count($response) > 0);
    }

    public function atualizar($id, $nome, $email) {
        $data = ["nome" => $nome, "email" => $email];
        return $this->api->patch($this->table_name, $id, $data) !== false;
    }

    public function atualizarSenha($id, $nova_p_hash) {
        $data = ["senha" => $nova_p_hash];
        return $this->api->patch($this->table_name, $id, $data) !== false;
    }

    public function deletar($id) {
        return $this->api->delete($this->table_name, $id) !== false;
    }
}

?>