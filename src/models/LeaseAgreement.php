<?php
include_once('src/models/Payments.php');
/**
*
*/
class LeaseAgreement extends Payments
{
	private $_destination = 'crm_docs/';
    public function addLeaseAgreement(){

        $post = $_POST;
		//var_dump($post);exit;
        $this->validate($post, array(
            'tenant' => array(
                'name' => 'Tenant',
                'required' => true
            ),
            'house_id' => array(
                'name' => 'House',
                'required' => true
            ),
            'lease_type' => array(
                'name' => 'Lease Type',
                'required' => true
            ),
            'start_date' => array(
                'name' => 'Start Date',
                'required' => true
            ),
            'end_date' => array(
                'name' => 'End Date',
                'required' => true
            )
        ));

//		if(empty($_FILES['lease_doc']['name'])){
//			$this->setWarning('You must attach the lease agreement!');
//			return false;
//		}

        if(strtotime($post['start_date']) > strtotime($post['end_date'])){
            $this->setWarning('Start Date cannot be later than the End Date!');
            return false;
        }else if(strtotime($post['end_date']) < strtotime($post['start_date'])){
            $this->setWarning('End Date cannot be later than the Start Date!');
            return false;
        }

        // validate document
        $uniqid = uniqid();
        $destination = $this->_destination.$uniqid.$_FILES['lease_doc']['name'];
//		$allowed_exts = array('doc', 'docx', 'pdf', 'rtf', 'png', 'gif', 'jpg', 'xlsx');
//		if(!$this->validateImage($destination, $allowed_exts)){
//			$this->setWarning('File type not allowed!');
//			return false;
//		}

        $valid = $this->getValidationStatus();
        if($valid) {
            $this->beginTranc();
            $doc_id = $this->addLeaseDoc($_FILES, $destination);
            if($doc_id){
                if($this->addLease($post['tenant'], $post['house_id'], $post['plot_id'], $post['lease_type'], $post['start_date'], $post['end_date'], $doc_id)) {
                        // get the rent service bill
                    $sb = $this->selectQuery('revenue_service_bill', 'revenue_bill_id,bill_interval', "bill_code = '".MontlyRent."'");
//                    var_dump($sb);die;
                    $service_bill_id = $sb[0]['revenue_bill_id'];
                    $bill_interval = $sb[0]['bill_interval'];

                    // get the rent amount
                    $house = $this->selectQuery('houses', 'rent_amount, house_number', "house_id = '".$post['house_id']."'");
                    $rent_amount = $house[0]['rent_amount'];
                    $house_no = $house[0]['house_number'];
                    // create billing file
                    if(!$this->insertQuery('customer_billing_file', array(
                        'biller_mfid' => $_SESSION['mf_id'],
                        'start_date' => date('Y-m-d', strtotime($post['start_date'])),
                        'billing_interval' => $bill_interval,
                        'billing_amount' => $rent_amount,
                        'created' => date('Y-m-d, H:i:s'),
                        'service_bill_id' => $service_bill_id,
                        'service_account' => $doc_id,
                        'status' => '1',
                        'unit_number'=>$_POST['house_id']
                    ))){
                        $this->setWarning('Failed to Create customer billing file'.get_last_error());
                    }

                    // get plot services
                    $plot_data = $this->selectQuery('houses', 'plot_id,house_number', "house_id = '".$post['house_id']."'");
//                    var_dump($plot_data);die;
//                    echo $plot_data[0];
                    $plot_services = $this->selectQuery('ps_data', '*', "plot_id = '".$plot_data[0]['plot_id']."'");
//                    var_dump($plot_services);die;
                    if($plot_services != false && count($plot_services) > 0 ){
                        foreach ($plot_services as $plot_service) {
                            // create a bill
                            if(!$bill_data = $this->insertQuery('customer_bills', array(
                                'bill_amount' => $plot_service['price'],
                                'bill_date' => date('Y-m-d'),
                                'bill_status' => '0',
                                'bill_amount_paid' => 0,
                                'bill_balance' => $plot_service['price'],
                                'mf_id' => $post['tenant'],
                                'biller_mfid' => $_SESSION['mf_id'],
                                'service_channel_id' => $plot_service['service_channel_id'],
//                                'service_account' => $plot_data[0]['house_number'],
                                'service_account' => $doc_id,
                                'unit_number'=>$_POST['house_id']
                            ), 'bill_id')){
                                $this->setWarning('Failed to create customer bill'.get_last_error());
                            }

                            // create a debit journal
                            if(!$this->insertQuery('journal', array(
                                'bill_id' => $bill_data['bill_id'],
                                'amount' => $plot_service['price'],
                                'dr_cr' => 'DR',
                                'journal_type' => 1,
                                'service_account' => $doc_id,
//                                'service_account' => $plot_data[0]['house_number'],
                                'particulars' => $plot_service['service_option'].' '.$plot_service['option_code'],
                                'stamp' => time(),
                                'mf_id' => $post['tenant'],
                                'journal_code' => 'SA',
                                'unit_number'=>$_POST['house_id']
                            ))){
                                $this->setWarning('Failed to create journal'.get_last_error());
                            }
                        }
                    }

                    // get house services
                    $house_services = $this->selectQuery('hs_data', '*', "house_id = '".$post['house_id']."'");
//                    var_dump($house_services);exit;
                    //traceActivity('House Services Array: '.$house_services, 'slfjsld');
                    if($house_services != false && count($house_services)> 0){
//                        traceActivity('Count Services','dll');
                        foreach ($house_services as $house_service){
                            // create a bill
                            if(!$bill_data = $this->insertQuery('customer_bills', array(
                                'bill_amount' => $house_service['price'],
                                'bill_date' => date('Y-m-d'),
                                'bill_status' => '0',
                                'bill_amount_paid' => 0,
                                'bill_balance' => $house_service['price'],
                                'mf_id' => $post['tenant'],
                                'biller_mfid' => $_SESSION['mf_id'],
                                'service_channel_id' => $house_service['service_channel_id'],
//                                'service_account' => $house_service['house_number'],
                                'service_account' => $doc_id,
                                'unit_number'=>$_POST['house_id']
                            ), 'bill_id')){
                                $this->setWarning('Failed to create customer bill'.get_last_error());
                            }

                            // create a debit journal
                            if(!$this->insertQuery('journal', array(
                                'bill_id' => $bill_data['bill_id'],
                                'amount' => $house_service['price'],
                                'dr_cr' => 'DR',
                                'journal_type' => 1,
                                'service_account' => $house_service['house_number'],
                                'service_account' => $doc_id,
                                'particulars' => $house_service['service_option'].' '.$house_service['option_code'],
                                'stamp' => time(),
                                'mf_id' => $post['tenant'],
                                'journal_code' => 'SA'
                            ))){
                                $this->setWarning('Failed to create journal'.get_last_error());
                            }
                        }
                    }
                    $this->endTranc();


                }else {

                }
            }
        }
        if(count($this->getWarnings())> 0){

        }else{
            $this->flashMessage('lease', 'success', 'Lease Agreement has been created!');
        }
    }

	public function addLease($tenant, $house_id, $plot_id,$lease_type, $start_date, $end_date, $doc_id){
		extract($_POST);
		$start_date = date('Y-m-d', strtotime($start_date));
		$end_date = date('Y-m-d', strtotime($end_date));
        //$doc_id = (isset($doc_id) && !empty($doc_id)) ? $doc_id : 'NULL';
		if($this->getValidationStatus()) {
			$data = $this->insertQuery('lease',
				array(
					'tenant' => $tenant,
					'house_id' => $house_id,
					'plot_id' => $plot_id,
					'lease_type' => $lease_type,
					'start_date' => $start_date,
					'end_date' => $end_date,
					'lease_document_id' => $doc_id
				),
				'lease_id'
			);
            //var_dump($data);exit;
			return $data['lease_id'];
		}else{
			return false;
		}
	}

	public function addLeaseDoc($file, $destination){
		extract($_POST);
		$doc_path = $this->uploadImage($file['lease_doc']['tmp_name'], $destination);

			if($data = $this->insertQuery('documents',
				array(
					'doc_name' => $file['lease_doc']['name'],
					'local_path' => $doc_path,
					'created_date' => date('Y-m-d'),
					'created_by' => $_SESSION['mf_id']
				),
				'doc_id'
			)) {
                return $data['doc_id'];
            }else{
                return false;
            }
	}

	public function getAllLeaseAgreements(){
		$return = array();
		$query= "SELECT * FROM lease_details WHERE status='TRUE'";
		if($result = run_query($query)){
			if(get_num_rows($result)){
				while ($rows = get_row_data($result)) {
					$return[] = $rows;
				}
				return $return;
			}
		}
	}

    public function updateLeaseAgreement($post){
        extract($_POST);
        //var_dump($post);exit;
        $this->validate($_POST, array(
            'tenant' => array(
                'name' => 'Tenant',
                'required' => true
            ),
            'lease_type' => array(
                'name' => 'Lease Type',
                'required' => true
            ),
            'start_date' => array(
                'name' => 'Start Date',
                'required' => true
            ),
            'end_date' => array(
                'name' => 'End Date',
                'required' => true
            )
        ));

        //validate start date and end date
        if(strtotime($post['start_date']) > strtotime($post['end_date'])){
            $this->setWarning('Start Date cannot be later than the End Date!');
            return false;
        }else if(strtotime($post['end_date']) < strtotime($post['start_date'])){
            $this->setWarning('End Date cannot be later than the Start Date!');
            return false;
        }

        // validate document
        $uniqid = uniqid();
        $destination = $this->_destination.$uniqid.$_FILES['lease_doc']['name'];
        $allowed_exts = array('doc', 'docx', 'pdf', 'rtf', 'png', 'gif', 'jpg');
        $this->beginTranc();
        if(!empty($_FILES['lease_doc']['name'])) {
            if (!$this->validateImage($destination, $allowed_exts)) {
                $this->setWarning('File type not allowed!');
                return false;
            }
            $valid = $this->getValidationStatus();
            if ($valid) {
                $_FILES['doc_id'] = $_POST['doc_id'];
                if ($this->updateLeaseDoc($_FILES, $destination, $allowed_exts)) {
                    if ($this->updateLease($post['tenant'], $post['house_id'], $post['lease_type'], $post['start_date'], $post['end_date'], $doc_id)) {
                        $this->flashMessage('lease', 'success', 'Lease Agreement has been updates!');
                    } else {
                        $this->flashMessage('lease', 'error', 'Failed to update lease agreement! ' . get_last_error());
                    }
                } else {
                    $this->flashMessage('lease', 'error', 'Failed to update lease document! ' . get_last_error());
                }
            }
        } else {
            //var_dump($_POST);exit;
            if ($this->updateLease($post)) {
                $this->flashMessage('lease', 'success', 'Lease Agreement has been updates!');
            } else {
                $this->flashMessage('lease', 'error', 'Failed to update lease agreement! ' . get_last_error());
            }
        }
        $this->endTranc();
    }

    public function updateLeaseDoc($file, $destination, $allowed_extensions){
        $doc_path = $this->uploadImage($file['lease_doc']['tmp_name'], $destination, $allowed_extensions);
        if(!empty($doc_path)) {
            $data = $this->updateQuery2('documents',
                array(
                    'doc_name' => $file['lease_doc']['name'],
                    'local_path' => $doc_path,
                    'created_date' => date('Y-m-d'),
                    'created_by' => $_SESSION['mf_id']
                ),
                array(
                    'doc_id' => $file['doc_id']
                )
            );
			//var_dump($data);exit;
            return $data;
        }else{
            return false;
        }
    }

	public function updateLease($post){
		$result = $this->updateQuery2('lease',
			array(
				'tenant' => $post['tenant'],
				'house_id' => $post['house_id'],
				'lease_type' => $post['lease_type'],
				'start_date' => date('Y-m-d', strtotime($post['start_date'])),
				'end_date' => date('Y-m-d', strtotime($post['end_date'])),
				'lease_document_id' => $post['doc_id']
			),
			array(
				'lease_id' => $post['edit_id']
			)
		);
		//var_dump($result);exit;
		return $result;
	}

	public function terminateLeaseAgreement($post){
		extract($_POST);
		//var_dump($post);exit;
		$result = $this->updateQuery2('lease',
			array(
				'status' => '0'
			),
			array(
				'lease_id' => $post['edit_id']
			)
		);
		//var_dump($result);exit;

	}

	public function getAllLeaseTypes($condition = null){
		$condition = (!is_null($condition)) ? $condition : '';
		$data = $this->selectQuery('lease_types', '*', $condition);
		return $data;
	}

	public function getHouses(){
		$result= run_query("SELECT * FROM houses_and_plots");
		return $result;
	}

	public function getHouseNo($number){
		$result= run_query("SELECT * FROM houses_and_plots WHERE house_id = '".$number."'");
		return $result;
	}

	public function getAllLeasesByRole(){
		//check whether user is a property manager or a tenant

		$role = $_SESSION['role_name'];
		if ($role == PM) {
			//user is a property manager
			$result =  $this->selectQuery('leases','*', " pm_mfid=  '" . $_SESSION['mf_id']. "' ");
		} else if ($role == LandLord) {
			//user is a landlord
			$result =  $this->selectQuery('leases','*', " landlord_mf_id=  '" . $_SESSION['mf_id']. "' ");
		} else if ($role == SystemAdmin){
			//if role is admin
			$result = $this->selectQuery('leases', '*');
		} else if ($role == TN){
		    //if role is a tenant
            $result =  $this->selectQuery('leases','*', " tenant_mf_id=  '" . $_SESSION['mf_id']. "' ");
        }
		//var_dump($result);die;
        if (count($result)) {
            return $result;
        }
	}

	public function getNameByMfId($mf_id){
		$result = $this->selectQuery('masterfile','surname,firstname,middlename', "mf_id ='".$mf_id."' ");
        if(count($result) > 0) {
            echo $result[0]['surname'] . '  ' . $result[0]['firstname'] . '  ' . $result[0]['middlename'];
        }
    }

    public function getLeaseByLeaseId($id){
        $data = $this->selectQuery('lease_details', '*', "lease_id = '".sanitizeVariable($id)."' ");
        echo json_encode($data[0]);
    }
	//function to terminate a lease
    public function terminateLease(){
        extract($_POST);
        //var_dump($_POST);exit;
        $result = $this->updateQuery2('lease',array(
            'status'=>'0'
        ),
            array(
                'lease_id'=> $_POST['edit_id']
            ));
        if ($result) {
            $this->flashMessage('lease', 'success', 'Lease Agreement has been terminated!');
        }else {
            $this->flashMessage('lease', 'error', 'Encountered an error while terminating the Lease Agreement!');
        }
    }

    public function getAllProperties(){
        $role = $_SESSION['role_name'];
        if ($role == PM){
            $result = $this->selectQuery('plots','plot_id,plot_name'," pm_mfid=  '" . $_SESSION['mf_id']. "'");
        } else if ($role == LandLord) {
            //user is a landlord
            $result =  $this->selectQuery('plots','plot_id,plot_name', " landlord_mf_id=  '" . $_SESSION['mf_id']. "' ");
        } else if ($role == SystemAdmin){
            //if role is admin
            $result = $this->selectQuery('plots', 'plot_id,plot_name');
        }
        //var_dump($result);die;
        if (count($result)) {
            return $result;
        }
    }

	public function getAllEmptyHouses($plot_id){
	    $empty_houses = array();
        $houses_with_lease = $this->getHousesWithLease();
		$houses = $this->selectQuery('houses', '*', "plot_id = '".sanitizeVariable($plot_id)."'");
        if(count($houses)){
            foreach ($houses as $house){
                if(!in_array($house['house_id'], $houses_with_lease)) {
                    $empty_houses[] = array(
                        'house_id' => $house['house_id'],
                        'house_no' => $house['house_number']
                    );
                }
            }
        }
        return $empty_houses;
	}

	public function getHousesWithLease(){
	    $return = array();
	    $houses = $this->selectQuery('lease', 'house_id', "status IS TRUE");
        if(count($houses)){
            foreach ($houses as $house){
                $return[] = $house['house_id'];
            }
        }
        return $return;
    }

	public function getAllTenantsWithHouses(){
		$data = $this->selectQuery('all_tenants_with_houses', '*');
		return $data;
	}

    public function getMyLease(){
        $data = $this->selectQuery('my_lease', '*', "pm_mfid = '".$_SESSION['mf_id']."' ");
        return $data;
    }

    public function leaseInfo(){
        $data = $this->selectQuery('my_lease', '*', "lease_id = '".$_GET['lease']."' ");
        return $data;
    }

    public function getUser(){
        $query = "SELECT CONCAT(surname,' ',firstname,' ',middlename) AS full_name FROM masterfile WHERE mf_id = '".$_SESSION['mf_id']."'";
        if($result = run_query($query)){
            if(get_num_rows($result)){
                $rows = get_row_data($result);
                return $rows['full_name'];
            }
        }
    }

    public function getPmTenants(){
        extract($_POST);
        $data = $this->selectQuery('pm_tenants', '*', 'created_by = "'.$_SESSION['mf_id'].'" ');
        return $data;
    }

    public function getMyLeaseStatement(){
        $data = $this->selectQuery('journal', '*', "mf_id = '".$_GET['tenant']."' AND unit_number = '".$_GET['unit']."' ");
        return array(
            'all' => $data,
            'specific' => $data[0]
        );
    }

}

