<?php

//consultas tipicas de un crud a la BD

class DB_manejador
{

    public $conexion;

    function __construct()
    {
        include_once ("conectar.php");
        $db = new BDConnect;
        $this->conexion = $db->conectar();
    }


    public function ListarEmpresas()
    {
        $sql = "SELECT * FROM empresas";
        $reg = mysqli_query($this->conexion, $sql);

        $resultados = array();
        while ($fila = mysqli_fetch_array($reg, MYSQLI_ASSOC)) {
            $resultados[] = $fila;
        }

        // var_dump($resultados);

        return $resultados;
    }

    public function BuscarEmpresa($id)
    {

    }

    public function CrearEmpresa($datos)
    {
        $sql = "INSERT INTO empresas(razon_social, ruc, correo, direccion,telefono)
        values(
        '" . $datos['razon_social'] . "',
        '" . $datos['ruc'] . "',
        '" . $datos['correo'] . "',
        '" . $datos['direccion'] . "',
        '" . $datos['telefono'] . "'
        
        )";
        $reg = mysqli_query($this->conexion, $sql);
        return TRUE;
    }

    public function EditarEmpresa($id)
    {

    }


   

    public function EliminarEmpresa($id)
    {
        $sql = "DELETE FROM empresas WHERE id = '" . intval($id) . "'";
        $reg = mysqli_query($this->conexion, $sql);

        if ($reg) {
            return true;
        } else {
            return false;
        }
    }


}


//probando
$tabla = new DB_manejador();
$tabla->ListarEmpresas();