<?php
set_title('General Audit Trail');
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'General Audit Trail',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'User Management' ),
		array ( 'text'=>'General Audit Trail' )
	)
	
));

if(isset($_SESSION['del'])){ echo $_SESSION['del']; unset($_SESSION['del']); }
?>
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			<tr>
			  	<th>#</th>
			  	<th>ACTION NAME</th>
			  	<th>ACTION TIME</th>
			  	<th>SESSION ID</th>
			  	<th>USER NAME</th>
			  </tr>
 		</thead>
 	<tbody>
 <?php

   $distinctQuery = "SELECT a.*, l.*, u.* FROM audit_trail a
				LEFT JOIN login_sessions l ON a.session_id = l.login_session_id
				LEFT JOIN user_login2 u ON a.mf_id = u.mf_id";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
   
    $con = 1;     
    $total = 0;   
    $counter = 1;  
    while($row = get_row_data($resultId)){
        $action_name = $row['case_name'];
		$action_time = $row['datetime'];
		$session_id = $row['session_id']; 
		$user_name = $row['username'];
	?>
<tr>             
	<td><?=$counter; ?></td>
    <td><?=$action_name; ?></td>
    <td><?=$action_time; ?></td>          
	<td><?=$session_id; ?></td>
	<td><?=$user_name; ?></td>
<?php
 		$counter++;
	}
	   
	?>
  
  </tbody>
</table>

