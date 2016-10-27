<?

set_layout("form-layout.php", array(
	'pageSubTitle' => 'Add New Staff',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'#', 'text'=>'Home' ),
		array ( 'text'=>'Staff' ),
		array ( 'text'=>'Add Staff' )
	),
	'pageWidgetTitle'=>'ADD A MEMBER OF STAFF'
));
if(isset($_SESSION['done-deal'])){
    echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['done-deal']."</p>";
    unset($_SESSION['done-deal']);
}
?>
	<!--begin form-->
		<form id="add_staff" action="" method="post"  enctype="multipart/form-data" class="form-horizontal">
			                        <div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="staff_id" class="control-label">STAFF ID:</label>
												<div class="controls">
													<input type="number" name="staff_id" id="staff_id" maxlength="10" x-moz-errormessage="Staff ID should be a number" required/>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="first_name" class="control-label">FIRST NAME:</label>
												<div class="controls">
													<input type="text" name="first_name" id="first_name" required/>
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="id_passport" class="control-label">ID/PASSPORT:</label>
												<div class="controls">
													<input type="text" name="id_passport" id="id_passport" required/>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="last_name" class="control-label">MIDDLE NAME:</label>
												<div class="controls">
													<input type="text" name="last_name" id="last_name" required/>
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="surname" class="control-label">SURNAME:</label>
												<div class="controls">
													<input type="text" name="surname" id="surname" required/>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="email" class="control-label">EMAIL:</label>
												<div class="controls">
													<input type="email" name="email" required/>
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="phone_number" class="control-label">PHONE NUMBER:</label>
												<div class="controls">
													<input type="text" name="phone_number" id="phone_number" required/>
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
													<select name="department_id" id="department_id" required><?php
$department_id=run_query("select * from departments Order by department_name");
					 while ($fetch=get_row_data($department_id))
					 {
					 echo "<option value='".$fetch['department_id']."'>".$fetch['department_name']."</option>";
					 }
					 ?></select>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="userlevelid" class="control-label">USER LEVEL:</label>
												<div class="controls">
													<select name="userlevelid" id="userlevelid" required><?php
$userlevelid=run_query("select * from userlevels Order by userlevelname");
					 while ($fetch=get_row_data($userlevelid))
					 {
					 echo "<option value='".$fetch['userlevelid']."'>".$fetch['userlevelname']."</option>";
					 }
					 ?></select>															
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="job_id" class="control-label">JOB :</label>
												<div class="controls">
													<select name="job_id" id="job_id" required><?php
$jobers=run_query("select * from jobs Order by job_name");
					 while ($fetch=get_row_data($jobers))
					 {
					 echo "<option value='".$fetch['job_id']."'>".$fetch['job_name']."</option>";
					 }
					 ?></select>
												</div>
											</div>
										</div>

										<div class="span6">
											<div class="control-group">
												<label for="status" class="control-label">Status</label>
												<div class="controls">
													<select name="status" required>
														<option value="True">Active</option>
														<option value="False">Inactive</option>
													</select>
												</div>
											</div>
										</div> 

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="username" class="control-label">USERNAME:</label>
												<div class="controls">
													<input type="text" name="username" id="username" required/>
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="password" class="control-label">PASSWORD:</label>
												<div class="controls">
													<input type="password" name="password" value="123456" required/>
												</div>
											</div>
										</div>
									</div>

									<div class="row-fluid">
										<div class="span6">
											<div class="control-group">
												<label for="" class="control-label"></label>
												<div class="controls">
													
												</div>
											</div>
										</div>
										<div class="span6">
											<div class="control-group">
												<label for="details" class="control-label">DETAILS:</label>
												<div class="controls">
													<textarea name="details" id="details" required></textarea>
												</div>
											</div>
										</div>
									</div>	
									<div class="form-actions">
                                        <input type="hidden" name="action" value="add_staff"/>
				                        <button class="btn btn-primary"  type="submit">ADD</button>
									    <button class="btn" type="reset">Reset</button>
		                            </div>		       
		</form>
	<!-- END FORM -->

    <div id="add_staff_errorloc" class="error_strings">
            </div>
<!---->
<script language="JavaScript" type="text/javascript"
    xml:space="preserve">//<![CDATA[
//You should create the validator only after the definition of the HTML form
  var frmvalidator  = new Validator("add_staff");
 frmvalidator.EnableOnPageErrorDisplaySingleBox();
 frmvalidator.EnableMsgsTogether();

 frmvalidator.addValidation("staff_id","maxlen=10");
  frmvalidator.addValidation("staff_id","req");


 frmvalidator.addValidation("department_id","req");



frmvalidator.addValidation("status","req");


frmvalidator.addValidation("username","req");

//frmvalidator.addValidation("leave_days","req");

frmvalidator.addValidation("details","req");

 frmvalidator.addValidation("first_name","req","Please enter your First Name");
  frmvalidator.addValidation("first_name","maxlen=20",	"Max length for FirstName is 20");
  frmvalidator.addValidation("first_name","alpha_s","Name can contain alphabetic chars only");


  frmvalidator.addValidation("last_name","maxlen=20",	"Max length for Middle Name is 20");
  frmvalidator.addValidation("last_name","alpha_s","Name can contain alphabetic chars only");

   frmvalidator.addValidation("email","maxlen=50");
   frmvalidator.addValidation("email","req");
   frmvalidator.addValidation("email","email");


 frmvalidator.addValidation("surname","req","Please enter your surname");
  frmvalidator.addValidation("surname","maxlen=20",	"Max length for surname is 20");
 
  
 // frmvalidator.addValidation("month","req","Please enter the month");
 

frmvalidator.addValidation("userlevelid","req");
  
  frmvalidator.addValidation("email","maxlen=50");
  frmvalidator.addValidation("email","req");
  frmvalidator.addValidation("email","email");
  
  frmvalidator.addValidation("phone_number","maxlen=50");
  frmvalidator.addValidation("phone_number","req");

frmvalidator.addValidation("id_passport","maxlen=12");
  
  
  frmvalidator.addValidation("Address","maxlen=50");
  frmvalidator.addValidation("Country","dontselect=0");
  
    function DoCustomValidation()
    {
        var frm = document.forms["add_staff"];
        if(frm.FirstName.value == 'Null')
        {
            sfm_show_error_msg("You can't submit this form. Go away! ");
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
</fieldset>

