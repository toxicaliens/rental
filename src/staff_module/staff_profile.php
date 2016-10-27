<?php

set_layout("form-layout.php", array(
	'pageSubTitle' => 'PROFILE',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'#', 'text'=>'Home' ),
		array ( 'text'=>'Staff' ),
		array ( 'url'=>'index.php?num=701','text'=>'Staff Members' ),
		array ( 'text'=>'Staff Profile' )
	),
	'pageWidgetTitle' => 'STAFF MEMBER PROFILE'
));

$staff=$_GET['staff'];
if(isset($staff))
{
$query="SELECT * FROM ".DATABASE.".staff WHERE staff_id='$staff'";
$data=run_query($query);
$row=get_row_data($data);
}
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
		if (isset($department_id)) {
		$department_name=getDepartmentName($department_id);
		}
		$userLevelId=$row['userlevelid'];
		if (isset($department_id)) {
		$userLevelName=getUserLevelName($userLevelId);
		}
		
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
    <!--begin form-->
		<form enctype="multipart/form-data" class="form-horizontal">
			                       <div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label  class="control-label">DEPARTMENT:</label>
												<div class="controls">
													<b><?=$department_name; ?></b>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label class="control-label">USER LEVEL: </label>
												<div class="controls">
													<b><?=$userLevelName; ?></b>
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label  class="control-label">JOB NAME: </label>
												<div class="controls">
													<b><?=$job_name; ?></b>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label class="control-label">STAFF ID:</label>
												<div class="controls">
													<b><?=$staff_id; ?></b>
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label  class="control-label">ID/PASSPORT:</label>
												<div class="controls">
													<b><?=$id_passport; ?></b>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label class="control-label">FIRST NAME:</label>
												<div class="controls">
													<b><?=$first_name; ?></b>
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label  class="control-label">MIDDLE NAME: </label>
												<div class="controls">
													<b><?=$last_name; ?></b>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label class="control-label">SURNAME:</label>
												<div class="controls">
													<b><?=$surname; ?></b>
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label  class="control-label">GENDER:</label>
												<div class="controls">
													<b><?=$gender; ?></b>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label class="control-label">EMAIL:</label>
												<div class="controls">
													<b><?=$email; ?></b>
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label  class="control-label">PHONE NUMBER: </label>
												<div class="controls">
													<b><?=$phone_number; ?></b>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label class="control-label">STATUS:</label>
												<div class="controls">
													<b><?=($status==1)?"Active":"Inactive"; ?></b>
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label  class="control-label">USERNAME:</label>
												<div class="controls">
													<b><?=$username; ?></b>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label class="control-label">TOTAL DEDUCTION:</label>
												<div class="controls">
													<b><?=$tot_ded; ?></b>
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label  class="control-label">NET SALARY: </label>
												<div class="controls">
													<b><?=$net_pay; ?></b>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label class="control-label">LEAVE DAYS:</label>
												<div class="controls">
													<b><?=$leave_days; ?></b>
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label  class="control-label"></label>
												<div class="controls">
													
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label class="control-label">DETAILS:</label>
												<div class="controls">
													<b><?=$details; ?></b>
												</div>
											</div>
										</div>
									</div>
        </form>
    <!-- END FORM -->   
   
