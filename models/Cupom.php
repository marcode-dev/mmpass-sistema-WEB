<?php
class Cupom {
    private $api;
    private $table_name = "cupons";

    public function __construct($api) {
        $this->api = $api;
    }

    public function buscarPorUsuario($usuario_id) {
        return $this->api->get($this->table_name, "order=id.desc");
    }

    public function cadastrar($nome, $desconto, $nivel, $usuario_id) {
        // Tentamos usar os nomes sem caracteres especiais primeiro, que é o padrão recomendado
        $payload = [
            "nome" => $nome,
            "desconto" => (int)$desconto,
            "nivel" => $nivel
        ];
        return $this->api->post($this->table_name, $payload);
    }

    public function atualizar($id, $nome, $desconto, $nivel) {
        $payload = [
            "nome" => $nome,
            "desconto" => (int)$desconto,
            "nivel" => $nivel
        ];
        return $this->api->patch($this->table_name, $id, $payload);
    }

    public function excluir($id) {
        return $this->api->delete($this->table_name, $id);
    }
}
?>
