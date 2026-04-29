<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/Auth.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/ClienteController.php';
require_once __DIR__ . '/controllers/EmpleadoController.php';
require_once __DIR__ . '/controllers/AdminController.php';
require_once __DIR__ . '/controllers/CitaController.php';
require_once __DIR__ . '/controllers/ServicioController.php';

$controller = $_GET['controller'] ?? null;
$action     = $_GET['action']     ?? null;

// Si no está autenticado, siempre al login
if (!Auth::estaAutenticado()) {
    $controller = 'auth';
    $action     = 'login';
} else {
    $rol = Auth::usuarioActual()['rol'] ?? '';
    // Default por rol
    if (!$controller) {
        switch ($rol) {
            case 'admin':
                $controller = 'admin'; $action = 'dashboard'; break;
            case 'empleado':
                $controller = 'empleado'; $action = 'index'; break;
            default:
                $controller = 'cliente'; $action = 'index'; break;
        }
    }
    $action = $action ?? 'index';
}

// Instanciar controlador
switch ($controller) {
    case 'auth':     $ctrl = new AuthController();     break;
    case 'cliente':  $ctrl = new ClienteController();  break;
    case 'empleado': $ctrl = new EmpleadoController(); break;
    case 'admin':    $ctrl = new AdminController();     break;
    case 'cita':     $ctrl = new CitaController();      break;
    case 'servicio': $ctrl = new ServicioController();  break;
    default:
        $ctrl = Auth::estaAutenticado() ? new AdminController() : new AuthController();
        $action = Auth::estaAutenticado() ? 'dashboard' : 'login';
        break;
}

if (method_exists($ctrl, $action)) {
    $ctrl->$action();
} else {
    http_response_code(404);
    echo "<h2>Acción '$action' no existe en el controlador '$controller'.</h2>";
}
