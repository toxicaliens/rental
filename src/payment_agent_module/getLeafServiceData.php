<?php
include '../connection/config.php';

$return = array();

if(!empty($_POST['rev_id'])){
	$query = "SELECT service_channel_id, service_option FROM service_channels WHERE revenue_channel_id = '".$_POST['rev_id']."' AND service_option_type ='Leaf'";
	if($result = pg_query($query)){
		if(pg_num_rows($result)){
			while ($rows = pg_fetch_assoc($result)) {
				$return[] = $rows;
			}
			echo json_encode($return);
		}
	}
}