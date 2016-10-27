<?php
include '../connection/config.php';

$device_id = getDeviceId($_POST['edit_id']);
if(!empty($device_id)) {
    $query = "SELECT gd.*, ca.customer_code, ca.issued_phone_number, ca.customer_account_id FROM gtel_device gd
    LEFT JOIN customer_account ca ON ca.device_id = gd.device_id
    WHERE gd.device_id = '" . $device_id . "'";

    if ($result = pg_query($query)) {
        $rows = pg_fetch_assoc($result);
        echo json_encode($rows);
    } else {
        echo $query . pg_last_error();
    }
}

function getDeviceId($customer_account_id){// in this case $edit_id is the customer account id
    if(!empty($customer_account_id)) {
        $query = "SELECT device_id FROM customer_account WHERE customer_account_id = '" . $customer_account_id . "'";
        if ($result = pg_query($query)) {
            if (pg_num_rows($result)) {
                $rows = pg_fetch_assoc($result);
                return $rows['device_id'];
            }
        }else{
            return false;
        }
    }else{
        return false;
    }
}
?>