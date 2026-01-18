
<?php
/* MODELO CATEGORIA MODEL */
class BeneficioUsuarioModel {
    private $db;
    // Constructor de la clase, inicializa la conexión a la base de datos  
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    public function obtenerPorUsuario($usuario_id) {
        $query = "SELECT ub.*, b.nombre as beneficio_nombre
                 FROM usuarios_beneficios ub
                 LEFT JOIN beneficios b ON ub.beneficio_id = b.id
                 WHERE ub.usuario_id = :usuario_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':usuario_id' => $usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function solicitarBeneficio($usuario_id, $beneficio_id) {
        $query = "INSERT INTO usuarios_beneficios (usuario_id, beneficio_id, fecha_solicitado)
                 VALUES (:usuario_id, :beneficio_id, NOW())";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':beneficio_id' => $beneficio_id
        ]);
    }
}