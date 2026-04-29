<?php
require_once __DIR__ . '/../config/db.php';

class ServicioModel {
    private $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM servicios ORDER BY categoria, nombre")->fetchAll();
    }

    public function getActivos() {
        return $this->db->query("SELECT * FROM servicios WHERE activo=1 ORDER BY categoria, nombre")->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM servicios WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
