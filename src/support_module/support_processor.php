<?php
//include_once('src/models/SupportTickets.php');
include_once('src/models/Quotes.php');
//$Support = new SupportTickets;
$Quotes = new Quotes();

switch ($_POST['action']) {
	case assign_staff:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Quotes->assignStaff();
		break;

	case add_Respond:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Quotes->respondToSupportIssue();
		break;

	case add_support:
       	logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Quotes->addSupport();
	    break;

	case reassign_staff:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Quotes->reassignStaff();
		break;

	case add_comment:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Quotes->addComment();
	break;

	case add_category:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Quotes->addCategory();
		$_SESSION['support_error'] = $Quotes->getWarnings();
		break;

	case edit_category:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Quotes->editCategory();
		$_SESSION['support_error'] = $Quotes->getWarnings();
		break;

	case delete_category:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Quotes->deleteCategory();
		break;

	case add_quotation:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Quotes->addQuataion();
	break;

	case add_voucher:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Quotes->addVoucher();
		$_SESSION['support_error'] = $Quotes->getWarnings();
		break;

	case edit_voucher:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Quotes->editVoucher();
		$_SESSION['support_error'] = $Quotes->getWarnings();
		break;

	case delete_voucher:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Quotes->deleteVoucher();
		break;

	case edit_quotation:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Quotes->editQuote();
	break;
	case delete_quotation:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Quotes->deleteQuote($_POST['delete_id']);
	break;

	case approve_maintenance_voucher:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		//var_dump($_POST);exit;
		$Quotes->approveVoucher($_POST['voucher_id']);
		$_SESSION['support_error'] = $Quotes->getWarnings();
		break;

	case decline_maintenance_voucher:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		//var_dump($_POST);exit;
		$Quotes->declineVoucher();
		$_SESSION['support_error'] = $Quotes->getWarnings();
		break;


}
?>