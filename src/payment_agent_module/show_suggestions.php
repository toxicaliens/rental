<?php
	require '../connection/config.php';
		$str = '';
		$query = "SELECT * FROM masterfile";
		$result = pg_query($query);
		echo "[";
		while($row = pg_fetch_assoc($result)){
			$full_name = $row['surname'].' '.$row['firstname'].' '.$row['middlename'];
			$mf_id = $row['mf_id'];

			$str .= "\"$full_name, $mf_id\",";
		}
		
		echo rtrim($str, ",");
		echo "]";
?>