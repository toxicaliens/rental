<?php
	include_once('src/models/LoanRepayments.php');
	$loan_repayment = new LoanRepayments;

	switch ($_POST['action']) {
		case update_customer_bill_and_log_transaction:
//			var_dump($_POST);die;
			logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
			$bill_balance = $_POST['bill_balance'];
			// var_dump($bill_balance);exit;
			$amount_paid = $_POST['amount_paid'];
			$bill_id = $_POST['bill_id'];
			$service_account = $_POST['service_account'];
			$request_type_id = $_POST['request_type_id'];
			$mf_id = $_POST['mf_id'];
			$agent_id = $_POST['agent'];
			$timestamp = time();
			$date = date('Y-m-d');
			$time = date('H:i:s');
			$option_code = $_POST['option_code'];
			$date_time = date('Y-m-d H:i:s');
			$description = $_POST['description'];
			$bill_amount = $_POST['bill_amt'];
			$attached_mf_id = $_POST['attached_mf_id'];

			if(!empty($bill_balance) && !empty($amount_paid)) {
				if (is_numeric($bill_balance) && is_numeric($amount_paid)) {
					$loan_repayment->addOverTheCounterPayment($amount_paid, $bill_id, $description, $date_time, 'Cash',$mf_id);
				}
			}
			break;
		
		case add_service_bills:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);  
        $bill_due_date = $_POST['bill_due_date'];
        $customer_id = $_POST['customer_id'];
        $service_bill_id = $_POST['service_bill_id'];
        $bill_amt = $_POST['bill_amt'];
        // $bill_status = $_POST['bill_status'];
        $service_account = $_POST['service_account'];
        $service_account_type = $_POST['service_account_type'];
        $sms_notification = $_POST['sms_notification'];
        $email_notification = $_POST['email_notification'];
        $particulars = $_POST['description'];
        $date_time = date('Y-m-d H:i:s');
        $timestamp = strtotime($date_time);

        if(empty($customer_id))
            {
                $add_parking_bills="INSERT INTO customer_bills
        (bill_due_date,
        mf_id,
      bill_date,
      service_bill_id,
      bill_amt,
      bill_balance,
      service_account,
      revenue_channel_id,
      sms_notification,
      email_notification) 
      VALUES ('".$bill_due_date."',
      NULL,
      '".date('Y-m-d')."',
      '".$service_bill_id."',
      '".$bill_amt."',
      '".$bill_amt."',
      '".$service_account."',
      '".$service_account_type."',
      '".$sms_notification."',
      '".$email_notification."')";
            }             
            else{
                    $add_parking_bills="INSERT INTO customer_bills
                        (bill_due_date,
                      mf_id,
                      bill_date,
                      service_bill_id,
                      bill_amt,
                      bill_balance,
                      service_account,
                      revenue_channel_id,
                      sms_notification,
                      email_notification) 
                      VALUES ('".$bill_due_date."',
                      '".$customer_id."',
                      '".date('Y-m-d')."',
                      '".$service_bill_id."',
                      '".$bill_amt."',
                      '".$bill_amt."',
                      '".$service_account."',
                      '".$service_account_type."',
                      '".$sms_notification."',
                      '".$email_notification."')";

            }

        
    // var_dump($add_parking_bills);exit;
    //echo $add_parking_bills;
    if(!run_query($add_parking_bills))
        
    {

	        $_SESSION['parking'] = pg_last_error();
    }
    else
    {
    	$journal_tranc = "INSERT INTO journal(
                            journal_date, 
                            amount, 
                            dr_cr, 
                            journal_type,
                            particulars,
                            service_account,
                            journal_code,
                            stamp)
                                VALUES (
                                    '".$date_time."',
                                    '".$bill_amt."', 
                                    'DR', 
                                    1,
                                    '".$particulars."',
                                    '".$service_account."',
                                    'SA',
                                    '".$timestamp."')";
                            // var_dump($journal_tranc);exit;

                            if(run_query($journal_tranc)){
                                //check if customer is attached to service account

                                if(!empty($customer_id)){
                                    $journal_tranc2 = "INSERT INTO journal(
                                    journal_date, 
                                    mf_id, 
                                    amount, 
                                    dr_cr, 
                                    journal_type,
                                    particulars,
                                    journal_code,
                                    stamp)
                                        VALUES (
                                            '".$date_time."', 
                                            '".$customer_id."', 
                                            '".$bill_amt."', 
                                            'DR', 
                                            1,
                                            '".$particulars."',
                                            'CU',
                                            '".$timestamp."'
                                            )";
                                    run_query($journal_tranc2);
    							}
    							// var_dump($journal_tranc2);exit;

    							$_SESSION['parking'] = '<div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    <strong>Success!</strong> Record added successfully.
                </div>';
}
}
		break;

	case buy_service_form:
	$service_account = $_POST['service_account'];
	$service_id = $_POST['service_id'];
	$cash_received = $_POST['cash_received'];
	$marked_price = $_POST['price'];
	$revenue_channel_id = $_POST['revenue_channel_id'];
	$thetimestamp = strtotime(date('Y-m-d'));
	$date_logged = date('Y-m-d H:i:s');
	$service_option_code = $_POST['service_option_code'];
	$revenue_channel_code = $_POST['revenue_channel_code'];
	
	// log the request
	if(!empty($service_account) && !empty($cash_received)){
		$log_req = "INSERT INTO log_req(
			transaction_code, 
			service_code, 
			user_account, 
			timestamp, 
			amount, 
			revenue_channel_id, 
			date_logged, 
			ccn_trans_id, 
			agent_id) 
		VALUES(
			'BUYSERVICE',
			'".$service_option_code."',
			'".$service_account."',
			'".$thetimestamp."',
			'".$cash_received."',
			'".$revenue_channel_id."',
			'".$date_logged."',
			NULL,
			'".$_SESSION['mf_id']."'
			)";
		// var_dump($log_req);exit;
		if(run_query($log_req)){
			//get rev-channel code
			switch ($revenue_channel_code) {
				case 'ICGPAK':
					$parking = new Parking($revenue_channel_code);

					$inputs = array('service_account'=>$service_account, 'service_id'=>$service_id, 'cash_received'=>$cash_received, 'marked_price'=>$marked_price);
					$parking->log_transaction($inputs);
				break;
			}
		}
	}
}
?>
