<?php
/**
 * Clase de Autenticación – Glamour Stock MVC
 */
require_once __DIR__ . '/../config/db.php';

class Auth {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    /** Registrar nuevo usuario */
    public function register($datos) {
        try {
            if (empty($datos['nombre']) || empty($datos['correo']) || empty($datos['password'])) {
                return ['success' => false, 'errors' => ['Nombre, correo y contraseña son requeridos']];
            }
            $chk = $this->db->prepare("SELECT id FROM usuarios WHERE correo=?");
            $chk->execute([trim($datos['correo'])]);
            if ($chk->fetch()) {
                return ['success' => false, 'errors' => ['El correo ya está registrado']];
            }
            $hash = password_hash($datos['password'], PASSWORD_BCRYPT, ['cost' => 12]);
            $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, correo, telefono, contraseña, rol) VALUES (?,?,?,?,'cliente')");
            $stmt->execute([
                trim($datos['nombre']),
                trim($datos['correo']),
                trim($datos['telefono'] ?? ''),
                $hash
            ]);
            return ['success' => true, 'id' => $this->db->lastInsertId()];
        } catch (Exception $e) {
            error_log("Error registro: " . $e->getMessage());
            return ['success' => false, 'errors' => ['Error al registrar']];
        }
    }

    /** Login */
    public function login($correo, $password) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE correo=? AND activo=1");
            $stmt->execute([trim($correo)]);
            $usuario = $stmt->fetch();
            if (!$usuario) return ['success' => false, 'error' => 'Credenciales incorrectas'];
            if (!password_verify($password, $usuario['contraseña'])) {
                return ['success' => false, 'error' => 'Credenciales incorrectas'];
            }
            self::crearSesion($usuario);
            return ['success' => true, 'usuario' => $usuario];
        } catch (Exception $e) {
            error_log("Error login: " . $e->getMessage());
            return ['success' => false, 'error' => 'Error al iniciar sesión'];
        }
    }

    /** Crear sesión */
    private static function crearSesion($u) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_regenerate_id(true);
        $_SESSION['gs_user'] = [
            'id'       => $u['id'],
            'nombre'   => $u['nombre'],
            'correo'   => $u['correo'],
            'telefono' => $u['telefono'] ?? '',
            'rol'      => $u['rol'],
        ];
    }

    public static function estaAutenticado(): bool {
        if (session_status() === PHP_SESSION_NONE) session_start();
        return isset($_SESSION['gs_user']);
    }

    public static function usuarioActual(): array {
        if (session_status() === PHP_SESSION_NONE) session_start();
        return $_SESSION['gs_user'] ?? [];
    }

    public static function tieneRol($roles): bool {
        $u = self::usuarioActual();
        if (empty($u)) return false;
        if (is_string($roles)) $roles = [$roles];
        return in_array($u['rol'], $roles);
    }

    public static function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
    }

    public static function requerirAuth($roles = []) {
        if (!self::estaAutenticado()) {
            header('Location: ' . SITE_URL . '/index.php?controller=auth&action=login');
            exit;
        }
        if (!empty($roles) && !self::tieneRol($roles)) {
            header('Location: ' . SITE_URL . '/index.php?controller=auth&action=login');
            exit;
        }
    }
}
