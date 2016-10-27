<?php
	include '../connection/config.php';

	$query = "SELECT * FROM service_channel_inputs WHERE input_id = '".$_POST['edit_id']."'";
	$result = pg_query($query);
	$rows = pg_fetch_assoc($result);
	echo json_encode($rows);
?>