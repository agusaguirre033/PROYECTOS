<?php

require_once BASE_PATH . 'models/BeneficioModel.php';
require_once BASE_PATH . 'models/BeneficioCategoriaModel.php';

class BeneficioController {
    private $beneficioModel;
    private $beneficioCategoriaModel;

    public function __construct() {
        $this->beneficioModel = new BeneficioModel();
        $this->beneficioCategoriaModel = new BeneficioCategoriaModel();
    }

    public function obtenerBeneficiosJSON() {
        header('Content-Type: application/json');
        try {
            $beneficios = $this->beneficioModel->obtenerTodos();
            echo json_encode(['status' => 'success', 'data' => $beneficios]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error al obtener beneficios']);
        }
    }

    public function obtenerBeneficioPorId($id) {
        header('Content-Type: application/json');
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado']);
            return;
        }

        try {
            $beneficio = $this->beneficioModel->obtenerPorId($id);
            if ($beneficio) {
                echo json_encode(['status' => 'success', 'data' => $beneficio]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Beneficio no encontrado']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error al obtener el beneficio']);
        }
    }

    public function altaBeneficio() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
            return;
        }

        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $descuento = floatval($_POST['descuento'] ?? 0);
        $categoria_id = intval($_POST['categoria_id'] ?? 0);

        if (strlen($nombre) < 3 || strlen($descripcion) < 10 || $descuento <= 0 || $categoria_id <= 0) {
            echo json_encode(['status' => 'error', 'message' => 'Datos inválidos']);
            return;
        }

        try {
            if ($this->beneficioModel->crear($nombre, $descripcion, $descuento, $categoria_id)) {
                echo json_encode(['status' => 'success', 'message' => 'Beneficio creado exitosamente']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al crear el beneficio']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error en la base de datos']);
        }
    }

    public function actualizarBeneficio() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
            return;
        }

        $id = intval($_POST['id'] ?? 0);
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $descuento = floatval($_POST['descuento'] ?? 0);
        $categoria_id = intval($_POST['categoria_id'] ?? 0);

        if (!$id || strlen($nombre) < 3 || strlen($descripcion) < 10 || $descuento <= 0 || $categoria_id <= 0) {
            echo json_encode(['status' => 'error', 'message' => 'Datos inválidos']);
            return;
        }

        try {
            if ($this->beneficioModel->actualizar($id, $nombre, $descripcion, $descuento, $categoria_id)) {
                echo json_encode(['status' => 'success', 'message' => 'Beneficio actualizado exitosamente']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el beneficio']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error en la base de datos']);
        }
    }

    public function eliminarBeneficio() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
            return;
        }

        $id = intval($_POST['id'] ?? 0);
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado']);
            return;
        }

        try {
            if ($this->beneficioModel->eliminar($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Beneficio eliminado exitosamente']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el beneficio']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error en la base de datos']);
        }
    }

    public function administrarBeneficios() {
        require_once BASE_PATH . 'views/admin/manageBenefits.php';
    }

    public function beneficios() {
        require_once BASE_PATH . 'views/user/benefits.php';
    }
}
