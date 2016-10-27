<?php
	session_start();
	include '../connection/config.php';

	$transactions = array();
	if(!empty($_POST['ticket_id'])){
		logAction('Open Ticket', $_SESSION['sess_id'], $_SESSION['mf_id']);
		
		$query1 = "UPDATE support_ticket SET status = '0' WHERE support_ticket_id = '".$_POST['ticket_id']."'";
		array_push($transactions, $query1);

		if(executeTransaction($transactions)){
			$return = array('status' => 1);
			echo json_encode($return);
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
?>