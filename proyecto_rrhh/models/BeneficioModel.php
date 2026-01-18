<?php
/* MODELO BENEFICIO
*/
class BeneficioModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function obtenerTodos() {
        $query = "SELECT b.*, c.nombre as categoria_nombre
                 FROM beneficios b
                 LEFT JOIN categorias c ON b.categoria_id = c.id
                 WHERE b.fecha_baja IS NULL";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM beneficios WHERE id = :id AND fecha_baja IS NULL";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($nombre, $descripcion, $descuento, $categoria_id) {
        $fecha_alta = date('Y-m-d H:i:s');
        $query = "INSERT INTO beneficios (nombre, descripcion, descuento, categoria_id, fecha_alta)
                 VALUES (:nombre, :descripcion, :descuento, :categoria_id, :fecha_alta)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':descuento' => $descuento,
            ':categoria_id' => $categoria_id,
            ':fecha_alta' => $fecha_alta
        ]);
    }

    public function actualizar($id, $nombre, $descripcion, $descuento, $categoria_id) {
        $query = "UPDATE beneficios
                 SET nombre = :nombre, descripcion = :descripcion, descuento = :descuento, categoria_id = :categoria_id
                 WHERE id = :id AND fecha_baja IS NULL";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':descuento' => $descuento,
            ':categoria_id' => $categoria_id,
            ':id' => $id
        ]);
    }

    public function eliminar($id) {
        $fecha_baja = date('Y-m-d H:i:s');
        $query = "UPDATE beneficios SET fecha_baja = :fecha_baja WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':fecha_baja' => $fecha_baja,
            ':id' => $id
        ]);
    }
}