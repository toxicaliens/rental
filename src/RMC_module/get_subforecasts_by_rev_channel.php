<?php
	include '../connection/config.php';

	if(isset($_POST['edit_id'])){
		$rev_id = $_POST['edit_id'];

		$query = "SELECT f.subcounty_id, f.target_amount, f.revenue_channel_id, s.sub_county_name FROM forecast f
		LEFT JOIN sub_county s ON s.sub_county_id = f.subcounty_id
		WHERE revenue_channel_id = '".$rev_id."' AND f.region_id IS NULL";
		$result = pg_query($query);
		while ($rows = pg_fetch_assoc($result)) {
			$return[] = $rows;
		}
		echo json_encode($return);
	}
?>