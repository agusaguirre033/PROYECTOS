<?php

class CategoriaController {
    private $beneficioCategoriaModel;

    public function __construct() {
        $this->beneficioCategoriaModel = new BeneficioCategoriaModel();
    }

    public function obtenerCategoriasJSON() {
        header('Content-Type: application/json');
        try {
            $categorias = $this->beneficioCategoriaModel->obtenerTodas();
            echo json_encode(['status' => 'success', 'data' => $categorias]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error al obtener categorías']);
        }
    }

    public function obtenerCategoriaPorId($id) {
        header('Content-Type: application/json');
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado']);
            return;
        }

        try {
            $categoria = $this->beneficioCategoriaModel->obtenerPorId($id);
            if ($categoria) {
                echo json_encode(['status' => 'success', 'data' => $categoria]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Categoría no encontrada']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error al obtener la categoría']);
        }
    }

    public function altaCategoria() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
            return;
        }

        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');

        if (strlen($nombre) < 3 || strlen($descripcion) < 10) {
            echo json_encode(['status' => 'error', 'message' => 'Datos inválidos']);
            return;
        }

        try {
            if ($this->beneficioCategoriaModel->crear($nombre, $descripcion)) {
                echo json_encode(['status' => 'success', 'message' => 'Categoría creada exitosamente']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al crear la categoría']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error en la base de datos']);
        }
    }

    public function actualizarCategoria() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
            return;
        }

        $id = $_POST['id'] ?? null;
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');

        if (!$id || strlen($nombre) < 3 || strlen($descripcion) < 10) {
            echo json_encode(['status' => 'error', 'message' => 'Datos inválidos']);
            return;
        }

        try {
            if ($this->beneficioCategoriaModel->actualizar($id, $nombre, $descripcion)) {
                echo json_encode(['status' => 'success', 'message' => 'Categoría actualizada exitosamente']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al actualizar la categoría']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error en la base de datos']);
        }
    }

    public function eliminarCategoria() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
            return;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado']);
            return;
        }

        try {
            if ($this->beneficioCategoriaModel->eliminar($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Categoría eliminada exitosamente']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar la categoría']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error en la base de datos']);
        }
    }
}