<?php
/* CONTROLADOR USER
Se encarga de controlar el acceso al dashboard
*/
class UserController {

    // Verifica la sesión y los permisos antes de cada acción
    private function verificarAcceso() {
        // 1. Verificar si hay sesión activa
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../login");
            exit();
        }
        
        // 2. Verificar si es admin intentando acceder a área de usuarios
        if ($_SESSION['puesto_id'] == 1) {
            header("Location: ../admin/dashboard");
            exit();
        }
        
        // 3. Verificar si es un usuario regular
        if ($_SESSION['puesto_id'] != 0) {
            // Si no es ni admin ni usuario regular, redirigir al login
            header("Location: ../login");
            exit();
        }
    }

    public function dashboard() {
        $this->verificarAcceso();

        require BASE_PATH . 'views/user/dashboard.php';
    }

    
}
