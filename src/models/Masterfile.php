<?php
	include_once('src/models/House.php');
	
	class Masterfile extends House{
        private $_destination = 'crm_images/';

		public function addMf(){
			if(!empty($_POST['b_role'])) {
                $this->validate($_POST, array(
                    // personal details
                    'surname' => array(
                        'name' => 'Surname',
                        'required' => true
                    ),
                    'id_passport' => array(
                        'name' => 'National Id/Passport',
                        'required' => true,
                        'unique' => 'masterfile'
                    ),
                    'email' => array(
                        'name' => 'Email Address',
                        'required' => true,
                        'unique' => 'masterfile'
                    ),
                    'regdate_stamp' => array(
                        'name' => 'Start Date',
                        'required' => true
                    ),

                    // address details
                    'county' => array(
                        'name' => 'County',
                        'required' => true
                    ),
                    'town' => array(
                        'name' => 'Town',
                        'required' => true
                    ),
                    'phone_number' => array(
                        'name' => 'Phone Number',
                        'required' => true
                    ),
                    'postal_address' => array(
                        'name' => 'Postal Address',
                        'required' => true
                    ),
                    'postal_code' => array(
                        'name' => 'Postal Code',
                        'required' => true
                    ),
                    'address_type_id' => array(
                        'name' => 'Address Type',
                        'required' => true
                    ),
                    'customer_type_id' => array(
                        'name' => 'Masterfile Type',
                        'required' => true
                    ),
                ));
                if($this->getValidationStatus()) {
                    switch ($_POST['b_role']) {
                        case Tenant:
                            $this->addTenant($_POST);
                            break;

                        case Landlord:
                            $this->addLandlord($_POST);
                            break;

                        case Contractor:
                            $this->addContractor($_POST);
                            break;

                        case Property_Manager:
                            $this->addPM($_POST);
                            break;
                    }
                }
			}else{
				$this->flashMessage('mf','warning','You must select a business role!');
			}
		}

        public function addTenant($tenant_data = array()){
            extract($_POST);
            //var_dump($_POST);exit;
            // validate

            if($this->getValidationStatus()){
                 // validate image
               $uniq_id = uniqid();
                $destination = $this->_destination.$uniq_id.$_FILES['profile-pic']['name'];
                $image_path = '';
                if(!empty($_FILES['profile-pic']['name'])) {
                    $image_path = $this->uploadImage($_FILES['profile-pic']['tmp_name'], $destination);
                }else{
                    $image_path = '';
                }

                $this->beginTranc();

                $mf_id = $this->addPersonalDetails($surname, $firstname, $middlename, $id_passport, $gender, $image_path, $regdate_stamp, $b_role, $customer_type_id, $email);
                if(!empty($mf_id)){
                    if($this->addAddress($phone_number, $postal_address, $town, $mf_id, $address_type_id, $ward, $street, $building, $county, $postal_code)) {
                        if($this->createTenantFile($mf_id)){
                            if($this->createLoginAccount($tenant_data, $mf_id)) {
                                $this->endTranc();
                                $this->flashMessage('mf', 'success', 'Masterfile has been added.');
                                App::redirectTo('?num=722');
                            }else{
                                $this->flashMessage('mf', 'error', 'Failed to create login account! ' . get_last_error());
                            }
                        }else{
                            $this->flashMessage('mf', 'error', 'Failed to create address! ' . get_last_error());
                        }
                    }else{
                        $this->flashMessage('mf', 'error', 'Failed to create tenant file! ' . get_last_error());
                    }
                }else{
                    $this->flashMessage('mf', 'error', 'Failed to add Personal Details! '.get_last_error());
                }
            }
        }

        public function addContractor($contractor_data){
            extract($_POST);
            // validate
            //var_dump($contractor_data); exit;
            $this->validate($contractor_data, array(
                'user_role' => array(
                    'name' => 'System User Role',
                    'required' => true
                )
            ));

            if($this->getValidationStatus()){
                $uniq_id = uniqid();
                $destination = $this->_destination.$uniq_id.$_FILES['profile-pic']['name'];
                $image_path = '';
                if(!empty($_FILES['profile-pic']['name'])) {
                    $image_path = $this->uploadImage($_FILES['profile-pic']['tmp_name'], $destination);
                }else{
                    $image_path = '';
                }

                $this->beginTranc();

                $mf_id = $this->addPersonalDetails($surname, $firstname, $middlename, $id_passport, $gender, $image_path, $regdate_stamp, $b_role, $customer_type_id, $email);
                if(!empty($mf_id)){
                        if($this->addAddress($phone_number, $postal_address, $town, $mf_id, $address_type_id, $ward, $street, $building, $county, $postal_address)) {
                            $bank_acc_id = $this->createBankAccount($mf_id, $bank_name, $branch_name, $account_no, $pin_no);
                            if($bank_acc_id) {
                                if ($this->createContractorFile($mf_id, $skill_name)) {
                                    if ($this->createLoginAccount($contractor_data, $mf_id)) {
                                        $this->flashMessage('mf', 'success', 'Masterfile has been added.');
                                    } else {
                                        $this->flashMessage('mf', 'error', 'Failed to create login account! ' . get_last_error());
                                    }
                                } else {
                                    $this->flashMessage('mf', 'error', 'Failed to create contractor file! ' . get_last_error());
                                }
                            }else{
                                $this->flashMessage('mf', 'error', 'Failed to create bank a/c for Contractor! '.get_last_error());
                            }
                        }else {
                            $this->flashMessage('mf', 'error', 'Failed to create address! ' . get_last_error());
                        }
                }else{
                    $this->flashMessage('mf', 'error', 'Failed to add Personal Details! '.get_last_error());
                }
            }
            $this->endTranc();
            App::redirectTo('?num=722');
        }

        public function addLandlord($landlord_data = array()){
            extract($_POST);
            //var_dump($landlord_data);exit;
            // validate
            $this->validate($landlord_data, array(
                'user_role' => array(
                    'name' => 'System User Role',
                    'required' => true
                ),
                'account_no' => array(
                    'name' => 'Account Number',
                    'required' => true
                ),
                'bank_name' => array(
                    'name' => 'Bank Name',
                    'unique' => 'banks',
                    'required' => true
                ),
                'branch_name' => array(
                    'name' => 'Branch Name',
                    'unique' => 'bank_branch',
                    'required' => true
                ),
                'pin_no' => array(
                    'name' => 'Pin No',
                    'required' => true,
                    'unique' => 'bank_account'
                )
            ));

            if($this->getValidationStatus()){
                $uniq_id = uniqid();
                $destination = $this->_destination.$uniq_id.$_FILES['profile-pic']['name'];
                $image_path = '';
                if(!empty($_FILES['profile-pic']['name'])) {
                    $image_path = $this->uploadImage($_FILES['profile-pic']['tmp_name'], $destination);
                }else{
                    $image_path = '';
                }

                $this->beginTranc();

                $mf_id = $this->addPersonalDetails($surname, $firstname, $middlename, $id_passport, $gender, $image_path, $regdate_stamp, $b_role, $customer_type_id, $email);
                if(!empty($mf_id)){
                    $bank_acc_id = $this->createBankAccount($mf_id, $bank_name, $branch_name, $account_no, $pin_no);
                    if($bank_acc_id){
                        if($this->createLandlordFile($mf_id)){
                            if($this->addAddress($phone_number, $postal_address, $town, $mf_id, $address_type_id, $ward, $street, $building, $county, $postal_code)) {
                                if($this->createLoginAccount($landlord_data, $mf_id)) {
                                    $this->flashMessage('mf', 'success', 'Masterfile has been added.');
                                }else{
                                    $this->flashMessage('mf', 'error', 'Failed to create login account! ' . get_last_error());
                                }
                            }else{
                                $this->flashMessage('mf', 'error', 'Failed to create address! ' . get_last_error());
                            }
                        }else{
                            $this->flashMessage('mf', 'error', 'Failed to create Landlord File '.get_last_error());
                        }
                    }else{
                        $this->flashMessage('mf', 'error', 'Failed to create Landlord File! '.get_last_error());
                    }
                }else{
                    $this->flashMessage('mf', 'error', 'Failed to add Personal Details! '.get_last_error());
                }
            }
            $this->endTranc();
            App::redirectTo('?num=722');
        }

        public function addPM($pm_data){
            extract($_POST);
            //var_dump($pm_data);exit;
            // validate
            $this->validate($pm_data, array(
                'user_role' => array(
                    'name' => 'System User Role',
                    'required' => true
                )
            ));

            if($this->getValidationStatus()){
                // validate image
               $uniq_id = uniqid();
                $destination = $this->_destination.$uniq_id.$_FILES['profile-pic']['name'];
                $image_path = '';
                if(!empty($_FILES['profile-pic']['name'])) {
                    $image_path = $this->uploadImage($_FILES['profile-pic']['tmp_name'], $destination);
                }else{
                    $image_path = '';
                }

                $this->beginTranc();

                $mf_id = $this->addPersonalDetails($surname, $firstname, $middlename, $id_passport, $gender, $image_path, $regdate_stamp, $b_role, $customer_type_id, $email);
                if(!empty($mf_id)){
                    if($this->addAddress($phone_number, $postal_address, $town, $mf_id, $address_type_id, $ward, $street, $building, $county, $postal_code)) {
                        if($this->createPmFile($mf_id)) {
                            if($this->createLoginAccount($pm_data, $mf_id)) {
                                $this->flashMessage('mf', 'success', 'Masterfile has been added.');
                            }else{
                                $this->flashMessage('mf', 'error', 'Failed to create login account! ' . get_last_error());
                            }
                        }else{
                            $this->flashMessage('mf', 'error', 'Failed to create property manager file! ' . get_last_error());
                        }
                    }else {
                        $this->flashMessage('mf', 'error', 'Failed to create address! ' . get_last_error());
                    }
                }else{
                    $this->flashMessage('mf', 'error', 'Failed to add Personal Details! '.get_last_error());
                }
            }
            $this->endTranc();
            App::redirectTo('?num=722');
        }

        public function addPersonalDetails($surname, $firstname, $middlename, $id_passport, $gender, $image_path, $regdate_stamp, $b_role, $customer_type_id, $email){
            $regdate_stamp = date('Y-m-d', strtotime($regdate_stamp));
            $data = $this->insertQuery('masterfile',
                array(
                    'surname' => $surname,
                    'firstname' => $firstname,
                    'middlename' => $middlename,
                    'id_passport' => $id_passport,
                    'gender' => $gender,
                    'images_path' => $image_path,
                    'regdate_stamp' => $regdate_stamp,
                    'b_role' => $b_role,
                    'dob' => 'NULL',
                    'time_stamp' => time(),
                    'customer_type_id' => $customer_type_id,
                    'email' => $email,
                    'created_by' => $_SESSION['mf_id']
                ),
                'mf_id'
            );
            //var_dump($data);exit;
            return $data['mf_id'];
        }

        public function addAddress($phone, $postal_address, $town, $mf_id, $address_type_id, $ward, $street, $building, $county, $postal_code){
            $result = $this->insertQuery('address',
                array(
                    'phone' => $phone,
                    'postal_address' => $postal_address,
                    'town' => $town,
                    'mf_id' => $mf_id,
                    'address_type_id' => $address_type_id,
                    'ward' => $ward,
                    'street' => $street,
                    'building' => $building,
                    'county' => $county,
                    'postal_code' => $postal_code
                )
            );
            //var_dump($result);exit;
            return $result;
        }

        public function createLoginAccount($post, $mf_id){
            $email = $post['email'];
            $full_name = $post['surname'].' '.$post['firstname'];

            $pass_data = $this->generatePassword();
            $result = $this->insertQuery('user_login2',
                array(
                    'username' => $email,
                    'password' => $pass_data['pass_hash'],
                    'user_active' => '1',
                    'user_role' => $post['user_role'],
                    'mf_id' => $mf_id,
                    'email' => $email
                )
            );
            //var_dump($result);exit;
            if($result) {
                $subject = "Welcome! Login Credentials";
                $body = "Dear $full_name\n";
                $body .= "Thank you for registering! Your login credentials are as follows;\n\n";
                $body .= "Username: $email\n";
                $body .= "Password: ".$pass_data['plain_pass'];
                $this->sendEmail($email, $subject, $body);
                return true;
            }
        }

        private static function generatePassword(){
            $plain_pass = 123456;
            $pass_hash = sha1($plain_pass);
            return array(
                'plain_pass' => $plain_pass,
                'pass_hash' => $pass_hash
            );
        }

		public static function findMasterFileByRoleName($role_name){
			$query = "SELECT * FROM masterfile mf INNER JOIN user_login2 ul ON "
					."mf.mf_Id = ul.mf_id INNER JOIN user_roles ur ON "
					."ul.user_role = ur.role_id WHERE ur.role_status is true "
					."AND mf.active is TRUE AND ur.role_name = '$role_name'";
			$result = run_query($query);
			return $result;
		}

		public function getCustomerAddresses($mf_id){
			$query = "SELECT a.*, at.address_type_name, cr.county_name FROM address a
			LEFT JOIN address_types at ON at.address_type_id = a.address_type_id 
			LEFT JOIN county_ref cr ON cr.county_ref_id = a.county
			WHERE mf_id = '".sanitizeVariable($mf_id)."'
			 ORDER BY at.address_type_name";
			return run_query($query);
		}

        public function addCustomerAddress($post){
            extract($_POST);
            //var_dump($_POST);exit;
            $this->validate($post, array(
                'county' => array(
                    'name' => 'County',
                    'required' => true
                ),
                'town' => array(
                    'name' => 'Town',
                    'required' => true
                ),
                'phone' => array(
                    'name' => 'Phone Number',
                    'required' => true
                ),
                'postal_address' => array(
                    'name' => 'Postal Address',
                    'required' => true,
                    'unique' => 'address'
                ),
                'postal_code' => array(
                    'name' => 'Postal Code',
                    'required' => true
                ),
                'address_type_id' => array(
                    'name' => 'Address Type',
                    'required' => true
                )
            ));

            if($this->getValidationStatus()) {
                $result = $this->insertQuery('address',
                    array(
                        'county' => $post['county'],
                        'town' => $post['town'],
                        'postal_address' => $post['postal_address'],
                        'address_type_id' => $post['address_type_id'],
                        'mf_id' => $post['mf_id'],
                        'ward' => $post['ward'],
                        'street' => $post['street'],
                        'building' => $post['building'],
                        'house_no' => $post['house_no'],
                        'postal_code' => $post['postal_code'],
                        'phone' => $post['phone']
                    )
                );
                //var_dump($result);exit;
                if($result){
                    $this->flashMessage('mf', 'success', 'A new address type has been added!');
                }else{
                    $this->flashMessage('mf', 'error', 'Encountered an error!');
                }
            }
        }

        public function editCustomerAddress($post){
            extract($_POST);
            //var_dump($post);exit;
            $this->validate($_POST, array(
                'county' => array(
                    'name' => 'County',
                    'required' => true
                ),
                'town' => array(
                    'name' => 'Town',
                    'required' => true
                ),
                'postal_address' => array(
                    'name' => 'Postal Address',
                    'required' => true,
                    'unique2' => array(
                        'table' => 'address',
                        'skip_column' => 'address_id',
                        'skip_value' => $post['address_id']
                    )
                ),
                'address_type_id' => array(
                    'name' => 'Address Type',
                    'required' => true
                ),
                'phone' => array(
                    'name' => 'Phone No.',
                    'required' => true
                ),
                'postal_code' => array(
                    'name' => 'Postal Code',
                    'required' => true
                )
            ));
            $result = $this->updateQuery2('address',
                array(
                    'phone' => $post['phone'],
                    'postal_address' => $post['postal_address'],
                    'town' => $post['town'],
                    'address_type_id' => $post['address_type_id'],
                    'ward' => $post['ward'],
                    'street' => $post['street'],
                    'building' => $post['building'],
                    'county' => $post['county'],
                    'postal_code' => $post['postal_code']
                ),
                array(
                    'address_id' => $post['address_id']
                )
            );
            //var_dump($result);exit;
            if ($result) {
                $this->flashMessage('mf', 'success', 'Address Type has been updated!');
            }else {
                $this->flashMessage('mf', 'error', 'Encountered an error while updating the Address Type!');
            }
        }

        public function deleteCustomerAddress($id){
            if($this->getAddressype(Main)){
                $this->flashMessage('mf', 'warning', 'Main Address Details cannot be deleted!');
            }else {
                if ($this->deleteQuery2('address', array(
                    'address_id' => $id
                ))
                ) {
                    $this->flashMessage('mf', 'success', 'Address Details has been deleted.');
                } else {
                    $this->flashMessage('mf', 'warning', 'The Address Detail is being used somewhere else in the system!');
                }
            }
        }

        public function getAddressype($type){
            $data = $this->selectQuery('address_types', 'address_type_name', "address_type_name = '".sanitizeVariable($type)."'");
            return $data;
        }

        public function getAllCounties($condition = null){
            $condition = (!is_null($condition)) ? $condition : '';
            $data = $this->selectQuery('county_ref', '*', $condition);
            return array(
                'all' => $data,
                'specific' => $data[0]
            );
        }

		public function checkForExistingRevenueChannelName($revenue_name, $mf_id){
			$query = "SELECT * FROM revenue_channel WHERE revenue_channel_name = '".$revenue_name."' AND mf_id = '".$mf_id."'";
			$result = run_query($query);
			$num_row = get_num_rows($result);
			if($num_row == 1){
				return true;
			}else{
				return false;
			}
		}

        public function getAllAddressType($condition = null){
            $condition = (!is_null($condition)) ? $condition : '';
            $data = $this->selectQuery('address_types', '*', $condition);
            return array(
                'all' => $data,
                'specific' => $data[0]
            );
        }

        public function addAddressType($post){
            $this->validate($post, array(
                'address_type_name' => array(
                    'name' => 'Address Type Name',
                    'required' => true,
                    'unique' => 'address_types'
                )
            ));

            if($this->getValidationStatus()) {
                $result = $this->insertQuery('address_types',
                    array(
                        'address_type_name' => $post['address_type_name'],
                        'status' => $post['status']
                    )
                );
                if($result){
                    $this->flashMessage('mf', 'success', 'A new address type has been added!');
                }else{
                    $this->flashMessage('mf', 'error', 'Encountered an error!');
                }
            }
        }

        public function editAddressType($post){
            extract($_POST);
            //var_dump($post);exit;
            $this->validate($_POST, array(
                'address_type_name' => array(
                    'name' => 'Address Type Name',
                    'required' => true,
                    'unique2' => array(
                        'table' => 'address_types',
                        'skip_column' => 'address_type_id',
                        'skip_value' => $post['address_type_id']
                    )
                )
            ));
            $result = $this->updateQuery2('address_types',
                array(
                    'address_type_name' => $post['address_type_name'],
                    'status' => $post['status']
                ),
                array(
                    'address_type_id' => $post['address_type_id']
                )
            );
            //var_dump($result);exit;
            if ($result) {
                $this->flashMessage('mf', 'success', 'Address Type has been updated!');
            }else {
                $this->flashMessage('mf', 'error', 'Encountered an error while updating the Address Type!');
            }
        }

        public function deleteAddressType(){
            extract($_POST);
            if($this->deleteQuery2('address_types', array(
                'address_type_id' => $address_type_id
            ))){
                $this->flashMessage('mf', 'success', 'Address type has been deleted');
                App::redirectTo('?num=727');
            }else{
                $this->flashMessage('mf', 'warning', 'The Address type is being used somewhere else in the system!');
            }
        }

        public function getAddressTypeByAddressTypeId($id){
            $data = $this->selectQuery('address_types', '*', "address_type_id = '".sanitizeVariable($id)."' ");
            echo json_encode($data[0]);
        }

		public function editAddress(){
			extract($_POST);
			if(!onEditcheckForExistingEntry('address', 'postal_address', $postal_address, 'address_id', $edit_id)){
				$query = "UPDATE address SET 
						phone = '".sanitizeVariable($phone_no)."',
						postal_address = '".sanitizeVariable($postal_address)."',
						town = '".sanitizeVariable($town)."',
						ward = '".sanitizeVariable($ward)."',
						address_type_id = '".sanitizeVariable($address_type_id)."',
						street = '".sanitizeVariable($street)."',
						building = '".sanitizeVariable($building)."',
						county = '".sanitizeVariable($county)."'
                    WHERE address_id = '".$_POST['edit_id']."' ";

	            $result = run_query($query);
	            // var_dump($query); exits;
	            if (!$result) {
	                $errormessage = '<div class="alert alert-error">
	                                    <button class="close" data-dismiss="alert">×</button>
	                                    <strong>Error!</strong> Entry not updated.
	                                </div>';
	                $_SESSION['done-deal'] = $errormessage;
	              }else{
	              $_SESSION['done-deal'] = '<div class="alert alert-success">
	                        <button class="close" data-dismiss="alert">×</button>
	                        <strong>Success!</strong> Entry updated successfully.
	                    </div>';
	                }
	        }
	          else{
	             $errormessage = '<div class="alert alert-warning">
	                                     <button class="close" data-dismiss="alert">×</button>
	                                     <strong>Warning!</strong> The Postal Address ('.$postal_address.') already exists. Try another!
	                                 </div>';
	                 $_SESSION['done-deal'] = $errormessage;
	        }
		}

		public function deleteAddress(){
			$query = "DELETE FROM address WHERE address_id = '".$_POST['delete_id']."'";
			$result = run_query($query);
			if($result){
				$_SESSION['done-deal'] = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert">&times;</button>
						<strong>Success!</strong> The Address has been removed.
					</div>';
			}
		}

        public function createBankAccount($mf_id, $bank_name, $branch_name, $account_no, $pin_no){
            extract($_POST);
            //var_dump($_POST);exit;
            $result = $this->insertQuery(
                'bank_account',
                array(
                    'bank_id' => $bank_name,
                    'branch_id' => $branch_name,
                    'account_no' => $account_no,
                    'pin_no' => $pin_no,
                    'mf_id' => $mf_id
                ),
                'bank_acc_id'
            );
            //var_dump($result);exit;
            if($result) {
                return true;
            }else {
                return false;
            }
        }

        public function createTenantFile($mf_id){
            $result = $this->insertQuery(
                'tenants',
                array(
                    'mf_id' => $mf_id,
                    'created_by' => $_SESSION['mf_id']
                )
            );
            //var_dump($result);exit;
            if($result) {
                return true;
            }else {
                return false;
            }
        }

        public function createLandlordFile($mf_id){
            $result = $this->insertQuery(
                'landlords',
                array(
                    'mf_id' => $mf_id,
                    'created_by' => $_SESSION['mf_id']
                )
            );
            //var_dump($result);exit;
            if($result) {
                return true;
            }else {
                return false;
            }
        }

        public function createContractorFile($mf_id, $skills){
            extract($_POST);
            $skills = '';
            if(count($skill_name)){
                foreach ($skill_name as $skill) {
                    $skills .= $skill.', ';
                }
            }
            $skills = rtrim($skills, ', ');
            $result = $this->insertQuery(
                'contractor',
                array(
                    'mf_id' => $mf_id,
                    'skills' => $skills,
                    'created_by' => $_SESSION['mf_id']
                )
            );
            //var_dump($result);exit;
            if($result) {
                return true;
            }else {
                return false;
            }
        }

        public function createPmFile($mf_id){
            $result = $this->insertQuery(
                'property_manager',
                array(
                    'mf_id' => $mf_id,
                    'created_by' => $_SESSION['mf_id']
                )
            );
            //var_dump($result);exit;
            if($result) {
                return true;
            }else {
                return false;
            }
        }

        public function getAllMasterfile($condition = null){
            $condition = (!is_null($condition)) ? $condition : '';
            $data = $this->selectQuery('all_masterfile', '*', $condition);
            return array(
                'all' => $data,
                'specific' => $data['0']
            );
        }

        public function getAllActiveMasterfile(){
            $data = $this->selectQuery('allActiveMasterfile', '*');
            return $data;
        }

        public function getAllTenants(){
            $data = $this->selectQuery('all_tenants', '*');
            return $data;
        }

        public function getAllMyMasterfile(){
            $data = $this->selectQuery('my_masterfile', '*', "created_by = '".$_SESSION['mf_id']."'");
            return $data;
        }

        public function getProfileInfo(){
            $query="SELECT m.*, ct.customer_type_name, ul.email, m.email FROM masterfile m 
                LEFT JOIN customer_types ct ON ct.customer_type_id = m.customer_type_id
                LEFT JOIN user_login2 ul ON ul.mf_id = m.mf_id
                WHERE m.mf_id = '".$mf_id."' ";
            $result = run_query($query);
            return array(
                'all' => $result,
                'specific' => $result[0]
            );
        }

        public function editMf($post){
            $this->validate($_POST, array(
                // personal details
                'surname' => array(
                    'name' => 'Surname',
                    'required' => true
                ),
                'firstname' => array(
                    'name' => 'First Name',
                    'required' => true
                ),
                'id_passport' => array(
                    'name' => 'National Id/Passport',
                    'required' => true,
                    'unique2' => array(
                        'table' => 'masterfile',
                        'skip_column' => 'mf_id',
                        'skip_value' => $post['mf_id']
                    )
                ),
                'gender' => array(
                    'name' => 'Gender',
                    'required' => true
                ),
                'regdate_stamp' => array(
                    'name' => 'Start Date',
                    'required' => true
                ),
                'customer_type_id' => array(
                    'name' => 'Masterfile Type',
                    'required' => true
                ),
            ));
            // upload the image if there is any
            $uniq_id = uniqid();
            $filename = $_FILES['images_path']['name'];
            $destination = $this->_destination.$uniq_id.$filename;
            $image_path = '';

            if($filename != '') {
                $image_path = $this->uploadImage($_FILES['images_path']['tmp_name'], $destination);
            }

            $result = $this->updateQuery('masterfile',
                "surname = '" . sanitizeVariable($post['surname']) . "',
                firstname = '" . sanitizeVariable($post['firstname']) . "',
                middlename = '" . sanitizeVariable($post['middlename']) . "',
                id_passport = '" . sanitizeVariable($post['id_passport']) . "',
                gender = '" . sanitizeVariable($post['gender']) . "',
                customer_type_id = '" . sanitizeVariable($post['customer_type_id']) . "', 
                images_path = '" . sanitizeVariable($image_path) . "',
                regdate_stamp = '" . sanitizeVariable($post['regdate_stamp']) . "',
                b_role = '" . sanitizeVariable($post['b_role']) . "'
                ",
                "mf_id = '".$post['mf_id']."'"
            );
            if ($result) {
                $this->flashMessage('mf', 'success', 'Masterfile has been updated!');
            }else {
                $this->flashMessage('mf', 'error', 'Encountered an error while updating the masterfile!');
            }
        }

        public function getAllUserRoles($condition = null){
            $condition = (!is_null($condition)) ? $condition : '';
            $data = $this->selectQuery('user_roles', '*', $condition);
            return $data;
        }

        public function getAllMasterfileType($condition = null){
            $condition = (!is_null($condition)) ? $condition : '';
            $data = $this->selectQuery('customer_types', '*', $condition);
            return $data;
        }

        public function blockUser($mf_id){
            $query = "UPDATE user_login2 SET user_active = '0', status = '0' WHERE mf_id = '".$mf_id."'";
            if(run_query($query)){
                //var_dump($query);exit;
                return true;
            }else{
                return false;
            }
        }

        public function softDelete(){
        extract($_POST);
        //var_dump($_POST);exit;
        $query1 = "UPDATE masterfile SET active = '0' WHERE mf_id = '".$mf_id."'";
        if(run_query($query1)){
            $this->blockUser($mf_id);
                $this->flashMessage('mf', 'success', 'Masterfile '.$surname.' '.$firstname.' has been deleted');
                App::redirectTo('index.php?num=729&mf_id='.$mf_id);
            }else{
                $this->flashMessage('mf', 'warning', 'Masterfile details are being used somewhere else in the 
                system!'.get_last_error().'');
            }
        }

        public function deleteMasterfile(){
            if(!empty($_POST['delete_id'])){
                $query = "DELETE FROM masterfile WHERE mf_id = '".$_POST['delete_id']."'";
                if(run_query($query)){
                    $this->flashMessage('mf', 'success', 'Masterfile has been permanently deleted');
                }else{
                    var_dump(get_last_error());exit;
                }
            }
        }

        public function getAllDelMasterfile($condition = null){
            $condition = (!is_null($condition)) ? $condition : '';
            $data = $this->selectQuery('deleted_masterfile', '*', $condition);
            return array(
                'all' => $data,
                'specific' => $data[0]
            );
        }

        public function getFullName($mf_id){
//            if(!empty($mf_id)) {
//                $data = $this->selectQuery('all_masterfile', 'full_name', "mf_id = '" . sanitizeVariable($mf_id) . "'");
//                $data = $data[0]['full_name'];
//            }else {
//                $data = '';
//            }
//            return $data;
        }

        public function getMfByBrole($brole){
            $data = $this->selectQuery('masterfile', '*', "b_role = '".sanitizeVariable($brole)."'");
            return $data;
        }

        public function getAllSkills($condition = null){
            $condition = (!is_null($condition)) ? $condition : '';
            $data = $this->selectQuery('skill_types', '*', $condition);
            return $data;
        }

        public function getAllContractors(){
            $data = $this->selectQuery('all_contractors', '*');
            return $data;
        }
        public function getAllLandlords(){
            $data = $this->selectQuery('all_landlords', '*');
            return $data;
        }

        public function getLoginBussRole(){
            $data = $this->selectQuery('masterfile', 'b_role', "mf_id = '".$_SESSION['mf_id']."'");
            return $data[0]['b_role'];
        }
    }
