<?php
	include_once('src/models/Broadcast.php');
	$broadcast = new Broadcast();

	switch ($_POST['action']) {
		case add_broadcast:
		    extract($_POST);
//		    var_dump($_POST);die;
			logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
			$broadcast->addBroadcast();
            $_SESSION['warnings'] = $broadcast->getWarnings();
			break;

        case add_pre_message:
            logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
            $broadcast->addPredefinedMessage();
            break;

        case edit_pre_message:
            logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
            $broadcast->editPreMessage();
            break;

        case del_pre_message:
            logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
            $broadcast->deletePreMessage();
            break;
	}
?>