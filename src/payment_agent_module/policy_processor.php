<?php
require_once 'src/models/UploadInsurancePolicy.php';
$policy = new UploadInsurancePolicy();

switch ($_POST['action']){
    case upload_insurance:
        $policy->uploadInsurance();
        break;
}