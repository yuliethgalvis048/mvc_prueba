<?php
require_once __DIR__ . '/../config/db.php';

class CitaModel {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function crear($datos) {
        try {
            if (empty($datos['servicio_id']) || empty($datos['fecha']) || empty($datos['hora'])) {
                return ['success' => false, 'error' => 'Todos los campos son requeridos'];
            }
            $stmt = $this->db->prepare("INSERT INTO citas (usuario_id, servicio_id, fecha, hora, comentarios, estado) VALUES (?,?,?,?,?,'pendiente')");
            $stmt->execute([$datos['usuario_id'], $datos['servicio_id'], $datos['fecha'], $datos['hora'], $datos['comentarios'] ?? '']);
            return ['success' => true, 'id' => $this->db->lastInsertId()];
        } catch (Exception $e) {
            return ['success' => false, 'error' => 'Error al crear cita'];
        }
    }

    public function getCitasPorUsuario($usuario_id) {
        $stmt = $this->db->prepare("
            SELECT c.*, s.nombre AS servicio_nombre, s.precio, s.duracion, s.categoria,
                   e.nombre AS empleado_nombre
            FROM citas c
            JOIN servicios s ON s.id=c.servicio_id
            LEFT JOIN usuarios e ON e.id=c.empleado_id
            WHERE c.usuario_id=?
            ORDER BY c.fecha DESC, c.hora DESC
        ");
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll();
    }

    public function getAll($filtroEstado = '') {
        $sql    = "SELECT c.*, u.nombre AS cliente_nombre, u.correo AS cliente_correo,
                          s.nombre AS servicio_nombre, s.precio, e.nombre AS empleado_nombre
                   FROM citas c
                   JOIN usuarios u ON u.id=c.usuario_id
                   JOIN servicios s ON s.id=c.servicio_id
                   LEFT JOIN usuarios e ON e.id=c.empleado_id";
        $params = [];
        if ($filtroEstado) {
            $sql .= " WHERE c.estado=?";
            $params = [$filtroEstado];
        }
        $sql .= " ORDER BY c.fecha DESC, c.hora DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function cambiarEstado($id, $estado, $usuario_id = null) {
        if ($usuario_id) {
            $stmt = $this->db->prepare("UPDATE citas SET estado=? WHERE id=? AND usuario_id=?");
            $stmt->execute([$estado, $id, $usuario_id]);
        } else {
            $stmt = $this->db->prepare("UPDATE citas SET estado=? WHERE id=?");
            $stmt->execute([$estado, $id]);
        }
    }
}
