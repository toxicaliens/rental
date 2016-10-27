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

	public function countActiveContractors($table, $condition){
		$query = "SELECT * FROM $table WHERE (regdate_stamp >= '".$this->from_timestamp."' AND regdate_stamp <= '".$this->to_timestamp."') AND b_role = '$condition'";
		return $count = $this->getCount($query);
	}

	public function myPropertyManagers($table){
		$query = "SELECT * FROM $table WHERE created_by  = '".$_SESSION['mf_id']."' ";
		return $count = $this->getCount($query);
	}

	public function countNoLandlords($table){
		$query = "SELECT * FROM $table WHERE created_by = '".$_SESSION['mf_id']."' ";
		return $count = $this->getCount($query);
	}

	public function countTotalNoTenants($table){
		$query = "SELECT * FROM $table WHERE b_role = 'tenant' AND created_by = '".$_SESSION['mf_id']."' ";
		return $count = $this->getCount($query);
	}

	public function countReferalRecords($table){
		$query = "SELECT * FROM $table WHERE pm_mfid = '".$_SESSION['mf_id']."' ";
		return $count = $this->getCount($query);
	}

	public function countBillRecords($table){
		$query = "SELECT * FROM $table ";
		return $count = $this->getCount($query);
	}
}
