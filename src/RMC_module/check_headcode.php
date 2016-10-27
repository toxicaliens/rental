<?php

 require '../connection/config.php';
if(isSet($_POST['$head_code_name'])){
	$head_code_name= $_POST['$head_code_name'];

	$sql_check=run_query("SELECT head_code_name FROM ifmis_headcodes WHERE head_code_name='".$head_code_name."'");

	if(num_rows($sql_check)){
		echo '<font color="red"> The Entry (<strong>'.$head_code_name.'</strong>) is already in use. Try another!</font>';
	    }
	    else
	    {
	    	echo 'OK'
	    }
}

?>