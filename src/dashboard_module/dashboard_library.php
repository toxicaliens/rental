<?php

class DashboardStats{
	private $timestamp;
	private $date_time;
	private $last_month;
	private $from_timestamp;
	private $to_timestamp;
	private $from_date;
	private $to_date;

	public function DashboardStats($from_date,$to_date){
		$this->from_date = $from_date;
		$this->to_date = $to_date;

		$this->generateTimestamps();

	}

	private function generateTimestamps(){
		$this->from_timestamp = date($this->from_date);
		$this->to_timestamp = date($this->to_date);
	}

	public function getCount($query){
		$result = run_query($query);
		$num_rows = get_num_rows($result);
		return $num_rows;
	}

	public function countRecords($table){
		$query = "SELECT * FROM $table WHERE date_started >= '".$this->from_timestamp."' AND date_started <= '".$this->to_timestamp."'";
		return $count = $this->getCount($query);
	}

	public function countPendingBillsRecords($table, $condition){
		$query = "SELECT * FROM $table WHERE (bill_date >= '".$this->from_date."' AND bill_date <= '".$this->to_date."') AND bill_status = '".$condition."'";
		return $count = $this->getCount($query);
	}

	public function countCustomerRecords($table, $condition){
		$query = "SELECT * FROM $table WHERE (regdate_stamp >= '".$this->from_timestamp."' AND regdate_stamp <= '".$this->to_timestamp."') AND b_role = '$condition'";
		return $count = $this->getCount($query);
	}

	public function countActiveCustomerRecords($table, $condition){
		$query = "SELECT * FROM $table WHERE status = '$condition'";
		return $count = $this->getCount($query);
	}

	public function countOpenTicketsRecords($table, $condition){
		$query = "SELECT * FROM $table WHERE (reported_time >= '".$this->from_timestamp."' AND reported_time <= '".$this->to_timestamp."') AND status = '$condition'";
		return $count = $this->getCount($query);
	}

	public function countActiveInsuranceRecords($table, $condition){
		$query = "SELECT * FROM $table WHERE (start_date >= '".$this->from_timestamp."' AND start_date <= '".$this->to_timestamp."') AND status = '$condition'";
		return $count = $this->getCount($query);
	}

	public function countReferalRecords($table){
		$query = "SELECT * FROM $table";
		return $count = $this->getCount($query);
	}

	public function countBillRecords($table){
		$query = "SELECT * FROM $table ";
		return $count = $this->getCount($query);
	}
}
?>