<?php
	session_start();
	header('Content-Type: application/json');
	$response;

	if(isset($_SESSION['username'])) {
		if(!isset($_POST["name"]) || !isset($_POST["address"]) || !isset($_POST["local"]) || !isset($_POST["parish"]) || !isset($_POST["postal"]) || !isset($_POST["nif"])) {
			$response['result'] = "MISSING_PARAMETER";
		} else {
			$db = new PDO("sqlite:../dados.db");
			$name = $_POST["name"];
			$address = $_POST["address"];
			$local = $_POST["local"];
			$parish = $_POST["parish"];
			$postal = $_POST["postal"];
			$nif = $_POST["nif"];

			// deve fazer a sua propria verificacao aqui e nao contar com o javascript do lado do cliente para a validade dos campos
			
			$insert = "INSERT INTO clientes VALUES (Null, '$name', '$address', '$local', '$parish', '$postal', '$nif')";
			if(($query = $db->query($insert))) {
				$response['result'] = "SUCCESS";
			} else {
				$response['result'] = "QUERY_ERROR";
			}
		}
	} else {
		$response['result'] = "ACCESS_DENIED";
	}
	die(json_encode($response));
?>