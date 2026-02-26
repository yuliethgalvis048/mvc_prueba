<?php
session_start();

require_once "controllers/clientecontroller.php";
require_once "controllers/authcontroller.php";

$controller=$_GET['controller'] ?? null;
$action=$_GET['action'] ?? null;


if(!isset($_SESSION['user'])){
    $controller='login';
    $action='login';
    
}
else{
    $controller=$controller ?? 'cliente';
    $action=$action ?? 'index';
}

switch($controller){
    case  'cliente':
        $controller=new clientecontroller();
        break;
          case  'login':
        $controller=new authcontroller();
        break;
        default:
        $controller=new clientecontroller();
        break;

}
if(method_exists($controller,$action)){
    $controller->$action();
}else{
    echo "la action no esta permitida o no existe";
}
?>