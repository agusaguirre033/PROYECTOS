<?php
/* MODELO VACACIONES
   Responsable de gestionar las operaciones relacionadas con las vacaciones de los usuarios.
   Se usan querys para modificar la base de datos.
*/
class VacationModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function crearVacacion($usuarioId, $fechaInicio, $fechaFin) {
        $fechaSolicitud = date('Y-m-d H:i:s'); // Obtiene la fecha actual
        $sql = "INSERT INTO vacaciones (usuario_id, fecha_solicitud, fecha_inicio, fecha_fin, estado_id)
                VALUES (:usuario_id, :fecha_solicitud, :fecha_inicio, :fecha_fin, 1)"; // 1 es el ID para "Pendiente"
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'usuario_id' => $usuarioId,
            'fecha_solicitud' => $fechaSolicitud,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin
        ]);
        return $this->db->lastInsertId();
    }

    public function obtenerVacaciones() {
        $sql = "SELECT v.*, e.estado 
                FROM vacaciones v 
                JOIN estados_vacaciones e ON v.estado_id = e.id
                ORDER BY v.fecha_solicitud DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerVacacionesJSON() {
        $sql = "
            SELECT
                v.*,
                e.estado,
                u.nombre,
                u.apellido,
                v.motivo_rechazo
            FROM vacaciones v
            JOIN estados_vacaciones e ON v.estado_id = e.id
            JOIN usuarios u ON v.usuario_id = u.id
            ORDER BY v.fecha_solicitud DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obtenerPorUsuarioId($usuario_id) {
        $sql = "SELECT v.*, e.estado, u.email, u.nombre
                FROM vacaciones v
                JOIN estados_vacaciones e ON v.estado_id = e.id
                JOIN usuarios u ON v.usuario_id = u.id
                WHERE v.usuario_id = :usuario_id
                ORDER BY v.fecha_solicitud DESC, v.fecha_inicio DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['usuario_id' => $usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT v.*, e.estado, u.email, u.nombre
                FROM vacaciones v
                JOIN estados_vacaciones e ON v.estado_id = e.id
                JOIN usuarios u ON v.usuario_id = u.id
                WHERE v.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function actualizarEstado($id, $estadoId) {
        $sql = "UPDATE vacaciones SET estado_id = :estado_id WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['estado_id' => $estadoId, 'id' => $id]);
    }

    public function eliminarVacacion($id) {
        $sql = "DELETE FROM vacaciones WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function actualizarEstadoConMotivo($id, $estadoId, $motivo = '') {
        $sql = "UPDATE vacaciones SET estado_id = :estado_id, motivo_rechazo = :motivo WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'estado_id' => $estadoId,
            'motivo' => $motivo,
            'id' => $id
        ]);
    }

    public function contarVacacionesEnPeriodo($fechaInicio, $fechaFin, $usuarioIdExcluir = null) {
        try {
            $sql = "
                SELECT COUNT(DISTINCT v.usuario_id) as total
                FROM vacaciones v
                WHERE 
                    (
                        (v.fecha_inicio BETWEEN :fecha_inicio AND :fecha_fin)
                        OR 
                        (v.fecha_fin BETWEEN :fecha_inicio AND :fecha_fin)
                        OR 
                        (:fecha_inicio BETWEEN v.fecha_inicio AND v.fecha_fin)
                    )
                    AND v.estado_id IN (1, 2) -- IDs de estados 'Pendiente' y 'Aprobado'
            ";

            $params = [
                ':fecha_inicio' => $fechaInicio,
                ':fecha_fin' => $fechaFin
            ];

            if ($usuarioIdExcluir) {
                $sql .= " AND v.usuario_id != :usuario_id";
                $params[':usuario_id'] = $usuarioIdExcluir;
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)$resultado['total'];

        } catch (PDOException $e) {
            error_log("Ocurrió un error: " . $e->getMessage());
            throw new Exception("Error - ");
        }
    }
}