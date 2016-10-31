<?php
	include_once('src/models/Masterfile.php');

	class Payment extends Masterfile{
		public function getRegionId($mf_id){
			if(!empty($mf_id)){
				$query = "SELECT region_id FROM revenue_clerk_allocation WHERE mf_id = '".$mf_id."'";
				$result = run_query($query);
				$rows = get_row_data($result);
				return $rows['region_id'];
			}
		}

		public function getSubcountyAndRevenueRegion($region_id){
			if (!empty($region_id)) {
				$query = "SELECT * FROM rmc_region WHERE region_id = '".$region_id."'";
				$result = run_query($query);
				$rows = get_row_data($result);
				return $rows;
			}
		}

		public function getAllCustomers(){
			$return = array();
			$query = "SELECT *, CONCAT(surname,' ',firstname,' ',middlename) AS full_name FROM masterfile WHERE b_role = 'Client'";
			if($result = run_query($query)){
				if(get_num_rows($result)){
					while ($rows = get_row_data($result)) {
						$return[] = $rows;
					}
					return $return;
				}
			}
		}		
		

		public function getPaymentModes(){
			$return = array();
			$query = "SELECT * FROM payment_mode";
			if($result = run_query($query)){
				if(get_num_rows($result)){
					while ($rows = get_row_data($result)) {
						$return[] = $rows;
					}
					return $return;
				}
			}
		}

		public function getRequestTypeData($req_code){
			$query = "SELECT * FROM request_types WHERE request_type_code = '".trim($req_code)."'";
			// var_dump($query);exit;
			if($result = run_query($query)){
				if(get_num_rows($result)){
					return get_row_data($result);
				}
			}
		}

		public function getServiceData($service_id){
			$query = "SELECT * FROM service_channels WHERE service_channel_id = '".$service_id."'";
			if($result = run_query($query)){
				if(get_num_rows($result)){
					return get_row_data($result);
				}
			}
		}


		public function getOrderItems($order_id){
			$return = array();
			if(!empty($order_id)){
				$query = "SELECT oi.*, sc.service_option, CONCAT(m.surname,' ',m.firstname) AS customer_name FROM order_items oi
				LEFT JOIN service_channels sc ON sc.service_channel_id = oi.service_channel_id
				LEFT JOIN masterfile m ON m.mf_id = oi.customer_mf_id
				WHERE oi.order_id = '".$order_id."'";
				if($result = run_query($query)){
					if(get_num_rows($result)){
						while ($rows = get_row_data($result)) {
							$return[] = $rows;
						}
						return $return;
					}
				}
			}
		}

		public function addOTCPayment($otc_ref_no = '', $bill_ref = 'NULL', $amount, $otc_type){
			$query = "INSERT INTO otc_payment(
            otc_ref_no, 
            bill_reference, 
            amount, 
            otc_type)
    		VALUES (
    			'".sanitizeVariable($otc_ref_no)."', 
    			".sanitizeVariable($bill_ref).", 
    			'".sanitizeVariable($amount)."', 
    			'".sanitizeVariable($otc_type)."'
    		) RETURNING otc_id";
			// var_dump($query);exit;
			if($result = run_query($query)){
				$rows = get_row_data($result);
				return $rows['otc_id'];
			}else{
				return false;
			}
		}

		public function getRequestType($request_type_code){
			$query = "SELECT request_type_id FROM request_types WHERE request_type_code = '".$request_type_code."'";
			if($result = run_query($query)){
				if(get_num_rows($result)){
					$rows = get_row_data($result);
					return $rows['request_type_id'];
				}
			}
		}

        /**
         * return $receipt_code
         */
		public function generateReceiptCode($revenue_channel_id = NULL){
//		    $revs = $this->selectQuery('revenue_channel', 'revenue_channel_code', "revenue_channel_id = '".$revenue_channel_id."'");
//            $revenue_channel_code = $revs[0]['revenue_channel_code'];
            $revenue_channel_code = '';
//            var_dump($revenue_channel_code);exit;
            // get Usp Code from system settings
            $usp_code = usp_code;

            // generate four digit random number
            $random = rand(1000, 9999);

            // make the code
            $receipt_code = $usp_code.$revenue_channel_code.time().$random;
            return $receipt_code;
        }

        public function getModeId($mode){
            $modes = $this->selectQuery('payment_mode', 'payment_mode_id', "payment_mode_code = '".$mode."'");
            return $modes[0]['payment_mode_id'];
        }

        public function getModeName($modeid){
            $mode = $this->selectQuery('payment_mode', 'payment_mode_name', "payment_mode_id = '".$modeid."'");
            return $mode[0]['payment_mode_name'];
        }

        public function getService($service_id){
            $serv = $this->selectQuery('service_channels', 'service_option', "service_channel_id = '".$service_id."'");
            return $serv[0]['service_option'];
        }
	}
?>