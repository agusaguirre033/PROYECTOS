<?php
/* MODELO EMPLEADO
*/
class EmpleadoModel {
    private $db;
    // Constructor de la clase, inicializa la conexión a la base de datos  
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    // busca un empleado por su DNI
    public function buscarPorDNI($dni) {
        $sql = "SELECT * FROM usuarios WHERE dni = :dni AND puesto_id = 0";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['dni' => $dni]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Lista todos los empleados.
    public function listarEmpleados() {
            $sql = "SELECT u.dni, u.nombre, u.apellido, u.email, u.fecha_nacimiento, 
                    a.id as area_id, a.nombre AS area_nombre
                    FROM usuarios u
                    JOIN areas a ON u.area_id = a.id
                    WHERE u.puesto_id = 0 AND u.fecha_baja IS NULL";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Formatear la fecha de nacimiento
            foreach ($empleados as &$empleado) {
                $empleado['fecha_nacimiento'] = date('d-m-Y', strtotime($empleado['fecha_nacimiento']));
            }

            return $empleados;

        }
    // Actualiza los datos de un empleado.
    public function actualizarEmpleado($data) {
        $sql = "UPDATE usuarios SET nombre = :nombre, apellido = :apellido, email = :email, fecha_nacimiento = :fecha_nacimiento, area_id = :area_id WHERE dni = :dni";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
    // Actualiza la baja de un emppleado.
    public function efectuarBaja($dni) {
        $sql = "UPDATE usuarios SET fecha_baja = NOW() WHERE dni = :dni";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':dni' => $dni]);
    }
    // Da de alta a un nuevo empleado.
    public function altaEmpleado($data) {
        try {
            $sql = "INSERT INTO usuarios (dni, nombre, apellido, email, fecha_nacimiento, area_id, puesto_id) 
                    VALUES (:dni, :nombre, :apellido, :email, :fecha_nacimiento, :area_id, 0)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':dni' => $data['dni'],
                ':nombre' => $data['nombre'],
                ':apellido' => $data['apellido'],
                ':email' => $data['email'],
                ':fecha_nacimiento' => $data['fecha_nacimiento'],
                ':area_id' => $data['area_id']
            ]);
        } catch (PDOException $e) {
            // Si el DNI ya existe
            if ($e->getCode() == 23000) {
                return ['error' => 'El DNI ya existe en el sistema'];
            }
            return ['error' => 'Error al dar de alta al empleado'];
        }
    }
}