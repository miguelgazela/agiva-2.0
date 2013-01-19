<?php
	session_start();
	header('Content-Type: application/json');
	$response;
	
	if(isset($_SESSION['username'])) {
		if(!isset($_GET['vehicleID']) || !isset($_GET['option'])) {
			$response['result'] = "MISSING_PARAMETER";
		} else {
			$vehicleID = $_GET['vehicleID'];
			$option = $_GET['option'];

			$db = new PDO("sqlite:../dados.db");

			// get the limit date for the vehicle
			$select = 'SELECT dataLimitePagamento FROM impostos WHERE idViatura = '.$vehicleID;
			if(($query = $db->query($select))) {
				$oldDateStr = $query->fetch(PDO::FETCH_ASSOC);

				if(!empty($oldDateStr)) {
					$response['oldDate'] = $oldDateStr['dataLimitePagamento'];
					$newDate = DateTime::createFromFormat('Y-m-d H:i:s', $oldDateStr['dataLimitePagamento']);

					if($option == "PAID") { // add a year
						$newDate->modify('+1 year');
					} else if($option == "UNPAID") { // subtract a year
						$newDate->modify('-1 year');
					}
					$newDateStr = $newDate->format('Y-m-d H:i:s');
					$response['newDate'] = $newDateStr;

					//update the database
					$update = 'UPDATE impostos SET dataLimitePagamento = "'.$newDateStr.'" WHERE idViatura = '.$vehicleID;
					if(($query = $db->query($update))) {
						$response['result'] = "SUCCESS";
					} else {
						$response['result'] = "QUERY_#2_ERROR";
					}

				} else {
					$response['result'] = "NO_VEHICLE_MATCH";
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