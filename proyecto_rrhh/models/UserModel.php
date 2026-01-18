<?php
/* MODELO USER
 Responsable de gestionar las operaciones relacionadas con los usuarios. Se usan querys para modificar la base de datos. 
*/
class UserModel {
    private $db;
    // Constructor de la clase, inicializa la conexión a la base de datos  
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function crearUsuario($data) {
        $sql = "INSERT INTO usuarios (dni, clave, nombre, apellido, email, fecha_nacimiento, puesto_id, area_id, fecha_alta)
                VALUES (:dni, :clave, :nombre, :apellido, :email, :fecha_nacimiento, :puesto_id, :area_id, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
        return $this->db->lastInsertId();
    }

    public function buscarPorDNI($dni) {
        $sql = "SELECT * FROM usuarios WHERE dni = :dni";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['dni' => $dni]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarToken($userId, $token, $expiry) {
        $sql = "UPDATE usuarios SET reset_token = :token, reset_token_expiry = :expiry WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['token' => $token, 'expiry' => $expiry, 'id' => $userId]);
    }

    public function buscarPorToken($token) {
        $sql = "SELECT * FROM usuarios WHERE reset_token = :token";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarClave($userId, $hashedPassword) {
        $sql = "UPDATE usuarios SET clave = :password WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['password' => $hashedPassword, 'id' => $userId]);
    }
    
    public function limpiarToken($userId) {
        $sql = "UPDATE usuarios SET reset_token = NULL, reset_token_expiry = NULL WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $userId]);
    }

    public function actualizarPerfil($dni, $data) {
        $sql = "UPDATE usuarios SET
                nombre = :nombre,
                apellido = :apellido,
                email = :email,
                fecha_nacimiento = :fecha_nacimiento
                WHERE dni = :dni";
       
        $stmt = $this->db->prepare($sql);
        $params = [
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'email' => $data['email'],
            'fecha_nacimiento' => $data['fecha_nacimiento'],
            'dni' => $dni
        ];
       
        return $stmt->execute($params);
    }

}

