<?php
	include '../connection/config.php';

	$return = '';
	if(!empty($_POST['rev_id'])){
		$query = "SELECT * FROM service_channels WHERE revenue_channel_id = '".$_POST['rev_id']."'";
		$result = pg_query($query);
		while ($rows = pg_fetch_assoc($result)) {
			$return[] = $rows;
		}
		echo json_encode($return);
	}
?>