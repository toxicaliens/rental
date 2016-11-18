<?php
	require_once 'src/models/Masterfile.php';
	/**
	* 
	*/
	class Broadcast extends Masterfile
	{
	    private $_group_mfs = array();
		public function getMessageTypes(){
			$query = "SELECT * FROM message_type";
			return $result = run_query($query);
		}

		public function getAllBroadcasts(){
			$query = "SELECT m.* FROM message m";
			// var_dump($query);exit;
			return run_query($query);
		}

		public function getAllCustomerAccounts(){
			$query = "SELECT CONCAT(m.surname,' ',m.firstname) AS customer_name, ca.issued_phone_number, ca.customer_account_id FROM customer_account ca
			LEFT JOIN masterfile m ON m.mf_id = ca.mf_id
			WHERE b_role = 'client' AND status IS TRUE";
			return run_query($query);
		}

		public function getCustomerNames($recipients, $msg_type_id){
			$str1 = str_replace('{', '', $recipients);
			$str2 = str_replace('}', '', $str1);
			$customer_name = '';
			$mf_ids = explode(',', $str2);

			foreach ($mf_ids as $mf_id) {
				if(!empty($mf_id)){
					$msg_str1 = str_replace('{', '', $msg_type_id);
					$msg_str2 = str_replace('}', '', $msg_str1);

					$msg_type_code = $this->getMsgTypeCode($msg_str2);
//					var_dump($msg_type_code);exit;

					if($msg_type_code != Email) {
						$query = "SELECT 
						CONCAT(m.surname,' ',m.firstname) AS customer_name, 
						ca.issued_phone_number 
						FROM customer_account ca
						LEFT JOIN masterfile m ON m.mf_id = ca.mf_id
						WHERE ca.customer_account_id = '" . sanitizeVariable($mf_id) . "'";
					}else{
						$query = "SELECT CONCAT(surname,' ',firstname,' ',middlename) AS customer_name, email 
						FROM masterfile WHERE mf_id = '".$mf_id."'";
					}
					// var_dump($query);exit;
					$result = run_query($query);
					$rows = get_row_data($result);
					$customer_name .= ($msg_type_code != Email) ? $rows['customer_name'].' - '.$rows['issued_phone_number'].', '."\n" : $rows['customer_name'].' ('.$rows['email'].'), '."\n";
				}
			}
			return rtrim($customer_name, ', '."\n");
		}

		public function getMessageTypeName($mes_types){
			$str1 = str_replace('{', '', $mes_types);
			$str2 = str_replace('}', '', $str1);
			$type_name = '';
			
			$type_ids = explode(',', $str2);
			foreach ($type_ids as $type_id) {
				if(!empty($type_id)){
					$query = "SELECT message_type_name FROM message_type WHERE message_type_id = '".sanitizeVariable($type_id)."'";
					
					$result = run_query($query);
					$rows = get_row_data($result);
					$type_name .= $rows['message_type_name'].', ';
				}
			}
			return rtrim($type_name,', ');
		}

		public function addBroadcast(){
            extract($_POST);
            // validation
            $rules = array(
                'broad_cast_type'=>array(
                    'name' => 'Broadcast Type',
                    'required'=>true
                ),
                'send_to' => array(
                    'name' => 'Send To',
                    'required' => true
                ),
                'subject'=>array(
                    'name'=>'Message Subject',
                    'required'=>true
                ),
                'message_type'=>array(
                    'name'=>'Message Type',
                    'required'=>true
                )
            );
//            var_dump($broad_cast_type);die;
            $broad_cast_type = '{'.$broad_cast_type.'}';
            $this->validate($_POST, $rules);
            if($this->getValidationStatus()){
                if($message_type == 'predefined'){
                    $message = $_POST['pre_message'];

                }else{
                    $message = $_POST['body'];
                }
                switch ($send_to){
                    case 'All':

                    break;

                    case 'Specific':
                        $this->_group_mfs =$recipients ;
                        $g_mfs = '{';
//                        $g_mfs = array();
                        foreach($recipients as $recipient){
                            $g_mfs .= $recipient.',';
                        }
                        $g_mfs = rtrim($g_mfs, ',');
                        $g_mfs .= '}';
                        $this->InsertBroadcasts($message, $subject, $broad_cast_type,$g_mfs);
                    break;

                    case 'Client Groups':
                        $clients = $_POST['client_groups'];
                        //var_dump($clients);die;
                         if (count($clients)){
                             foreach($clients as $client){
                                 switch ($client){
                                     case'all_tenants':
                                         $group_mfs = '{';
                                         $all_tenants_mf = $this->getTenantGroup();
//                            var_dump($all_tenants_mf);die;
                                         $this->_group_mfs = $all_tenants_mf;
                                         if(count($all_tenants_mf)){
                                             foreach ($all_tenants_mf as $tenant_mf){
                                                 $group_mfs .= $tenant_mf['tenant'].',';
                                             }
                                             $group_mfs = rtrim($group_mfs, ',');
                                             $group_mfs .= '}';
//                                var_dump($group_mfs);exit;
                                             $this->InsertBroadcasts($message,$subject,$broad_cast_type, $group_mfs);
//
                                         }else{
                                             $this->setWarning('No Tenants found');
                                         }
                                         break;
                                     case'all_contractors':
                                         $group_mfs = '{';
                                         $all_contractors_mfs =$this->selectQuery('contractor','mf_id', "created_by = '".$_SESSION['mf_id']."'");
                                         $this->_group_mfs = $all_contractors_mfs;
                                         if(count($all_contractors_mfs)){
                                             foreach ($all_contractors_mfs as $con_mf){
                                                 $group_mfs .= $con_mf[0].',';
                                             }
                                             $group_mfs = rtrim($group_mfs, ',');
                                             $group_mfs .= '}';
//                                var_dump($group_mfs);exit;
                                             $this->InsertBroadcasts($message,$subject,$broad_cast_type, $group_mfs);
                                         }else{
                                             $this->setWarning('No contractor found');
                                         }
                                         break;
                                     case'all_landlords':
                                         $group_mfs = '{';
                                         $all_landlords_mfs =$this->selectQuery('plots','landlord_mf_id', "pm_mfid = '".$_SESSION['mf_id']."'");
                                         $this->_group_mfs = $all_landlords_mfs;
                                         if(count($all_landlords_mfs)){
                                             foreach ($all_landlords_mfs as $landlord_mf_mf){
                                                 $group_mfs .= $landlord_mf_mf[0].',';
                                             }
                                             $group_mfs = rtrim($group_mfs, ',');
                                             $group_mfs .= '}';
//                                var_dump($group_mfs);exit;
                                             $this->InsertBroadcasts($message,$subject,$broad_cast_type, $group_mfs);
                                         }else{
                                             $this->setWarning('No contractor found');
                                         }
                                         break;
                                 }
                             }
                        }
                        break;
                }
            }
		}
		//function to insert broadcasts into broad casts table
        public function InsertBroadcasts($message,$subject,$broad_cast_type, $group_mfs){
            $this->beginTranc();
           $results = $this->insertQuery('message',array(
                'body'=> $message,
                'subject'=> $subject,
                'sender'=>$_SESSION['mf_id'],
                'recipients'=> $group_mfs,
                'message_type_id'=> $broad_cast_type
            ),
                'message_id');
            $message_id = $results[0];

            if($results) {
                if($_POST['send_to']== 'Specific'){
                    foreach ($this->_group_mfs as $mfs) {
                        $this->insertCustomerMessages($mfs, $message_id);

                    }
                }else {
                    foreach ($this->_group_mfs as $mfs) {
                        $this->insertCustomerMessages($mfs[0], $message_id);
                    }
                }
            }else{
                //set a warining if the broadcast message is not inserted
                $this->setWarning('Failed to create broadcast message'.get_last_error());
            }
           if (!count($this->getWarnings())){
               $this->flashMessage('broadcast','success','Broadcast Sent');
           }
            $this->endTranc();
        }
        //function to insert customer messages to customer message
        public function insertCustomerMessages($mf_id, $message_id){
            $result = $this->insertQuery('customer_messages',array(
                'mf_id'=>$mf_id,
                'message_id'=> $message_id
            ));
            (!$result)? $this->setWarning('Failed to add customer message'.get_last_error()): '';
        }

		public function getMfIdFromAccId($accId){
			if(!empty($accId)){
				$query = "SELECT mf_id FROM customer_account WHERE customer_account_id = '".sanitizeVariable($accId)."'";
				if($result = run_query($query)){
					$rows = get_row_data($result);
					return $rows['mf_id'];
				}
			}
		}

		public function getMsgTypeCode($msg_id){
			if(!empty($msg_id)){
				$query = "SELECT message_type_code FROM message_type WHERE message_type_id = '".sanitizeVariable($msg_id)."'";
				if($result = run_query($query)){
					$rows = get_row_data($result);
					return $rows['message_type_code'];
				}
			}
		}

		public function addToCustomerMessages($acc_ids, $mes_id){
			// var_dump($acc_ids);exit;
			foreach ($acc_ids as $acc_id) {
				$query = "INSERT INTO customer_messages(
	            customer_account_id, message_id)
	    		VALUES ('".$acc_id."', '".$mes_id."')";
	    		if(run_query($query)){
	    			// return true;
	    		}else{
	    			var_dump(get_last_error());exit;
	    		}
	    	}
	    	return true;
		}

		public function addToCustomerMessage($acc_id, $mes_id){
			$query = "INSERT INTO customer_messages(
            customer_account_id, message_id)
    		VALUES ('".$acc_id."', '".$mes_id."')";
    		if(run_query($query)){
    			$_SESSION['broadcast'] = '<div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    <strong>Success!</strong>A new broadcast has been added.
                </div>';
				return true;
    		}else{
    			var_dump(get_last_error());exit;
    		}
		}

		public function getAllPredefinedMessages(){
			$query = "SELECT * FROM predefined_message";
			return run_query($query);
		}

		public function addPredefinedMessage(){
		    extract($_POST);
            //var_dump($_POST);die;
			if(!empty($_POST['message'])&&($_POST['notification_type'])){
				$query = "INSERT INTO predefined_message(predefined_message, notification_type) VALUES('".sanitizeVariable($_POST['message'])."','".sanitizeVariable($_POST['notification_type'])."')";
				if(run_query($query)){
					$_SESSION['predefined'] = '<div class="alert alert-success">
	                    <button class="close" data-dismiss="alert">×</button>
	                    <strong>Success!</strong> Message Added.
	                </div>';
				}else{
					return false;
				}
			}
		}

		public function editPreMessage(){
			if(!empty($_POST['message'])&&($_POST['notification_type'])){
				$query = "UPDATE predefined_message SET predefined_message = '".sanitizeVariable($_POST['message'])."',notification_type = '".sanitizeVariable($_POST['notification_type'])."'
				WHERE predefined_mess_id = '".sanitizeVariable($_POST['edit_id'])."'";
				if(run_query($query)){
					$_SESSION['predefined'] = '<div class="alert alert-success">
	                    <button class="close" data-dismiss="alert">×</button>
	                    <strong>Success!</strong> Message Updated.
	                </div>';
				}
			}
		}

		public function deletePreMessage(){
			$query = "DELETE FROM predefined_message WHERE predefined_mess_id = '".$_POST['delete_id']."'";
			if(run_query($query)){
				$_SESSION['predefined'] = '<div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    <strong>Success!</strong> Message Deleted.
                </div>';
			}
		}

		public function getAllClientGroups(){
			$query = "SELECT * FROM masterfile WHERE b_role = 'client group'";
			return run_query($query);
		}

		public function sendMessageToAllClientsInGroup($client_group){
			extract($_POST);
			$message = ($message_type == 'custom') ? $body: $pre_message;

			$mf_ids = $this->getMfidsInClientGroup($client_group);
			if(count($mf_ids)) {
				$mfid_list = 'array[';
				$mf_lst = '';
				foreach ($mf_ids as $mf_id) {
					$mfid_list .= $mf_id.',';
					$mf_lst .= $mf_id.',';
				}

				$mf_lst = rtrim($mf_lst, ',');
				$cust_acc_ids = $this->getAllCustomerAccountsUnderClientInClientGroup($mf_lst);
				if (count($cust_acc_ids)) {
					$recip_array = 'array[';
					foreach ($cust_acc_ids as $cust_acc_id) {
						$recip_array .= $cust_acc_id . ',';
					}
					$recip_array = rtrim($recip_array, ',');
					$recip_array .= ']';
				}

				$mfid_list = rtrim($mfid_list, ',');
				$mfid_list .= ']';
				$msg_type_code = $this->getMsgTypeCode($broad_cast_type);
				//var_dump($msg_type_code);exit;
				if($msg_type_code == Email){
					$recip_array = $mfid_list;
				}
				// var_dump($recip_array);exit;
			}

			$query = "INSERT INTO message(
			body, 
			subject, 
			sender, 
			recipients, 
			created, 
			message_type_id)
			VALUES(
			'".sanitizeVariable($message)."', 
			'".sanitizeVariable($subject)."',
			'".$_SESSION['mf_id']."', 
			".sanitizeVariable($recip_array).",
			'".date('Y-m-d H:i:s')."', 
			array[$broad_cast_type]) RETURNING message_id";
			if($result = run_query($query)){
				$rows = get_row_data($result);
				foreach ($cust_acc_ids as $accountid) {
					$this->addToCustomerMessage($accountid, $rows['message_id']);
				}
			}else{
				var_dump('Create message: '.$query.' '.get_last_error());exit;
			}
		}

		public function getAllCustomerAccountsUnderClientInClientGroup($client_mf_id){
			$query = "SELECT customer_account_id FROM customer_account WHERE mf_id in(".$client_mf_id.")";
			if($result = run_query($query)){
				if(get_num_rows($result)){
					while($rows = get_row_data($result)){
						$return[] = $rows['customer_account_id'];
					}
					return $return;
				}
			}else{
				return false;
			}
		}

		public function getMfidsInClientGroup($client_group){
			$query = "SELECT mf_id FROM masterfile WHERE company_name = '".sanitizeVariable($client_group)."'";
			if($result = run_query($query)) {
				while ($rows = get_row_data($result)) {
					$return[] = $rows['mf_id'];
				}
				return $return;
			}
		}

		/*
		below is the method to produce a list of all tenants depending on the role
		If role is a property manager the list will contain tenants on the properties
		he/she manages
		*/
		public function getTenantGroup(){
		    //first the system checks the logged in role
            $role = $_SESSION['role_name'];
            //if the role is the system admin(super admin) it does the following
            if($role == SystemAdmin){
                $results = $this->selectQuery('tenant_groups','tenant');
            }elseif ($role == PM){
                $results = $this->selectQuery('tenant_groups','tenant',"pm_mfid = '". $_SESSION['mf_id']."' ");
            }elseif ($role == LandLord){
                $results = $this->selectQuery('tenant_groups','tenant',"landlord_mf_id = '". $_SESSION['mf_id']."' ");
            }
            return $results;
//            var_dump($results);die;
        }
        /*below is the function to get a list of all landlords belonging to a specific propety
         depending on his/her logged in mf_id
        */
        public function getLandlordGroup(){
            //check the role as always
            $role = $_SESSION['role_name'];
        }
	}
?>