<?php
class Cupom {
    private $api;
    private $table_name = "cupons";

    public function __construct($api) {
        $this->api = $api;
    }

    public function buscarPorUsuario($usuario_id) {
        // A tabela cupons não possui a coluna usuario_id conforme o screenshot
        return $this->api->get($this->table_name, "order=id.desc");
    }

    public function cadastrar($nome, $desconto, $nivel, $usuario_id) {
        $payload = [
            "nome" => $nome,
            "desconto%" => (int)$desconto,
            "nivel" => $nivel
        ];
        return $this->api->post($this->table_name, $payload);
    }

    public function atualizar($id, $nome, $desconto, $nivel) {
        $payload = [
            "nome" => $nome,
            "desconto%" => (int)$desconto,
            "nivel" => $nivel
        ];
        return $this->api->patch($this->table_name, $id, $payload);
    }

    public function excluir($id) {
        return $this->api->delete($this->table_name, $id);
    }
}
?>
