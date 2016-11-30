<?php
include_once('src/models/Masterfile.php');;

class SupportTickets extends Masterfile{
 	public function allMaintenanceTickets(){
		if($_SESSION['role_name'] == SystemAdmin){
			$condtion = Null;
		}else{
			$condtion = " WHERE mt.reported_by = '".$_SESSION['mf_id']."'";
		}
 		$query ="SELECT mt.*, c.category_name, CONCAT(m.surname,' ',m.firstname,' ',m.middlename) AS customer_name FROM maintenance_ticket mt
 		LEFT JOIN masterfile m ON m.mf_id = mt.reported_by
 		LEFT JOIN category c ON c.category_id = mt.subject
 		$condtion
 		";
 		$result = run_query($query);
		return $result;
 	}

	public function AllReferrals($condition = ''){
		$query ="SELECT * FROM referrals WHERE referrals_id IS NOT NULL $condition";
 		$result = run_query($query);
		return $result;
	}

	public function mySupportTickets(){
		$query = "SELECT sta.*, st.* FROM support_ticket_assignment sta 
		LEFT JOIN support_ticket st ON st.support_ticket_id = sta.support_ticket_id
		WHERE sta.assigned_to = '".$_SESSION['mf_id']."'";
		//var_dump($query);exit;
		return run_query($query);
	}

	public function getSupportMessageTypes(){
			$query = "SELECT * FROM message_type WHERE message_type_code ='EMAIL'";
			//var_dump($query);exit;
			return $result = run_query($query);
	}

	public function getSendToClient($id){
		$query ="SELECT customer_account_id FROM support_ticket 
 		WHERE support_ticket_id = '".$id."'";
 		$result = run_query($query);
 		$row= get_row_data($result);
		return $row['customer_account_id'];
	}

	public function respondToSupportIssue(){
         extract($_POST);
        $customer_account = $this->getSendToClient($support_ticket_id);
        $sender = $_SESSION['mf_id'];
        $reciever = 'array['.$customer_account.']';
        $message = 'array['.$message_type.']';
        $body_message = "Dear Customer,\n\n";
    	$body_message .= $body;
 		$body_message .="\n\nGTEL-Care";
 
        $query = "INSERT INTO message(body, subject, sender, recipients,message_type_id) 
	      VALUES('".sanitizeVariable($body_message)."','".sanitizeVariable($subject)."','".sanitizeVariable($sender)."'
	      ,".$reciever.",".$message.")RETURNING message_id";
	          //var_dump($query);exit;
	     $result = run_query($query);
          if($result){
		    $data = get_row_data($result);
				if($result = $this->addTOSupportMessage($data['message_id'])){
					if($result){
		                $_SESSION['support'] = '<div class="alert alert-success">
		                        <button class="close" data-dismiss="alert">×</button>
		                        <strong>Success!</strong>The Message was send successfully.
		                    </div>';
		                     App::redirectTo('index.php?num=issued_tickets');
				}
			}
		}
	}

	public function addTOSupportMessage($mess){
		extract($_POST);
        $query = "INSERT INTO support_tickets_messages(support_ticket_id, message_id) 
	      VALUES('".sanitizeVariable($support_ticket_id)."','".sanitizeVariable($mess)."')RETURNING message_id";
	          //var_dump($query);exit;
	     $result = run_query($query);
	     if($result){
		    $data = get_row_data($result);
				if($result = $this->addToCustomerInbox($data['message_id'])){
					return $result;
			}
		}
    }

    public function addToCustomerInbox($data){
    	extract($_POST);
        $customer_account = $this->getSendToClient($support_ticket_id);
    	$query = "INSERT INTO customer_messages(customer_account_id, message_id) VALUES('".$customer_account."','".$data."')";
    	//var_dump($query);exit;
		$result =run_query($query);
		return $result;
    }

    public function getTicketDetails($ticket_id){
    	$query = "SELECT st.*, CONCAT(m.surname,' ',m.firstname) AS customer_name, sta.assigned_to FROM support_ticket st
    	LEFT JOIN customer_account ca ON ca.customer_account_id = st.customer_account_id
    	LEFT JOIN masterfile m ON m.mf_id = ca.mf_id
    	LEFT JOIN support_ticket_assignment sta ON sta.support_ticket_id = st.support_ticket_id
    	WHERE st.support_ticket_id = '".$ticket_id."'";
    	$result = run_query($query);
    	return $rows = get_row_data($result);
    }

    public function getTicketComments($ticket_id){
    	$query = "SELECT stm.*, m.body, m.sender, m.created, CONCAT(mf.surname,' ',mf.firstname) AS user_name FROM support_tickets_messages stm
    	LEFT JOIN message m ON m.message_id = stm.message_id
    	LEFT JOIN masterfile mf ON m.sender =  mf.mf_id 
    	WHERE stm.support_ticket_id = '".$ticket_id."'";
    	// var_dump($query);exit;
    	return run_query($query);
    }

    public function addComment(){
    	extract($_POST);
    	$reciever = $this->getMfidFromCustomerAccId($recip_id);
    	$recipients = "{ $recip_id }";
         //var_dump($recipients);exit;
    	$message_type_id = $this->getSupportMessageTypeId('PUSH_NOTIFICATION');
    	$mess_type = "{ $message_type_id }";
    	$body = "Dear Customer,\n\n";
    	$body .= $comment;
 		$body .="\n\nGTEL-Care";
 		$query = "INSERT INTO message(body, subject, sender, recipients, message_type_id) 
 		VALUES ('".sanitizeVariable($body)."', '".sanitizeVariable($subject)."', '".$_SESSION['mf_id']."', '".$recipients."', '".$mess_type."') RETURNING message_id";
    	//var_dump($query); exit;
		$result = run_query($query);
        if($result){
        	$rows = get_row_data($result);
        	// add customer message
        	if($this->addCustomerMessage($ticket_id, $rows['message_id'])){
            	$_SESSION['done-deal'] = '<div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    <strong>Success!</strong> Comment was Successfully Recorded.
                </div>';
               App::redirectTo('index.php?num=view_ticket&ticket_id='.$ticket_id);
            }
        }else{
        	var_dump(get_last_error());exit;
        }
 	}

 	public function addCustomerMessage($customer_account_id, $message_id){
 		$query = "INSERT INTO support_tickets_messages(support_ticket_id, message_id) 
 		VALUES('".sanitizeVariable($customer_account_id)."', '".$message_id."')RETURNING support_ticket_id";
 		//var_dump($query);exit;
 		$result = run_query($query);
 		if($result){
        	$rows = get_row_data($result);
        	// add customer message
        	if($this->addReponseMessage($rows['support_ticket_id'], $message_id)){
            	$_SESSION['done-deal'] = '<div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    <strong>Success!</strong> Comment was Successfully Recorded.
                </div>';
                App::redirectTo('index.php?num=view_ticket&ticket_id='.$customer_account_id);
            }
        }else{
        	var_dump(get_last_error());exit;
        }
 	}
     
    public function addReponseMessage($ticket_id, $message_id){
    	 extract($_POST);
        $customer_account = $this->getSendToClient($ticket_id);
    	$query = "INSERT INTO customer_messages(customer_account_id, message_id) 
 		VALUES('".sanitizeVariable($customer_account)."', '".$message_id."')";
 		//var_dump($query);exit;
 		$result = run_query($query);
 		return $result;
    }

 	public function getSupportMessageTypeId($code){
 		$query = "SELECT message_type_id FROM message_type WHERE message_type_code = '".$code."'";
 		$result = run_query($query);
 		if($result){
 			$rows = get_row_data($result);
 			return $rows['message_type_id'];
 		}
 	}

 	public function getMfidFromCustomerAccId($acc_id){
 		if(!empty($acc_id)){
	 		$query = "SELECT mf_id FROM customer_account WHERE customer_account_id = '".$acc_id."'";
	 		$result = run_query($query);
	 		$rows = get_row_data($result);
	 		return $rows['mf_id'];
	 	}else{
	 		var_dump(get_last_error());exit;
	 	}
 	}

	public function getVoucherCategories(){
		if($_SESSION['role_name'] == SystemAdmin){
			$condition = Null;
		}else{
			$condition = " WHERE created_by = '".$_SESSION['mf_id']."'";
		}
		$query = "SELECT * FROM category
    	 $condition";
		// var_dump($query);exit;
		return run_query($query);
	}

	public function addCategory(){
		extract($_POST);
		$validate = array(
			'category_name'=>array(
				'name'=> 'Category Name ',
				'required'=>true,
//				'unique'=>'category'
			),
			'category_code'=>array(
				'name'=> 'Category Code',
				'required'=>true,
//				'unique'=>'category'
			)
		);
		// var_dump($validate);
		$this->validate($_POST, $validate);
		if ($this->getValidationStatus()){
			//if the validation has passed, run a query to insert the details
			//into the database
			if($this-> addCategoryDetails($category_code, $category_name)){
				$this->flashMessage('support', 'success', 'Voucher Category has been added.');
			}else{
				$this->flashMessage('support', 'error', 'Failed to create voucher category! ' . get_last_error());
			}
		}

	}

	public function addCategoryDetails($category_code, $category_name){
		$result = $this->insertQuery('category',
			array(
				'category_name' => $category_name,
				'category_code' => $category_code,
				'created_by'=>$_SESSION['mf_id']
			)
		);

		return $result;
	}
	
	public function editCategory(){
		extract($_POST);
		//var_dump($_POST);exit;
		$validate = array(
			'category_name'=>array(
				'name'=> 'Category Name ',
				'required'=>true,
				'unique2' => array(
					'table' => 'category',
					'skip_column' => 'category_id',
					'skip_value' => $post['edit_id']
				)
			),
			'category_code'=>array(
				'name'=> 'Category Code',
				'required'=>true,
				'unique2' => array(
					'table' => 'category',
					'skip_column' => 'category_id',
					'skip_value' => $post['edit_id']
				)
			)
		);

		$this->validate($_POST, $validate);
		if ($this->getValidationStatus()){
			//if the validation has passed, run a query to insert the details
			//into the database
			$result = $this->updateQuery2(
				'category',
				array(
					'category_name' => $category_name,
                    'category_code' => $category_code
				),
				array(
					'category_id' => $edit_id
				)
			);
			if($result){
				$this->flashMessage('support', 'success', 'Voucher Category has been Updated.');
			}else{
				$this->flashMessage('support', 'error', 'Failed to update voucher category! ' . get_last_error());
			}
		}
	}
	
	public function deleteCategory(){
		extract($_POST);
		$result = $this->deleteQuery('category', "category_id = '".$delete_id."'");
		if($result)
			$this->flashMessage('support', 'success', 'Voucher Category has been deleted!');
		else
			$this->flashMessage('support', 'error', 'Encountered an error! '.get_last_error());
	}

	public function getallComplains(){
		$query ="SELECT mt.*, CONCAT(m.surname,' ',m.firstname,' ',m.middlename) AS customer_name FROM maintenance_ticket mt
 		LEFT JOIN masterfile m ON m.mf_id = mt.reported_by
 		";
		$result = run_query($query);
	}

	public function getComplains(){
		$query = "SELECT * FROM maintenance_ticket";
		$result = run_query($query);
		return $result;
	}

	public function getMaintenanceVoucher(){
        if($_SESSION['role_name'] == SystemAdmin){
            $condition = Null;
        }else{
            $condition = " WHERE create_user = '".$_SESSION['mf_id']."'";
        }
		$query ="SELECT * FROM maintenancevoucher $condition";
		$result = run_query($query);
        return $result;
	}

	public function getMaintenanceVoucherForContractors(){
//		if($_SESSION['role_name'] == SystemAdmin){
//			$condition = Null;
//		}else{
//			$condition = " WHERE create_user = '".$_SESSION['mf_id']."'";
//		}
		$query ="SELECT * FROM maintenancevoucher WHERE approve_status IS TRUE ";
		$result = run_query($query);
		return $result;
	}

	public function addVoucher(){
		extract($_POST);
		$complaint =(!empty($complaint_id) ? $complaint_id : 'NULL');
		//var_dump($complaint);exit;
		$user = $_SESSION['mf_id'];
		$status = '0';
		$validate = array(
			'category_id'=>array(
				'name'=> 'Category Name',
				'required'=>true
			),
			'maintenance_name'=>array(
				'name'=> 'Maintenance Description',
				'required'=>true
			),
            'property_id'=>array(
                'name'=>'Property',
                'required'=>true
            ),
            'maintenance_description'=>array(
                'name'=>'maintenance description',
                'required'=>true
            )
		);
		// var_dump($validate);
		$this->validate($_POST, $validate);
		if ($this->getValidationStatus()){
			//if the validation has passed, run a query to insert the details
			//into the database
            if($unit_id == ''){
                $unit_id = 0;
            }else{
                $unit_id = $_POST['unit_id'];
            }
			if($this-> addvoucherDetails($category_id, $maintenance_name, $complaint, $user, $status,$property_id,$unit_id,$maintenance_description)){
				$this->flashMessage('support', 'success', 'Maintenance ticket has been added.');
			}else{
				$this->flashMessage('support', 'error', 'Failed to create maintenance ticket! ' . get_last_error());
			}
		}

	}

	public function addvoucherDetails($category_id, $maintenance_name, $complaint, $user, $status,$property_id,$unit_id,$maintenance_description){
		$result = $this->insertQuery('maintenance_vouchers',
			array(
				'category_id' => $category_id,
//				'complaint_id' => $complaint,
				'maintenance_name' => $maintenance_name,
                'property_id'=>$property_id,
                'unit_id'=>$unit_id,
                'maintenance_description'=>$maintenance_description,
				'create_user' => $user,
				'approve_status' => $status
			)
		);

		return $result;
	}

	public function getCompliansName($complain){
		if(!empty($complain)){
			$query = "SELECT body FROM maintenance_ticket WHERE maintenance_ticket_id = '".$complain."'";
			$result = run_query($query);
			$rows = get_row_data($result);
			return $rows['body'];
		}else{
			return false;
		}
	}

	public function getMaintenanceDetails($id){
		$data = $this->selectQuery('maintenance_vouchers','*'," voucher_id = '".$id."' ");
		echo json_encode($data[0]);
	}

	public function editVoucher(){
		extract($_POST);
		$complaint =(!empty($complaint_id) ? $complaint_id : 'NULL');
		//var_dump($complaint);exit;
		$user = $_SESSION['mf_id'];
		$status = '0';
		$validate = array(
			'category_id'=>array(
				'name'=> 'Category Name ',
				'required'=>true,
				'unique2' => array(
					'table' => 'maintenance_vouchers',
					'skip_column' => 'voucher_id',
					'skip_value' => $voucher_id
				)
			),
			'maintenance_name'=>array(
				'name'=> 'Maintenance Description',
				'required'=>true,
				'unique2' => array(
					'table' => 'maintenance_vouchers',
					'skip_column' => 'voucher_id',
					'skip_value' => $voucher_id
				)
			)
		);

		$this->validate($_POST, $validate);
		if ($this->getValidationStatus()){
			//if the validation has passed, run a query to insert the details
			//into the database
			$result = $this->updateQuery2(
				'maintenance_vouchers',
				array(
					'category_id' => $category_id,
					'complaint_id' => $complaint,
				    'maintenance_name' => $maintenance_name,
				    'create_user' => $user,
				    'approve_status' => $status
				),
				array(
					'voucher_id' => $voucher_id
				)
			);
			if($result){
				$this->flashMessage('support', 'success', ' Maintenance Voucher  has been Updated.');
			}else{
				$this->flashMessage('support', 'error', 'Failed to update maintenance voucher! ' . get_last_error());
			}
		}
	}

	public function deleteVoucher(){
		extract($_POST);
		$result = $this->deleteQuery('maintenance_vouchers', "voucher_id = '".$voucher_id."'");
		if($result)
			$this->flashMessage('support', 'success', 'Voucher Category has been deleted!');
		else
			$this->flashMessage('support', 'error', 'Encountered an error! '.get_last_error());
	}
	public function getMessageTypeId($code){
		$query = "SELECT message_type_id FROM message_type WHERE message_type_code = '".$code."'";
		$result = run_query($query);
		if($result){
			$rows = get_row_data($result);
			return $rows['message_type_id'];
		}
	}

	public function approveVoucher($voucher_id){
		$this->beginTranc();
		$result = $this->updateQuery2('maintenance_vouchers', array(
			'approve_status' => '1',
			'approve_user'=>$_SESSION['mf_id']

		), array('voucher_id' => $voucher_id));
		if($result){
			$data = $this->prepRecipMfids(Contractor);
			$mfids = $data['list'];
			$mfid_arr = $data['array'];

			if(!empty($mfids)){
				$subject = 'Voucher#: '.$voucher_id;
				$body = "Dear Contractor, \n";
				$body .= "A maintenance voucher has been created. \n";
				$body .= "Please log into the system to attach a quote. \n";
				$body .= "Thanks";
				$mess = array(
					'subject' => $subject,
					'body' => $body,
				);

				if($this->createMessage(Push,$mfids,$mess, $mfid_arr)){
					if($this->createMessage(Email,$mfids,$mess, $mfid_arr)){
						if($this->createMessage(SMS,$mfids,$mess, $mfid_arr)){
							$this->endTranc();
							$this->flashMessage('support', 'success', 'Voucher has been approved');
						}
					}
				}
			}
		}else{
			$this->flashMessage('support', 'error', 'Encountered an error!'.get_last_error());
		}
	}

	public function prepRecipMfids($brole){
		$data = $this->selectQuery('masterfile', 'mf_id', "b_role = '".sanitizeVariable($brole)."'");
		$mfids = '';
		$mfid_arr = array();
		if(count($data)){
			$mfids = '{';
			foreach ($data as $row){
				$mfids .= $row['mf_id'].',';
				$mfid_arr[] = $row['mf_id'];
			}
			$mfids = rtrim($mfids, ',');
			$mfids .= '}';
		}
		return array(
			'list' => $mfids,
			'array' => $mfid_arr
		);
	}

	public function createMessage($mess_type_code, $mfids, $message_data = array(), $mfid_arr = array()){
		$data = $this->insertQuery('message',
			array(
				'body' => $message_data['body'],
				'subject' => $message_data['subject'],
				'sender' => $_SESSION['mf_id'],
				'recipients' => $mfids,
				'message_type_id' => "{".$this->getMessageTypeId($mess_type_code)."}",
				'status' => '0'
			),
			'message_id'
		);
		if($data['message_id']){
			if(count($mfid_arr)) {
				foreach ($mfid_arr as $mf_id) {
					if ($this->createCustomerMessage($mf_id, $data['message_id'])) {
						return true;
					} else {
						$this->flashMessage('support', 'error', 'Encounted an error!' . get_last_error());
					}
				}
			}
		}else{
			$this->flashMessage('support', 'error', 'Encounted an error!'.get_last_error());
			return false;
		}
	}

	public function createCustomerMessage($mf_id, $message_id){
//		var_dump($_POST);exit;
		$result = $this->insertQuery('customer_messages',
			array(
				'mf_id' => $mf_id,
				'message_id' => $message_id
			)
		);
		if($result){
			return true;
		}else{
			return false;
		}
	}

//	public  function declineVoucher(){
//		extract($_POST);
//		$status = '0';
//		$result = $this->updateQuery2(
//			'maintenance_vouchers',
//			array(
//				'approve_status' => $status
//			),
//			array(
//				'voucher_id' => $voucher_id
//			)
//		);
//		if($result){
//			$this->flashMessage('support', 'success', ' Maintenance Voucher  has been Declined.');
//		}else{
//			$this->flashMessage('support', 'error', 'Failed to update maintenance voucher! ' . get_last_error());
//		}
//	}

	public function addSupport(){
		extract($_POST);
		$status = '0';
		$user = $_SESSION['mf_id'];

		$result = $this->insertQuery('maintenance_ticket',
			array(
				'mf_id' => $user,
				'subject' => $category_id,
				'reported_by' => $user,
				'status' => $status,
				'body' => $body
			)
		);

		if($result){
			$this->flashMessage('support', 'success', 'The Maintenance Ticket was Recorded Successfully.');
		}else{
			$this->flashMessage('support', 'error', 'Failed to create Maintenance Ticket! ' . get_last_error());
		}
	}
}
?>

