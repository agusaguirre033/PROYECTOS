<?php
/* MODELO AREA
*/
class AreaModel {
    private $db;

    // Inicia conexión a la base de datos  
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Método para obtener todas las áreas
    public function obtenerAreas() {
        $sql = "SELECT * FROM areas WHERE fecha_baja IS NULL ORDER BY nombre";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }
    
    // Método para obtener las áreas pero en JSON. Se usa para solicitudes AJAX en la tabla
    public function obtenerAreasJSON() {
        $query = "SELECT id, nombre FROM areas WHERE fecha_baja IS NULL ORDER BY nombre";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Método para buscar un área por ID
    public function buscarPorId($id) {
        $sql = "SELECT * FROM areas WHERE id = :id AND fecha_baja IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para agregar un nuevo área
    public function altaArea($data) {
        $sql = "INSERT INTO areas (nombre, fecha_alta) VALUES (:nombre, :fecha_alta)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'nombre' => $data['nombre'],
                'fecha_alta' => date('Y-m-d H:i:s') // Fecha y hora de alta
            ]);
            return true;
        } catch(PDOException $e) {
            return ['error' => 'Error al agregar el área: ' . $e->getMessage()];
        }
    }

    // Método para actualizar un área existente
    public function actualizarArea($data) {
        $sql = "UPDATE areas SET nombre = :nombre WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'nombre' => $data['nombre'],
                'id' => $data['id']
            ]);
        } catch(PDOException $e) {
            return false;
        }
    }

    // Método para eliminar (dar de baja) un área
    public function efectuarBaja($id) {
        // Actualiza la fecha_baja y elimina la fecha_alta
        $sql = "UPDATE areas SET fecha_baja = :fecha_baja, fecha_alta = NULL WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'fecha_baja' => date('Y-m-d H:i:s'), // Fecha de baja actual
                'id' => $id
            ]);
        } catch(PDOException $e) {
            return false;
        }
    }
}