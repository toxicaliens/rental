<?php
	session_start();
	include '../connection/config.php';

	$transactions = array();
	if(!empty($_POST['ticket_id'])){
		logAction('Close Ticket', $_SESSION['sess_id'], $_SESSION['mf_id']);
		
		// add the support ticket
		$query1 = "UPDATE support_ticket SET status = '1' WHERE support_ticket_id = '".$_POST['ticket_id']."'";
		if(pg_query($query1)){

			// send the message of closure of ticket
			$body = "Dear Customer, your ticket(".$_POST['ticket_id'].") has been resolved on (".date('Y-M-d')."). Please call Gtel support for any inquiries.";
			$query2 = "INSERT INTO message(
	            body, subject, sender, recipients, created, message_type_id)
	    		VALUES ('".$body."', 'Ticket Closed', '".$_SESSION['mf_id']."', '{".$_POST['customer_account_id']."}', '".date('Y-m-d H:i:s')."', '{".getMessageTypeid('PUSH_NOTIFICATION')."}') RETURNING message_id";
	    	if($result = pg_query($query2)){
	    		$rows = pg_fetch_assoc($result);

    			$query3 = "INSERT INTO customer_messages(customer_account_id, message_id) VALUES('".$_POST['customer_account_id']."', '".$rows['message_id']."')";
	    		if(pg_query($query3)){
					$return = array('status' => 1);
					echo json_encode($return);
				}
			}

		}
	}

	function logAction($case_name, $session_id, $staff_customer_id){
	    date_default_timezone_set('Africa/Nairobi');
	    $timestamp = date('Y-m-d H:i:s');
	    $query = "INSERT INTO audit_trail(session_id, mf_id, case_name, datetime) VALUES ('".$session_id."', '".$staff_customer_id."', '".$case_name."', '".$timestamp."')";
	    if(pg_query($query)){
	        return true;
	    }else{
	        return false;
	    }
	}

	function executeTransaction($transactions, $safe_point = null){
	    $success = TRUE;
	    pg_query("BEGIN");
	    try{
	        foreach ($transactions as $transaction):
	            $result = pg_query($transaction);
	            if(!$result) throw new Exception("$transaction failed");
	        endforeach;
	        pg_query("COMMIT");
	    } catch(Exception $e)
	    {
	        echo "Rolling back transactions\n";
	        $query = "ROLLBACK";
	        if(!is_null($safe_point))
	            $query .= " TO $safe_point";
	        pg_query($query);
	        $success = FALSE;
	        //we could show this error on the interface....or a customer error
	        echo "Caught Exception ('{$e->getMessage()}')\n{$e}\n";
	    }
	    return $success;
	}

	function getMessageTypeid($code){
		$query = "SELECT message_type_id FROM message_type WHERE message_type_code = '".$code."'";
		$result = pg_query($query);
		$rows = pg_fetch_assoc($result);
		return $rows['message_type_id'];
	}

	function getAccountId($mf_id){
		$query = "SELECT customer_account_id FROM customer_account WHERE mf_id = '".$mf_id."'";
		$result = pg_query($query);
		$rows = pg_fetch_assoc($result);
		return $rows['customer_account_id'];
	}
?>