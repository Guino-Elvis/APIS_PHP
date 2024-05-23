<?php

//funcion para  coneccion a la base de datos

class BDConnect
{

    public $conexion;

    public function conectar()
    {
        include_once("config.php");
        $link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($link->connect_errno) {
            echo " Error a la coneccion DB";
        } else {
            $this->conexion = $link;
            return $link;
        }
    }
}


$conex = new BDConnect;
$mc = $conex->conectar();
//echo 'todo bien';