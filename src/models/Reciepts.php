<?php
include_once 'src/models/Payment.php';
class Reciepts extends Payment
{
	private $_receipt_array = array();

	public function __construct($order){
		$query = "SELECT ot.*, o.*, m.surname,m.middlename,m.firstname, s.service_option  from order_items ot
	  	LEFT JOIN \"order\" o ON o.order_id = ot.order_id
	  	LEFT JOIN masterfile m ON m.mf_id = ot.customer_mf_id
	  	LEFT JOIN service_channels s ON s.service_channel_id =ot.service_channel_id
	  	WHERE ot.order_id ='".$order."'";
	  	//var_dump($query);exit;
	  	$result = run_query($query);
	  	if ($result){
	  		while($rows = get_row_data($result)){
	  			$this->_receipt_array[] = $rows;
	  		}
	  		return $this->_receipt_array;
	  	}
	}

	public function getReceiptData(){
		return $this->_receipt_array;
	}

	public function getLamuReciepts($trans){
    	$query = "SELECT t.*, t.transaction_date::bigint AS tranc_date, m.*, r.*,s.* from transactions t
           LEFT JOIN masterfile m ON m.mf_id = t.mf_id
           LEFT JOIN revenue_channel r ON r.revenue_channel_id = t.service_type_id
           LEFT JOIN service_channels s ON s.service_channel_id =t.service_id
            WHERE t.transaction_id = '".$trans."'";
                //var_dump($query);exit;
      $result = run_query($query);
      $row = get_row_data($result);
      return $row;  
  	}

  	public function getPaymentId($order){
  		$query = "SELECT payment_id FROM \"order\" WHERE order_id = '".$order."'";
  		if($result = run_query($query)){
  			if(get_num_rows($result)){
  				$rows = get_row_data($result);
  				return $rows['payment_id'];
  			}
  		}
  	}

  	public function getCustomerName($order){
  		$query = "SELECT DISTINCT(customer_mf_id), CONCAT(m.surname,' ',m.firstname,' ',m.middlename) AS customer_name FROM order_items oi
  		LEFT JOIN masterfile m ON m.mf_id = oi.customer_mf_id
  		WHERE order_id = '".$order."'";
  		if($result = run_query($query)){
  			if(get_num_rows($result)){
  				$rows = get_row_data($result);
  				return $rows['customer_name'];
  			}else{
  				return '';
  			}
  		}
  	}

	public function servedBy($mf_id){
		$query = "SELECT surname, firstname, middlename FROM masterfile 
        WHERE mf_id = '".$mf_id."'";
		$result = run_query($query);
		return $rows = get_row_data($result);
	}

}
?>
