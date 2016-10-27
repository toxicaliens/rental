<?php
include_once('src/models/Masterfile.php');

class Bills extends Masterfile{
	public static function filterBills($from, $to){
		if(!empty($from) && !empty($to)){
			return " AND bill_date >= '".sanitizeVariable($from)."' AND bill_date <= '".sanitizeVariable($to)."'";
		}
	}	

	public static function getFromAndToDates($daterange){
		if(!empty($daterange)){
			return explode(' - ', $daterange);
		}
	}
}