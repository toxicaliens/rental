<?php
include '../connection/config.php';

if(!empty($_POST['edit_id'])){
	$query = "SELECT * FROM system_value WHERE setting_id = '".pg_escape_string(trim($_POST['edit_id']))."'";
	if($result = pg_query($query)){
		if(pg_num_rows($result)){
			echo json_encode(pg_fetch_assoc($result));
		}
	}
}