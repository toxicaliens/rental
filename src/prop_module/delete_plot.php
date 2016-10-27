<?php
	set_title('Delete Property');
	if(isset($_GET['id'])){
		$id = $_GET['id'];

		$delete_property = "DELETE FROM plots WHERE plot_id = '$id'";
		if(run_query($delete_property)){
			header('location: ?num=3000');
		}else{
			echo 'There was an error';
		}
	}
?>