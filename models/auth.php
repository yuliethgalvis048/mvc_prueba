<?php
require_once __DIR__."/../config/db.php";

class auth{
    private $db;
    public function __construct(){
        $this->db=Database::conectar();
    }
    public function login($nombres,$pass){
        
        $sql="SELECT*from rol INNER JOIN rol_user ON rol.id_rol=rol_user.id_rol_user INNER JOIN 
        cliente ON rol_user.id_cliente = cliente.id_cliente WHERE nombre='$nombre' AND pass='$pass';'";
 
        $resul=$this->db->query($sql);

        if($resul->num_rows>0){
            $datos=$resul->fetch_assoc();
            return $datos;
        }
        else{
            return false;
        }

    }

    public function logout(){   
        session_destroy();
        header("Location: index.php");
    }     

}


?>