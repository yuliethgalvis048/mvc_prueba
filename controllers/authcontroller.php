<?php

require_once __DIR__."/../models/auth.php";
class authcontroller {
    public function login(){

    if($_POST){
  $model=new auth();
  $login=$model->login($_POST['usuario'],$_POST['clave']);
   
  if($login){
    $_SESSION['user']=$login['nombre'];
    $_SESSION['rol']=$login['rol'];
    if()
    
    header("location: index.php?controller=cliente&action=index");
    exit;
  }else{
    echo"no se encontro el usuario";
  }
    }
      require_once __DIR__. "/../views/auth/login.php";
    }

    
    public function logout(){   
        session_destroy();
        header("Location: index.php");
    }   

    public function admin(){
      require_once __DIR__."/../views/admin/admin.php"
    }
}