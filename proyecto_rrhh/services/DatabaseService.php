<?php

require_once __DIR__ . '/../config/config.php';

class Database {
    // Instancia privada para el patrón Singleton
    private static $instance = null;
    // Conexión a la base de datos
    private $conn;
    
    private function __construct() {
        // Configuración de parámetros de conexión. Ahora los sacamos del archivo config
        $host = BD_HOST;
        $dbname = BD_NOMBRE; 
        $username = BD_USUARIO;
        $password = BD_CLAVE; 
        
        try {
            // Creación de una nueva conexion PDO
            $this->conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            // Configuración del modo error para lanzar excepciones
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            // Manejo de excepciones en caso de error de conexión
            die("Error de conexión: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        // Verificación si ya existe una instancia
        if (!self::$instance) {
            // Si no existe, se crea una nueva instancia
            self::$instance = new Database();
        }
        // Se devuelve la instancia existente
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->conn;
    }
}