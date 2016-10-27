<?php
	require '../connection/config.php';
	if(isset($_POST['head_code_id'])){
		$head_code_id = $_POST['head_code_id'];

		$query="SELECT h.*, s.* FROM ifmis_headcodes h
             LEFT JOIN ifmis_subcodes s ON h.head_code_id=s.head_code_id
             WHERE h.head_code_id='".$head_code_id."'";
		$result = pg_query($query);
		while($row = pg_fetch_assoc($result)){
			$subcode_name = $row['subcode_name'];
			$subcode_id = $row['subcode_id'];

			echo "<option value=\"$subcode_id\">$subcode_name</option>";
		}
	}

?>



