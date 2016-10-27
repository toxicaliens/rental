<?php
	function checkWhetherOldPasswordExists($mf_id, $old_password){
		$pass_hash = sha1($old_password);
		$query = "SELECT * FROM user_login2 WHERE mf_id = '".$mf_id."' AND password = '".$pass_hash."'";
		$result = run_query($query);
		$num_rows = get_num_rows($result);
		if($num_rows){
			return true;
		}else{
			return false;
		}
	}
?>