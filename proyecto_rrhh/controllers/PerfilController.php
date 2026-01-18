<?php
require_once BASE_PATH . 'models/UserModel.php';
class PerfilController {
    private $userModel;
    public function __construct() {
        $this->userModel = new UserModel();
    }
    public function obtenerPerfil() {
        if (!isset($_SESSION['dni'])) {
            $response = ['success' => false, 'message' => 'Usuario no autenticado'];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
        try {
            $usuario = $this->userModel->buscarPorDNI($_SESSION['dni']);
           
            if ($usuario) {
                $response = [
                    'success' => true,
                    'data' => [
                        'dni' => htmlspecialchars($usuario['dni']),
                        'nombre' => htmlspecialchars($usuario['nombre']),
                        'apellido' => htmlspecialchars($usuario['apellido']),
                        'email' => htmlspecialchars($usuario['email']),
                        'fecha_nacimiento' => htmlspecialchars($usuario['fecha_nacimiento']),
                        'sueldo' => htmlspecialchars($usuario['sueldo'])
                    ]
                ];
            } else {
                throw new Exception('No se encontraron los datos del usuario');
            }
        } catch (Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    public function actualizarPerfil() {
        if (!isset($_SESSION['dni'])) {
            $response = ['success' => false, 'message' => 'Usuario no autenticado'];
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
        try {
            // Validar y sanitizar datos
            $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
            $apellido = filter_input(INPUT_POST, 'apellido', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $fecha_nacimiento = filter_input(INPUT_POST, 'fecha_nacimiento', FILTER_SANITIZE_STRING);
            if (!$nombre || !$apellido || !$email) {
                throw new Exception('Todos los campos son obligatorios');
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('El formato del email no es válido');
            }
            // Verificar email duplicado
            $existingUser = $this->userModel->buscarPorEmail($email);
            if ($existingUser && $existingUser['dni'] !== $_SESSION['dni']) {
                throw new Exception('El email ya está registrado');
            }
            $data = [
                'nombre' => $nombre,
                'apellido' => $apellido,
                'email' => $email,
                'fecha_nacimiento' => $fecha_nacimiento
            ];
            if ($this->userModel->actualizarPerfil($_SESSION['dni'], $data)) {
                $_SESSION['nombre'] = $nombre;
                $_SESSION['apellido'] = $apellido;
                $_SESSION['email'] = $email;
               
                $response = [
                    'success' => true,
                    'message' => 'Perfil actualizado correctamente'
                ];
            } else {
                throw new Exception('Error al actualizar el perfil');
            }
        } catch (Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}