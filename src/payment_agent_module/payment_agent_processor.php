<?php
	include_once('src/models/Payment.php');

	$payment_obj = new Payment();
	switch ($_POST['action']) {
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
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		extract($_POST);

		if(empty($order_id)){
			$order_id = $parking->addOrder();
			if(is_numeric($order_id)){
				if($parking->addOrderItems($service_option, $order_id, $quantity, $price, $service_account, $customer)){
					$_SESSION['parking'] = '<div class="alert alert-success">
		                <button class="close" data-dismiss="alert">×</button>
		                <strong>Success!</strong> Order has been placed.
		            </div>';
		            $_SESSION['customer'] = $_POST['customer'];
		            App::redirectTo('?num=167&order_id='.$order_id);
				}
			}
		}else{
			if($parking->addOrderItems($service_option, $order_id, $quantity, $price, $service_account, $_SESSION['customer'])){
				$_SESSION['parking'] = '<div class="alert alert-success">
	                <button class="close" data-dismiss="alert">×</button>
	                <strong>Success!</strong> Item has been added to the order.
	            </div>';
	            App::redirectTo('?num=167&order_id='.$order_id);
			}
		}
	break;

	case process_payment:
	logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
//    var_dump('Alert...');exit;
	extract($_POST);
    $parking->beginTranc();
    // create receipt
    $revs = $parking->selectQuery('revenue_channel', 'revenue_channel_id', "revenue_channel_code = '".LandRate."'");
    $revenue_channel_id = $revs[0]['revenue_channel_id'];
//    var_dump($revenue_channel_id);exit;
    $receiptnumber = $payment_obj->generateReceiptCode($revenue_channel_id);
//    var_dump($receiptnumber);exit;
    if(!$payment_obj->insertQuery('receipts', array(
        'generated_code' => $receiptnumber,
        'receipt_type' => Buy_Service,
        'order_id' => $order_id
    ))){
        $parking->setWarning('Failed to create receipt!'.get_last_error());
    }

	for($count = 1; $count <= $total_count; $count++){
		$parking->processPayment($_POST['order_item_id'.$count], $receiptnumber);
	}
	$parking->endTranc();
	if(count($parking->getWarnings()) == 0) {
        App::redirectTo('?num=170&order_id=' . $order_id);
    }else{
        $_SESSION['warnings'] = $parking->getWarnings();
    }
	break;

    case bulk_payment:
//        var_dump($_POST);exit;
        // validate form inputs
        $payment_obj->validate($_POST, array(
            'service_account' => array(
                'name' => 'Service Account',
                'required' => true
            ),
//            'revenue_channel' => array(
//                'name' => 'Revenue Channel',
//                'required' => true
//            ),
            'total_cash_received' => array(
                'name' => 'Cash Received',
                'required' => true,
                'numeric' => true
            ),
            'payment_mode' => array(
                'name' => 'Payment Mode',
                'required' => true
            )
        ));

        $service_account = $_POST['service_account'];
        $description = $_POST['desc'];
        $received_from = $_POST['received_from'];
        $description .= (!empty($received_from)) ? ' Payment Received from: '.$received_from : '';
        $payment_mode = $_POST['payment_mode'];
//        var_dump($payment_mode);exit;
        $payment_ref = $_POST['payment_ref'];
//        var_dump($payment_ref);exit;

        // begin transaction
        $payment_obj->beginTranc();

        // generate the receipt no
        $receiptnumber = $payment_obj->generateReceiptCode();

//        var_dump($receiptnumber);exit;
        if($payment_obj->getValidationStatus()) {
            $condition = (!empty($_POST['revenue_channel'])) ? " AND revenue_channel_id = '" . sanitizeVariable($_POST['revenue_channel']) . "' " : "";
            $bills = $payment_obj->selectQuery('bill_data', '*', "service_account = '" . sanitizeVariable($_POST['service_account']) . "' $condition AND bill_balance > 0");
            if ($bill_count = count($bills)) {
                $count = 1;
                //create receipt
                $payment_obj->insertQuery('receipts', array(
                    'generated_code' => $receiptnumber,
                    'receipt_type' => Pay_Bill,
                ));

                $tot_paid_annual = 0;
                $tot_paid_penalty = 0;
                foreach ($bills as $bill) {
                    // calculate bill balance
                    $bill_balance = $bill['bill_balance'];
                    $index = 'cash_received' . $count;
                    $cash_paid = $_POST[$index];
                    $amount_paid_so_far = $bill['bill_amount_paid'] + $cash_paid;
                    $mf_id = (!empty($bill['mf_id'])) ? $bill['mf_id'] : 'NULL';
                    $service_id = $bill['service_channel_id'];
                    if(empty($_POST['revenue_channel'])){
                        $rev = $payment_obj->selectQuery('service_channels', 'revenue_channel_id', " service_channel_id = '".sanitizeVariable($service_id)."'");
                        $rev = $rev[0];
                        $rev_id = $rev['revenue_channel_id'];
                    }else{
                        $rev_id = $_POST['revenue_channel'];
                    }

                    // get request type
                    $request_data = $payment_obj->selectQuery('request_types', 'request_type_id', "request_type_code = '" . Pay_Bill . "'");
                    $request_type_id = $request_data[0]['request_type_id'];

//                    var_dump($bill_balance);exit;
                    // cash paid must be greater than 0
                    if ($cash_paid > 0) {
                        // check if the bill has balance
                        if ($bill_balance > 0) {
                            // ensure the cash paid is not greater than the bill balance
                            if ($cash_paid <= $bill_balance) {
                                // calculate the new bill balance
                                $new_balance = $bill_balance - $cash_paid;

                                // update bill balance
                                if(!$payment_obj->updateQuery2('customer_bills', array(
                                    'bill_balance' => $new_balance,
                                    'bill_amount_paid' => $amount_paid_so_far
                                ), array(
                                    'bill_id' => $bill['bill_id']
                                ))){
                                    $payment_obj->setWarning('Failed to Update Bill');
                                }

                                // create transaction
                                $tranc_data = $payment_obj->insertQuery('transactions', array(
                                    'cash_paid' => $cash_paid,
                                    'details' => $description,
                                    'receiptnumber' => $receiptnumber,
                                    'transaction_date' => date('Y-m-d H:i:s'),
                                    'transacted_by' => $_SESSION['mf_id'],
                                    'service_id' => $bill['service_channel_id'],
                                    'mf_id' => $mf_id,
                                    'service_account' => $bill['service_account'],
//                                    'request_type_id' => $request_type_id,
                                    'bill_id' => $bill['bill_id'],
                                    'payment_mode_id' => $payment_obj->getModeId($payment_mode),
                                    'payment_reference' => $payment_ref
                                ), 'transaction_id');
                                $transaction_id = $tranc_data['transaction_id'];
//                                var_dump($transaction_id);exit;
                                if(!is_numeric($transaction_id)){
                                    $payment_obj->setWarning('Failed to create transaction');
                                }

                                $particulars = 'OTC payment Trans#: ' . $transaction_id . '. Received from: ' . $received_from;
                                // create credit journal
                                if ($payment_obj->insertQuery('journal', array(
                                    'mf_id' => $_SESSION['mf_id'],
                                    'amount' => $cash_paid,
                                    'dr_cr' => 'DR',
                                    'journal_code' => 'MF',
                                    'journal_type' => 1,
                                    'service_account' => $service_account,
                                    'particulars' => $particulars,
                                    'journal_date' => date('Y-m-d H:i:s'),
                                    'stamp' => time()
                                ))
                                ) {
                                    //                                $payment_obj->flashMessage('otc', 'success', 'Bulk payment has been successfully recorded.');
                                }else{
                                    $payment_obj->setWarning('Failed to create Journal'.get_last_error());
                                }

                                $payment_obj->insertQuery('otc_payment', array(
                                    'otc_type' => $request_type_id,
                                    'bill_reference' => $bill['bill_id'],
                                    'amount' => $cash_paid
                                ));
                            } else {
                                $payment_obj->setWarning('You cannot pay more than the balance(' . $bill_balance . ') for ' . $bill['bill_name']);
                            }
                        } else {
                            $payment_obj->setWarning($bill['service_option'] . ' bill has already been cleared!');
                        }
                    }
                    $count++;
                }

                $payment_obj->endTranc();

                $warnings = $payment_obj->getWarnings();
                if (count($warnings) == 0) {
                    App::redirectTo('?num=payment_receipt&rec_no=' . $receiptnumber);
                }
            }
            $_SESSION['warnings'] = $payment_obj->getWarnings();
            break;
        }
}
?>