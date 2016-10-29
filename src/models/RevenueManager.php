<?php
	/**
	* 
	*/
	require_once 'src/models/Library.php';
	class RevenueManager extends Library
	{
		public function getAllRevenueChannelsForRegions()
		{
			$query = "SELECT DISTINCT(f.revenue_channel_id) AS revenue_channel_id, rc.revenue_channel_name FROM revenue_channel rc
			INNER JOIN forecast f ON f.revenue_channel_id = rc.revenue_channel_id
			WHERE subcounty_id IS NULL
			ORDER BY revenue_channel_name ASC";
			// var_dump($query);exit;
			return run_query($query);
		}

		public function getAllRevenueChannelsForSubcounty()
		{
			$query = "SELECT DISTINCT(f.revenue_channel_id) AS revenue_channel_id, rc.revenue_channel_name FROM revenue_channel rc
			INNER JOIN forecast f ON f.revenue_channel_id = rc.revenue_channel_id
			WHERE region_id IS NULL
			ORDER BY revenue_channel_name ASC";
			// var_dump($query);exit;
			return run_query($query);
		}

		public function getAllRevenueChannels()
		{
			$results = $this->selectQuery('revenue_channel','*');

			return $results;
		}
		//function to add a new revenue channel
		public function addRevenueChannel(){
			extract($_POST);
			if(!checkForExistingEntry('revenue_channel', 'revenue_channel_name', $revenue_channel_name)){
				if(!checkForExistingEntry('revenue_channel', 'revenue_channel_code', $revenue_channel_code)){
					$add_revenue_channels="INSERT INTO revenue_channel(revenue_channel_name,revenue_channel_code)
    			                       VALUES('".$revenue_channel_name."', '".$revenue_channel_code."')";
					// var_dump($add_revenue_channels);exit;
					$result = run_query($add_revenue_channels);

					if (!$result) {
						$errormessage = '<div class="alert alert-warning">
                                            <button class="close" data-dismiss="alert">×</button>
                                            <strong>Warning!</strong> The revenue channel('.$revenue_channel_name.') already exists. Try another!
                                        </div>';
						$_SESSION['RMC'] = $errormessage;
					}else{
						$_SESSION['RMC'] = '<div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> Entry added successfully.
                            </div>';
					}
				}else{
					$_SESSION['RMC'] = '<div class="alert alert-warning">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Success!</strong> The revenue channel code('.$revenue_channel_code.') already exists.
                        </div>';
				}
			}else{
				$_SESSION['RMC'] = '<div class="alert alert-warning">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Success!</strong> The revenue channel name('.$revenue_channel_name.') already exists.
                        </div>';
			}
		}

		//function to get edit details by id
		public function getRevenueChannelById($id){
			$result =$this->selectQuery('revenue_channel','*', "revenue_channel_id ='".sanitizeVariable($id)."' ");
			return $result[0];
		}
		//function to delete a revenue channel
		public function deleteRevenueChannel($id){
			$message = array();
			$result = $this->deleteQuery('revenue_channel',"revenue_channel_id = '".$id."' ");

			if($result){
				$errormessage = '<div class="alert alert-success">
                                            <button class="close" data-dismiss="alert">×</button>
                                            <strong>Success!</strong>Revenue Channel Deleted!
                                        </div>';
				$_SESSION['RMC'] = $errormessage;
			}else{
				$errormessage = '<div class="alert alert-error">
                                            <button class="close" data-dismiss="alert">×</button>
                                            <strong>Error!</strong>Revenue Channel Not Deleted !
                                        </div>';
				$_SESSION['RMC'] = $errormessage;
			}
			return $message;
		}

        public function addServiceBill($post){
            //var_dump($_POST);exit;
            $this->validate($post, array(
                'bill_code' => array(
                    'name' => 'Bill Code',
                    'required' => true,
                    'unique' => 'revenue_service_bill'
                ),
                'bill_description' => array(
                    'name' => 'Bill Description',
                    'required' => true
                ),
                'bill_type' => array(
                    'name' => 'Bill Type',
                    'required' => true
                ),
                'amount_type' => array(
                    'name' => 'Amount Type',
                    'required' => true
                ),
                'bill_due_time' => array(
                    'name' => 'Bill Due Time',
                    'required' => true
                ),
                'revenue_channel_id' => array(
                    'name' => 'Revenue Channel',
                    'required' => true
                )
            ));

            if($this->getValidationStatus()) {
                $result = $this->insertQuery('revenue_service_bill',
                    array(
                        'bill_name' => $post['bill_name'],
                        'bill_description' => $post['bill_description'],
                        'bill_category' => $post['bill_category'],
                        'bill_code' => $post['bill_code'],
                        'bill_type' => $post['bill_type'],
                        'bill_interval' => $post['bill_interval'],
                        'amount_type' => $post['amount_type'],
                        'bill_due_time' => $post['bill_due_time'],
                        'revenue_channel_id' => $post['revenue_channel_id'],
                        'service_channel_id' => $post['service_option'],
                        'amount' => $post['amount']
                    )
                );
                //var_dump($result);exit;
                if($result){
                    $this->flashMessage('rev_mg', 'success', 'Service Bill '.$post['bill_description'].' has been added!');
                }else{
                    $this->flashMessage('rev_mg', 'error', 'Encountered an error!');
                }
            }
        }
}






















