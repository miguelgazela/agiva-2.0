<?php
	session_start();
	header('Content-Type: application/json');
	$response;

	if(isset($_SESSION['username'])) {
		if(!isset($_GET["task"]) || !isset($_GET["date"]) || !isset($_GET["priority"])) {
			$response['result'] = "MISSING_PARAMETER";
		} else {
			$db = new PDO("sqlite:../dados.db");
			$task = $_GET["task"];
			$date = $_GET["date"];
			$priority = $_GET["priority"];
			$user = $_SESSION['username'];

			// deve fazer a sua propria verificacao aqui e nao contar com o javascript do lado do cliente para a validade dos campos
			
			$insert = "INSERT INTO tarefas VALUES (Null, '$user', '$task', '$date', '$priority')";
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