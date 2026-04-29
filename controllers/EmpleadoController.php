<?php
require_once __DIR__ . '/../includes/Auth.php';
require_once __DIR__ . '/../models/CitaModel.php';
require_once __DIR__ . '/../models/ServicioModel.php';

class EmpleadoController {

    public function index() {
        Auth::requerirAuth(['empleado', 'admin']);
        $usuario = Auth::usuarioActual();
        $db = getDB();

        $citasHoy = $db->query("
            SELECT c.*, u.nombre AS cliente_nombre, s.nombre AS servicio_nombre
            FROM citas c
            JOIN usuarios u ON u.id=c.usuario_id
            JOIN servicios s ON s.id=c.servicio_id
            WHERE c.fecha=CURDATE() AND c.estado IN ('pendiente','confirmada')
            ORDER BY c.hora
        ")->fetchAll();

        $totalMes = $db->query("
            SELECT COUNT(*) FROM citas WHERE MONTH(fecha)=MONTH(NOW()) AND YEAR(fecha)=YEAR(NOW())
        ")->fetchColumn();

        require_once __DIR__ . '/../views/empleado/index.php';
    }

    public function perfil() {
        Auth::requerirAuth(['empleado', 'admin']);
        $usuario = Auth::usuarioActual();
        $db      = getDB();
        $error   = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $stmt = $db->prepare("UPDATE usuarios SET nombre=?, telefono=? WHERE id=?");
                $stmt->execute([trim($_POST['nombre']), trim($_POST['telefono'] ?? ''), $usuario['id']]);
                $_SESSION['gs_user']['nombre']   = trim($_POST['nombre']);
                $_SESSION['gs_user']['telefono'] = trim($_POST['telefono'] ?? '');
                $usuario = Auth::usuarioActual();
                $success = 'Perfil actualizado.';
            } catch (Exception $e) {
                $error = 'Error al actualizar.';
            }
        }

        require_once __DIR__ . '/../views/empleado/perfil.php';
    }
}
