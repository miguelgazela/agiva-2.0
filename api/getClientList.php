<?php
	session_start();
	header('Content-Type: application/json');
	$response;

	if(isset($_SESSION['username'])) {
		$db = new PDO("sqlite:../dados.db");
		$query = "SELECT id, nome FROM clientes ORDER BY nome";
	
		if($result = $db->query($query)) {
			$clients = $result->fetchAll(PDO::FETCH_ASSOC);
			if(!empty($clients)) {
				$response['result'] = 'SUCCESS';
				$response['data'] = $clients;
			} else {
				$response['result'] = 'NO_CLIENTS';
			}
		} else {
			$response['result'] = "QUERY_ERROR";
		}
	} else {
		$response['result'] = 'ACCESS_DENIED';
	}
	die(json_encode($response));
?>