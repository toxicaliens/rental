<?php
	include_once('src/models/LoanRepayments.php');
	/**
	* 
	*/
	class GpayWallet extends LoanRepayments
	{
		
		public function getCustomerBalances(){
			$query = "SELECT CONCAT(m.surname,' ', m.firstname,' ',m.middlename) AS customer_name, cf.* FROM customer_file cf
			LEFT JOIN masterfile m ON m.mf_id = cf.mf_id";
			return run_query($query);
		}

		public function getAllCustomers(){
			$query = "SELECT CONCAT(m.surname,' ',m.firstname,' ',m.middlename) AS customer_name, m.mf_id FROM masterfile m WHERE b_role = 'client'";
			// var_dump($query);exit;
			return $result = run_query($query);
		}

		public function addCustomerBalance(){
			extract($_POST);
			// validation
			if(!empty($customer) && !empty($balance)){
				if($balance >= 0){
					// add the balance
					$query = "INSERT INTO customer_file(mf_id, balance) VALUES('".sanitizeVariable($customer)."', '".sanitizeVariable($balance)."')";
					// var_dump($query);exit;
					// check if customer already exists
					if(!checkForExistingEntry('customer_file', 'mf_id', $customer)){
						if(run_query($query)){
							if($this->creditWalletJournal('NULL', $balance, 'CR', 1, 'Add Customer Balance', $customer)){
								$_SESSION['customer_balance'] = '<div class="alert alert-success">
				                    <button class="close" data-dismiss="alert">×</button>
				                    <strong>Success!</strong> New Customer Balance has been added.
				                </div>';
				                App::redirectTo('?num=customer_balances');
				            }
						}
					}else{
						// get the current balance
						$curr_balance = $this->getCustomerBalance($customer);
						$new_balance = $curr_balance + $balance;
						
						$query = "UPDATE customer_file SET balance = '".sanitizeVariable($new_balance)."' WHERE mf_id = '".$customer."'";
						if(run_query($query)){
							if($this->creditWalletJournal('NULL', $balance, 'CR', 1, 'Add Customer Balance', $customer)){
								$_SESSION['customer_balance'] = '<div class="alert alert-success">
				                    <button class="close" data-dismiss="alert">×</button>
				                    <strong>Success!</strong> Customer Balance has been updated.
				                </div>';
				            }
						}
					}
				}
			}else{

			}
		}

		public function editCustomerBalance(){
			extract($_POST);

			if(!empty($customer) && !empty($balance) && !empty($edit_id)){
				if($balance >= 0){
					// add the balance
					$query = "UPDATE customer_file SET mf_id = '".sanitizeVariable($customer)."', balance = '".sanitizeVariable($balance)."' WHERE mf_id = '".$customer."'";
					// var_dump($query);exit;
					// check if customer already exists
					if(!onEditCheckForExistingEntry('customer_file', 'mf_id', $customer, 'mf_id', $edit_id)){
						if(run_query($query)){
							$_SESSION['customer_balance'] = '<div class="alert alert-success">
			                    <button class="close" data-dismiss="alert">×</button>
			                    <strong>Success!</strong> Customer file has been updated.
			                </div>';
			                App::redirectTo('?num=customer_balances');
			            }
			        }else{
			        	$_SESSION['customer_balance'] = '<div class="alert alert-warning">
			                    <button class="close" data-dismiss="alert">×</button>
			                    <strong>Warning!</strong> Customer The Customer('.$this->getCustomerName($customer).') already exists.
			                </div>';
			        }
			    }
			}
		}

		public function deleteCustomerBalance(){
			extract($_POST);

			if(!empty($delete_id)){
				$query = "DELETE FROM customer_file WHERE mf_id = '".$delete_id."'";
				if(run_query($query)){
					$_SESSION['customer_balance'] = '<div class="alert alert-success">
	                    <button class="close" data-dismiss="alert">×</button>
	                    <strong>Success!</strong> Customer file has been deleted.
	                </div>';
	                App::redirectTo('?num=customer_balances');
				}
			}
		}

		public function getCustomerBalance($mf_id){
			$query = "SELECT balance FROM customer_file WHERE mf_id = '".$mf_id."'";
			$result = run_query($query);
			$rows = get_row_data($result);
			return $rows['balance'];
		}

		public function getCustomerName($mf_id){
			if(!empty($mf_id)){
				$query = "SELECT CONCAT(surname,' ',firstname,' ',middlename) AS customer_name FROM masterfile WHERE mf_id = '".$mf_id."'";
				$result = run_query($query);
				$rows = get_row_data($result);
				return $rows['customer_name'];
			}	
		}
	}
?>
