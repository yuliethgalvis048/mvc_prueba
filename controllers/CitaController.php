<?php
require_once __DIR__ . '/../includes/Auth.php';
require_once __DIR__ . '/../models/CitaModel.php';

class CitaController {
    public function cambiarEstado() {
        Auth::requerirAuth(['admin', 'empleado']);
        header('Content-Type: application/json');
        $id     = (int)($_POST['id'] ?? 0);
        $estado = $_POST['estado'] ?? '';
        $estados = ['pendiente','confirmada','completada','cancelada'];
        if ($id && in_array($estado, $estados)) {
            $cm = new CitaModel();
            $cm->cambiarEstado($id, $estado);
            echo json_encode(['ok' => true]);
        } else {
            echo json_encode(['ok' => false]);
        }
        exit;
    }
}
