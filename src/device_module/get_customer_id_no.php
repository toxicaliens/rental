<?php
	include '../connection/config.php';

	if(!empty($_POST['mf_id'])){
		$id_no = getCustomerIdNo($_POST['mf_id']);

		$query = "SELECT r.*, CONCAT(surname,' ',firstname,' ',middlename) AS referee_name FROM referrals r
		LEFT JOIN masterfile m ON m.mf_id = r.referee_mf_id
		WHERE referral_id_no = '".$id_no."'";
		$result = pg_query($query);
		$rows = pg_fetch_assoc($result);
		echo json_encode($rows);
	}

	function getCustomerIdNo($mf_id){
		$query = "SELECT id_passport FROM masterfile WHERE mf_id = '".$mf_id."'";
		$result = pg_query($query);
		$rows = pg_fetch_assoc($result);
		return $rows['id_passport'];
	}
?>