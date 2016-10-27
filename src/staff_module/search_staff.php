<?php
//row to be deleted
$stuff=$_GET['staff'];
if (isset($stuff))
{
//delete the row
$delete_staffs="DELETE FROM ".DATABASE.".staff WHERE staff_id='$stuff'";
$delete_staff=run_query($delete_staffs);
if ($delete_staff)
    {
      echo "<p><font color='#006600'>The Item has been deleted</font></p>";
    }
}


?>
<?
 	if (!empty($_POST['search_item'])){
		$search = $_POST['search_item'];
		$distinctQuery2 = "select count(staff_id) as total_staff from ".DATABASE.".staff WHERE 

					 surname LIKE '%$search%' 
					OR	first_name LIKE '%$search%'
					OR	last_name LIKE '%$search%'
					OR	username LIKE '%$search%'
                        
					";
		$resultId2 = run_query($distinctQuery2);	
		$arraa = get_row_data($resultId2);
		$total_rows2 = $arraa['total_staff'];
	}

	if (!empty($_POST['search_item'])){
                        $search =$_POST['search_item'];
			$distinctQuery = "SELECT * FROM staff WHERE
						surname LIKE '%$search%' 
					OR	first_name LIKE '%$search%'
					OR	last_name LIKE '%$search%'
					OR	username LIKE '%$search%'
                      
						ORDER BY staff_id DESC";
			 $resultId = run_query($distinctQuery);
		}

/**
 * Set page layout
 */
set_layout("dt-layout.php");
?>
		<!-- BEGIN PAGE -->  
		<div class="span12">
				<div class="row-fluid">
				<!-- BEGIN PAGE TITLE -->
				<h3 class="page-title">
					Search for Staff Members
					<small></small>
				</h3>
				<!-- END PAGE TITLE -->

				<!-- BEGIN BREADCRUMBS -->
<?php

/***
 * Using template function to display the breadcrumb
 */
set_breadcrumbs( array (
	array ( 'url'=>'index.php', 'text'=>'Home' ),
	array ( 'text'=>'Staff' ),
	array ( 'text'=>'Search Staff' )
));
?>
				<!-- END BREADCRUMBS -->
				

				<!-- BEGIN PAGE CONTENT -->
				<div class="row-fluid">
					<div class="span12">
						<div class="row-fluid">
							<div class="widget">
								<div class="widget-title"><h4>Search Parameters</h4></div>
								<div class="widget-body form">
									<form name="staff_member" method="post" action="" class="form-horizontal">
										<div class="control-group">
											<label for="staff_id" class="control-label">Search String</label>
											<div class="controls">
												<input name="search_item" type="text" id="search_item" size="50" />
												<span class="help-block">Enter Surname/First Name/Last Name/Username:</span>
											</div>
										</div>
										
										<input name="action" type="hidden" class="header_del_sub" id="action" value="showStaffMember" />
										
										<div class="form-actions">
											<button class="btn btn-primary" type="submit">Search</button>
											<button class="btn" type="reset">Reset</button>
										</div>
									</form>
								</div>
							</div>
<?php if (!empty($resultId)){?>
	                       <div class="widget">
								<div class="widget-title"><h4>Search Results</h4></div>
								<div class="widget-body form">
									<table id="table1" class="table table-bordered">
										<thead>
											<tr class="table_fields">
												<th>STAFF ID</th>
			                                    <th>SURNAME</th>
 			                                    <th>JOB </th>
                                                <th>DEPARTMENT </th>
                                                <th>USER LEVEL </th>
 			                                    <th>PHONE </th>
  			                                    <th>EMAIL</th>
 		   	                                    <th>EDIT</th>
			                                    <th>REMOVE</th>
			                                    <th>PROFILE</th>
											</tr>
										</thead>
										<tbody> 
 <?
		$con = 1;
		$total = 0;
		while($row = get_row_data($resultId))
		{
		$staff_id=$row['staff_id'];
		$job_id=$row['job_id'];
		if (isset($job_id))
		{
		$job_name=getJobName($job_id);
		}

		$gender=$row['gender'];
		$email=$row['email'];
		$phone_number=$row['phone_number'];
		$surname=$row['surname'];
		$last_name=$row['last_name'];
		$department_id=$row['department_id'];
		if (isset($department_id))
		{
		$department_name=getDepartmentName($department_id);
		}
	
		$userLevelId=$row['userlevelid'];
		if(isset($userLevelId)) {
		$userLevelName=getUserLevelName($userLevelId);
		}
		$active=$row['active'];
		$id_passport=$row['id_passport'];
		$leave_days=$row['leave_days'];
		$details=$row['details'];
		$first_name=$row['first_name'];
		$username=$row['username'];
		$status=$row['status'];
		$tot_earn=$row['tot_earn'];
		$tot_ded=$row['tot_ded'];
		$net_pay=$row['net_pay'];
 ?>
	                                        <tr>
												<td><?=$staff_id; ?></td>
                                                <td><?=$surname; ?></td>
		                                        <td><?=$job_name; ?></td>
                                                <td><?=$department_name; ?></td>
	                                            <td><?=$userLevelName; ?> </td>	
		                                        <td><?=$phone_number; ?></td>
		                                        <td><?=$email; ?></td>		
												<td><a id="edit_link" href="index.php?num=702&staff=<?=$staff_id; ?>">EDIT</a></td>
		                                        <td><a id="delete_link" href="index.php?num=701&staff=<?=$staff_id; ?>" onclick="return confirm('Are you sure you want to delete?')">Remove</a></td>
		                                        <td><a id="edit_link" href="index.php?num=705&staff=<?=$staff_id; ?>">PROFILE</a></td>
											</tr>
											</tr>
<?
		$total++;
	} /* End of while loop */
	
	// If there were no records to show
	if ( $total == 0 ) {
?>
											<tr>
												<td colspan="10" align="center">No User Found with data <span style="color:red;"><?=$_POST['search_item']?></span></td>
<?php }?>
										<tbody>
									</table> <div class="clearfix"></div>
								</div>
							</div>
<?php
} /* End of showing searched results */
?>

						</div>
					</div>
				</div>
				<!-- END PAGE CONTENT -->
				
			</div>
		</div>
		<!-- END PAGE --> 
