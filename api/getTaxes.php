<?php
	session_start();
	header('Content-Type: application/json');
	$response;

	if(isset($_SESSION['username'])) {
		$db = new PDO("sqlite:../dados.db");
	
		$query = "SELECT clientes.*, viaturas.*, impostos.dataLimitePagamento FROM clientes, viaturas, impostos WHERE clientes.id = viaturas.idCliente AND viaturas.id = impostos.idViatura ORDER BY impostos.dataLimitePagamento";
	
		if($result = $db->query($query)) {
			$taxes = $result->fetchAll(PDO::FETCH_ASSOC);
			if(!empty($taxes)) {
				$response['result'] = 'SUCCESS';
				$response['data'] = $taxes;
			}
			else {
				$response['result'] = 'NO_TAXES';
			}
		}
	}
	else
		$response['result'] = 'ACCESS_DENIED';

	die(json_encode($response));
?>