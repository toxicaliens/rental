<?php
include_once('src/models/Masterfile.php');

class BillingFiles extends Masterfile{
	public function filterBillingFiles($from, $to){
		if(!empty($from) && !empty($to)){
			return " AND start_date >= '".sanitizeVariable($from)."' AND start_date <= '".sanitizeVariable($to)."'";
		}
	}	

	public function getFromAndToDates($daterange){
		if(!empty($daterange)){
			return explode(' - ', $daterange);
		}
	}
}