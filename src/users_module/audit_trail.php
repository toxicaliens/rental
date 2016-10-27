<table id="table1" class="table table-condensed table-hover">
	<thead>
		<tr>
			<th>#</th>
			<th>Action Name</th>
			<th>Action Time</th>
			<th>Session Id</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$query = "SELECT a.*, l.*, u.* FROM audit_trail a
				LEFT JOIN login_sessions l ON a.session_id = l.login_session_id
				LEFT JOIN user_login2 u ON a.mf_id = u.mf_id
				WHERE a.mf_id = '".$_SESSION['mf_id']."';
			";
			$result = run_query($query);
			$counter = 1;
			while($row = get_row_data($result)){
				$action_name = $row['case_name'];
				$action_time = $row['datetime'];
				$session_id = $row['session_id'];

				echo "<tr>
					<td>$counter</td>
					<td>$action_name</td>
					<td>$action_time</td>
					<td>$session_id</td>
				</tr>";
				$counter++;
			}
		?>
	</tbody>
</table>