<?php
require_once __DIR__."/../models/Cliente.php";
class clientecontroller{

public function index(){
    $cliente=new cliente();
    $datos=$cliente->mostrar();
    require_once __DIR__."/../views/cliente/listar.php";

  }
public function crear(){
    if($_POST){
        $cliente=new Cliente();
        $c=$cliente->save(

        $_POST['nombre'],
        $_POST['apellido'],
        $_POST['edad'],
        $_POST['pass'],
        $_POST['correo'],
        $_POST['direccion'],
        $_POST['telefono']
        );
        header("Location: index.php");
    }
    require_once __DIR__."/../views/cliente/crear.php";
  }
  public function editar(){
      $cliente=new Cliente();  
     if($_POST){
       
        $c=$cliente->update(   
        $_POST['id'],
        $_POST['nombre'],
        $_POST['apellido'],
        $_POST['edad'],
        $_POST['pass'],
        $_POST['correo'],
        $_POST['direccion'],
        $_POST['telefono']
        );
        header("Location: index.php");

    } 
    $datos = $cliente->GetById($_GET['id']);
    require_once __DIR__."/../views/cliente/editar.php";
  }
 public function eliminar(){
    $cliente=new cliente();
    $c=$cliente->delete($_GET['id']);
    header("Location: index.php");
 }

  }

?>