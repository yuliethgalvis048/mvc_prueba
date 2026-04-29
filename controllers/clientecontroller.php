<?php
require_once __DIR__ . '/../includes/Auth.php';
require_once __DIR__ . '/../models/ClienteModel.php';
require_once __DIR__ . '/../models/CitaModel.php';
require_once __DIR__ . '/../models/ServicioModel.php';

class ClienteController {

    public function index() {
        Auth::requerirAuth(['cliente']);
        $usuario  = Auth::usuarioActual();
        $citaModel = new CitaModel();
        $citas = $citaModel->getCitasPorUsuario($usuario['id']);
        require_once __DIR__ . '/../views/cliente/index.php';
    }

    public function catalogo() {
        Auth::requerirAuth(['cliente']);
        $usuario = Auth::usuarioActual();
        $sm      = new ServicioModel();
        $servicios = $sm->getActivos();
        require_once __DIR__ . '/../views/cliente/catalogo.php';
    }

    public function agendar() {
        Auth::requerirAuth(['cliente']);
        $usuario  = Auth::usuarioActual();
        $sm       = new ServicioModel();
        $servicios = $sm->getActivos();

        $error   = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cm = new CitaModel();
            $result = $cm->crear([
                'usuario_id'  => $usuario['id'],
                'servicio_id' => $_POST['servicio_id'] ?? 0,
                'fecha'       => $_POST['fecha'] ?? '',
                'hora'        => $_POST['hora'] ?? '',
                'comentarios' => $_POST['comentarios'] ?? '',
            ]);
            if ($result['success']) {
                $success = '¡Cita agendada con éxito!';
            } else {
                $error = $result['error'];
            }
        }

        require_once __DIR__ . '/../views/cliente/agendar.php';
    }

    public function perfil() {
        Auth::requerirAuth(['cliente']);
        $usuario = Auth::usuarioActual();
        $db = getDB();

        $error   = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $stmt = $db->prepare("UPDATE usuarios SET nombre=?, telefono=? WHERE id=?");
                $stmt->execute([
                    trim($_POST['nombre'] ?? $usuario['nombre']),
                    trim($_POST['telefono'] ?? ''),
                    $usuario['id']
                ]);
                // Actualizar sesión
                $_SESSION['gs_user']['nombre']   = trim($_POST['nombre']);
                $_SESSION['gs_user']['telefono'] = trim($_POST['telefono'] ?? '');
                $usuario = Auth::usuarioActual();
                $success = 'Perfil actualizado correctamente.';
            } catch (Exception $e) {
                $error = 'Error al actualizar perfil.';
            }
        }

        require_once __DIR__ . '/../views/cliente/perfil.php';
    }

    public function cancelarCita() {
        Auth::requerirAuth(['cliente']);
        $usuario = Auth::usuarioActual();
        $id      = (int)($_GET['id'] ?? 0);
        if ($id) {
            $cm = new CitaModel();
            $cm->cambiarEstado($id, 'cancelada', $usuario['id']);
        }
        header('Location: index.php?controller=cliente&action=index');
        exit;
    }
}
