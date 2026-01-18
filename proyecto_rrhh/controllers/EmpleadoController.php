<?php
/*
 CONTROLADOR EMPLEADO
*/ //Este controlar se encarga de gestionar las acciones relacionadas con los empleados,
// * incluyendo la visualizaciòn, edición, eliminación y creación de nuevos empleados.

// Ruta de las dependencias
require_once BASE_PATH . 'models/empleadoModel.php';
require_once BASE_PATH . 'models/AreaModel.php';
require_once BASE_PATH . 'controllers/AdminController.php';

class EmpleadoController { 
    private $empleadoModel;
    private $areaModel;
    private $adminController;

    // Se inician las dependencias: 
    public function __construct() {
        $this->empleadoModel = new empleadoModel();
        $this->areaModel = new AreaModel();
        $this->adminController = new AdminController();
    }
    // Verifica si el ususrio tiene acceso a la selecciòn de admisitración.
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
    // Muestra la página de gestión de empleados.
    public function administrarEmpleados() {
        $this->verificarAcceso();
    
        // Obtener la lista de empleados
        $empleados = $this->empleadoModel->listarEmpleados();
    
        // Pasar la lista de empleados a la vista
        require BASE_PATH . 'views/admin/manageEmployees.php';
    }
    // Obtiene la lista de empleados en formato JSON.

    public function obtenerEmpleadosJSON() {  
        $this->verificarAcceso();
        header('Content-Type: application/json');
        $empleados = $this->empleadoModel->listarEmpleados();
        echo json_encode($empleados);
        exit;
    }
    //Muestra la pàgina de modificación de un empleado.

    public function modificarEmpleado() {
        $this->verificarAcceso();
        if (isset($_GET['dni'])) {
            $dni = $_GET['dni'];
            $empleado = $this->empleadoModel->buscarPorDNI($dni);
            require BASE_PATH . 'views/admin/modifyEmployee.php';
        } else {
            header("Location: manageEmployees.php");
            exit();
        }
    }
    // Actualiza los datos de un empleado.

    public function actualizarEmpleado() {
        $this->verificarAcceso();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'dni' => $_POST['dni'],
                'nombre' => $_POST['nombre'],
                'apellido' => $_POST['apellido'],
                'email' => $_POST['email'],
                'fecha_nacimiento' => $_POST['fecha_nacimiento'],
                'area_id' => $_POST['area_id']
            ];

            if ($this->empleadoModel->actualizarEmpleado($data)) {
                header("Location: manageEmployees?success=1");
                exit();
            } else {
                echo "Error al actualizar el empleado.";
            }
        }
    }

    //Elimina un empleado.

    public function eliminarEmpleado() {
        $this->verificarAcceso();

        if (isset($_GET['dni'])) {
            $dni = $_GET['dni'];
            if ($this->empleadoModel->efectuarBaja($dni)) {
                header("Location: manageEmployees?deleted=1");
                exit();
            } else {
                echo "Error al dar de baja al empleado.";
            }
        } else {
            header("Location: manageEmployees.php");
            exit();
        }
    }

    //Crea un nuevo empleado.

    public function altaEmpleado() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'dni' => $_POST['dni'],
                'nombre' => $_POST['nombre'],
                'apellido' => $_POST['apellido'],
                'email' => $_POST['email'],
                'fecha_nacimiento' => $_POST['fecha_nacimiento'],
                'area_id' => $_POST['area_id']
            ];
            
            $resultado = $this->empleadoModel->altaEmpleado($data);
            
            if (is_array($resultado) && isset($resultado['error'])) {
                echo json_encode(['status' => 'error', 'message' => $resultado['error']]);
            } else {
                echo json_encode(['status' => 'success']);
            }
            exit;
        }
    }
     //Obtiene la lista de áreas en formato JSON.

    public function obtenerAreasJSON() {
        $areas = $this->areaModel->obtenerAreasJSON();
        header('Content-Type: application/json');
        echo json_encode($areas);
        exit;
    }
}