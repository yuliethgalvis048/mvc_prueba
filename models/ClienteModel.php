<?php
require_once __DIR__ . '/../config/db.php';

class ClienteModel {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function buscar($busqueda = '') {
        $sql    = "SELECT u.*, (SELECT COUNT(*) FROM citas c WHERE c.usuario_id=u.id) as total_citas
                   FROM usuarios u WHERE u.rol='cliente' AND u.activo=1";
        $params = [];
        if ($busqueda) {
            $sql .= " AND (u.nombre LIKE ? OR u.correo LIKE ? OR u.telefono LIKE ?)";
            $like    = "%$busqueda%";
            $params  = [$like, $like, $like];
        }
        $sql .= " ORDER BY u.nombre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function total() {
        return $this->db->query("SELECT COUNT(*) FROM usuarios WHERE rol='cliente' AND activo=1")->fetchColumn();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id=? AND activo=1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
