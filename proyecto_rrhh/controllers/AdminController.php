<?php
/* CONTROLADOR ADMIN
Se encarga de controlar el acceso al dashboard (por ahora)
*/
// Ruta de las dependencias
require_once BASE_PATH . 'models/UserModel.php';

class AdminController { 
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }


    // Verifica la sesión y los permisos antes de cada acción
    private function verificarAcceso() {
        // 1. Verificar si hay sesión activa
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../login");
            exit();
        }
        
        // 2. Verificar si es usuario intentando acceder a área admin
        if ($_SESSION['puesto_id'] == 0) {
            header("Location: ../user/dashboard");
            exit();
        }
        
        // 3. Verificar si es un usuario regular
        if ($_SESSION['puesto_id'] != 1) {
            // Si no es ni admin ni usuario regular, redirigir al login
            header("Location: ../login");
            exit();
        }
    }

    // Si el navegador tiene una sesión establecida, la obtiene y carga el dashboard.
    public function dashboard() {
        $this->verificarAcceso();

        require BASE_PATH . 'views/admin/dashboard.php';
    }

}