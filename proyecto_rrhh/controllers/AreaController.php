<?php
/*
 CONTROLADOR AREA
*/ 
// Se incluye el modelo de área, donde se manejan las operaciones relacionadas con las áreas 
require_once BASE_PATH . 'models/AreaModel.php';

class AreaController { 
    private $areaModel;
// Constructor de la clase que inicializa el modelo de área
    public function __construct() {
        $this->areaModel = new AreaModel();
    }
// Función privada para verificar si el usuario tiene acceso a las funciones 
    private function verificarAcceso() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../login");
            exit();
        }
        // Si el usuario tiene un puesto_id igual a 0, se redirige al dashboard del usuario  
        if ($_SESSION['puesto_id'] == 0) {
            header("Location: ../user/dashboard");
            exit();
        }
        // Si el puesto_id no es 1, se redirige al login 
        if ($_SESSION['puesto_id'] != 1) {
            header("Location: ../login");
            exit();
        }
    }

    // Función para mostrar la vista de gestión de áreas
    public function administrarAreas() {
        $this->verificarAcceso();
        $areas = $this->areaModel->obtenerAreas();
        require BASE_PATH . 'views/admin/manageAreas.php';
    }

    // Función para obtener las áreas en JSON, para usarlas con AJAX
    public function obtenerAreasJSON() {
        $this->verificarAcceso();
        header('Content-Type: application/json');
        $areas = $this->areaModel->obtenerAreas();
        echo json_encode($areas);
        exit;
    }

    // Función para actualizar una área (nombre)
    public function actualizarArea() {
        $this->verificarAcceso();
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $_POST['id'],
                'nombre' => $_POST['nombre']
            ];
            
            if ($this->areaModel->actualizarArea($data)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el área']);
            }
            exit;
        }
    }

    // Función para dar de baja una área
    public function eliminarArea() {
        $this->verificarAcceso();

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($this->areaModel->efectuarBaja($id)) {
                exit();
            } else {
                echo "Error al dar de baja el área.";
            }
        } else {
            header("Location: manageAreas");
            exit();
        }
    }

    // Función para dar de alta una área
    public function altaArea() {
        $this->verificarAcceso();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => $_POST['nombre'],
                'fecha_alta' => date('Y-m-d'),
                'fecha_baja' => null
            ];
            
            $resultado = $this->areaModel->altaArea($data);
            
            if (is_array($resultado) && isset($resultado['error'])) {
                echo json_encode(['status' => 'error', 'message' => $resultado['error']]);
            } else {
                echo json_encode(['status' => 'success']);
            }
            exit;
        }
    }
}

