<?php
/**
 * Created by PhpStorm.
 * User: JOEL
 * Date: 7/14/2016
 * Time: 10:47 AM
 */

include '../connection/config.php';

$return = '';
if(!empty($_POST['mf_id'])){
    $query = "UPDATE masterfile SET active = '1' WHERE mf_id = '".$_POST['mf_id']."'";
    if(pg_query($query)){
        if(checkExists($_POST['mf_id'])){
            $query = "UPDATE user_login2 SET user_active = '1', status = '1' WHERE mf_id = '".$_POST['mf_id']."'";
            if(pg_query($query)){
                $return = updateRelatedRecords($_POST['mf_id']);
            }
        }else{
            $return = updateRelatedRecords($_POST['mf_id']);
        }
    }else{
        $return = array('status' => 0);
    }
}
echo json_encode($return);

function checkExists($mf_id){
    $query = "SELECT * FROM masterfile WHERE mf_id = '".$mf_id."'";
    if($result = pg_query($query)){
        if(pg_num_rows($result)){
            return true;
        }else{
            return false;
        }
    }
}

function getAllCustomerAccCodesAndIds($mf_id){
    $acc_data = array();

    $query = "SELECT customer_account_id, customer_code FROM customer_account WHERE mf_id = '".$mf_id."'";
    if($result = pg_query($query)){
        if(pg_num_rows($result)){
            while($rows = pg_fetch_assoc($result)){
                $acc_data[] = $rows;
            }
            return $acc_data;
        }
    }
}

function updateRelatedRecords($mf_id){
    $query2 = "UPDATE customer_account SET status = '1' WHERE mf_id = '".$mf_id."'";
    if(pg_query($query2)){
        $acc_data = getAllCustomerAccCodesAndIds($mf_id);
        if(count($acc_data)){
            foreach($acc_data as $account){
                $query3 = "UPDATE gtel_insurance SET status = '1' WHERE customer_account_id = '".$account['customer_account_id']."'";
                if(pg_query($query3)){
                    $query4 = "UPDATE customer_billing_file SET status = '1' WHERE customer_account_code = '".$account['customer_code']."'";
                    if(pg_query($query4)){
                        $query5 = "UPDATE journal SET status = '1' WHERE service_account = '".$account['customer_code']."'";
                        if(pg_query($query5)){
                            $query6 = "UPDATE customer_bills SET bill_status = '2' WHERE service_account = '".$account['customer_code']."'";
                            if(pg_query($query6)){
                                $return = array('status'=>1);
                            }
                        }
                    }
                }
            }
        }else{
            $return = array('status'=>1);
        }
        return $return;
    }
}