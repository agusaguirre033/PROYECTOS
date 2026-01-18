<?php
session_start(); // Iniciar la sesión de PHP. Solo se hace en esta línea para que no se rompa.
define('BASE_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR); // Define la ruta base para incluir archivos.
require_once BASE_PATH . 'services/DatabaseService.php'; // Incluye el servicio de base de datos.
require_once BASE_PATH . 'controllers/AuthController.php'; // Controlador de autenticación.
require_once BASE_PATH . 'controllers/UserController.php'; // Controlador de usuario.
require_once BASE_PATH . 'controllers/AdminController.php'; // Controlador de administrador.
require_once BASE_PATH . 'controllers/EmpleadoController.php'; // Controlador de empleados.
require_once BASE_PATH . 'controllers/AreaController.php'; // Controlador de áreas.
require_once BASE_PATH . 'controllers/IndexController.php'; // Controlador del índice.
require_once BASE_PATH . 'controllers/VacationController.php'; // Controlador de vacaciones.
require_once BASE_PATH . 'controllers/PerfilController.php'; // Controlador de editar perfil.
require_once BASE_PATH . 'controllers/CategoriaController.php'; // Controlador de categorías de beneficios
require_once BASE_PATH . 'controllers/BeneficioController.php'; // Controlador de beneficios.


$action = $_GET['action'] ?? 'landing'; // Acá pusimos el caso por defecto.
$authController = new AuthController();
$userController = new UserController();
$adminController = new AdminController();
$empleadoController = new EmpleadoController();
$areaController = new AreaController(); 
$indexController = new IndexController();
$vacationController = new VacationController();
$perfilController = new PerfilController();
$beneficioController = new BeneficioController();
$categoriaController = new CategoriaController();

switch ($action) {
    // Landing. Ruta por defecto
    case 'landing':
        $indexController->landing(); 
        break;

    // Rutas para el auth
    case 'register':
        $authController->registro();
        break;
    case 'login':
        $authController->iniciarSesion();
        break;
    case 'forgot_password':
        $authController->recuperarClave();
        break;
    case 'reset_password':
        $authController->restablecerClave();
        break;
    case 'logout':
        $authController->cerrarSesion();
        break;

    // Ruta para redirigir al dashboard según el puesto
    case 'dashboard':
        $authController->redirigirDashboard();
        break;

    // Páginas del dashboard de usuario
    case 'user/dashboard':
        $userController->dashboard();
        break;

    // Páginas del dashboard de admin
    case 'admin/dashboard':
        $adminController->dashboard();
        break;
    case 'admin/manageEmployees':
        $empleadoController->administrarEmpleados();
        break;

    // Rutas para los controladores de Empleado. Se usan en las páginas.
    case 'modificarEmpleado':
        $empleadoController->modificarEmpleado();
        break;
    case 'actualizarEmpleado':
        $empleadoController->actualizarEmpleado();
        break;
    case 'eliminarEmpleado':
        $empleadoController->eliminarEmpleado(); 
        break;
    case 'obtenerEmpleadosJSON':
        $empleadoController->obtenerEmpleadosJSON();
        break;
    case 'altaEmpleado':
        $empleadoController->altaEmpleado();
        break;

    // Rutas para los controladores de Área. Se usan en las páginas.
    case 'admin/manageAreas':
        $areaController->administrarAreas();
        break;
    case 'actualizarArea':
        $areaController->actualizarArea();
        break;
    case 'eliminarArea':
        $areaController->eliminarArea();
        break;
    case 'obtenerAreasJSON':
        $areaController->obtenerAreasJSON();
        break;
    case 'altaArea':
        $areaController->altaArea();
        break;

    // Rutas para gestionar vacaciones
    case 'admin/manageVacations':
        $vacationController->manageVacations(); 
        break; 
    case 'user/vacations': 
        $vacationController->misVacaciones(); 
        break; 
    case 'user/solicitarVacacion': 
        $vacationController->solicitarVacacion(); 
        break; 
    case 'admin/aprobarVacacion': 
       $vacationController->aprobar($_GET['id']); 
       break; 
    case 'admin/rechazarVacacion': 
       $vacationController->rechazar($_GET['id']); 
       break;
    case 'obtenerVacacionesJSON': 
        $vacationController->obtenerVacacionesJSON(); 
        break; 
    case 'user/obtenerVacacionesJSON': 
        $vacationController->obtenerVacacionesUsuarioJSON(); 
        break; 
    case 'obtenerPerfil':
        $perfilController->obtenerPerfil();
        break;
    case 'actualizarPerfil':
        $perfilController->actualizarPerfil();
        break;

    // Páginas de gestión de beneficios
    case 'admin/manageBenefits':
        $beneficioController->administrarBeneficios();
        break;

    case 'user/benefits':
        $beneficioController->beneficios();
        break;

    // Rutas para los controladores de Categoría
    case 'categoria/obtenerCategoriasJSON':
        $categoriaController->obtenerCategoriasJSON();
        break;
    case 'categoria/obtenerPorId':
        $categoriaController->obtenerCategoriaPorId($_GET['id'] ?? null);
        break;
    case 'categoria/altaCategoria':
        $categoriaController->altaCategoria();
        break;
    case 'categoria/modificarCategoria':
        $categoriaController->actualizarCategoria();
        break;
    case 'categoria/eliminarCategoria':
        $categoriaController->eliminarCategoria();
        break;

    // Rutas para los controladores de Beneficio
    case 'beneficio/obtenerBeneficiosJSON':
        $beneficioController->obtenerBeneficiosJSON();
        break;
    case 'beneficio/obtenerPorId':
        $beneficioController->obtenerBeneficioPorId($_GET['id'] ?? null);
        break;
    case 'beneficio/altaBeneficio':
        $beneficioController->altaBeneficio();
        break;
    case 'beneficio/modificarBeneficio':
        $beneficioController->actualizarBeneficio();
        break;
    case 'beneficio/eliminarBeneficio':
        $beneficioController->eliminarBeneficio();
        break;

    default:
       header("HTTP/1.0 404 Not Found");
       echo "No se encontró la página >.<"; 
       exit();
}
?>
