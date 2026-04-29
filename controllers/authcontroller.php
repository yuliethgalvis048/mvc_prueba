<?php
require_once __DIR__ . '/../includes/Auth.php';

class AuthController {

    public function login() {
        if (Auth::estaAutenticado()) {
            $this->redirigirPorRol();
            return;
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth   = new Auth();
            $result = $auth->login($_POST['correo'] ?? '', $_POST['password'] ?? '');
            if ($result['success']) {
                $this->redirigirPorRol();
                return;
            }
            $error = $result['error'];
        }

        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function registro() {
        if (Auth::estaAutenticado()) {
            $this->redirigirPorRol();
            return;
        }

        $error   = '';
        $success = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth   = new Auth();
            $result = $auth->register($_POST);
            if ($result['success']) {
                $success = 'Registro exitoso. Ya puedes iniciar sesión.';
            } else {
                $error = implode('<br>', $result['errors']);
            }
        }

        require_once __DIR__ . '/../views/auth/registro.php';
    }

    public function logout() {
        Auth::logout();
        header('Location: index.php?controller=auth&action=login');
        exit;
    }

    private function redirigirPorRol() {
        $rol = Auth::usuarioActual()['rol'] ?? '';
        switch ($rol) {
            case 'admin':
                header('Location: index.php?controller=admin&action=dashboard'); break;
            case 'empleado':
                header('Location: index.php?controller=empleado&action=index'); break;
            default:
                header('Location: index.php?controller=cliente&action=index'); break;
        }
        exit;
    }
}
