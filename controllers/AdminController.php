<?php
require_once __DIR__ . '/../includes/Auth.php';
require_once __DIR__ . '/../models/ClienteModel.php';
require_once __DIR__ . '/../models/CitaModel.php';
require_once __DIR__ . '/../models/ServicioModel.php';
require_once __DIR__ . '/../models/EmpleadoModel.php';

class AdminController {

    public function dashboard() {
        Auth::requerirAuth(['admin', 'empleado']);
        $usuario = Auth::usuarioActual();
        $db = getDB();

        try {
            $totalCitas       = $db->query("SELECT COUNT(*) FROM citas")->fetchColumn();
            $citasPendientes  = $db->query("SELECT COUNT(*) FROM citas WHERE estado='pendiente'")->fetchColumn();
            $citasHoy         = $db->query("SELECT COUNT(*) FROM citas WHERE fecha=CURDATE()")->fetchColumn();
            $totalServicios   = $db->query("SELECT COUNT(*) FROM servicios WHERE activo=1")->fetchColumn();
            $totalClientes    = $db->query("SELECT COUNT(*) FROM usuarios WHERE rol='cliente' AND activo=1")->fetchColumn();
            $totalEmpleados   = $db->query("SELECT COUNT(*) FROM usuarios WHERE rol='empleado' AND activo=1")->fetchColumn();
            $ingresosPotenciales = $db->query("SELECT COALESCE(SUM(s.precio),0) FROM citas c JOIN servicios s ON s.id=c.servicio_id WHERE c.estado IN ('pendiente','confirmada','completada')")->fetchColumn();

            $proximasCitas = $db->query("
                SELECT c.*, u.nombre AS cliente_nombre, s.nombre AS servicio_nombre, s.precio, s.duracion
                FROM citas c
                JOIN usuarios u ON u.id=c.usuario_id
                JOIN servicios s ON s.id=c.servicio_id
                WHERE c.fecha >= CURDATE() AND c.estado IN ('pendiente','confirmada')
                ORDER BY c.fecha, c.hora LIMIT 10
            ")->fetchAll();

            $serviciosTop = $db->query("
                SELECT s.nombre, COUNT(c.id) as total, s.precio
                FROM citas c JOIN servicios s ON s.id=c.servicio_id
                GROUP BY c.servicio_id, s.nombre, s.precio
                ORDER BY total DESC LIMIT 5
            ")->fetchAll();
        } catch (Exception $e) {
            $totalCitas=$citasPendientes=$citasHoy=$totalServicios=$totalClientes=$totalEmpleados=$ingresosPotenciales=0;
            $proximasCitas=$serviciosTop=[];
        }

        require_once __DIR__ . '/../views/admin/dashboard.php';
    }

    public function clientes() {
        Auth::requerirAuth(['admin', 'empleado']);
        $usuario   = Auth::usuarioActual();
        $cm        = new ClienteModel();
        $busqueda  = trim($_GET['buscar'] ?? '');
        $clientes  = $cm->buscar($busqueda);
        $total     = $cm->total();
        require_once __DIR__ . '/../views/admin/clientes.php';
    }

    public function empleados() {
        Auth::requerirAuth(['admin']);
        $usuario   = Auth::usuarioActual();
        $em        = new EmpleadoModel();
        $busqueda  = trim($_GET['buscar'] ?? '');
        $empleados = $em->buscar($busqueda);
        require_once __DIR__ . '/../views/admin/empleados.php';
    }

    public function citas() {
        Auth::requerirAuth(['admin', 'empleado']);
        $usuario = Auth::usuarioActual();
        $cm      = new CitaModel();
        $filtro  = $_GET['estado'] ?? '';
        $citas   = $cm->getAll($filtro);
        require_once __DIR__ . '/../views/admin/citas.php';
    }

    public function servicios() {
        Auth::requerirAuth(['admin']);
        $usuario   = Auth::usuarioActual();
        $sm        = new ServicioModel();
        $servicios = $sm->getAll();
        require_once __DIR__ . '/../views/admin/servicios.php';
    }

    // APIs AJAX
    public function apiClientes() {
        Auth::requerirAuth(['admin', 'empleado']);
        header('Content-Type: application/json');
        $cm = new ClienteModel();
        $accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

        switch ($accion) {
            case 'crear':
                $db   = getDB();
                $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
                try {
                    $stmt = $db->prepare("INSERT INTO usuarios (nombre,correo,telefono,contraseña,rol) VALUES (?,?,?,?,'cliente')");
                    $stmt->execute([$_POST['nombre'], $_POST['correo'], $_POST['telefono'] ?? '', $hash]);
                    echo json_encode(['ok' => true]);
                } catch (Exception $e) {
                    echo json_encode(['ok' => false, 'error' => 'Error al crear cliente']);
                }
                break;
            case 'eliminar':
                $db = getDB();
                $db->prepare("UPDATE usuarios SET activo=0 WHERE id=?")->execute([$_POST['id']]);
                echo json_encode(['ok' => true]);
                break;
            case 'historial':
                $cm2 = new CitaModel();
                $citas = $cm2->getCitasPorUsuario((int)$_GET['id']);
                echo json_encode($citas);
                break;
            default:
                echo json_encode(['ok' => false, 'error' => 'Acción desconocida']);
        }
        exit;
    }

    public function apiEmpleados() {
        Auth::requerirAuth(['admin']);
        header('Content-Type: application/json');
        $accion = $_POST['accion'] ?? '';
        $db     = getDB();

        switch ($accion) {
            case 'crear':
                $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
                try {
                    $stmt = $db->prepare("INSERT INTO usuarios (nombre,correo,telefono,contraseña,rol) VALUES (?,?,?,?,?)");
                    $stmt->execute([$_POST['nombre'], $_POST['correo'], $_POST['telefono'] ?? '', $hash, $_POST['rol'] ?? 'empleado']);
                    echo json_encode(['ok' => true]);
                } catch (Exception $e) {
                    echo json_encode(['ok' => false, 'error' => 'Correo ya registrado']);
                }
                break;
            case 'eliminar':
                $db->prepare("UPDATE usuarios SET activo=0 WHERE id=?")->execute([$_POST['id']]);
                echo json_encode(['ok' => true]);
                break;
            default:
                echo json_encode(['ok' => false]);
        }
        exit;
    }

    public function apiCitas() {
        Auth::requerirAuth(['admin', 'empleado']);
        header('Content-Type: application/json');
        $accion = $_POST['accion'] ?? '';
        $db     = getDB();

        switch ($accion) {
            case 'cambiar_estado':
                $db->prepare("UPDATE citas SET estado=? WHERE id=?")->execute([$_POST['estado'], $_POST['id']]);
                echo json_encode(['ok' => true]);
                break;
            default:
                echo json_encode(['ok' => false]);
        }
        exit;
    }

    public function apiServicios() {
        Auth::requerirAuth(['admin']);
        header('Content-Type: application/json');
        $accion = $_POST['accion'] ?? '';
        $db     = getDB();

        switch ($accion) {
            case 'crear':
                $stmt = $db->prepare("INSERT INTO servicios (nombre,descripcion,precio,duracion,categoria) VALUES (?,?,?,?,?)");
                $stmt->execute([$_POST['nombre'], $_POST['descripcion'] ?? '', $_POST['precio'], $_POST['duracion'] ?? 0, $_POST['categoria'] ?? '']);
                echo json_encode(['ok' => true]);
                break;
            case 'editar':
                $stmt = $db->prepare("UPDATE servicios SET nombre=?,descripcion=?,precio=?,duracion=?,categoria=? WHERE id=?");
                $stmt->execute([$_POST['nombre'], $_POST['descripcion'] ?? '', $_POST['precio'], $_POST['duracion'] ?? 0, $_POST['categoria'] ?? '', $_POST['id']]);
                echo json_encode(['ok' => true]);
                break;
            case 'eliminar':
                $db->prepare("UPDATE servicios SET activo=0 WHERE id=?")->execute([$_POST['id']]);
                echo json_encode(['ok' => true]);
                break;
            case 'get':
                $s = $db->prepare("SELECT * FROM servicios WHERE id=?");
                $s->execute([$_GET['id']]);
                echo json_encode($s->fetch());
                break;
            default:
                echo json_encode(['ok' => false]);
        }
        exit;
    }
}
