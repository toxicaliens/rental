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
		$this->from_timestamp = strtotime($this->from_date);
		$this->to_timestamp = strtotime($this->to_date);
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

	public function countAgentsType($table, $key){
		$query = "SELECT DISTINCT($key) FROM $table WHERE $key IS NOT NULL";
		return $count = $this->getCount($query);
	}
}
?>