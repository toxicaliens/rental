<?php
include_once('src/models/Masterfile.php');

class Transactions extends Masterfile{
	public static function filterTransactions($from, $to){
		if(!empty($from) && !empty($to)){
			return " AND transaction_date::date >= '".sanitizeVariable($from)."' AND transaction_date::date <= '".sanitizeVariable($to)."'";
		}
	}	

	public static function getFromAndToDates($daterange){
		if(!empty($daterange)){
			return explode(' - ', $daterange);
		}
	}
}