<?php
if(isset($_GET['mf_id'])){
	$mf_id = $_GET['mf_id'];

	$result = run_query("SELECT surname, firstname, middlename FROM masterfile WHERE mf_id = '".$mf_id."'");
	$row = get_row_data($result);
}

set_layout("form-layout.php", array(
	'pageSubTitle' => 'Edit Staff Details...',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'../oriems-live/', 'text'=>'Home' ),
		array ( 'text'=>'Staff' ),
		array ( 'url'=>'index.php?num=701','text'=>'Staff Members' ),
		array ( 'text'=>'Edit Staff' )
	),
	'pageWidgetTitle'=>'STAFF NAME: '.$row['surname'].' '.$row['firstname'].' '.$row['middlename']
));
if(isset($_SESSION['done-edit'])){
    echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['done-edit']."</p>";
    unset($_SESSION['done-edit']);
}

//get the value


//get the row
if(isset($_GET['mf_id']))
{
	$mf_id=$_GET['mf_id'];
$query="SELECT * FROM ".DATABASE.".staff WHERE mf_id='$mf_id'";
$data=run_query($query);
$total_rows=get_num_rows($data);

}
$con=1;
$total=0;

$row=get_row_data($data);
//the values
// $job_id=$row['job_id'];
$email=$row['email'];
$phone_number=$row['phone_number'];
$department_id=$row['department_id'];
$userlevelid=$row['userlevelid'];
$status=$row['status'];
$id_passport=$row['id_passport'];
$leave_days=$row['leave_days'];
$mf_id=$row['mf_id'];
$net_pay=$row['net_pay'];
$tot_earn=$row['tot_earn'];
$tot_ded=$row['tot_ded'];
$username=$row['username'];
$leave_days=$row['leave_days'];
$details=$row['details'];
$month=$row['month'];
$job_code=$row['job_code'];
	   
?>
    <!--begin form-->
		<form action="" id="edit_staff" method="post"  enctype="multipart/form-data" name="edit_staff" class="form-horizontal">
			                       <div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="mf_id" class="control-label">MF ID:</label>
												<div class="controls">
													<input type="text" name="mf_id" value="<?php if(isset($_GET['mf_id'])) echo $_GET['mf_id']; ?>"  readonly style="background-color: #ccc"  />
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
													<input type="number" minlength="10" maxlength="15" name="phone_number" value="<?=$phone_number; ?>" required/>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="username" class="control-label">USERNAME:</label>
												<div class="controls">
													<input type="text" name="username" value="<?=$username; ?>" readonly/>
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="department_id" class="control-label">DEPARTMENT:</label>
												<div class="controls">
													<select name="department_id" id="department_id" required>
														<!-- <option value="">--Choose Department--</option> -->
<?=get_select_with_selected('departments','department_id','department_name',$department_id)?>
					                                </select>
												</div>
											</div>
										</div>

										<div class="span6">
											<div class="control-group">
												<label for="userlevelid" class="control-label">USER LEVEL:</label>
												<div class="controls">
													<select name="userlevelid" required readonly>
<?=get_select_with_selected('user_roles','role_id','role_name',$userlevelid)?>
                                                    </select>															
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="job_options" class="control-label">JOB :</label>
												<div class="controls">
												<select name="job_id" id="job_options" required>
												<?=get_select_with_selected('jobs', 'job_code', 'job_name', $job_code); ?>
				                                </select>
												</div>
											</div>
										</div>

										<div class="span6">
											<div class="control-group">
												<label for="active" class="control-label">Status</label>
												<div class="controls">
													 <select name="status" required>
														<option <?if($row['active']==1){?>selected="selected"<?}?> value="TRUE">Active</option>
                                                        <option <?if($row['active']==0){?>selected="selected"<?}?> value="FALSE">Inactive</option>
													</select>
												</div>
											</div>
										</div> 

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="details" class="control-label">DETAILS:</label>
												<div class="controls">
													<textarea name="details">
				                                        <?=trim($details); ?>
				                                    </textarea>
												</div>
											</div>
										</div>
									</div>	
									<div class="form-actions">
										<input type="hidden" name="action" value="edit_staff"/>
				                       <?php ViewActions($_GET['num'], $_SESSION['role_id']); ?> 
									</div>
		</form>
	<!-- END FORM -->

    <div id="edit_staff_errorloc" class="error_strings">
            </div>

<!---->
<?php set_js(array("src/js/delete.js")); ?>
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
<?php set_js(array("src/js/filter_jobs.js")); ?>