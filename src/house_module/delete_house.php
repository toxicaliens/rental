<?php
	set_title('Delete House');
	if(isset($_GET['house'])){
		$house = $_GET['house'];

		echo $delete_house = "DELETE FROM houses WHERE house_id = '$house'";
		if(run_query($delete_house)){
			header('location: ?num=all_houses');
		}else{
			echo 'There was an error';
		}
	}
?>