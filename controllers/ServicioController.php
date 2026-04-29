<?php
require_once __DIR__ . '/../includes/Auth.php';
require_once __DIR__ . '/../models/ServicioModel.php';

class ServicioController {
    public function index() {
        Auth::requerirAuth(['admin']);
        $sm = new ServicioModel();
        $servicios = $sm->getAll();
        $usuario = Auth::usuarioActual();
        require_once __DIR__ . '/../views/admin/servicios.php';
    }
}
