<?php
	include '../connection/config.php';

	if($_POST['service_bill_id']){
		$query = "SELECT amount FROM revenue_service_bill WHERE revenue_bill_id = '".$_POST['service_bill_id']."'";
		$result = pg_query($query);
		$rows = pg_fetch_assoc($result);
		echo json_encode($rows);
	}
?>