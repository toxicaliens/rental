<?php
include_once('src/models/Masterfile.php');
//	/**
//	*
//	*/
	class Payments extends Masterfile
	{
		
		public function addToBillingFile($service_account, $billing_interval, $billing_amount, $billing_amount_balance, $service_bill_id){
	        $query = "INSERT INTO customer_billing_file(
	        created_by, service_account, start_date, 
	        billing_interval, billing_amount, billing_amount_balance, service_bill_id,
	        created)
			VALUES ('".$_SESSION['mf_id']."', '".sanitizeVariable($service_account)."', '".date('Y-m-d')."', 
	        '".sanitizeVariable($billing_interval)."', '".sanitizeVariable($billing_amount)."', '".sanitizeVariable($billing_amount_balance)."', '".sanitizeVariable($service_bill_id)."',
	        '".date('Y-m-d H:i:s')."') RETURNING billing_file_id";
	        traceActivity('Billing File: '.$query);
	        $result = run_query($query);
	        if($result){
	            return $result;
	        }else{
	            return false;
	        }
    	}

    	public function createBill($bill_due_date, $billing_amount, $bill_date, $bill_status, $bill_amount_paid, $bill_balance, $billing_file_id, $service_account, $mf_id, $service_channel_id){
	        // var_dump($_POST);exit;
	        $ins_sql = "INSERT INTO customer_bills(
	            bill_due_date, bill_amount, 
	            bill_date, bill_status, 
	            bill_amount_paid, bill_balance, 
	            billing_file_id, service_account, 
	            mf_id, service_channel_id)
	    		VALUES ('".sanitizeVariable($bill_due_date)."', '".sanitizeVariable($billing_amount)."', 
	    		'".date('Y-m-d')."', '".sanitizeVariable($bill_status)."', 
	    		'".sanitizeVariable($bill_amount_paid)."', '".sanitizeVariable($bill_balance)."', 
	    		'".sanitizeVariable($billing_file_id)."', '".sanitizeVariable($service_account)."',
	    		'".sanitizeVariable($mf_id)."', '".sanitizeVariable($service_channel_id)."')";
	        traceActivity($ins_sql);
	        if(run_query($ins_sql)){
	            return true;
	        }else{
	            return false;
	        }
	    } 

	    public function getServiceBill($house_id){
			$query = "SELECT * FROM revenue_service_bill WHERE product_id='".$house_id."'";
			// traceActivity($query);
// 			var_dump($query);exit;
			$result = run_query($query);
			if($result){
				return get_row_data($result);
			}else{
				return false;
			}
		}

		public function recordJournalDebit($mf_id, $bill_amount, $service_account, $particulars){
			$query = "INSERT INTO journal(
                        journal_date,
                        mf_id, 
                        amount, 
                        dr_cr, 
                        journal_type,
                        particulars,
                        service_account,
                        journal_code,
                        stamp)
                            VALUES (
                                '".date('Y-m-d')."',
                                ".$mf_id.",
                                ".$bill_amount.", 
                                'DR', 
                                1,
                                '".$particulars."',
                                '".$service_account."',
                                'SA',
                                '".time()."')";
		
		if(run_query($query)){
			return true;
		}else{
			return false;
		}
	}
	}
?>