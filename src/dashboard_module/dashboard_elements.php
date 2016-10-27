<?php
	include '../connection/config.php';
	include '../library.php';
	if(isset($_POST['from_date']) && isset($_POST['to_date'])){
		$from_date = date('Y-m-d', strtotime($_POST['from_date']));
		$to_date = date('Y-m-d', strtotime($_POST['to_date']));

		$period = new DashboardStats($from_date, $to_date);

		include 'main_dashboard_stats.php';
	}
?>
