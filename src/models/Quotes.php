<?php
include_once('src/models/SupportTickets.php');

class Quotes extends SupportTickets
{
	public function allQuotations($mf_id){
		$query = "SELECT * FROM quotes WHERE contractor_mf_id = '".$mf_id."'";
		$results = run_query($query);
		return $results;
	}
	public function getAllMaintainance(){
		$query = "SELECT * FROM maintenance_vouchers WHERE approve_status IS TRUE";
		$results = run_query($query);
		return $results;

	}

	//function to add quotation to the database

	public function addQuataion(){
		extract($_POST);
		//var_dump($_POST);die();
		$validate = array(
			'bid_amount'=>array(
				'name'=> 'Bid Amount',
				'required'=>true
				
			),
			'maintainance'=>array(
				'name'=> 'Maintainance',
				'required'=>true
			)
		);
		// var_dump($validate);
		$this->validate($_POST, $validate);
		if ($this->getValidationStatus()){
			//if the validation has passed, run a query to insert the details
			//into the database
			if($this-> addQuataionDetails($bid_amount, $maintainance)){
				$this->flashMessage('quotes', 'success', 'The Quotation has been added.');
			}else{
				$this->flashMessage('quotes', 'error', 'Failed to add quotation! ' . get_last_error());
			}
		}
	}

	public function addQuataionDetails($bid_amount, $maintainance){
		$contractor = $_SESSION['mf_id'];
		$bid_status = '0';
		$job_status = '0';

		$result = $this->insertQuery('quotes',
			array(
				'bid_amount' => $bid_amount,
				'maintainance_id' => $maintainance,
				'contractor_mf_id' => $contractor,
				'bid_status' => $bid_status,
				'job_status' => $job_status
			)
		);

		return $result;
	
	}

	public function getQuoteDataFromQuoteId($id){
		if(!empty($id)){
			$data = $this->selectQuery('quotes', '*', "qoute_id = '".$id."'");
			echo json_encode($data[0]);
		}
	}

	public function checkIfQuoteWasApproved($bid_status, $job_status){
		if($bid_status == 't'){
			return ($job_status == 't')? 'Complete': 'Incomplete';
		}else{
			return '';		
		}
	}
	public function editQuote(){
		extract($_POST);
		//var_dump($_POST);die();
		$validate = array(
			'bid_amount'=>array(
				'name'=> 'Bid Amount',
				'required'=>true
				
			),
			'maintainance'=>array(
				'name'=> 'Maintainance',
				'required'=>true
			)
		);
		// var_dump($validate);
		$this->validate($_POST, $validate);
		if ($this->getValidationStatus()){
			//if the validation has passed, run a query to insert the details
			//into the database
			if($this-> editQuotaionDetails($bid_amount, $maintainance, $edit_id)){
				$this->flashMessage('quotes', 'success', 'The Quotation has been edited.');
			}else{
				$this->flashMessage('quotes', 'error', 'Failed to edit quotation! ' . get_last_error());
			}
		}
	}
	public function editQuotaionDetails($bid_amount, $maintainance, $id){
		$result = $this->updateQuery2('quotes',
			array(
				'bid_amount' => $bid_amount,
				'maintainance_id' => $maintainance
			),
			array('qoute_id' => $id)
			);
		return $result;
	}

	//function to delete a quatation
	public function deleteQuote($delete_id){
		extract($_POST);
		$result = $this->deleteQuery('quotes', "qoute_id = '".$delete_id."'");
		if($result)
			$this->flashMessage('quotes', 'success', 'Quotation has been deleted!');
		else
			$this->flashMessage('quotes', 'error', 'Encountered an error! '.get_last_error());

	}
}