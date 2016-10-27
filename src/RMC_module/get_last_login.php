<?php
	session_start();
	include '../connection/config.php';

	$query = "SELECT datetime FROM login_sessions WHERE mf_id = '".$_SESSION['mf_id']."' order by datetime desc limit 1";
	$result = pg_query($query);
	$rows = pg_fetch_assoc($result);

	$return = array('datetime'=>date('Y-m-d H:i:s', strtotime($rows['datetime'])), 'mf_id'=>$_SESSION['mf_id']);
	echo json_encode($return);
?>