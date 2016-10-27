<?php
include_once('src/models/Library.php');
	class LoanRepayments extends Library
	{
		
		public function addRepaymentsFromCSV(){
			// upload the csv file
			$target_path='';

			$allowedExts = array("csv");
	        $temp = explode(".", $_FILES["csv"]["name"]);
	        $extension = end($temp);
	        $timestamp = date('Y_m_d_H_i_s_');

	        // var_dump($extension);exit;
			if (in_array($extension, $allowedExts)) {
	            if ($_FILES["csv"]["error"] > 0) {
	               "Return Code: " . $_FILES["csv"]["error"] . "<br>";
	            } else {
                 	$target_path = "assets/csv/".$timestamp."".$_FILES["csv"]["name"];
                 	if(move_uploaded_file($_FILES["csv"]["tmp_name"], $target_path)){
                 		// get the contents of the csv file
                 		$myFile = $target_path;
						// var_dump($myFile);exit;
						// echo "got file...";
						
						if(file_exists($myFile))
						{
							// var_dump('file exists');exit;
						   	$fh = fopen($myFile,'r');
						   	$toread = filesize($myFile);
						   	$allfile = fread($fh,$toread);
						   	$wordChunks = explode("\n", $allfile);
						   	// var_dump($wordChunks);exit;
						}
						
						$count = 0;
						// echo "start inserting...";
						while($wordChunks[$count]){
							$data = $wordChunks[$count];
							$dataline = explode(",",$data);
							// var_dump($dataline);exit;

							//get the fields
							if(!empty($dataline[1]) && !empty($dataline[2]) && !empty($dataline[3]) && !empty($dataline[4])){
								$cash_paid_balance = $dataline[1];
								$tranc_date = $dataline[2];
								$service_account = $dataline[3];
								$payment_mode = $dataline[4];
							
								// var_dump($service_account);exit;

								if(is_numeric($cash_paid_balance)){
									// var_dump('After Start');exit;
									$bill_result = $this->getPendingBillFromServiceAccount($service_account);
									$counter = 1;
									$counter_sum = '';
									if(get_num_rows($bill_result)){
										while($bill_details = get_row_data($bill_result)){
											// var_dump($bill_details);exit;
											$bill_balance = $bill_details['bill_balance'];
											$service_id = $bill_details['service_channel_id'];
											$repay_date = $bill_details['bill_due_date'];

											if($cash_paid_balance > 0){
												$cash_paid = $cash_paid_balance;	
												// $bal .= 'Cash Paid Balance: '.$cash_paid_balance.' Bill Balance: '.$bill_balance;

												if($cash_paid_balance >= $bill_balance){
													$b_balance = 0;
													$bill_status = 1;
													$total_amount_paid = $bill_details['bill_balance'] + $bill_details['bill_amount_paid'];
													$cash_paid_balance = $cash_paid_balance - $bill_balance;
													$acc_data = $this->getAccountDetailsFromCustomerAccCode($service_account);

													// update bill balance
													if($this->updateBillBalance($bill_details['bill_id'], $total_amount_paid, $b_balance, $bill_status)){
														// create journal
														$stamp = time();
														
														$result = $this->addPayment($bill_balance, $tranc_date, $service_account, $_SESSION['mf_id'], $bill_details['bill_id'], $service_id, $payment_mode);
														if ($result) {
															$tranc_data = get_row_data($result);
															if($this->createJournal($bill_details['bill_id'], $bill_balance, 'CR', 1, $service_account, 'Loan Repayment from transaction id: '.$tranc_data['transaction_id'], $stamp, $bill_details['mf_id'])){
																//add the payments
															
																/* if commissionaire, award commission
																4% of the total cost of the phone divided by the no of months for the complete payment period
																*/
																// get total cost of the phone
																$price = $this->getServicePrice($service_id);
																$period = 12; // in months
																$perc = 0.04;
																$commission_award = ($price / $period) * $perc;

																// update customer balance
																if(!empty($acc_data['referee_mf_id'])){
																	if($this->updateCustomerBalance($acc_data['referee_mf_id'], $commission_award)){
																		if ($this->creditWalletJournal($bill_details['bill_id'], $commission_award, 
																			'CR', 1, 'Commission Award for Referral', $acc_data['referee_mf_id'])) {
																			$recipients = "{ ".$acc_data['customer_account_id']." }";
																			$body = "Dear Customer, ";
																			$body .= "You have been awarded $commission_award";
																			$subject = "Commission Award";
																			$push = $this->getMessageTypeId('PUSH_NOTIFICATION');
																			$message_type_id = "{ $push }";
																			if($result = $this->sendMessage($body, $subject, $_SESSION['mf_id'], $recipients, $message_type_id)){
																				$message_data = get_row_data($result);

																				if($this->addCustMessage($acc_data['customer_account_id'], $message_data['message_id'])){
																				}
																			}
																		}
																	}
																}

																// check if the payment was late
																if($this->checkIfPaymentWasLate($tranc_date, $repay_date)){
																	$late = '1';
																	$curr_score_count = $this->getCurrScoreCount($acc_data['customer_account_id']);
																	$credit_score_value = $curr_score_count + 1;
																	$this->addCreditScore($bill_details['mf_id'], $credit_score_value);
																}else{
																	$late = '0';
																}

																if($this->addLoanRepayment($bill_details['bill_id'], date('Y-m-d'), $service_account, $tranc_data['transaction_id'], $late)){
																	$recipients = "{ ".$acc_data['customer_account_id']." }";
																	$body = "Loan Repayment has been successfully received. Thank you.";
																	$subject = "Confirmed";
																	$inbox = $this->getMessageTypeId('INBOX');
																	$message_type_id = "{ $inbox }";

																	if($result = $this->sendMessage($body, $subject, $_SESSION['mf_id'], $recipients, $message_type_id)){
																		$message_data = get_row_data($result);

																		if($this->addCustMessage($acc_data['customer_account_id'], $message_data['message_id'])){
																			$push = $this->getMessageTypeId('PUSH_NOTIFICATION');
																			$message_type_id = "{ $push }";

																			if($this->sendMessage($body, $subject, $_SESSION['mf_id'], $recipients, $message_type_id)){	
																				if($this->addCustMessage($acc_data['customer_account_id'], $message_data['message_id'])){
																					$_SESSION['upload_csv']='<div class="alert alert-success">
																						<button class="close" data-dismiss="alert">×</button>
																						<strong>Success!</strong> The data has been imported.
																					</div>';
																				}
																			}
																		}
																	}
																}								
															}//endofcreatejournal
														}
													}else{
														$counter_sum .= $counter.', ';
													}
												}else{
													$bill_status = 0;
													$new_balance = $bill_balance - $cash_paid_balance;
													$total_amount_paid = $cash_paid_balance + $bill_details['bill_amount_paid'];
													$acc_data = $this->getAccountDetailsFromCustomerAccCode($service_account);

													//update the bill
													if($this->updateBillBalance($bill_details['bill_id'], $total_amount_paid, $new_balance, $bill_balance)){
														// create journal
														$stamp = time();
														if($this->createJournal($bill_details['bill_id'], $cash_paid, 'CR', 1, $service_account, 'Payment from CSV file', $stamp, $bill_details['mf_id'])){
															//add the payments
															$result = $this->addPayment($cash_paid, $tranc_date, $service_account, $_SESSION['mf_id'], $bill_details['bill_id'], $service_id, $payment_mode);
															if ($result) {
																$_SESSION['upload_csv']='<div class="alert alert-success">
																	<button class="close" data-dismiss="alert">×</button>
																	<strong>Success!</strong> The data has been imported.
																</div>';			
															}
														}
													}else{
														$counter_sum .= $counter.', ';
													}
													$cash_paid_balance = 0;
													break;
												}
											}
											$counter++;
										}
										$counter_sum = rtrim($counter_sum, ', ');
										$this->createRepaymentUpload($counter, $counter_sum);

										// check if there is any cash paid balance left
										if($cash_paid_balance > 0){
											// top up wallet balance 
											$details['mf_id'] = $this->getMfidFromCustomerAcc($service_account);
											if(!empty($details['mf_id'])){
												// var_dump('Cash paid balance: '.$bill_details['mf_id']);exit;
												if($this->updateCustomerBalance($details['mf_id'], $cash_paid_balance)){
													// credit wallet balance
													if ($this->creditWalletJournal('NULL', $cash_paid_balance, 'CR', 1, 'Credit Customer Balance', $details['mf_id'])) {
													 	$_SESSION['upload_csv']='<div class="alert alert-success">
															<button class="close" data-dismiss="alert">×</button>
															<strong>Success!</strong> The data has been imported.
														</div>';
														// stop the loop  if there's cash paid balance is zero
														break;
													} 
												}
											}
										}
									}									
								}
							}
							$count++;
	                 	}
	                 	
		            }
	         	}
			}
		}

		public function addBulkPayments($account_code, $amount_paid, $payment_mode, $tranc_date){
			$cash_paid_balance = $amount_paid;
			$service_account = $account_code;

			if(is_numeric($cash_paid_balance)){
				// var_dump('After Start');exit;
				$bill_result = $this->getPendingBillFromServiceAccount($service_account);
				$counter = 1;
				$counter_sum = '';
				if(get_num_rows($bill_result)){
					while($bill_details = get_row_data($bill_result)){
						// var_dump($bill_details);exit;
						$bill_balance = $bill_details['bill_balance'];
						$service_id = $bill_details['service_channel_id'];

						if($cash_paid_balance > 0){
							$cash_paid = $cash_paid_balance;
							// $bal .= 'Cash Paid Balance: '.$cash_paid_balance.' Bill Balance: '.$bill_balance;

							if($cash_paid_balance >= $bill_balance){
								$b_balance = 0;
								$bill_status = 1;
								$total_amount_paid = $bill_details['bill_balance'] + $bill_details['bill_amount_paid'];
								$cash_paid_balance = $cash_paid_balance - $bill_balance;
								$acc_data = $this->getAccountDetailsFromCustomerAccCode($service_account);

								// update bill balance
								if($this->updateBillBalance($bill_details['bill_id'], $total_amount_paid, $b_balance, $bill_status)){
									// create journal
									$stamp = time();


									if($this->createJournal($bill_details['bill_id'], $cash_paid, 'CR', 1, $service_account, 'Payment from CSV file', $stamp, $bill_details['mf_id'])){
										//add the payments
										$result = $this->addPayment($cash_paid, $tranc_date, $service_account, $_SESSION['mf_id'], $bill_details['bill_id'], $service_id, $payment_mode);
										if ($result) {
											/* if commissionaire, award commission
                                            4% of the total cost of the phone divided by the no of months for the complete payment period
                                            */
											// get total cost of the phone
											$price = $this->getServicePrice($service_id);
											$period = 12; // in months
											$perc = 0.04;
											$commission_award = ($price / $period) * $perc;

											// update customer balance
											if(!empty($acc_data['referee_mf_id'])){
												if($this->updateCustomerBalance($acc_data['referee_mf_id'], $commission_award)){
													if ($this->creditWalletJournal($bill_details['bill_id'], $commission_award,
														'CR', 1, 'Commission Award', $acc_data['referee_mf_id'])) {
													}
												}
											}

											$data = get_row_data($result);
											// check if the payment was late
											if($this->checkIfPaymentWasLate($tranc_date, $acc_data['repayment_date'])){
												$late = '1';
												$curr_score_count = $this->getCurrScoreCount($acc_data['customer_account_id']);
												$credit_score_value = $curr_score_count + 1;
												$this->addCreditScore($bill_details['mf_id'], $credit_score_value);
											}else{
												$late = '0';
											}

											if($this->addLoanRepayment($bill_details['bill_id'], date('Y-m-d'), $service_account, $data['transaction_id'], $late)){
												$recipients = "{ ".$acc_data['customer_account_id']." }";
												$body = "Loan Repayment has been successfully received. Thank you.";
												$subject = "Confirmed";
												$inbox = $this->getMessageTypeId('INBOX');
												$message_type_id = "{ $inbox }";

												if($result = $this->sendMessage($body, $subject, $_SESSION['mf_id'], $recipients, $message_type_id)){
													$message_data = get_row_data($result);

													if($this->addCustMessage($acc_data['customer_account_id'], $message_data['message_id'])){
														$push = $this->getMessageTypeId('PUSH_NOTIFICATION');
														$message_type_id = "{ $push }";

														if($this->sendMessage($body, $subject, $_SESSION['mf_id'], $recipients, $message_type_id)){
															if($this->addCustMessage($acc_data['customer_account_id'], $message_data['message_id'])){
																$_SESSION['upload_csv']='<div class="alert alert-success">
																						<button class="close" data-dismiss="alert">×</button>
																						<strong>Success!</strong> The data has been imported.
																					</div>';
															}
														}
													}
												}
											}
										}
									}
								}else{
									$counter_sum .= $counter.', ';
								}
							}else{
								$bill_status = 0;
								$new_balance = $bill_balance - $cash_paid_balance;
								$total_amount_paid = $cash_paid_balance + $bill_details['bill_amount_paid'];
								$acc_data = $this->getAccountDetailsFromCustomerAccCode($service_account);

								//update the bill
								if($this->updateBillBalance($bill_details['bill_id'], $total_amount_paid, $new_balance, $bill_balance)){
									// create journal
									$stamp = time();
									if($this->createJournal($bill_details['bill_id'], $cash_paid, 'CR', 1, $service_account, 'Payment from CSV file', $stamp, $bill_details['mf_id'])){
										//add the payments
										$result = $this->addPayment($cash_paid, $tranc_date, $service_account, $_SESSION['mf_id'], $bill_details['bill_id'], $service_id, $payment_mode);
										if ($result) {
											$_SESSION['upload_csv']='<div class="alert alert-success">
												<button class="close" data-dismiss="alert">×</button>
												<strong>Success!</strong> The data has been imported.
											</div>';
										}
									}
								}else{
									$counter_sum .= $counter.', ';
								}
							}
						}
						$counter++;
					}
					$counter_sum = rtrim($counter_sum, ', ');
					$this->createRepaymentUpload($counter, $counter_sum);

					// check if there is any cash paid balance left
					if($cash_paid_balance > 0){
						// top up wallet balance
						$details['mf_id'] = $this->getMfidFromCustomerAcc($service_account);
						if(!empty($details['mf_id'])){
							// var_dump('Cash paid balance: '.$bill_details['mf_id']);exit;
							if($this->updateCustomerBalance($details['mf_id'], $cash_paid_balance)){
								// credit wallet balance
								if ($this->creditWalletJournal('NULL', $cash_paid_balance, 'CR', 1, 'Credit Customer Balance', $details['mf_id'])) {
									$_SESSION['upload_csv']='<div class="alert alert-success">
										<button class="close" data-dismiss="alert">×</button>
										<strong>Success!</strong> The data has been imported.
									</div>';
								}
							}
						}
					}
				}
			}
		}

		public function addOverTheCounterPayment($cash_paid_balance, $bill_id, $particulars, $tranc_date, $payment_mode,$mf_id){
			if(is_numeric($cash_paid_balance)){
				$bill_details = $this->getPendingBillFromBillId($bill_id);
				if(count($bill_details)) {
					$bill_balance = $bill_details['bill_balance'];
					$service_id = $bill_details['service_channel_id'];
					$service_account = $bill_details['service_account'];

					if ($cash_paid_balance > 0) {
						$cash_paid = $cash_paid_balance;

						if ($cash_paid_balance == $bill_balance) {
							$b_balance = 0;
							$bill_status = 1;
							$total_amount_paid = $bill_details['bill_balance'] + $bill_details['bill_amount_paid'];

							// update bill balance
//							$this->beginTranc();
							if ($this->updateBillBalance($bill_details['bill_id'], $total_amount_paid, $b_balance, $bill_status)) {
								// create journal
								$stamp = time();

								if ($this->createJournal($bill_details['bill_id'], $cash_paid, 'CR', 1, $service_account, $particulars, $stamp, $bill_details['mf_id'])) {
									//add the payments
									$result = $this->addPayment($cash_paid, $tranc_date, $service_account, $_SESSION['mf_id'], $bill_details['bill_id'], $service_id, $payment_mode);
									if ($result) {
										/* if commissionaire, award commission
                                        4% of the total cost of the phone divided by the no of months for the complete payment period
                                        */
										// get total cost of the phone
										$price = $this->getServicePrice($service_id);
										$period = 12; // in months
										$perc = 0.04;
										$commission_award = ($price / $period) * $perc;

										$acc_data = $this->getAccountDetailsFromCustomerAccCode($service_account);
										if(count($acc_data)) {
											// update customer balance
											if (!empty($acc_data['referee_mf_id'])) {
												if ($this->updateCustomerBalance($acc_data['referee_mf_id'], $commission_award)) {
													if ($this->creditWalletJournal($bill_details['bill_id'], $commission_award,
														'CR', 1, 'Commission Award', $acc_data['referee_mf_id'])
													) {
													}
												}
											}

											$data = get_row_data($result);
											// check if the payment was late
											if ($this->checkIfPaymentWasLate($tranc_date, $acc_data['repayment_date'])) {
												$late = '1';
												$curr_score_count = $this->getCurrScoreCount($acc_data['customer_account_id']);
												$credit_score_value = $curr_score_count + 1;
												$this->addCreditScore($bill_details['mf_id'], $credit_score_value);
											} else {
												$late = '0';
											}

											if ($this->addLoanRepayment($bill_details['bill_id'], date('Y-m-d'), $service_account, $data['transaction_id'], $late)) {
												$recipients = "{ " . $acc_data['customer_account_id'] . " }";
												$body = "Loan Repayment has been successfully received. Thank you.";
												$subject = "Confirmed";
												$inbox = $this->getMessageTypeId('INBOX');
												$message_type_id = "{ $inbox }";

												if ($result = $this->sendMessage($body, $subject, $_SESSION['mf_id'], $recipients, $message_type_id)) {
													$message_data = get_row_data($result);

													if ($this->addCustMessage($mf_id, $message_data['message_id'])) {
														$push = $this->getMessageTypeId('PUSH_NOTIFICATION');
														$message_type_id = "{ $push }";

														if ($this->sendMessage($body, $subject, $_SESSION['mf_id'], $recipients, $message_type_id)) {
															if ($this->addCustMessage($mf_id, $message_data['message_id'])) {
//																$this->endTranc();
																$_SESSION['done-deal'] = '<div class="alert alert-success">
																		<button class="close" data-dismiss="alert">×</button>
																		<strong>Success!</strong> The payment has been recorded.
																	</div>';
															}
														}
													}
												}
											}
										}
									}
								}
							}
						} else if($cash_paid_balance <= $bill_balance) {
							$bill_status = 0;
							$new_balance = $bill_balance - $cash_paid_balance;
							$total_amount_paid = $cash_paid_balance + $bill_details['bill_amount_paid'];
							$acc_data = $this->getAccountDetailsFromCustomerAccCode($service_account);

							//update the bill
							if ($this->updateBillBalance($bill_details['bill_id'], $total_amount_paid, $new_balance, $bill_balance)) {
								// create journal
								$stamp = time();
								if ($this->createJournal($bill_details['bill_id'], $cash_paid, 'CR', 1, $service_account, 'Payment from CSV file', $stamp, $bill_details['mf_id'])) {
									//add the payments
									$result = $this->addPayment($cash_paid, $tranc_date, $service_account, $_SESSION['mf_id'], $bill_details['bill_id'], $service_id, $payment_mode);
									if ($result) {

										$_SESSION['done-deal'] = '<div class="alert alert-success">
											<button class="close" data-dismiss="alert">×</button>
											<strong>Success!</strong> The payment has been recorded.
										</div>';
									}
								}
							}
						}
					}
				}
			}
		}

		public function getPendingBillFromBillId($bill_id){
			$query = "SELECT * FROM customer_bills WHERE bill_id = '".$bill_id."'";
			if($result = run_query($query)){
				if(get_num_rows($result)){
					return get_row_data($result);
				}
			}
		}

		public function addPayment($cash_paid, $tranc_date, $service_account, $transacted_by, $bill_id, $service_id, $payment_mode){
			$query = "INSERT INTO transactions(
            cash_paid, transaction_date, service_account, 
            transacted_by, bill_id, service_id, payment_mode)
    		VALUES ('".sanitizeVariable($cash_paid)."', '".sanitizeVariable($tranc_date)."', '".sanitizeVariable($service_account)."', 
            '".sanitizeVariable($transacted_by)."', '".sanitizeVariable($bill_id)."', '".sanitizeVariable($service_id)."', '".sanitizeVariable($payment_mode)."') RETURNING transaction_id";
            // var_dump($query);exit;
            if($result = run_query($query)){
            	return $result;
            }else{
            	var_dump('Add Payment: '.$query.' '.get_last_error());exit;
            }
		}

		public function getPendingBillFromServiceAccount($account_code){
			// get only pending bills
			$query = "SELECT * FROM customer_bills 
			WHERE service_account = '".sanitizeVariable($account_code)."' AND bill_balance > 0 AND bill_status <> '2'
			ORDER BY bill_date ASC";
			// return $query;
			//var_dump('Get Pending Bills: '.$query.' '.get_last_error());exit;
			if($result = run_query($query)){
				return $result;
			}
		}

		public function updateBillBalance($bill_id, $total_amount_paid, $bill_balance, $bill_status){
			$query = "UPDATE customer_bills SET 
			bill_amount_paid = '".sanitizeVariable($total_amount_paid)."',
			bill_balance = '".sanitizeVariable($bill_balance)."',
			bill_status = '".sanitizeVariable($bill_status)."'
			WHERE bill_id = '".$bill_id."'";
			if(run_query($query))
				return true;
			else
				var_dump('Update Bill Balance: '.get_last_error());exit;
		}

		public function createJournal($bill_id, $cash_paid, $dr_cr, $journal_type, $service_account, $particulars, $stamp,$mf_id){
			$query = "INSERT INTO journal(
            bill_id, amount, dr_cr, journal_type, service_account, particulars, 
            stamp, mf_id)
    		VALUES ('".$bill_id."', '".$cash_paid."', '".$dr_cr."', '".$journal_type."', '".$service_account."', '".$particulars."', '".$stamp."', '".$mf_id."')";
            if(run_query($query))
            	return true;
            else
            	var_dump('Create Journal :'.get_last_error());exit;
		}

		public function getServiceChannel($revenue_channel_id){
			$query = "SELECT * FROM service_channels WHERE revenue_channel_id = '".$revenue_channel_id."'";
			$result = run_query($query);
			$rows = get_row_data($result);
			return $rows['service_channel_id'];
		}

		public function addLoanRepayment($bill_id, $repayment_date, $account_code, $transaction_id, $late){
			$query = "INSERT INTO loan_repayments(bill_id, repayment_date, account_code, transaction_id, late)
			VALUES('".sanitizeVariable($bill_id)."', '".sanitizeVariable($repayment_date)."', 
				'".sanitizeVariable($account_code)."', '".$transaction_id."', '".$late."')";
			if(run_query($query)) {
//				$this->endTranc();
				return true;
			}

			else {
				var_dump('Add Loan Repayment ' . $query . ' ' . get_last_error());
				exit;
			}
			}

		public function updateCustomerBalance($mf_id, $balance){
			$curr_balance = $this->getCustomerBalance($mf_id);// if the balance does not exist the function will return 0
			$new_balance = $curr_balance + $balance;

			if(checkForExistingEntry('customer_file', 'mf_id', $mf_id)){// if the customer file exists, update with the new balance else create customer file
				$query = "UPDATE customer_file SET balance = '".$new_balance."' WHERE mf_id = '".$mf_id."'";
			}else{
				$query = "INSERT INTO customer_file(mf_id, balance) VALUES('".sanitizeVariable($mf_id)."', '".sanitizeVariable($balance)."')";
			}
			// var_dump($query);exit;
			$result = run_query($query);
			if($result){
				return true;
			}else{
				var_dump('Update Customer Balance: '.get_last_error());exit;
			}
		}

		public function getCustomerBalance($mf_id){
			$query = "SELECT balance FROM customer_file WHERE mf_id = '".$mf_id."'";
			$result = run_query($query);
			$num_rows = get_num_rows($result);
			if($num_rows >= 1){
				$rows = get_row_data($result);
				return $rows['balance'];
			}else{
				return 0;
			}
		}

		public function getAccountDetailsFromCustomerAccCode($account_code){
			if(!empty($account_code)) {
				$query = "SELECT * FROM customer_account WHERE customer_code = '" . $account_code . "'";
				$result = run_query($query);
				return get_row_data($result);
			}
		}

		public function creditWalletJournal($bill_id, $amount, $dr_cr, $journal_type, $particulars, $mf_id){
			$query = "INSERT INTO public.wallet_journal(
            bill_id, amount, dr_cr, journal_type, particulars, 
            journal_date, stamp, mf_id)
    		VALUES (".$bill_id.", '".$amount."', '".$dr_cr."', '".$journal_type."', '".$particulars."', '".date('Y-m-d H:i:s')."', '".time()."', '".$mf_id."');
";
			if(run_query($query)){
				return true;
			}else{
				var_dump('Credit Wallet: '.$query.' '.get_last_error());exit;
			}
		}

		public function getServicePrice($service_channel_id){
			$query = "SELECT price FROM service_channels WHERE service_channel_id = '".$service_channel_id."'";
			$result = run_query($query);
			$rows = get_row_data($result);
			return $rows['price'];
		}

		public function checkIfPaymentWasLate($payment_date, $repayment_date){
			$payment_date = strtotime($payment_date);
			$repayment_date = strtotime($repayment_date);
			// var_dump('Payment Date: '.$payment_date.' Repayment Date: '.$repayment_date);exit;s
			if($payment_date > $repayment_date){
				return true;
			}else{
				return false;
			}
		}

		public function addCreditScore($mf_id, $score_value){
			if(!checkForExistingEntry('customer_account_credit_score', 'mf_id', $mf_id)){
				$query = "INSERT INTO customer_account_credit_score(
           		mf_id, credit_score_count)
    			VALUES ('".sanitizeVariable($mf_id)."', '".$score_value."')";
	    	}else{
	    		$query = "UPDATE customer_account_credit_score SET credit_score_count = '".sanitizeVariable($score_value)."' WHERE mf_id = '".sanitizeVariable($mf_id)."'";
	    	}
    		if(run_query($query)){
    			return true;
    		}else{
    			var_dump('Add Credit Score: '.get_last_error());exit;
    		}
		}

		public function getCustomerAccountData($customer_account_code){
			$query = "SELECT * FROM customer_account WHERE customer_code = '".$customer_account_code."'";
			if($result = run_query($query)){
				return $rows = get_row_data($result);
			}
		}

		public function getCurrScoreCount($customer_account_id){
			$query = "SELECT credit_score_count FROM customer_account_credit_score WHERE customer_account_id = '".$customer_account_id."'";
			if($result = run_query($query)){
				$num_rows = get_num_rows($result);
				if($num_rows >= 1){
					$rows = get_row_data($result);
					return $rows['credit_score_value'];
				}else{
					return 0;
				}
			}
		}

		public function sendMessage($body, $subject, $sender, $recipients, $message_type_id){
			$stamp = date('Y-m-d H:i:s');
			$query = "INSERT INTO public.message( body, subject, sender, recipients, created, message_type_id)
   			VALUES ('".sanitizeVariable($body)."', '".sanitizeVariable($subject)."', '".sanitizeVariable($sender)."',
   			 '".sanitizeVariable($recipients)."', '".$stamp."', '".sanitizeVariable($message_type_id)."') RETURNING message_id";
			// var_dump($query);exit;
   			if($result = run_query($query)){
 				return $result;
   			}else{
   				return false;
   			}
		}

		public function getMessageTypeId($code){
	 		$query = "SELECT message_type_id FROM message_type WHERE message_type_code = '".$code."'";
	 		$result = run_query($query);
	 		if($result){
	 			$rows = get_row_data($result);
	 			return $rows['message_type_id'];
	 		}
	 	}

	 	public function getCustomerAccountIds($mf_id){
	 		$query = "SELECT customer_account_id FROM customer_account WHERE mf_id = '".$mf_id."'";
	 		$result = run_query($query);
	 		if($result){
	 			$return = '{';
	 			while($rows = get_row_data($result)){
	 				$return .= $rows['customer_account_id'].',';	
	 			}
	 			$return = rtrim($return, ',');
	 			$return .= '}';

	 			return $return;
	 		}
	 	}

	 	public function getCustomerAccountIdsData($mf_id){
	 		$query = "SELECT customer_account_id FROM customer_account WHERE mf_id = '".$mf_id."'";
	 		$result = run_query($query);
	 		if($result){
	 			while($rows = get_row_data($result)){
	 				$return[] = $rows['customer_account_id'];	
	 			}

	 			return $return;
	 		}
	 	}

	 	public function addCustMessage($mf_id, $message_id){
	 		$query = "INSERT INTO customer_messages(mf_id, message_id) 
	 		VALUES('".sanitizeVariable($mf_id)."', '".$message_id."')";
	 		if(run_query($query)){
	 			return true;
	 		}else{
	 			var_dump('Add Customer Message '.$query.' '.get_last_error());exit;
	 		}
	 	}

	 	public function getMfidFromCustomerAcc($code){
			if(!empty($code)) {
				$query = "SELECT mf_id FROM customer_account WHERE customer_code = '" . $code . "'";
				if ($result = run_query($query)) {
					$rows = get_row_data($result);
					return $rows['mf_id'];
				}
			}
	 	}

	 	public function createRepaymentUpload($repayment_count, $error){
			$query = "INSERT INTO public.loan_repayment_uploads(
            upload_mf_id, upload_date, repayment_count, error_report)
    		VALUES ('".$_SESSION['mf_id']."', '".date('Y-m-d')."', 
    			'".sanitizeVariable($repayment_count)."', '".sanitizeVariable($error)."')";
    		if(run_query($query)){
    			return true;
    		}else{
    			var_dump('Create Airtime Upload: '.$query.' '.get_last_error());exit;
    		}
		}
	}
?>
