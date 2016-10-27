<?php
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Edit Staff Details...',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'../oriems-live/', 'text'=>'Home' ),
		array ( 'text'=>'Staff' ),
		array ( 'url'=>'index.php?num=701','text'=>'Staff Members' ),
		array ( 'text'=>'Edit Staff' )
	),
	'pageWidgetTitle'=>'EDIT STAFF DETAIL'
));
if(isset($_SESSION['done-edit'])){
    echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['done-edit']."</p>";
    unset($_SESSION['done-deal']);
}

if($_POST['action'] == "edit_staff")
{
	//echo "<div>12321321</div>";
		//values of the staff to be updated
		$staffs_id=$_POST['staff_id'];
		$job_id=$_POST['job_id'];
		$gender=$_POST['gender'];
		$email=$_POST['email'];
		$status=$_POST['status'];
		$department_id=$_POST['department_id'];
		$phone_number=$_POST['phone_number'];
		$surname=$_POST['surname'];
		$userLevelId=$_POST['userlevelid'];
		$first_name=$_POST['first_name'];
		$last_name=$_POST['last_name'];
		$tot_earn=$_POST['tot_earn'];
		$username=$_POST['username'];
		$details=$_POST['details'];
		$id_passport=$_POST['id_passport'];
		$net_pay=$_POST['net_pay'];
		//$month=strtoupper($_POST['month']);
		$leave_days=$_POST['leave_days'];
		$net_pay=$_POST['net_pay'];
      		$tot_earn=$_POST['tot_earn'];
		$tot_ded=$_POST['tot_ded'];
		
		//check for correct input of entries
		if (empty($job_id))
		{
		$message="You did not enter the job Name";
		}
		
		elseif (empty($gender))
		{
		$message="You did not enter the gender.";
		}
		elseif(empty($email))
		{
		$message="You did not enter the email address";
		}
		elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email))
		{

		$message="The email is invalid";
		}
		elseif (!isset($status))
		{
		$message="You did not enter the status";
		}
		elseif (empty($department_id))
		{
		$message="You did not enter the department ";
		}
		elseif (empty($phone_number))
		{
		$message="You did not enter the phone Number";
		}
		elseif(strlen($phone_number)>14 || strlen($phone_number)<10)
		{
		$message="The phone number is invalid";
		}
		elseif (empty($surname))
		{
		$message="You did not enter the surname";
		}
		elseif (empty($userLevelId))
		{
		$message="You did not enter the User Level ";
		}
		
		elseif (empty($first_name))
		{
		$message="You did not enter the first name";
		}
		
		/*elseif (empty($tot_earn))
		{
		$message="Please indicate you total earning";
		}*/
		
		elseif (empty($username))
		{
		$message="You did not enter your username";
		}
		
		elseif (empty($details))
		{
		$message="You did not enter the details";
		}
		elseif (empty($id_passport))
		{
		$message="You did not enter the ID/Passport";
		}
		elseif(strlen($id_passport)>8 || strlen($id_passport)<6)
		{
		$message="The Id number/passport  is invalid";
		}

		/*elseif (empty($net_pay))
		{
		$message="You did not enter the net pay";
		}*/
		/*elseif (empty($month))
		{
		$message="You did not enter the month";
		}*/
		/*elseif (empty($leave_days))
		{
		$message="You did not enter the leave days";
		}
		
		elseif($ld>5)
			{
			$message="You number of leave days should not be more than a five characters";
			}*/
		else {
		//update the staff member
	 	$edit_staff="UPDATE ".DATABASE.".staff SET job_id='$job_id',
	         gender='$gender',email='$email',department_id='$department_id'
		,phone_number='$phone_number',status='$status',surname='$surname',userlevelid='$userLevelId'
		,first_name='$first_name',last_name='$last_name',tot_earn='$tot_earn',tot_ded='$tot_ded',username='$username',details='$details',id_passport='$id_passport',net_pay='$net_pay',leave_days='$leave_days'
		WHERE staff_id='$staffs_id'";
		$message = $edit_staff;
		$edit_staf=run_query($edit_staff);
		}
		if ($edit_staff)
		{
		$message="You updated the staff member information";
		}
		
}
elseif($_POST['action'] == "reset_password")
{
	$staff_id=$_POST['staff_id'];
		$password=md5("123456");
		$reset_pwd="UPDATE ".DATABASE.".staff SET password='$password' WHERE staff_id='$staff_id'";
		$rst=run_query($reset_pwd);
		if($rst)
		{
		$message="The password has been reset";
		}

}

//get the value
 $staff=$_GET['staff'];

//get the row
if(isset($staff))
{
$query="SELECT * FROM ".DATABASE.".staff WHERE staff_id='$staff'";
$data=run_query($query);
$total_rows=get_num_rows($data);

}
$con=1;
$total=0;

$row=get_row_data($data);

        //the values
                $job_id=$row['job_id'];
		$gender=$row['gender'];
		$email=$row['email'];
		$phone_number=$row['phone_number'];
		$surname=$row['surname'];
		$last_name=$row['last_name'];
		$department_id=$row['department_id'];
		$userlevelid=$row['userlevelid'];
		$status=$row['status'];
		$id_passport=$row['id_passport'];
		$leave_days=$row['leave_days'];
		$staff_id=$row['staff_id'];
		$first_name=$row['first_name'];
		$net_pay=$row['net_pay'];
		$tot_earn=$row['tot_earn'];
		$tot_ded=$row['tot_ded'];
		$username=$row['username'];
		$leave_days=$row['leave_days'];
		$details=$row['details'];
		$month=$row['month'];
	   
?>
<div><? echo $processed ." || " .$message; ?></div>
    <!--begin form-->
		<form action="" id="edit_staff" method="post"  enctype="multipart/form-data" name="edit_staff" class="form-horizontal">
			                       <div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="staff_id" class="control-label">STAFF ID:</label>
												<div class="controls">
													<input type="text" name="staff_id" value="<?=$staff; ?>"  readonly style="background-color: #ccc"  />
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="first_name" class="control-label">FIRST NAME:</label>
												<div class="controls">
													<input type="text" name="first_name" value="<?=$first_name; ?>"/>
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="id_passport" class="control-label">ID/PASSPORT:</label>
												<div class="controls">
													<input type="text" name="id_passport" value="<?=$id_passport; ?>"/>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="last_name" class="control-label">MIDDLE NAME:</label>
												<div class="controls">
													<input type="text" name="last_name"  value="<?=$last_name; ?>"/>
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="surname" class="control-label">SURNAME:</label>
												<div class="controls">
													<input type="text" name="surname" value="<?=$surname; ?>">
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="email" class="control-label">EMAIL:</label>
												<div class="controls">
													<input type="text" name="email" value="<?=$email; ?>"/>
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="phone_number" class="control-label">PHONE NUMBER:</label>
												<div class="controls">
													<input type="text" name="phone_number" value="<?=$phone_number; ?>"/>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="gender" class="control-label">GENDER:</label>
												<div class="controls">
													<select name="gender" required>
														<option>Male</option>
														<option>Female</option>
													</select>
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="department_id" class="control-label">DEPARTMENT:</label>
												<div class="controls">
													<select name="department_id">
<?=get_select_with_selected('departments','department_id','department_name',$department_id)?>
					                                </select>
												</div>
											</div>
										</div>

										<div class="span6">
											<div class="control-group">
												<label for="userlevelid" class="control-label">USER LEVEL:</label>
												<div class="controls">
													<select name="userlevelid">
<?=get_select_with_selected('userlevels','userlevelid','userlevelname',$userlevelid)?>
                                                    </select>															
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="job_id" class="control-label">JOB :</label>
												<div class="controls">
													<select name="job_id">
<?=get_select_with_selected('jobs','job_id','job_name',$job_id)?>
					                                </select>
												</div>
											</div>
										</div>

										<div class="span6">
											<div class="control-group">
												<label for="status" class="control-label">Status</label>
												<div class="controls">
													 <select name="status">
														<option <?if($row['status']==1){?>selected="selected"<?}?> value="TRUE">Active</option>
                                                        <option <?if($row['status']==0){?>selected="selected"<?}?> value="FALSE">Inactive</option>
													</select>
												</div>
											</div>
										</div> 

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="username" class="control-label">USERNAME:</label>
												<div class="controls">
													<input type="text" name="username" value="<?=$username; ?>"/>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="net_pay" class="control-label">NET PAY:</label>
												<div class="controls">
													<input type="text" name="net_pay" value="<?=$net_pay; ?>"/>
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="tot_ded" class="control-label">TOTAL DEDUCTIONS:</label>
												<div class="controls">
													<input type="text" name="tot_ded" value="<?=$tot_ded; ?>"/>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="tot_earn" class="control-label">TOTAL EARNING:</label>
												<div class="controls">
													<input type="text" name="tot_earn" value="<?=$tot_earn; ?>"/>
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="leave_days" class="control-label">LEAVE DAYS:</label>
												<div class="controls">
												    <input type="text" name="leave_days" value="<?=$leave_days; ?>"/>	    
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="details" class="control-label">DETAILS:</label>
												<div class="controls">
													<textarea name="details">
				                                        <?=$details; ?>
				                                    </textarea>
												</div>
											</div>
										</div>
									</div>	
									<div class="form-actions">
										<input type="hidden" name="action" value="edit_staff"/>
				                        <input type="submit" button class="btn btn-primary" name="submit" value="SAVE"/> 
									</div>
		</form>
	<!-- END FORM -->

    <div id="edit_staff_errorloc" class="error_strings">
            </div>

<!---->
<script language="JavaScript" type="text/javascript"
    xml:space="preserve">//<![CDATA[
//You should create the validator only after the definition of the HTML form
  var frmvalidator  = new Validator("edit_staff");
 frmvalidator.EnableOnPageErrorDisplaySingleBox();
 frmvalidator.EnableMsgsTogether();

// frmvalidator.addValidation("net_pay","maxlen=50");
//  frmvalidator.addValidation("net_pay","req");
 
 frmvalidator.addValidation("department_id","req");

//frmvalidator.addValidation("tot_earn","req");

frmvalidator.addValidation("status","req");
//frmvalidator.addValidation("tot_ded","req");

frmvalidator.addValidation("username","req");

//frmvalidator.addValidation("leave_days","req");

//frmvalidator.addValidation("details","req");

 frmvalidator.addValidation("first_name","req","Please enter your First Name");
  frmvalidator.addValidation("first_name","maxlen=20",	"Max length for FirstName is 20");
  frmvalidator.addValidation("first_name","alpha_s","Name can contain alphabetic chars only");

 
 // frmvalidator.addValidation("last_name","maxlen=20",	"Max length for Middle Name is 20");
 // frmvalidator.addValidation("last_name","alpha_s","Name can contain alphabetic chars only");


 frmvalidator.addValidation("surname","req","Please enter your surname");
  frmvalidator.addValidation("surname","maxlen=20","Max length for surname is 20");
  frmvalidator.addValidation("surname","alpha_s","surname can contain alphabetic chars only");
  
  frmvalidator.addValidation("month","req","Please enter the month");
  frmvalidator.addValidation("month","maxlen=20","For month, Max length is 20");

frmvalidator.addValidation("userlevelid","req");
  
  frmvalidator.addValidation("email","maxlen=50");
  frmvalidator.addValidation("email","req");
  frmvalidator.addValidation("email","email");
  
  frmvalidator.addValidation("phone_number","maxlen=14");
  frmvalidator.addValidation("phone_number","req");

frmvalidator.addValidation("id_passport","maxlen=8");
  frmvalidator.addValidation("id_passport","req");
  
  frmvalidator.addValidation("Address","maxlen=50");
  frmvalidator.addValidation("Country","dontselect=0");
  
    function DoCustomValidation()
    {
        var frm = document.forms["edit_staff"];
        if(frm.FirstName.value == 'Null')
        {
            sfm_show_error_msg("Null, you can't submit this form. Go away! ");
            return false;
        }
        else
        {
            return true;
        }
    }
	
  frmvalidator.setAddnlValidationFunction(DoCustomValidation);
//]]></script>
<!---->
    <!--begin form-->
		<form action="" method="POST" >
			                       <div class="row-fluid">
										<div class="span12">
											<div class="form-actions">
													<input type="hidden" name="staff_id" value="<?=$staff; ?>"/>
                                                    <input type="text" name="password" readonly="readonly" value="123456"/>
                                                    <input type="hidden" name="action" value="reset_password"/>
				                                    <input type="submit" value="Reset Password" style="width:140px"/>		          
											</div>
										</div>
									</div>
										
		</form>
    <!-- END FORM -->
 
