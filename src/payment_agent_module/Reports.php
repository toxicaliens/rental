<?php
include_once 'src/model/Library.php';
/**
* 
*/
class Reports extends Library
{
    protected $reversal_warnings = array();
 
 public function getStaffSummary($mf_id){
 	$query = "SELECT * FROM revenue_names
                     WHERE transaction_status IS TRUE AND agent_id = '".$mf_id."'";
                     //var_dump($query);exit;
        return run_query($query);
 }

 public function getRevenueClerk($mf_id){
 	$query = "SELECT s.*, CONCAT(m.surname,' ',m.firstname,' ',m.middlename) AS customer_name FROM staff s
 	LEFT JOIN masterfile m ON m.mf_id = s.mf_id
 	WHERE s.mf_id = '".$mf_id."'";
 	//var_dump($query);exit;
 	$result = run_query($query);
    $rows = get_row_data($result);
	return $rows;
 }

 function getRevenueClerkTotalForDay($date, $rev_id, $mf_id){
    if($rev_id != ''){
        $rev_filter = "AND revenue_channel_id = '".$rev_id."'";
    }else{
        $rev_filter = '';
    }
    $condition = "where transaction_status IS TRUE AND date_time::date = '".$date."' $rev_filter AND agent_id = '".$mf_id."'";
    $query = "SELECT * FROM revenue_names $condition";
    return $result = run_query($query);
}

function getTotalDailySummary($date, $rev_id){
    if($rev_id != ''){
        $rev_filter = "AND revenue_channel_id = '".$rev_id."'";
    }else{
        $rev_filter = '';
    }
    $condition = "where transaction_status IS TRUE AND date_time::date = '".$date."' $rev_filter";
    $query = "SELECT * FROM revenue_names $condition";
    return $result = run_query($query);
}

function getTotalSummary($date, $rev_id){
    $condition1 = '';
    $condition2 = '';

    if($date != ''){
      $arr = explode("-", $date);
      
      $from_date = date('Y-m-d', strtotime($arr[0]));
      $to_date = date('Y-m-d', strtotime($arr[1])); 
      $condition1 = "WHERE transaction_status IS TRUE AND transaction_status IS TRUE AND (date_time::date >= '".$from_date."' AND date_time::date <= '".$to_date."')";
    }else{
      $post_day = date('Y-m-d');
      $condition1 = "WHERE transaction_status IS TRUE AND transaction_status IS TRUE AND date_time::date ='".$post_day."'";
    }

    if($rev_id != ''){
        $rev_filter = "AND revenue_channel_id = '".$rev_id."'";
    }else{
        $rev_filter = '';
    }
     
    $condition = "where transaction_status IS TRUE AND date_time::date = '".$date."' $rev_filter";
    $query = "SELECT * FROM revenue_names $condition1 $rev_filter";
    return $result = run_query($query);
}

    public function getAllTransactions($date = null, $service_account = null, $rec_no = null, $tranc_id = null, $request_id = null){
        $condition = " transaction_status IS TRUE AND cash_paid >= 0 ";
        $condition .= (!is_null($date)) ? " AND date_time::date = '".sanitizeVariable(date('Y-m-d', strtotime($date)))."'": "";
        $condition .= (!empty($service_account)) ? " AND service_account = '".sanitizeVariable($service_account)."'" : "";
        $condition .= (!empty($rec_no)) ? " AND receiptnumber = '".sanitizeVariable($rec_no)."'" : "";
        $condition .= (!empty($tranc_id)) ? " AND transaction_id = '".sanitizeVariable($tranc_id)."'" : "";
        $condition .= (!empty($request_id)) ? " AND header_id = '".sanitizeVariable($request_id)."'" : "";
        $data = $this->selectQuery('revenue_names', '*', "$condition");
        return $data;
    }

    public function createReversalRequest($transaction_id){
        if(checkForExistingEntry('reversal_request','transaction_id',$transaction_id))
            return false;

        logAction('create_reversal_request',$_SESSION['sess_id'],$_SESSION['mf_id']);
        if($this->insertQuery('reversal_request', array(
            'creator_mf_id' => $_SESSION['mf_id'],
            'transaction_id' => $transaction_id
        )))
            return true;
        else
            return false;
    }

    public function getPendingReversalRequests(){
        $data = $this->selectQuery('reversal_requests', '*', "transaction_status IS TRUE");
        return $data;
    }

    public function confirmReversalRequest($transaction_id){
        $reversal_data = $this->selectQuery('reversal_requests', '*', "transaction_id = '".sanitizeVariable($transaction_id)."'");
        $reversal_req_id = $reversal_data[0]['reversal_request_id'];
        $bill_id = $reversal_data[0]['bill_id'];
        $cash_paid = $reversal_data[0]['cash_paid'];
//        var_dump($reversal_req_id);exit;

        if($reversal_data[0]['creator_mf_id'] == $_SESSION['mf_id']){
            $this->reversal_warnings[] = 'Confirmation cannot be done by the same person who created the reversal request!';
            return false;
        }

        logAction('create_reversal_request',$_SESSION['sess_id'],$_SESSION['mf_id']);
        $this->beginTranc();

        // check if transaction is attached to a bill
        if(!empty($bill_id)){
            $bill_data = $this->selectQuery('customer_bills', 'bill_balance, bill_id, amount_paid', "bill_id = '".$bill_id."'");
            $bill_row = $bill_data[0];
            $bill_balance = $bill_row['bill_balance'] + $cash_paid;
            $amount_paid = $bill_row['amount_paid'] - $cash_paid;

            $this->updateQuery2('customer_bills', array(
                'bill_balance' => $bill_balance,
                'amount_paid' => $amount_paid
            ),array(
                'bill_id' => $bill_id
            ));
        }

        // create -ve transaction
        if($this->insertQuery('transactions', array(
            'cash_paid' => -$reversal_data[0]['cash_paid'],
            'details' => 'Transaction Reversal',
            'receiptnumber' => $reversal_data[0]['receiptnumber'],
            'agent_id' => (!empty($reversal_data[0]['agent_id'])) ? $reversal_data[0]['agent_id'] : 'NULL',
            'service_id' => (!empty($reversal_data[0]['service_id'])) ? $reversal_data[0]['service_id'] : 'NULL',
            'service_type_id' => (!empty($reversal_data[0]['service_type_id'])) ? $reversal_data[0]['service_type_id'] : 'NULL',
            'mf_id' => (!empty($reversal_data[0]['mf_id'])) ? $reversal_data[0]['mf_id'] : 'NULL',
            'agent_payment_ref' => $reversal_data[0]['agent_payment_ref'],
            'request_type_id' => (!empty($reversal_data[0]['request_type_id'])) ? $reversal_data[0]['request_type_id'] : 'NULL',
            'service_account' => $reversal_data[0]['service_account'],
            'region_id' => (!empty($reversal_data[0]['region_id'])) ? $reversal_data[0]['region_id'] : 'NULL',
            'subcounty_id' => (!empty($reversal_data[0]['subcounty_id'])) ? $reversal_data[0]['subcounty_id'] : 'NULL',
            'revenue_region_id' => (!empty($reversal_data[0]['revenue_region_id'])) ? $reversal_data[0]['revenue_region_id'] : 'NULL',
            'transaction_status' => '0',
            'transaction_date' => $reversal_data[0]['transaction_date'],
            'date_time' => $reversal_data[0]['date_time']
        ))){
            // create a negative journal entry
            if($this->insertQuery('journal', array(
                'mf_id' => (!empty($reversal_data[0]['agent_id'])) ? $reversal_data[0]['agent_id'] : 'NULL',
                'amount' => -$reversal_data[0]['cash_paid'],
                'dr_cr' => 'DR',
                'journal_code' => 'SA',
                'journal_type' => 1,
                'service_account' => $reversal_data[0]['service_account'],
                'particulars' => 'Transaction Reversal for Transaction#: '.$transaction_id,
                'stamp' => time(),
                'reversal_request_id' => $reversal_req_id,
                'journal_date' => $reversal_data[0]['date_time']
            ))){
                // change the transaction status to false
                if($this->updateQuery2('transactions', array('transaction_status' => '0'), array('transaction_id' => $transaction_id))){
                       if($this->updateQuery2('reversal_request', array(
                           'approve_mf_id' => $_SESSION['mf_id']
                       ),array(
                           'reversal_request_id' => $reversal_req_id
                       ))){
                            $this->endTranc();
                            return true;
                       }
                }else{
                    $this->reversal_warnings[] = 'Encountered an error while updating the transaction!';
                }
            }else{
                $this->reversal_warnings[] = 'Encountered an error while creating Journal!';
            }
        }else{
            $this->reversal_warnings[] = 'Encountered an error while creating transaction!';
        }
    }

    public function getReversalWarnings(){
        return $this->reversal_warnings;
    }

    public function getConfirmedTransactions(){
        $data = $this->selectQuery('reversal_requests', '*', "transaction_status IS NOT TRUE");
        return $data;
    }

    public function getFullName($mf_id){
        $data = $this->selectQuery('masterfile', "CONCAT(surname,' ',middlename) AS full_name", "mf_id = '".$mf_id."'");
        return $data[0]['full_name'];
    }

    public function getTotalAmountForEachDayInMonth($date){
        $query = "SELECT SUM(cash_paid) as total_collected FROM transactions WHERE transaction_status IS TRUE AND date_time::date = '".sanitizeVariable($date)."'";
        if($result = run_query($query)){
            if(get_num_rows($result)){
                $rows = get_row_data($result);
                return $rows['total_collected'];
            }else{
                return 0;
            }
        }
    }

    public function getLandRecords(){
        $data = $this->selectQuery('land_rates', '*', "land_rates_currentbalance > 0");
        return $data;
    }
}
?>
