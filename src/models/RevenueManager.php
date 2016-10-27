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
}






















