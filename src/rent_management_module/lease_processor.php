<?php
/**
 * Created by PhpStorm.
 * User: SATELLITE
 * Date: 8/15/2016
 * Time: 5:06 PM
 */

include_once('src/models/LeaseAgreement.php');
$lease = new LeaseAgreement();

switch($_POST['action']){

    case add_lease_agreement:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $lease->addLeaseAgreement($_POST);
        $_SESSION['warnings'] = $lease->getWarnings();
        break;

    case update_lease:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $lease->updateLeaseAgreement($_POST);
        $_SESSION['warnings'] = $lease->getWarnings();
        break;

    case terminate_lease:

        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
//        extract($_POST);
//        var_dump($_POST);die;
        $lease->terminateLease($_POST);
        $_SESSION['warnings'] = $lease->getWarnings();
        break;
}
