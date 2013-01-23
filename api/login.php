<?php
	session_start();
	header('Content-Type: application/json');
	$response;

	if(!isset($_POST['username']) || !isset($_POST['password'])) {
		$response['result'] = "MISSING_PARAMETERS";
	} else {
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		if(strlen($username) == 0 || strlen($password)) {
			$response['result'] = "INCORRECT_PARAMETERS";
		}
			
		$db = new PDO("sqlite:../dados.db");
		$select = "SELECT * FROM administradores WHERE username = '$username'";
		if(($result = $db->query($select))) {
			$user = $result->fetch(PDO::FETCH_ASSOC);
			if(!empty($user) && isset($user['username'])) {
				if($user['password'] == $password) {
					$response['result'] = "SUCCESS";
					$_SESSION['username'] = $user['username'];
				} else {
					$response['result'] = "WRONG_PASSWORD";
				}
			}
		} else {
			$response['result'] = "QUERY_#1_ERROR";
		}
	}
	die(json_encode($response));
?>