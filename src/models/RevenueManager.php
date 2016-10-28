<?php
	require_once('src/models/Masterfile.php');
	/**
	* 
	*/
	class RevenueManager extends Masterfile
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
			$query = "SELECT * FROM revenue_channel ORDER BY revenue_channel_name ASC";
			// var_dump($query);exit;
			return run_query($query);
		}

		public function getAllRegions()
		{
			$query = "SELECT * FROM region ORDER BY region_name ASC";
			// var_dump($query);exit;
			return run_query($query);
		}

		public function getAllCountiesd()
		{
			$query = "SELECT * FROM county_ref ORDER BY county_name";
			return run_query($query);
		}

		public function getAllSubcounties()
		{	
			$query = "SELECT * FROM sub_county ORDER BY sub_county_name ASC";
			return run_query($query);
		}

		public function getSubcountiesInCounty($county_id)
		{	
			$query = "SELECT * FROM sub_county WHERE county_ref_id = '".$county_id."'";
			return run_query($query);
		}

		public function populateTargetAmountsForEachSubcounty($rev_id){
			$result = $this->getAllSubcounties();

			//loop all subcounties while populating the target amount
			while ($rows = get_row_data($result)) {
				//get target amounts for the respective subcounty
				$this->getTargetAmountForSubcounty($rows['sub_county_id'], $rev_id);
			}
		}

		public function getTargetAmountForSubcounty($subcounty_id, $rev_id){
			$query = "SELECT * FROM forecast WHERE subcounty_id = '".$subcounty_id."' AND revenue_channel_id = '".$rev_id."'";
			$result = run_query($query);
			$num_rows =  get_num_rows($result);
			if($num_rows != 0){
				$rows = get_row_data($result);
				$target_amt = $rows['target_amount'];
				echo "<td>Ksh. ".number_format($target_amt,2)."</td>";
			}else{
				echo "<td><a href=\"#add_sub_forecast\" data-toggle=\"modal\" sub_id=\"$subcounty_id\" rev_id=\"$rev_id\" class=\"btn btn-mini add_sub_forecast\"><i class=\"icon-plus\"></i> Add Forecast</a></td>";
			}
		}

		public function populateTargetAmountsForEachRegion($rev_id){
			$result = $this->getAllRegions();

			//loop all subcounties while populating the target amount
			while ($rows = get_row_data($result)) {
				//get target amounts for the respective subcounty
				$this->getTargetAmountForRegion($rows['region_id'], $rev_id);
			}
		}

		public function getTargetAmountForRegion($region_id , $rev_id){
			$query = "SELECT * FROM forecast WHERE region_id = '".$region_id."' AND revenue_channel_id = '".$rev_id."'";
			$result = run_query($query);
			$num_rows =  get_num_rows($result);
			if($num_rows != 0){
				$rows = get_row_data($result);
				$target_amt = $rows['target_amount'];
				echo "<td>Ksh. ".number_format($target_amt,2)."</td>";
			}else{
				echo "<td><a href=\"#add_forecast\" data-toggle=\"modal\" reg_id=\"$region_id\" rev_id=\"$rev_id\" class=\"btn btn-mini add_forecast\"><i class=\"icon-plus\"></i> Add Forecast</a></td>";
			}
		}

		public function getSubcountyForecastsByRevenueChannel($rev_id){
			$query = "SELECT f.*, s.sub_county_name FROM forecast f
			LEFT JOIN sub_county s ON s.sub_county_id = f.subcounty_id
			WHERE revenue_channel_id = '".$rev_id."' AND subcounty_id IS NOT NULL";
			return run_query($query);
		}

		public function getRevenueName($rev_id){
			$query = "SELECT revenue_channel_name FROM revenue_channel WHERE revenue_channel_id = '".$rev_id."'";
			$result = run_query($query);		
			$rows = get_row_data($result);
			return $rows['revenue_channel_name'];	
		}

		public function getRegionForecastsByRevenueChannel($rev_id){
			$query = "SELECT f.*, r.region_name FROM forecast f
			LEFT JOIN region r ON r.region_id = f.region_id
			WHERE revenue_channel_id = '".$rev_id."' AND f.region_id IS NOT NULL";
			return run_query($query);
		}

		  public function getMonthlyTargetAmountForSubcounty($subcounty_id, $rev_id){
			$query = "SELECT * FROM forecast WHERE subcounty_id = '".$subcounty_id."' AND revenue_channel_id = '".$rev_id."'";
			$result = run_query($query);
			$num_rows =  get_num_rows($result);
			if($num_rows != 0){
				$rows = get_row_data($result);
				$target_amt = $rows['target_amount'];
				$amount = $target_amt * 30.4;
				echo "<td>Ksh. ".number_format($amount,2)."</td>";
			}else{
				echo "<td>0</td>";
			}
		}

	public function populateMonthlyTargetAmountsForEachSubcounty($rev_id){
			$result = $this->getAllSubcounties();

			//loop all subcounties while populating the target amount
			while ($rows = get_row_data($result)) {
				//get target amounts for the respective subcounty
				$this->getMonthlyTargetAmountForSubcounty($rows['sub_county_id'], $rev_id);
			}
		}

	public function populateMonthlyTargetAmountsForEachRegion($rev_id){
			$result = $this->getAllRegions();

			//loop all subcounties while populating the target amount
			while ($rows = get_row_data($result)) {
				//get target amounts for the respective subcounty
				$this->getMonthlyTargetAmountForRegion($rows['region_id'], $rev_id);
			}
		}

	public function getMonthlyTargetAmountForRegion($region_id , $rev_id){
			$query = "SELECT * FROM forecast WHERE region_id = '".$region_id."' AND revenue_channel_id = '".$rev_id."'";
			$result = run_query($query);
			$num_rows =  get_num_rows($result);
			if($num_rows != 0){
				$rows = get_row_data($result);
				$target_amt = $rows['target_amount'];
				$amount = $target_amt * 30.4;
				echo "<td>Ksh. ".number_format($amount,2)."</td>";
			}else{
				echo "<td>0</td>";
			}
		}

	 public function getQuaterlyTargetAmountForSubcounty($subcounty_id, $rev_id){
			$query = "SELECT * FROM forecast WHERE subcounty_id = '".$subcounty_id."' AND revenue_channel_id = '".$rev_id."'";
			$result = run_query($query);
			$num_rows =  get_num_rows($result);
			if($num_rows != 0){
				$rows = get_row_data($result);
				$target_amt = $rows['target_amount'];
				$amount = $target_amt * 91.3;
				echo "<td>Ksh. ".number_format($amount,2)."</td>";
			}else{
				echo "<td>0</td>";
			}
		}

	public function populateQuaterlyTargetAmountsForEachSubcounty($rev_id){
			$result = $this->getAllSubcounties();

			//loop all subcounties while populating the target amount
			while ($rows = get_row_data($result)) {
				//get target amounts for the respective subcounty
				$this->getQuaterlyTargetAmountForSubcounty($rows['sub_county_id'], $rev_id);
			}
		}

	public function populateQuaterlyTargetAmountsForEachRegion($rev_id){
			$result = $this->getAllRegions();

			//loop all subcounties while populating the target amount
			while ($rows = get_row_data($result)) {
				//get target amounts for the respective subcounty
				$this->getQuaterlyTargetAmountForRegion($rows['region_id'], $rev_id);
			}
		}

	public function getQuaterlyTargetAmountForRegion($region_id , $rev_id){
			$query = "SELECT * FROM forecast WHERE region_id = '".$region_id."' AND revenue_channel_id = '".$rev_id."'";
			$result = run_query($query);
			$num_rows =  get_num_rows($result);
			if($num_rows != 0){
				$rows = get_row_data($result);
				$target_amt = $rows['target_amount'];
				$amount = $target_amt * 91.3;
				echo "<td>Ksh. ".number_format($amount,2)."</td>";
			}else{
				echo "<td>0</td>";
			}
		}

	public function getSemiTargetAmountForSubcounty($subcounty_id, $rev_id){
			$query = "SELECT * FROM forecast WHERE subcounty_id = '".$subcounty_id."' AND revenue_channel_id = '".$rev_id."'";
			$result = run_query($query);
			$num_rows =  get_num_rows($result);
			if($num_rows != 0){
				$rows = get_row_data($result);
				$target_amt = $rows['target_amount'];
				$amount = $target_amt * 182.5;
				echo "<td>Ksh. ".number_format($amount,2)."</td>";
			}else{
				echo "<td>0</td>";
			}
		}

	public function populateSemiTargetAmountsForEachSubcounty($rev_id){
			$result = $this->getAllSubcounties();

			//loop all subcounties while populating the target amount
			while ($rows = get_row_data($result)) {
				//get target amounts for the respective subcounty
				$this->getSemiTargetAmountForSubcounty($rows['sub_county_id'], $rev_id);
			}
		}

	public function populateSemiTargetAmountsForEachRegion($rev_id){
			$result = $this->getAllRegions();

			//loop all subcounties while populating the target amount
			while ($rows = get_row_data($result)) {
				//get target amounts for the respective subcounty
				$this->getSemiTargetAmountForRegion($rows['region_id'], $rev_id);
			}
		}

	public function getSemiTargetAmountForRegion($region_id , $rev_id){
			$query = "SELECT * FROM forecast WHERE region_id = '".$region_id."' AND revenue_channel_id = '".$rev_id."'";
			$result = run_query($query);
			$num_rows =  get_num_rows($result);
			if($num_rows != 0){
				$rows = get_row_data($result);
				$target_amt = $rows['target_amount'];
				$amount = $target_amt * 182.5;
				echo "<td>Ksh. ".number_format($amount,2)."</td>";
			}else{
				echo "<td>0</td>";
			}
		}

	public function getAnnualTargetAmountForSubcounty($subcounty_id, $rev_id){
			$query = "SELECT * FROM forecast WHERE subcounty_id = '".$subcounty_id."' AND revenue_channel_id = '".$rev_id."'";
			$result = run_query($query);
			$num_rows =  get_num_rows($result);
			if($num_rows != 0){
				$rows = get_row_data($result);
				$target_amt = $rows['target_amount'];
				$amount = $target_amt * 365;
				echo "<td>Ksh. ".number_format($amount,2)."</td>";
			}else{
				echo "<td>0</td>";
			}
		}

	public function populateAnnualTargetAmountsForEachSubcounty($rev_id){
			$result = $this->getAllSubcounties();

			//loop all subcounties while populating the target amount
			while ($rows = get_row_data($result)) {
				//get target amounts for the respective subcounty
				$this->getAnnualTargetAmountForSubcounty($rows['sub_county_id'], $rev_id);
			}
		}

	public function populateAnnualTargetAmountsForEachRegion($rev_id){
			$result = $this->getAllRegions();

			//loop all subcounties while populating the target amount
			while ($rows = get_row_data($result)) {
				//get target amounts for the respective subcounty
				$this->getAnnualTargetAmountForRegion($rows['region_id'], $rev_id);
			}
		}

	public function getAnnualTargetAmountForRegion($region_id , $rev_id){
		$query = "SELECT * FROM forecast WHERE region_id = '".$region_id."' AND revenue_channel_id = '".$rev_id."'";
		$result = run_query($query);
		$num_rows =  get_num_rows($result);
		if($num_rows != 0){
			$rows = get_row_data($result);
			$target_amt = $rows['target_amount'];
			$amount = $target_amt * 365;
			echo "<td>Ksh. ".number_format($amount,2)."</td>";
		}else{
			echo "<td>0</td>";
		}
	}

	public function checkForExistingForecast($table, $column1, $value1, $column2, $value2){
      $check_query = "SELECT * FROM $table WHERE $column1 = '".$value1."' AND $column2 = '".$value2."'";
      // var_dump($check_query);exit;
	  $result = run_query($check_query);
	  $num_rows = get_num_rows($result);
	  if($num_rows >= 1){
	    return true;
	  }else{
	    return false;
	  }
    }

    public function getLeafOptions(){
    	$return = array();
    	$query = "SELECT service_channel_id, service_option, option_code FROM service_channels 
    	WHERE service_option_type = 'Leaf'";
    	if($result = run_query($query)){
    		if(get_num_rows($result)){
    			while ($rows = get_row_data($result)) {
    				$return[] = $rows;
    			}
    			return $return;
    		}
    	}
    }

    public function getServicePrice($service_id){
    	$query = "SELECT price FROM service_channels WHERE service_channel_id = '".$service_id."'";
    	if($result = run_query($query)){
    		if($get_num_rows($result)){
    			$rows = get_row_data($result);
    			return $rows['price'];
    		}
    	}
    }

    public function getCurrencySymbols(){
    	$data = $this->selectQuery('currency', '*');
		return $data;
	}

	public function getServiceBillName($service_bill_id){
		$rows = $this->selectQuery('revenue_service_bill', 'bill_name', "revenue_bill_id = '".$service_bill_id."'");
		return $rows[0]['bill_name'];
	}

		public function getServiceBillCode($service_bill_id){
			$rows = $this->selectQuery('revenue_service_bill', 'bill_code', "revenue_bill_id = '".$service_bill_id."'");
			return $rows[0]['bill_code'];
		}
}
?>






















