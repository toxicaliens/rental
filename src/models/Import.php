<?php
include_once('src/models/Device_management.php');
/**
* 
*/
class Import extends DeviceManagement{
	private $_errors = array(),
			$_client_group_errors = array(),
			$_success = array();
	
	public function importData(){
		$file = $this->uploadCsv('masterfile_csv');

		if(file_exists($file)){
			$file = fopen($file, "r");
			
			$count = 1;
			$counter = '';
			while(! feof($file)){
				$data = fgetcsv($file);
				if($this->addMasterfile($count, $data)){
					$counter .= $count.', ';
				}

				$count++;
			}
			$counter = rtrim($counter, ', ');
			$this->createMasterfileUploadHistory($count, $counter);
			fclose($file);
		}
	}

	public function importClientGroups(){
		$file = $this->uploadCsv('client_groups_csv');

		if(file_exists($file)){
			$file = fopen($file, "r");
			
			$count = 1;
			$counter = '';
			while(! feof($file)){
				$data = fgetcsv($file);
				if($this->addClientGroups($count, $data)){
					$counter .= $count.', ';
				}

				$count++;
			}
			$counter = rtrim($counter, ', ');
			$this->createCompanyUploadHistory($count, $counter);

			fclose($file);
		}
	}

	public function addClientGroups($row, $data){
		if(count($data)){
			$company_name = $data[1];

			if(!empty($company_name)){
				if($this->createClientGroup($row, $company_name)){
					$this->_success[] = 'Successfully Imported for row $row';
                    return true;
				}
			}else{
				$this->_client_group_errors[] = 'Row '.$row.': doesn\'t have any data';
			}
		}else{
			$this->_client_group_errors[] = 'Row '.$row.': doesn\'t have any data';
		}
	}

	public function uploadCsv($name){
		$target_path='';

		$allowedExts = array("csv");
        $temp = explode(".", $_FILES[$name]["name"]);
        $extension = end($temp);
        $timestamp = 'MF_'.date('Y_m_d_H_i_s_');

        // var_dump($extension);exit;
		if (in_array($extension, $allowedExts)) {
            if ($_FILES[$name]["error"] > 0) {
               $this->_import_errors[] = "Return Code: " . $_FILES[$name]["error"];
            } else {
             	$target_path = "assets/csv/".$timestamp."".$_FILES[$name]["name"];
             	if(move_uploaded_file($_FILES[$name]["tmp_name"], $target_path)){
             		return $target_path;					
				}else{
					$this->_errors[] = 'Encoutered an error while uploading';
				}
			}
		}
	}

	public function getErrors(){
		return $this->_errors;
	}

	public function getSuccessMessages(){
		return $this->_success;
	}

	public function getClientGroupErrors(){
		return $this->_client_group_errors;
	}

	public function addMasterfile($row, $data){
		if(count($data)){
			// masterfile details
			$brole = $data[0];
			$start_date = $data[1];

			$full_name = $data[2];
			$names = explode(' ', $full_name);
			$surname = $names[0];
			$fname = (isset($names[1])) ? $names[1] : '';
			$mname = (!empty($names[2])) ? $names[2] : '';

			$gender = $data[3];
			$email = $data[4];
			$client_group = $data[5];
			$id_pass = $data[6];
			$mf_type = $data[7];
			$dob = $data[8];
			$role = $data[9];

			// address details
			$county = $data[11];
			$town = $data[12];
			$phone = $data[13];
			$postal_code = $data[14];
			$address_type = $data[15];
			$postal_address = $data[16];
			$ward = $data[17];
			$street = $data[18];
			$building = $data[19];
			$house_no = $data[20];

			$phone_type1 = $data[22];
			$model1 = $this->getModelId($phone_type1);
			$imei1 = $data[23];
			$acc_code1 = $data[24];
			$issued_phone_number1 = $data[25];
			$repayment_date1 = $data[26];

			$phone_type2 = $data[28];
			$model2 = $this->getModelId($phone_type2);
			$imei2 = $data[29];
			$acc_code2 = $data[30];
			$issued_phone_number2 = $data[31];
			$repayment_date2 = $data[32];

			$phone_type3 = $data[34];
			$model3 = $this->getModelId($phone_type3);
			$imei3 = $data[35];
			$acc_code3 = $data[36];
			$issued_phone_number3 = $data[37];
			$repayment_date3 = $data[38];

			$address_type_id = $this->getAddressTypeId($address_type);

			if(!empty($brole)){
				$business_role = trim(strtolower($brole));
				$county = $this->getCountyId($county);

				switch ($business_role) {
					case 'client':
						$customer_type_id = $this->getCustomerTypeId($mf_type);
						$client_group = $this->getClientGroup($row, $client_group);
						$mf_type = $this->getCustomerTypeId($mf_type);
						
						if(!checkForExistingEntry('masterfile', 'id_passport', $id_pass)){
							if(!checkForExistingEntry('masterfile', 'email', $email)){
								// validation
								if(
									empty($start_date) ||
									empty($full_name) ||
									empty($gender) ||
									empty($email) ||
									empty($client_group) ||
									empty($id_pass) ||
									empty($mf_type) 
								){
									$err_msg = '';
									$err_msg .= "The following data is missing for the row $row; ";
									$err_msg .= (empty($start_date)) ? "Start Date, " : '';
									$err_msg .= (empty($full_name)) ? "Full Name, " : '';
									$err_msg .= (empty($gender)) ? "Gender, " : '';
									$err_msg .= (empty($email)) ? "Email, " : '';
									$err_msg .= (empty($client_group)) ? "Company, " : '';
									$err_msg .= (empty($id_pass)) ? "Id No/Passport, " : '';
									$err_msg .= (empty($mf_type)) ? "Masterfile Type, " : '';

									$this->_errors[] = rtrim($err_msg, ', ');
								}else{
									if($result = $this->insertMasterfile($row, 
										$surname, 
										$fname, 
										$mname, 
										$id_pass, 
										$business_role, 
										$dob, 
										$customer_type_id, 
										$email, 
										$client_group,
										$start_date,
										$gender)
									){

										$rows = get_row_data($result);
										$mf_id = $rows['mf_id'];

										if($address_result = $this->addToAddress(
											$phone, 
											$email, 
											$postal_address, 
											$town, 
											$mf_id, 
											$address_type_id, 
											$ward, 
											$street, 
											$building, 
											$house_no, 
											$county, 
											$postal_code)
										){
											if($this->createCustomerAccountFromCsv(
												$row,
												$mf_id, 
												$issued_phone_number1, 
												$acc_code1, 
												$repayment_date1,
												$imei1,
												$model1)
											){
												$this->_success[] = "Imported data for row $row";
						                    }

						                    if($this->createCustomerAccountFromCsv(
												$row,
												$mf_id, 
												$issued_phone_number2, 
												$acc_code2, 
												$repayment_date2,
												$imei2,
												$model2)
											){
												$this->_success[] = "Imported data for row $row";
						                    }else{
						                    	$_errors = "Row $row: Encountered an error while creating customer account!";
						                    }

						                    if($this->createCustomerAccountFromCsv(
												$row,
												$mf_id, 
												$issued_phone_number3, 
												$acc_code3, 
												$repayment_date3,
												$imei3,
												$model3)
											){
												$this->_success[] = "Imported data for row $row";
						                    }else{
						                    	$_errors = "Row $row: Encountered an error while creating customer account!";
						                    }
										}
									}									
								}	
							}else{
								$this->_errors[] = "Skipped row $row: Email($email) already exists";
							}
						}else{
							$this->_errors[] = "Skipped row $row: ID Number($id_pass) already exists";
						}
						break;

					case 'staff':
						$role_id = $this->getRoleId($role);
						$customer_type_id = $this->getCustomerTypeId($mf_type);	
						// validation
						if(
							empty($start_date) ||
							empty($surname) ||
							empty($fname) ||
							empty($gender) ||
							empty($email) ||
							empty($id_pass) ||
							empty($dob) ||
							empty($role_id)
						){
							$err_msg = '';
							$err_msg .= "The following data is missing for the row $row; ";
							$err_msg .= (empty($start_date)) ? "Start Date, " : '';
							$err_msg .= (empty($surname)) ? "Surname Name, " : '';
							$err_msg .= (empty($fname)) ? "Full name, " : '';
							$err_msg .= (empty($gender)) ? "Gender, " : '';
							$err_msg .= (empty($email)) ? "Email, " : '';
							$err_msg .= (empty($id_pass)) ? "Id No/Passport, " : '';
							$err_msg .= (empty($dob)) ? "Date Of Birth, " : '';
							$err_msg .= (empty($rele_id)) ? "Role id, " : '';
							

							$this->_errors[] = rtrim($err_msg, ', ');
						}else{
							if($result = $this->insertMasterfile($row, 
								$surname, 
								$fname, 
								$mname, 
								$id_pass, 
								$business_role, 
								$dob, 
								$customer_type_id, 
								$email, 
								$client_group,
								$start_date,
								$gender)
							){
								$rows = get_row_data($result);
								$mf_id = $rows['mf_id'];

								if($address_result = $this->addToAddress(
									$phone, 
									$email, 
									$postal_address, 
									$town, 
									$mf_id, 
									$address_type_id, 
									$ward, 
									$street, 
									$building, 
									$house_no, 
									$county, 
									$postal_code)
								){
									if($this->createLoginAccount($email, $role_id, $mf_id)){
										$_SESSION['upload_csv']='<div class="alert alert-success">
				                            <button class="close" data-dismiss="alert">&times;</button>
				                            <strong>Success!</strong> Imported the data.
				                        </div>';
				                    }
								}
							}else{
								$this->_errors[] = "Encountered an error while adding masterfile for row $row";
							}
						}
						break;					
				}
			}
		}else{
			$this->_errors[] = 'Row '.$row.': doesn\'t have any data';
		}
	}

	public function insertMasterfile($row, $surname, $fname, $mname, $id_pass, $brole, $dob, $customer_type_id, $email, $client_group, $start_date, $gender){
		if(!checkForExistingEntry('masterfile', 'id_passport', $id_pass)){
			$check = checkForExistingEntry('masterfile', 'email', $email);
			if(!$check){	
				$customer_type_id = (!empty($customer_type_id)) ? $customer_type_id : 'NULL';
				$client_group = (!empty($client_group)) ? $client_group : 'NULL';
				$dob_column = (!empty($dob)) ? "dob, " : '';
				$dob_value = (!empty($dob)) ? "'".$dob."', " : '';
				$start_date_column = (!empty($start_date)) ? "regdate_stamp, " : '';
				$start_date_value = (!empty($start_date)) ? "'".$start_date."', " : '';

				$query = "INSERT INTO masterfile(
	            surname, 
	            active, 
	            firstname, 
	            middlename, 
	            id_passport, 
	            gender, 
	            images_path, 
	            ".$start_date_column." 
	            b_role, 
	            ".$dob_column." 
	            time_stamp, 
	            customer_type_id, 
	            email, 
	            company_name)
			    VALUES (
			    	'".sanitizeVariable($surname)."', 
			    	'1', 
			    	'".sanitizeVariable($fname)."', 
			    	'".sanitizeVariable($mname)."', 
			    	'".sanitizeVariable($id_pass)."', 
			    	'".sanitizeVariable($gender)."', 
			        '', 
			        $start_date_value 
			        '".sanitizeVariable($brole)."', 
			        $dob_value
			        '".time()."', 
			        ".sanitizeVariable($customer_type_id).", 
			        '".sanitizeVariable($email)."', 
			    	".sanitizeVariable($client_group).")
				RETURNING mf_id";

				if($result = run_query($query)){
					return $result;
				}else{
					return false;
				}
			}else{
				$this->_errors[] = 'Row '.$row.' Email: '.$email.' aleady exists!';
			}
		}else{
			$this->_errors[] = 'Row '.$row.' ID Number: '.$id_pass.' aleady exists!';
		}
	}

	public function addToAddress($phone, $email, $postal_address, $town, $mf_id, $address_type_id, $ward, $street, $building, $house_no, $county, $postal_code){
		if(
			!empty($phone) &&
			!empty($postal_address) &&
			!empty($mf_id) &&
			!empty($address_type_id) &&
			!empty($town) &&
			!empty($county)
		){
			$query = "INSERT INTO address(
	            phone, 
	            email, 
	            postal_address, 
	            town, 
	            mf_id, 
	            address_type_id, 
	            ward, 
	            street, 
	            building, 
	            house_no, 
	            county, 
	            postal_code)
	    		VALUES (
	    			'".sanitizeVariable($phone)."', 
	    			'".sanitizeVariable($email)."', 
	    			'".sanitizeVariable($postal_address)."', 
	    			'".sanitizeVariable($town)."', 
	    			'".sanitizeVariable($mf_id)."', 
	    			".sanitizeVariable($address_type_id).", 
	            	'".sanitizeVariable($ward)."', 
	            	'".sanitizeVariable($street)."', 
	            	'".sanitizeVariable($building)."', 
	            	'".sanitizeVariable($house_no)."', 
	            	".sanitizeVariable($county).", 
	            	'".sanitizeVariable($postal_code)."')";
			
			if($result = run_query($query)){
				return $result;
			}else{
				return false;
			}
		}else{
			return true;
		}
	}

	public function getAddressTypeId($address_type_name){
		$query = "SELECT address_type_id FROM address_types WHERE lower(address_type_name) LIKE '%".trim(strtolower($address_type_name))."%'";
		if($result = run_query($query)){
			if(get_num_rows($result)){
				$rows = get_row_data($result);
				return $rows['address_type_id'];
			}
		}
	}

	public function getCustomerTypeId($type){
		$query = "SELECT customer_type_id FROM customer_types WHERE lower(customer_type_name) LIKE '%".trim(strtolower($type))."%'";
		if($result = run_query($query)){
			if(get_num_rows($result)){
				$rows = get_row_data($result);
				return $rows['customer_type_id'];
			}
		}
	}

	public function getClientGroup($row, $type){
		$query = "SELECT mf_id FROM masterfile WHERE lower(surname) LIKE '%".trim(strtolower($type))."%'";
		if($result = run_query($query)){
			if(get_num_rows($result)){
				$rows = get_row_data($result);
				return $rows['mf_id'];
			}else{
				if($result = $this->createClientGroup($row, $type)){
					$data = get_row_data($result);
					return $data['mf_id'];
				}
			}
		}
	}

	public function getRoleId($type){
		$query = "SELECT role_id FROM user_roles WHERE lower(role_name) LIKE '%".trim(strtolower($type))."%'";
		if($result = run_query($query)){
			if(get_num_rows($result)){
				$rows = get_row_data($result);
				return $rows['role_id'];
			}
		}
	}

	public function getCountyId($county_name){
		$query = "SELECT county_ref_id FROM county_ref WHERE lower(county_name) LIKE '%".trim(strtolower($county_name))."%'";
		if($result = run_query($query)){
			if(get_num_rows($result)){
				$rows = get_row_data($result);
				return $rows['county_ref_id'];
			}
		}
	}

	public function getModelId($model_name){
		$query = "SELECT device_model_id FROM gtel_device_model WHERE model LIKE '%".$model_name."%'";
		if($result = run_query($query)){
			if(get_num_rows($result)){
				$rows = get_row_data($result);
				return $rows['device_model_id'];
			}
		}
	}

	public function createLoginAccount($email, $user_role, $mf_id){		
		$pass_hashy = sha1(123456);

	    if(checkForExistingEntry('user_login2', 'username', $email)){
        	$this->_errors[] = "The email($email) already exists!";
	    }else{
	        $add_login_account = "INSERT INTO user_login2(
	        username, password, email, user_active, user_role, client_mf_id, mf_id)
	        VALUES ('".$email."', '".$pass_hashy."', '".$email."', '1', ".$user_role.", NULL, '".$mf_id."') 
	        RETURNING user_id";

	        if($data = run_query($add_login_account)){
	            return $data;
	        }else{
	        	return false;
	        }
	    }
	}

	public function createCustomerAccountFromCsv($row, $mf_id, $issued_phone_number, $customer_code, $repayment_date, $imei, $model){
		if(
			!empty($mf_id) &&
			!empty($issued_phone_number) &&
			!empty($customer_code) &&
			!empty($repayment_date) &&
			!empty($imei) &&
			!empty($model) 
		){
			if(!checkForExistingEntry('customer_account', 'customer_code', $customer_code)){
				$start_date = date('Y-m-d');
				$curr_month = date('m');
				$next_month = $curr_month + 1;
				$customer_bill_due_date = date('Y-'.$next_month.'-d');
				// $next_payment_date = date('Y-0'.$next_month.'-0'.$repayment_date);
				if($result = $this->createDevice($row, $model, $imei)){
					$rows = get_row_data($result);
					$query = "INSERT INTO customer_account(
		            mf_id, 
		            device_id,  
		            issued_phone_number, 
		            customer_code,  
		            repayment_date, 
		            status)
				    VALUES (
				    	'".sanitizeVariable($mf_id)."', 
				    	".sanitizeVariable($rows['device_id']).", 
				        '".sanitizeVariable($issued_phone_number)."', 
				        '".sanitizeVariable($customer_code)."', 
				        '".sanitizeVariable($repayment_date)."', 
				        '1')";
				
				
					if(run_query($query)){
						$serv_bill_details = $this->getServiceBill($model);

						if(count($serv_bill_details)){
							if($result = $this->addToBillingFile($customer_code, $serv_bill_details['bill_interval'], 
								$serv_bill_details['amount'], $serv_bill_details['amount'],
					            $serv_bill_details['revenue_bill_id'], $start_date)){

								$billing_array = get_row_data($result);
								if($billing_array['billing_file_id']){
									$bill_date = date('Y-m-d');
									$bill_result = $this->createBill(
										$customer_bill_due_date, 
										$serv_bill_details['amount'], $bill_date, 0, 0, 
										$serv_bill_details['amount'], 
										$billing_array['billing_file_id'], 
										$customer_code, 
										$mf_id, 
										$serv_bill_details['service_channel_id']);

					            	if($bill_result){
					            		$journal_result = $this->recordJournalDebit($mf_id, 
					            		$serv_bill_details['amount'], $customer_code, 'Monthly Loan Repayment Bill');
					            		if($journal_result){
					            			return true;
					            		}
					            	}else{
					            		$this->_errors[] = "Error creating bill for row $row";
					            	}
								}
							}else{
								$this->_errors[] = "Row $row: error creating billing file!";
							}
						}else{
							$this->_errors[] = "Row $row: Doesn't have any configured service bill ($model)";
						}
					}else{
						return false;
					}
				}
			}else{
				$this->_errors[] = "Row $row: Customer Code($customer_code) already exists!";
			}
		}
	}

	public function createMasterfileUploadHistory($count, $error){
		$query = "INSERT INTO public.masterfile_upload_history(
        uploader_mf_id, upload_date, record_count, error_report)
		VALUES ('".$_SESSION['mf_id']."', '".date('Y-m-d')."', 
			'".sanitizeVariable($count)."', '".sanitizeVariable($error)."')";
		if(run_query($query)){
			return true;
		}else{
			return false;
		}
	}

	public function createCompanyUploadHistory($count, $error){
		$query = "INSERT INTO public.company_upload_history(
        uploader_mf_id, upload_date, record_count, error_report)
		VALUES ('".$_SESSION['mf_id']."', '".date('Y-m-d')."', 
			'".sanitizeVariable($count)."', '".sanitizeVariable($error)."')";
		if(run_query($query)){
			return true;
		}else{
			var_dump('Create Airtime Upload: '.$query.' '.get_last_error());exit;
		}
	}

	public function createClientGroup($row, $company_name){
		if(!checkForExistingEntry('masterfile', 'surname', $company_name)){
			$query = "INSERT INTO masterfile(surname, b_role, customer_type_id) 
			VALUES('".sanitizeVariable($company_name)."', 'client group', 1) 
			RETURNING mf_id";
			if($result = run_query($query)){
				return $result;
			}
		}else{
			$this->_client_group_errors[] = "Row $row: company name ($company_name) aleady exists!";
		}
	}

	public function createDevice($row, $model_id, $imei){
		if(!checkForExistingEntry('gtel_device', 'imei', $imei)){
			$query = "INSERT INTO gtel_device(device_model_id, imei) 
			VALUES('".sanitizeVariable($model_id)."', '".sanitizeVariable($imei)."')
			RETURNING device_id";
			if($result = run_query($query)){
				return $result;
			}else{
				return false;
			}
		}else{
			$this->_errors[] = "Row $row: IMEI: $imei already exists!";
		}
	}
}