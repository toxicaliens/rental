<?php

	set_title('Delete Property');
	if(isset($_GET['id'])){
		$id = $_GET['id'];

		$delete_property = "DELETE FROM user_roles WHERE role_id = '$id'";
		if(run_query($delete_property)){
			header('location: ?num=all_roles');
		}else{
			echo 'There was an error';
		}
	}
	
?>