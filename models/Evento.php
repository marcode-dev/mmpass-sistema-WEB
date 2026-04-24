<?php
class Evento {
    private $conn;
    private $table_name = "eventos";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function buscarPorUsuario($usuario_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE usuario_id = :uid ORDER BY data DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":uid", $usuario_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorIdEUsuario($id, $usuario_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id AND usuario_id = :uid";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":uid", $usuario_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarCompras($evento_id) {
        $query = "SELECT c.*, u.nome as comprador_nome, u.email as comprador_email
                  FROM ingressos c
                  JOIN usuarios u ON c.usuario_id = u.id
                  WHERE c.evento_id = :eid";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":eid", $evento_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastrar($nome, $data, $local, $preco, $imagem, $usuario_id) {
        $query = "INSERT INTO " . $this->table_name . " (nome, data, local, preco, imagem, usuario_id) VALUES (:nome, :data, :local, :preco, :imagem, :usuario_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":data", $data);
        $stmt->bindParam(":local", $local);
        $stmt->bindParam(":preco", $preco);
        $stmt->bindParam(":imagem", $imagem);
        $stmt->bindParam(":usuario_id", $usuario_id);
        return $stmt->execute();
    }

    public function excluir($id, $usuario_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":usuario_id", $usuario_id);
        return $stmt->execute();
    }

    public function buscarTodos() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY data ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>