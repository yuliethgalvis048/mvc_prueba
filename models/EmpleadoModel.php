<?php
require_once __DIR__ . '/../config/db.php';

class EmpleadoModel {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function buscar($busqueda = '') {
        $sql    = "SELECT *, (SELECT COUNT(*) FROM citas c WHERE c.empleado_id=u.id) as citas_asignadas
                   FROM usuarios u WHERE u.rol IN ('empleado','admin') AND u.activo=1";
        $params = [];
        if ($busqueda) {
            $sql .= " AND (u.nombre LIKE ? OR u.correo LIKE ? OR u.telefono LIKE ?)";
            $like   = "%$busqueda%";
            $params = [$like, $like, $like];
        }
        $sql .= " ORDER BY u.rol, u.nombre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
