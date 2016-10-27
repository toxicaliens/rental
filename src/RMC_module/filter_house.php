<?php
	require '../connection/config.php';
	if(isset($_POST['plot_id'])){
		$plot_id = $_POST['plot_id'];

		$query="SELECT * FROM houses_and_plots 
             WHERE plot_id='".$plot_id."'";
		$result = pg_query($query);
		while($row = pg_fetch_assoc($result)){
			$house_number = $row['house_number'];
			$house_id = $row['house_id'];

			echo "<option value=\"$house_id\">$house_number</option>";
		}
	}

?>



