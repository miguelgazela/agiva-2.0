<?php
	session_start();
	header('Content-Type: application/json');
	$response;

	if(isset($_SESSION['username'])) {
		if(!isset($_POST["brand"]) || !isset($_POST["model"]) || !isset($_POST["licence"]) || !isset($_POST["licenceDate"]) || !isset($_POST["limit"]) || !isset($_POST["clientID"])) {
			$response['result'] = "MISSING_PARAMETER";
		} else {
			$db = new PDO("sqlite:../dados.db");
			$brand = $_POST["brand"];
			$model = $_POST["model"];
			$licence = strtoupper($_POST["licence"]);
			$licenceDate = $_POST["licenceDate"].' 08:00:00';
			$limitDate = $_POST["limit"].' 08:00:00';
			$clientID = $_POST["clientID"];

			// deve fazer a sua propria verificacao aqui e nao contar com o javascript do lado do cliente para a validade dos campos
			
			$insert = "INSERT INTO viaturas VALUES (Null, '$clientID', '$brand', '$model', '$licence', '$licenceDate')";
			if(($query = $db->query($insert))) {
				// get the id of the new vehicle
				$vehicleID;
				$queryVehicleID = "SELECT seq FROM sqlite_sequence WHERE name = 'viaturas'";
				if(($result = $db->query($queryVehicleID))) {
					$row = $result->fetch(PDO::FETCH_ASSOC);
					$vehicleID = $row['seq'];
					//$response['calculatedID'] = $vehicleID;
					$insert = "INSERT INTO impostos VALUES ('$clientID', '$vehicleID', '$limitDate')";
					if(($query = $db->query($insert))) {
						$response['result'] = "SUCCESS";
					} else {
						$response['result'] = "QUERY_#3_ERROR";
					}
				} else {
					$response['result'] = "QUERY_#2_ERROR";
				}
			} else {
				$response['result'] = "QUERY_#1_ERROR";
			}
		}
	} else {
		$response['result'] = "ACCESS_DENIED";
	}
	die(json_encode($response));
?>