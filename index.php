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

// echo "se ha recibido el metodo get".$method;

if ($method == "GET") {
	$db = new DB_manejador();
	$empresas = $db->ListarEmpresas();
	//var_dump($empresas);
	$respuesta = array();

	$respuesta['error']= false;
	$respuesta['mensaje']= "empresas listadas correctamente";
	$respuesta['data']= $empresas;


	echoResponse(200,$respuesta);
}


if ($method == "POST") {

	//se recibe los encabezados enviados desde posmant
	$headers = apache_request_headers();

	if ($headers["Token"] == SECRET_KEY ) {

		$db = new DB_manejador();
		$db->CrearEmpresa($_POST);
	
		$respuesta = array();
		$respuesta['error']= false;
		$respuesta['mensaje']= "empresas creada correctamente";
		$respuesta['data']= $_POST;
	
		echoResponse(200,$respuesta);
		// var_dump($_POST);
	}
	else {
		$respuesta = array();
		$respuesta['error']= true;
		$respuesta['mensaje']= "Clave de acceso denegado";
		$respuesta['data']= "";
	
		echoResponse(401,$respuesta);
	}


	
}



function echoResponse($code, $messagey)
{
	//clear the old headers
	//header_remove();
	// set the actual code
	http_response_code($code);
	// set the header to make sure cache is forced
	header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
	// treat this as json
	header('Content-Type: application/json');
	// ok, validation error, or failure
	header('Status: ' . $code);
	// return the encoded json
	echo json_encode($messagey);
}


