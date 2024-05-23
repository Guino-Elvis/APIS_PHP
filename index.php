<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: text/html; charset=utf-8');
header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');

include_once "includes/config.php";
include_once "includes/conectar.php";
include_once "includes/manejador.php";

$method = $_SERVER["REQUEST_METHOD"];



if ($method == "GET") {
    $db = new DB_manejador();
    $empresas = $db->ListarEmpresas();
    $respuesta = array();

    $respuesta['error'] = false;
    $respuesta['mensaje'] = "Empresas listadas correctamente";
    $respuesta['data'] = $empresas;

    echoResponse(200, $respuesta);
}

if ($method == "POST") {
    $headers = apache_request_headers();

    if ($headers["Token"] == SECRET_KEY  ) {
        if (empty($_POST)) {
            $respuesta = array();
            $respuesta['error'] = true;
            $respuesta['mensaje'] = "Datos vacíos";
            $respuesta['data'] = "-";
            echoResponse(422, $respuesta);
        } else {
            $requiredFields = array('razon_social', 'ruc', 'correo', 'direccion', 'telefono');
            $missingFields = array();
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    $missingFields[] = $field;
                }
            }

            if (!empty($missingFields)) {
                $respuesta = array();
                $respuesta['error'] = true;
                $respuesta['mensaje'] = "Faltan los siguientes campos: " . implode(", ", $missingFields);
                $respuesta['data'] = "-";
                echoResponse(422, $respuesta);
            } else {
                $db = new DB_manejador();
                $db->CrearEmpresa($_POST);
                $respuesta = array();
                $respuesta['error'] = false;
                $respuesta['mensaje'] = "Empresa creada correctamente";
                $respuesta['data'] = $_POST;

                echoResponse(200, $respuesta);
            }
        }
    } else {
        $respuesta = array();
        $respuesta['error'] = true;
        $respuesta['mensaje'] = "Clave de acceso denegada";
        $respuesta['data'] = "";

        echoResponse(401, $respuesta);
    }
}

if ($method == "DELETE") {
    $headers = apache_request_headers();

	if (($headers["Token"] == SECRET_KEY) && ($headers["Delete-Token"] == SECRET_DELETE)) {
        // Leer los datos enviados en el cuerpo de la solicitud
        parse_str(file_get_contents("php://input"), $_DELETE);

        if (!isset($_DELETE['id']) || empty($_DELETE['id'])) {
            $respuesta = array();
            $respuesta['error'] = true;
            $respuesta['mensaje'] = "ID no proporcionado";
            $respuesta['data'] = "-";
            echoResponse(422, $respuesta);
        } else {
            $id = intval($_DELETE['id']);
            $db = new DB_manejador();
            $result = $db->EliminarEmpresa($id);

            if ($result) {
                $respuesta = array();
                $respuesta['error'] = false;
                $respuesta['mensaje'] = "Empresa eliminada correctamente";
                $respuesta['data'] = $id;
                echoResponse(200, $respuesta);
            } else {
                $respuesta = array();
                $respuesta['error'] = true;
                $respuesta['mensaje'] = "Error al eliminar la empresa";
                $respuesta['data'] = $id;
                echoResponse(500, $respuesta);
            }
        }
    } else {
        $respuesta = array();
        $respuesta['error'] = true;
        $respuesta['mensaje'] = "Clave de acceso denegada";
        $respuesta['data'] = "";

        echoResponse(401, $respuesta);
    }
}

function echoResponse($code, $message) {
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($message);
}
