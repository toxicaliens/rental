<?php
/**
 * Created by PhpStorm.
 * User: JOEL
 * Date: 7/15/2016
 * Time: 11:20 AM
 */
include_once ('src/models/Accounts.php');
$acc = new Accounts();

switch($_POST['action']) {
    case add_bank:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $acc->addBank($_POST);
        $_SESSION['warnings'] = $acc->getWarnings();
        break;

    case edit_bank:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $acc->editBank($_POST);
        $_SESSION['warnings'] = $acc->getWarnings();
        break;

    case delete_bank:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $acc->deleteBank($_POST['delete_id']);
        break;

    case add_branch:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $acc->addBranch($_POST);
        $_SESSION['warnings'] = $acc->getWarnings();
        break;

    case edit_branch:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $acc->editBranch($_POST);
        $_SESSION['warnings'] = $acc->getWarnings();
        break;

    case delete_branch:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $acc->deleteBranch($_POST['delete_id']);
        break;
}