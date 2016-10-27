<?php
	session_start();
	require '../connection/config.php';
	
	$cash_paid = $_POST['cash_paid79'];
	$agent_id = $_SESSION['mf_id'];
	$service_id = $_POST['service_id'];
	$request_type_id = $_POST['request_type_id'];
	$service_account = $_POST['service_account'];
	$transaction_date = date('Y-m-d');

	if(!empty($cash_paid) && !empty($agent_id)){
		echo $query = "INSERT INTO transactions(cash_paid, agent_id, mf_id, request_type_id, service_account, service_id) 
		VALUES(
			'".$cash_paid."',
			'".$_SESSION['mf_id']."',
			null,
			'".$request_type_id."',
			'".$service_account."',
			'".$service_id."')";
		$result = pg_query($query);
		if($result){
			echo 'Payment was successfully recorded!';
		}else{
			echo pg_last_error();
		}
	}
?>