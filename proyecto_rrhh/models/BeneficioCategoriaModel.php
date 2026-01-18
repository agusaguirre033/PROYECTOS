<?php
/* MODELO CATEGORIA MODEL */
class BeneficioCategoriaModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function obtenerTodas() {
        $query = "SELECT * FROM categorias WHERE fecha_baja IS NULL";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM categorias WHERE id = :id AND fecha_baja IS NULL";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($nombre, $descripcion) {
        $fecha_alta = date('Y-m-d H:i:s');
        $query = "INSERT INTO categorias (nombre, descripcion, fecha_alta) VALUES (:nombre, :descripcion, :fecha_alta)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':fecha_alta' => $fecha_alta
        ]);
    }

    public function actualizar($id, $nombre, $descripcion) {
        $query = "UPDATE categorias SET nombre = :nombre, descripcion = :descripcion WHERE id = :id AND fecha_baja IS NULL";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':id' => $id
        ]);
    }

    public function eliminar($id) {
        $fecha_baja = date('Y-m-d H:i:s');
        $query = "UPDATE categorias SET fecha_baja = :fecha_baja WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':fecha_baja' => $fecha_baja,
            ':id' => $id
        ]);
    }
}