<?php
class Evento {
    private $api;
    private $table_name = "eventos";

    public function __construct($api) {
        $this->api = $api;
    }

    public function buscarPorUsuario($usuario_id) {
        return $this->api->get($this->table_name, "select=*,favoritos(count)&usuario_id=eq." . $usuario_id . "&order=data.desc");
    }

    public function buscarPorIdEUsuario($id, $usuario_id) {
        $response = $this->api->get($this->table_name, "select=*,favoritos(count)&id=eq." . $id . "&usuario_id=eq." . $usuario_id . "&limit=1");
        return ($response && count($response) > 0) ? $response[0] : false;
    }

    public function buscarCompras($evento_id) {
        // Junção relacional: busca ingressos e os dados do usuário associado
        $response = $this->api->get("ingressos", "evento_id=eq." . $evento_id . "&select=*,usuarios(nome,email)");
        
        if (!$response) return [];

        // Mapear para o formato que a View espera
        return array_map(function($item) {
            return [
                "id" => $item["id"],
                "usuario_id" => $item["usuario_id"],
                "evento_id" => $item["evento_id"],
                "data_compra" => $item["data_compra"],
                "codigo" => $item["codigo"] ?? "N/A",
                "usado" => $item["usado"] ?? false,
                "comprador_nome" => $item["usuarios"]["nome"] ?? "Desconhecido",
                "comprador_email" => $item["usuarios"]["email"] ?? ""
            ];
        }, $response);
    }

    public function cadastrar($nome, $data, $local, $preco, $imagem, $capacidade, $usuario_id) {
        $payload = [
            "nome" => $nome,
            "data" => $data,
            "local" => $local,
            "preco" => $preco,
            "imagem" => $imagem,
            "usuario_id" => (int)$usuario_id,
            "ingressos_vendidos" => 0,
            "capacidade" => (int)$capacidade
        ];
        $response = $this->api->post($this->table_name, $payload);
        return $response !== false;
    }

    public function excluir($id, $usuario_id) {
        $response = $this->api->delete($this->table_name, $id); // Simplificado: deleta por ID
        return $response !== false;
    }

    public function buscarTodos() {
        return $this->api->get($this->table_name, "select=*,favoritos(count)&order=data.asc");
    }
}
?>