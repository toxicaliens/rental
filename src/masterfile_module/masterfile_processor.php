<?php
	include_once('src/models/Masterfile.php');
	$mf = new Masterfile();

	switch ($_POST['action']) {

		case add_masterfile:
			logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
            $mf->addMf();
			$_SESSION['mf_warnings'] = $mf->getWarnings();
		break;

		case edit_masterfile:
			logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
			$mf->editMf($_POST);
			$_SESSION['mf_warnings'] = $mf->getWarnings();
			break;

        case Del252:
            logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
            $mf->softDelete();
            $_SESSION['mf_warnings'] = $mf->getWarnings();
            break;

        case delete_masterfile:
            logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
            $mf->deleteMasterfile();
            break;

		case add_customer_address:
			logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
			$mf->addCustomerAddress($_POST);
			$_SESSION['mf_warnings'] = $mf->getWarnings();
			break;

		case edit_customer_address:
			logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
			$mf->editCustomerAddress($_POST);
			$_SESSION['mf_warnings'] = $mf->getWarnings();
			break;

		case delete_customer_address:
			logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
			$mf->deleteCustomerAddress($_POST['delete_id']);
            $_SESSION['mf_warnings'] = $mf->getWarnings();
			break;
		
		case add_address_type:
			logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
			$mf->addAddressType($_POST);
			$_SESSION['mf_warnings'] = $mf->getWarnings();
			break;

		case edit_address_type:
			logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
			$mf->editAddressType($_POST);
			$_SESSION['mf_warnings'] = $mf->getWarnings();
			break;

		case Del693:
			logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
			$mf->deleteAddressType($_POST);
			break;
	}
?>