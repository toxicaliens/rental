<?php
include_once('src/models/Device_management.php');
$Device = new DeviceManagement;

switch ($_POST['action']) {
	case add_phone_types:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Device->addDevice();
		break;

	case edit_phone_types:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Device->editDevice();
		break;

	case delete_phone_type:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Device->deleteDevice();
		break;

	case add_phone:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
	    $Device->addPhone();
	    break;

	case attach_device:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Device->attachDevice();
	break;

	case detach_device:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Device->detachCustomerFromDevice();
	break;

	case edit_phone:
	    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Device->editPhone();
	    break;

	case delete_phone:
	    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
	    $Device->deletePhone();
	    break;
    
    case add_attribute:
	    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
	    $Device->addAttribute();
	    break;

	case edit_attribute:
	    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Device->editAttribute();
	    break;

	case delete_attribute:
	    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Device->deleteAttribute();
	    break;

	case manage_apps:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Device->manageDeviceApps();
		break;

	case add_model_attribute:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Device->addModelAttribute();
		break;

	case edit_model_attribute:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Device->editModelAttribute();
		break;

	case attach_apps_to_groups:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Device->activateAppsForAllGroupDevices();
		break;

	case delete_model_attributes:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Device->detachDevices();
		break;
	
	case delete_customer_account:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$Device->deleteCustomerAccount();
		break;
}
?>