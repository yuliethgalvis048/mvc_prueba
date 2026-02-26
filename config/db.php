<?php

class Database{
    public static function conectar(){
        $conexion=new mysqli(
            "localhost",
            "root",
            "",
            "bd"
            );
            if($conexion->connect_errno){
                die($conexion->connect_error);
            }
            return $conexion;

    }
}

?>