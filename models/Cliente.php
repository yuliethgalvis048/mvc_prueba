<?php
require_once  __DIR__."/../config/db.php";

class cliente{
    private $db;
    public function __construct(){
        $this->db=Database::conectar();
    
        }

    public function mostrar(){
        $sql="SELECT* FROM cliente";
        $result=$this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC); 
    }
    public function save($nombre,$apellido,$edad,$pass,$correo,$direccion,$telefono){
    $sql="INSERT INTO cliente(nombre,apellido,edad,pass,correo_electronico,direccion,telefono)
   VALUES('$nombre','$apellido','$edad','$pass','$correo','$direccion','$telefono')";
  return $this->db->query($sql);
  }

  public function GetById($id){
   $sql="SELECT* FROM cliente WHERE id_cliente=$id";
   $result=$this->db->query($sql);
   return $result->fetch_assoc();
 }

 public function update($id,$nombre,$apellido,$edad,$pass,$correo,$direccion,$telefono){
  $sql="UPDATE cliente SET nombre='$nombre',apellido='$apellido',edad='$edad',pass='$pass',correo_electronico='$correo',direccion='$direccion',telefono='$telefono'WHERE id_cliente=$id";
return $this->db->query($sql);
 
  }
  public function delete($id){
    $sql="DELETE FROM cliente WHERE id_cliente=$id";
return $this->db->query($sql);
  }

  }

?>
