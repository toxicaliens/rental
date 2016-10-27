<?php
include_once('src/models/House.php');
$House = new House;


switch($_POST['action'])
{
	//add a new house
	case add_house:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$House->addHouse();
		$_SESSION['warnings'] = $House->getWarnings();
	break;

	//add an attribute to a house\
	 case add_attribute:
 		//var_dump($_POST);exit;
	    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
	    $House->addAttrb();
	    break;

	case edit_attribute:
	    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$House->editAttribute();
	    break;

	case delete_attribute:
	    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$House->deleteAttribute();
	    break;

	//attach an attribute to a house\
	case add_house_specs:
		//var_dump($_POST);exit;
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$House->attachHouseAttribute();
		$_SESSION['warnings'] = $House->getWarnings();
		break;

	case edit_house_spec:
		extract($_POST);
		//var_dump($_POST);exit();
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$House->editHouseAttribute();
		$_SESSION['warnings'] = $House->getWarnings();
		break;

	case delete_house_spec:
		extract($_POST);
		//var_dump($_POST);exit();
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$House->detachHouseAttribute();
		break;

	case delete_house:
//		var_dump($_POST);die;
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$House->deleteHOuse();
		break;
	case edit_house:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$House->editHouse();
		break;
    case'attach_house_service':
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $House->attachHouseService();
        $_SESSION['warnings'] = $House->getWarnings();
        break;
    case'detach_house_service':
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $House->detachHouseService();
        $_SESSION['warnings'] = $House->getWarnings();
        break;
}

