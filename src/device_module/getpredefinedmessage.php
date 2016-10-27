<?php
	include '../connection/config.php';

	if($_POST['edit_id']){
		$query = "SELECT predefined_message FROM predefined_message WHERE predefined_mess_id = '".$_POST['edit_id']."'";
		$result = pg_query($query);
		$rows = pg_fetch_assoc($result);
		echo json_encode($rows);
	}
?>