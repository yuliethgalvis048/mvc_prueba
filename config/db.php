<?php
/**
 * Configuración de Base de Datos – Glamour Stock MVC
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'g_s');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

define('SITE_NAME', 'Glamour Stock');
define('SITE_URL', 'http://localhost/MVC_PRUEBA');
define('MAX_LOGIN_ATTEMPTS', 5);
define('SESSION_LIFETIME', 7200);

date_default_timezone_set('America/Bogota');

class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $this->conn = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            error_log("Error de conexión: " . $e->getMessage());
            die("Error de conexión a la base de datos.");
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    private function __clone() {}
}

function getDB() {
    return Database::getInstance()->getConnection();
}
