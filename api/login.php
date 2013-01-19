<?php
	session_start();
	
	if(!isset($_POST['username']))
		die('NO_USERNAME');
		
	if(!isset($_POST['password']))
		die('NO_PASSWORD');
		 
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if(strlen($username) == 0)
		die('EMPTY_USERNAME');
		
	if(strlen($password) == 0)
		die('EMPTY_PASSWORD');
		
	$db = new PDO("sqlite:../dados.db");
	
	$select = "SELECT * FROM administradores WHERE username = '$username'";
	$query = $db->query($select);
	
	if($query == FALSE)
		die('QUERY_NOT_ABLE_TO_PERFORM');
	
	$result = $query->fetch(PDO::FETCH_ASSOC);
	
	if(!isset($result['username']))
		die('LOGIN_FAILURE');
		
	if($result['password'] != $password)
		die('LOGIN_FAILURE');
	
	$_SESSION['username'] = $result['username'];
	//$_SESSION['password'] = $result['password'];
	
	die('OK');
	
?>