<?php
	include '../connection/config.php';

	if(isset($_POST['edit_id'])){
		$rev_id = $_POST['edit_id'];

		$query = "SELECT f.region_id, f.target_amount, f.revenue_channel_id, r.region_name FROM forecast f
		LEFT JOIN region r ON r.region_id = f.region_id
		WHERE revenue_channel_id = '".$rev_id."' AND f.subcounty_id IS NULL";
		$result = pg_query($query);
		while ($rows = pg_fetch_assoc($result)) {
			$return[] = $rows;
		}
		echo json_encode($return);
	}
?>