<?php
/*
 CONTROLADOR AUTH 
 Responsable de gestionar la autenticación de usuarios, registro y recuperación de contraseña.
*/

// Ruta de las dependencias
require_once BASE_PATH . 'models/UserModel.php';
require_once BASE_PATH . 'models/AreaModel.php'; 
require_once BASE_PATH . 'services/EmailService.php';

class AuthController { 
    private $userModel;
    private $areaModel;

    // Se inician las dependencias: UserModel para gestionar los usuarios y EmailService para enviar correos.
    public function __construct() {
        $this->userModel = new UserModel();
        $this->areaModel = new AreaModel();
        $this->emailService = new EmailService();
    }

    // Método para redirigir al dashboard según su puesto. Se incluye en todos los métodos, así si tiene una sesión establecida lo redirige al dashboard.
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


    // Método para registrar un usuario
    public function registro() {

        $areas = $this->areaModel->obtenerAreas();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Si la solicitud es POST (recibimos datos para el registro)
            // Se preparan los datos recibidos en la vista
            $data = [
                'dni' => $_POST['dni'],
                'clave' => $_POST['clave'],
                'nombre' => $_POST['nombre'],
                'apellido' => $_POST['apellido'],
                'email' => $_POST['email'],
                'fecha_nacimiento' => $_POST['fecha_nacimiento'],
                'puesto_id' => intval($_POST['puesto']),
                'area_id' => intval($_POST['area']),
            ];

            // Primero validamos la contraseña con el método validarClave
            if (!$this->validarClave($data['clave'])) {
                $error = "La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un caracter especial.";
                require BASE_PATH . 'views/auth/register.php';
                return;
            }

            // Verificamos que las contraseñas coincidan
            if ($data['clave'] !== $_POST['confirmar_clave']) {
                $error = "Las contraseñas no coinciden.";
                require BASE_PATH . 'views/auth/register.php';
                return;
            }

            // Verificamos que el usuario puso una área en el formulario
            if (empty($data['area_id'])) {
                $error = "Tenés que seleccionar a que área perteneces.";
                require BASE_PATH . 'views/auth/register.php';
                return;
            }

            // Una vez hechas las validaciones, hasheamos la contraseña antes de guardarla.
            // En vez de crear una función (visto en el proyecto del profe) usamos la función de PHP 'password_hash' y el algoritmo por defecto.
            $data['clave'] = password_hash($data['clave'], PASSWORD_DEFAULT);

            // Llamamos al modelo User para crear el usuario
            $userId = $this->userModel->crearUsuario($data);

            // Lo autenticamos y dirigimos al dashboard
            if ($userId) {
                $_SESSION['user_id'] = $userId;
                $_SESSION['dni'] = $data['dni'];
                $_SESSION['puesto_id'] = $data['puesto_id'];
                $_SESSION['nombre'] = $data['nombre'];
                header("Location: register?success");
                exit();
            }
        }
        // Si no es una solicitud POST (no hay datos) se muestra la página.
        require BASE_PATH . 'views/auth/register.php';
    }

    // Función para válidar la contraseña
    private function validarClave($password) {
        /* Expresión para verificar que cumpla con los requisitos que establecimos:
            (?=.*[a-z]): Que haya al menos una minúscula
            (?=.*[A-Z]): Lo mismo pero con una mayúscula
            (?=.*\d): Verifica que haya un dígito
            (?=.[@$!%?&]): Verifica que haya un carácter especial
            [A-Za-z\d@$!%*?&]{8,}: Permite cualquier combinación (según tenga lo anterior) con un minímo de 8 carácteres
        */
        $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
        // El preg_match comprueba si pasa la validación y devuelve true o false para usarse en el método registro/restablecer contraseña
        return preg_match($pattern, $password); 
    }

    // Método para iniciar sesión
    public function iniciarSesion() {
        
        $this->redirigirDashboard();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $dni = $_POST['dni'];
            $clave = $_POST['clave'];
            
            // Se verifican las credenciales, se busca por DNI al usuario
            $user = $this->userModel->buscarPorDNI($dni);
            if ($user && password_verify($clave, $user['clave'])) {
                // Si coincide con un registro, se crea la sesión y dirige al usuario al dashboard
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['dni'] = $user['dni'];
                $_SESSION['puesto_id'] = $user['puesto_id'];
                $_SESSION['nombre'] = $user['nombre'];
                $this->redirigirDashboard();
                exit();
            } else {
                $error = "Los datos no son correctos :(";
            }
        }
        require BASE_PATH . 'views/auth/login.php'; // Si no es una solicitud POST (sin datos), enviamos al usuario al login.
    }

    // Método para manejar la recuperación de contraseña
    public function recuperarClave() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            // Se busca el usuario por su email registrado
            $user = $this->userModel->buscarPorEmail($email);
           
            if ($user) {
                // Si existe el usuario, se crea un token que dura 6 horas para restablecer su contraseña
                $reset_token = bin2hex(random_bytes(16)); // Usamos la función de PHP 'bin2hex' para crear un token (carácteres aleatorios de 16 letras)
                $reset_token_expiry = date('Y-m-d H:i:s', strtotime('+6 hours')); // Obtenemos la fecha de expiración
                $this->userModel->actualizarToken($user['id'], $reset_token, $reset_token_expiry); // Llamamos al método para actualizar el token
                
                // Se envía el correo y envía al usuario al link + '?success' para confirmarle la acción
                if ($this->emailService->enviarCorreo_RecuperarClave($email, $reset_token)) {
                    header("Location: forgot_password?success");
                } else { 
                    $error = "Hubo un problema al enviar el correo. Inténtalo de nuevo más tarde.";
                }
            } else {
                $error = "Esta dirección de correo no está registrada. ¡Creá una cuenta!";
            }
        }
        require BASE_PATH . 'views/auth/forgot_password.php';
    }

    // Método para restablecer la contraseña
    public function restablecerClave() {
        $token = '';
        $error = null;
        $message = null;

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $token = $_GET['token'] ?? ''; // Se obtiene y registra el token del link (?token= TOKEN)
            if (empty($token)) {
                header("Location: forgot_password");
                exit();
            }
            
            // Se busca al usuario por el token que se dio y verifica si es válido
            $user = $this->userModel->buscarPorToken($token);
            if (!$user || strtotime($user['reset_token_expiry']) <= time()) {
                $error = "Token inválido o expirado.";
                header("Location: forgot_password?error");
                exit();
            }
        } 
        // En la solicitud POST se está recibiendo la nueva contraseña
        elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtener el token del link
            $token = $_GET['token'] ?? '';
            $nuevaClave = $_POST['nueva_clave'] ?? '';
            $confirmarClave = $_POST['confirmar_clave'] ?? '';

            // Comprobaciones
            if (empty($token)) {
                $error = "Token no válido.";
            }
            elseif (empty($nuevaClave) || empty($confirmarClave)) {
                $error = "Todos los campos son obligatorios.";
            }
            elseif ($nuevaClave !== $confirmarClave) {
                $error = "Las contraseñas no coinciden.";
            }
            elseif (!$this->validarClave($nuevaClave)) {
                $error = "La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un caracter especial.";
            }
            else { // Si paso las comprobaciones la clave, se busca al usuario, se cambia la contraseña y se elimina el token
                $user = $this->userModel->buscarPorToken($token);
                if ($user && strtotime($user['reset_token_expiry']) > time()) {
                    $hashedPassword = password_hash($nuevaClave, PASSWORD_DEFAULT);
                    if ($this->userModel->actualizarClave($user['id'], $hashedPassword)) {
                        $this->userModel->limpiarToken($user['id']);
                        header("Location: login?success");
                        exit();
                    } else {
                        $error = "Ocurrió un error al actualizar tu contraseña :("; 
                    }
                } else {
                    $error = "Token inválido o expirado."; // Si el token no es válido
                }
            }
        }
        // Si hay algún error o no hay token, se carga la vista de nuevo
        require BASE_PATH . 'views/auth/reset_password.php';
    }

    // Función para cerrar sesión
    public function cerrarSesion() {
        session_destroy();
        header("Location: login");
        exit();
    }
}