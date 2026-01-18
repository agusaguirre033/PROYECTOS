<?php
/* CONTROLADOR VACACIONES
   Responsable de gestionar las operaciones relacionadas con las solicitudes de vacaciones.
*/

// Ruta de las dependencias
require_once BASE_PATH . 'models/VacationModel.php';
require_once BASE_PATH . 'services/EmailService.php';

class VacationController {
        private $vacationModel;
        private $emailService; 
    
        // Se inician las dependencias
        public function __construct() {
            $this->vacationModel = new VacationModel();
            $this->emailService = new EmailService();  
        }
        
    // Método para redirigir al dashboard según su puesto.
    public function redirigirDashboard() {
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['puesto_id'] == 1) {
                header("Location: ./admin/dashboard");
            } else {
                header("Location: ./user/dashboard");
            }
            exit();
        }
    }

    // Método para mostrar todas las solicitudes de vacaciones (admin)
    public function manageVacations() {
        require BASE_PATH . 'views/admin/manageVacations.php';
    }

    // Método para mostrar las vacaciones del usuario (usuario)
    public function misVacaciones() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: login");
            exit();
        }
        
        require BASE_PATH . 'views/user/vacations.php';
    }

    public function solicitarVacacion() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $response = ['status' => 'error', 'message' => ''];
    
            try {
                // Validar campos requeridos
                if (empty($_POST['usuario_id']) || empty($_POST['fecha_inicio']) || empty($_POST['fecha_fin'])) {
                    throw new Exception('Todos los campos son requeridos');
                }
    
                $usuarioId = $_POST['usuario_id'];
                $fechaInicio = $_POST['fecha_inicio'];
                $fechaFin = $_POST['fecha_fin'];
    
                $fechaInicioObj = new DateTime($fechaInicio);
                $fechaFinObj = new DateTime($fechaFin);
                $hoy = new DateTime();
    
                // Validación de 30 días de anticipación
                $diferenciaDias = $hoy->diff($fechaInicioObj)->days;
                if ($diferenciaDias < 30) {
                    throw new Exception('Las vacaciones deben solicitarse con al menos 30 días de anticipación');
                }
    
                // Validación de fecha fin posterior a inicio
                if ($fechaFinObj <= $fechaInicioObj) {
                    throw new Exception('La fecha de fin debe ser posterior a la fecha de inicio');
                }
    
                // Validar superposición con otros empleados
                $vacacionesSuperpuestas = $this->vacationModel->contarVacacionesEnPeriodo($fechaInicio, $fechaFin, $usuarioId);
                if ($vacacionesSuperpuestas >= 2) {
                    throw new Exception('Ya hay 2 empleados con vacaciones aprobadas en ese período. Por favor, seleccione otras fechas');
                }
    
                // Intentar crear la vacación
                $vacacionId = $this->vacationModel->crearVacacion($usuarioId, $fechaInicio, $fechaFin, 'pendiente');
    
                if ($vacacionId) {
                    $response['status'] = 'success';
                    $response['message'] = 'Solicitud de vacaciones creada exitosamente';
    
                    // Programa la tarea para verificar el estado de la solicitud
                    $this->programarVerificacionEstadoSiSeAproboONo($vacacionId, $fechaInicio);
                    
                    // Programa la tarea para enviar el correo tras 30 días si sigue pendiente
                    $this->programarEnvioCorreo($vacacionId);
                    
                } else {
                    throw new Exception('Error al crear la solicitud de vacaciones');
                }
    
            } catch (Exception $e) {
                $response['message'] = $e->getMessage();
            }
    
            // Enviar respuesta JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }
    }

    
    public function aprobar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtener información del usuario
            $vacacion = $this->vacationModel->obtenerPorId($id);
            if ($vacacion) {
                if ($this->vacationModel->actualizarEstado($id, 2)) { // 2 es el ID para "Aprobado"
                    // Enviar correo de notificación
                    $emailService = new EmailService();
                    $emailService->enviarCorreo_NotificacionVacaciones(
                        $vacacion['email'],
                        $vacacion['nombre'],
                        $vacacion['fecha_inicio'],
                        $vacacion['fecha_fin'],
                        true
                    );
                }
            }
            exit();
        }
    }
    
    public function rechazar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $motivo = isset($_POST['motivo']) ? $_POST['motivo'] : '';
            
            // Obtener información del usuario
            $vacacion = $this->vacationModel->obtenerPorId($id);
            if ($vacacion) {
                if ($this->vacationModel->actualizarEstadoConMotivo($id, 3, $motivo)) { // 3 es el ID para "Rechazado"
                    // Enviar correo de notificación
                    $emailService = new EmailService();
                    $emailService->enviarCorreo_NotificacionVacaciones(
                        $vacacion['email'],
                        $vacacion['nombre'],
                        $vacacion['fecha_inicio'],
                        $vacacion['fecha_fin'],
                        false,
                        $motivo
                    );
                }
            }
            exit();
        }
    }

    public function obtenerVacacionesJSON() {
        $vacaciones = $this->vacationModel->obtenerVacacionesJSON();
        header('Content-Type: application/json');
        echo json_encode($vacaciones);
        exit;
    }
    
    public function obtenerVacacionesUsuarioJSON() {
        $vacaciones = $this->vacationModel->obtenerPorUsuarioId($_SESSION['user_id']);
        header('Content-Type: application/json');
        echo json_encode($vacaciones);
        exit;
    }

}
