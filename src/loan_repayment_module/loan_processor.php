<?php
	include_once('src/models/LoanRepayments.php');
	$loan = new LoanRepayments();
	
	switch ($_POST['action']) {
		case upload_csv:
			$loan->addRepaymentsFromCSV();
			break;
	}
?>