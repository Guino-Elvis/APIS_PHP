<?php

//consultas tipicas de un crud a la BD

class DB_manejador
{

    public $conexion;

    function __construct()
    {
        include_once("conectar.php");
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

    public function BuscarEmpresa($id) {
        
    }

    public function CrearEmpresa($dato) {
        
    }

    public function EditarEmpresa($id) {
        
    }

    
    public function EliminarEmpresa($id) {
        
    }



}


//probando
$tabla = new DB_manejador();
$tabla->ListarEmpresas();