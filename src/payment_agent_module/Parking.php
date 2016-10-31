<?php
include_once('src/model/Payment.php');
/**
* 
*/
class Parking extends Payment{
	public function getFullName(){
	    $query = "SELECT firstname, surname FROM " . DATABASE . "masterfile WHERE mf_id = '$one'";
	    $data = run_query($query);
	    $rows = get_row_data($data);
	    $name = trim($rows['firstname']) . " " . trim($rows['surname']);
	    return $name;
	}

	public function addOrder(){
		$query = "INSERT INTO \"order\"(user_mf_id, order_date, order_status, payment_id) 
		VALUES(
			'".$_SESSION['mf_id']."',
			'".date('Y-m-d')."',
			0,
			NULL
		) RETURNING order_id";
		// var_dump($query);exit;
		if($result = run_query($query)){
			$rows = get_row_data($result);
			return $rows['order_id'];
		}else{
			return false;
		}
	}

	public function addOrderItems($service_id, $order_id, $quantity, $unit_price, $service_account, $customer){
		$subtotal = $quantity * $unit_price;
		$customer = (!empty($customer)) ? $customer : 'NULL';
		$query = "INSERT INTO order_items(service_channel_id, order_id, quantity, unit_price, subtotal, service_account, customer_mf_id) 
		VALUES(
			'".sanitizeVariable($service_id)."',
			'".sanitizeVariable($order_id)."',
			'".sanitizeVariable($quantity)."',
			'".sanitizeVariable($unit_price)."',
			'".sanitizeVariable($subtotal)."',
			'".sanitizeVariable($service_account)."',
			".sanitizeVariable($customer)."
		) RETURNING order_id";
		if($result = run_query($query)){
			return true;
		}else{
			return false;
		}
	}

	public function getPaymentDetails($order_item_id){
		$query = "SELECT * FROM order_items WHERE order_item_id = '".$order_item_id."'";
		if($result = run_query($query)){
			if(get_num_rows($result)){
				return get_row_data($result);
			}
		}
	}

	public function processPayment($order_item_id){
		$data = $this->getPaymentDetails($order_item_id);
		// var_dump($data);exit;

		$mf_id = (!empty($data['customer_mf_id'])) ?$data['customer_mf_id'] : 'NULL';
		$service_account = $data['service_account'];
		$reference_code = $_POST['ref'];
		$total_amount = $_POST['amount'];
		$order_id = $_POST['order_id'];
		$service_id = $data['service_channel_id'];

		$service_data = $this->getServiceData($service_id);
		$price = $service_data['price'];
		$revenue_channel_id = $service_data['revenue_channel_id'];

		$thetimestamp = time();
		$date_logged = date('Y-m-d H:i:s');
		$service_option_code = $service_data['option_code'];
		
		// log the request
		if(!empty($service_account)){
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
				'".$price."',
				'".$revenue_channel_id."',
				'".$date_logged."',
				NULL,
				'".$_SESSION['mf_id']."'
				)";
			// var_dump($log_req);exit;
			if(run_query($log_req)){
				$inputs = array(
					'service_account'=>$service_account, 
					'service_id'=>$service_id, 
					'cash_received'=>$price, 
					'price'=>$price,
					'mf_id'=>$mf_id,
					'reference_code'=>$reference_code,
					'total_amount'=>$total_amount,
					'order_id'=>$order_id
				);
				$this->log_transaction($inputs);
			}
		}
	}

	public function log_transaction($inputs){
		$req_data = $this->getRequestTypeData(Buy_Service);
		$query = "INSERT INTO transactions(
			cash_paid, 
			agent_id, 
			mf_id, 
			request_type_id, 
			service_account, 
			service_id,
			receiptnumber,
			transaction_date) 
		VALUES(
			'".$inputs['price']."',
			'".$_SESSION['mf_id']."',
			".$inputs['mf_id'].",
			'".$req_data['request_type_id']."',
			'".$inputs['service_account']."',
			'".$inputs['service_id']."',
			'".$inputs['reference_code']."',
			'".time()."') RETURNING transaction_id";
		// var_dump($query);exit;
		$result = run_query($query);
		if($result){
			$rows = get_row_data($result);
			if($otc_id = $this->addOTCPayment('','NULL', $inputs['total_amount'], $req_data['request_type_id'])){
				if($this->updateOrderItemPaymentId($otc_id, $inputs['order_id'])){
					$_SESSION['parking'] = '<div class="alert alert-success">
		                <button class="close" data-dismiss="alert">×</button>
		                <strong>Success!</strong> Payment was successfully recorded.
		            </div>';
		            App::rediretTo('?num=167');
		        }
	        }
		}
	}

	public function updateOrderItemPaymentId($payment_id, $order_id){
		$query = "UPDATE \"order\" SET payment_id = '".$payment_id."' WHERE order_id = '".$order_id."'";
		if(run_query($query)){
			return true;
		}else{
			return false;
		}
	}
}
?>