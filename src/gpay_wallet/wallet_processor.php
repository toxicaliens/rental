<?php
	include_once('src/models/GpayWallet.php');
	$gpay = new GpayWallet;

	switch ($_POST['action']) {
		case add_customer_balance:
			logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
			$gpay->addCustomerBalance();
			break;

			case edit_customer_balance:
				logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
				$gpay->editCustomerBalance();
				break;

				case delete_customer_balance:
					logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
					$gpay->deleteCustomerBalance();
					break;
	}
?>