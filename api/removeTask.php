<?php
	session_start();
	header('Content-Type: application/json');
	$response;

	if(isset($_SESSION['username'])) {
		if(!isset($_GET["id"])) {
			$response['result'] = "MISSING_PARAMETER";
		} else {
			$db = new PDO("sqlite:../dados.db");
			$taskID = $_GET["id"];
			$user = $_SESSION['username'];

			// deve fazer a sua propria verificacao aqui e nao contar com o javascript do lado do cliente para a validade dos campos
			
			$delete = "DELETE FROM tarefas WHERE tarefas.id = '$taskID' AND tarefas.user = '$user'";
			if(($query = $db->query($delete))) {
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