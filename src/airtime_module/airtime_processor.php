<?php
	include_once('src/models/Airtime.php');
	$airtime = new Airtime();
	
	switch ($_POST['action']) {
		case upload_txt:
			$airtime->processTxtFile();
			break;
	}
?>