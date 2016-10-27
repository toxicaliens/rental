<?php
set_title('Add User');
/**
 * Set the page layout that will be used
 */
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Add A User',
	'pageSubTitleText' => 'allow one to add a new customer',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'User Managment' ),
		array ( 'text'=>'Add User')
	),
	'pageWidgetTitle' => 'User Details'
));

set_css(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css',
	'assets/plugins/bootstrap-datepicker/css/datepicker.css'
));
set_js(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
	'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'
)); 
if(isset($_SESSION['mes'])){
    echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['mes']."</p>";
    unset($_SESSION['mes']);
}
;
?>    
<!-- BEGIN FORM -->
	<form action="" method="post" id="add_user" enctype="multipart/form-data" class="form-horizontal">
		<div class="alert alert-error hide">
            <button class="close" data-dismiss="alert">×</button>
            You have some form errors. Please check below.
        </div>
        <div class="alert alert-success hide">
            <button class="close" data-dismiss="alert">×</button>
            Your form validation is successful!
        </div>
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="username" class="control-label">Username<span class="required">*</span></label>
					<div class="controls">
						<input type="text" name="username" required />
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="password" class="control-label">Password<span class="required">*</span></label>
					<div class="controls">
						<input type="password" name="password" required />
					</div>
				</div>
			</div>
		</div>
     	<div class="row-fluid">
     		<div class="span6">
				<div class="control-group">
					<label for="pass_again" class="control-label">Confirm Password<span class="required">*</span></label>
					<div class="controls">
						<input type="password" name="pass_again" required/>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="status" class="control-label">Status:<span class="required">*</span></label>
					<div class="controls">
						<select name="status" required>
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="status" class="control-label">Email:<span class="required">*</span></label>
					<div class="controls">
						<input type="email" name="email" required/>
					</div>
				</div>
			</div>
		</div>		
		<div class="row-fluid">
		    <!-- <div class="span6">
				<label class="control-label">IMAGE UPLOAD:</label>
                <div class="controls">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-new thumbnail" style="width: 100px; height: 100px;"><img src="assets/img/profile/photo.jpg" /></div>
                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100px; max-height: 100px; line-height: 20px;"></div>
                        <div>
                            <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input name="profile-pic" type="file" /></span>
                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                        </div>
                </div> 
                </div>
            </div> -->
            <div class="span6">
            		<label for="user_role" class="control-label">User Role<span class="required">*</span></label>
					<div class="controls">
						<select name="user_role" required>
							<option value="">--Choose Role--</option>
							<?php

                                $query = "SELECT * FROM user_roles ORDER BY role_name ASC";

                                if ($data = run_query($query))
                                {
                                        while ( $fetch = get_row_data($data) )
                                        {
                                ?>
                                <option value="<?=$fetch['role_id']; ?>"><?php echo $fetch['role_name']; ?></option>";
                                <?php
                                    }
                                }
                                ?>
						</select>
					</div>
            </div>
        </div>   
		
		<input type="hidden" name="balance" value="0"/>
		<input type="hidden" name="action" value="add_user"/>
		
		<div class="form-actions">
			<?php
				$role_id = getCurrentUserRoleId($_SESSION['sys_name']);
				viewActions($_GET['num'], $role_id);
			?>
		</div>
	</form>
	<!-- END FORM -->

 <div id="add_crm_errorloc" class="error_strings">
            </div>

<!---->
	<script language="JavaScript" type="text/javascript"
	    xml:space="preserve">//<![CDATA[
	//You should create the validator only after the definition of the HTML form
	  var frmvalidator  = new Validator("add_crm");
	 frmvalidator.EnableOnPageErrorDisplaySingleBox();
	 frmvalidator.EnableMsgsTogether();

	frmvalidator.addValidation("surname","req","Please enter your surname");
	  frmvalidator.addValidation("surname","maxlen=20","Max length for surname is 20");
	  frmvalidator.addValidation("surname","alpha_s","surname can contain alphabetic chars only");

	frmvalidator.addValidation("start_date","req");

	  frmvalidator.addValidation("time_date","req");
 	
	frmvalidator.addValidation("balance","req");

	frmvalidator.addValidation("status","req");

	frmvalidator.addValidation("firstname","req","Please enter your First Name");
	  frmvalidator.addValidation("firstname","maxlen=20",	"Max length for FirstName is 20");
	  frmvalidator.addValidation("firstname","alpha_s","Name can contain alphabetic chars only");


	frmvalidator.addValidation("username","req","Please enter your userame");
	  frmvalidator.addValidation("username","maxlen=20",	"Max length for username is 20");

	frmvalidator.addValidation("password","req","Please enter your password");
	  frmvalidator.addValidation("password","maxlen=20","Max length for password is 20");

	frmvalidator.addValidation("middlename","req","Please enter your Middle Name");
	  frmvalidator.addValidation("middlename","maxlen=20",	"Max length for Middle Name is 20");
	  frmvalidator.addValidation("middlename","alpha_s","Name can contain alphabetic chars only");

	frmvalidator.addValidation("regdate_stamp","req");

	frmvalidator.addValidation("national_id_number","maxlen=10");
	  frmvalidator.addValidation("national_id_number","req");

	 
	  frmvalidator.addValidation("phone","maxlen=14");
	  frmvalidator.addValidation("phone","req");

           frmvalidator.addValidation("email","maxlen=50");
            frmvalidator.addValidation("email","req");
             frmvalidator.addValidation("email","email");

	
	 frmvalidator.addValidation("passport","req","Please enter the passport");
	  frmvalidator.addValidation("passport","maxlen=10");
	
	  frmvalidator.addValidation("Address","maxlen=50");
	  frmvalidator.addValidation("Country","dontselect=0");

	  
	    function DoCustomValidation()
	    {
		var frm = document.forms["add_user"];
		if(frm.firstname.value == 'Null')
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
<?php
/**
 * Using jQuery Validator Plugin
 */
set_css(array("assets/plugins/bootstrap-datepicker/css/datepicker.css"));
set_js(array(
	"assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js",
	"assets/scripts/form-validator.js",
	"src/js/add.crm.customer.js"
));
?>
