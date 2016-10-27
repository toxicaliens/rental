<?php

set_title('Edit Users');
/**
 * Set the page layout that will be used
 */
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Edit Users Details',
	'pageSubTitleText' => 'allow one to edit payment details',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'User Management' ),
		array ( 'text'=>'Edit Users' )
	),
	'pageWidgetTitle' => 'Users Details'
));

set_css(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css',
	'assets/plugins/bootstrap-datepicker/css/datepicker.css'
));
set_js(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
	'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'
)); 

//get the value

if (isset($_GET['user']))
{
	$user=$_GET['user'];
//get the row
$query="SELECT * FROM ".DATABASE.".user_login2 WHERE user_id='$user'";
$data=run_query($query);
$total_rows=get_num_rows($data);

$con=1;
$total=0;

$row=get_row_data($data);

//the values
$id = $row['user_id'];
$username = $row['username'];
$email=$row['email'];
$status=$row['user_active'];  
$user_role=$row['user_role'];
}
?>    
<!-- BEGIN FORM -->
	<form action="" method="post" id="edit_user" enctype="multipart/form-data" class="form-horizontal">
		<div class="alert alert-error hide">
            <button class="close" data-dismiss="alert">×</button>
            You have some form errors. Please check below.
        </div>
        <div class="alert alert-success hide">
            <button class="close" data-dismiss="alert">×</button>
            You have some form errors. Please check below.
        </div>    
        <?php if(isset($_SESSION['done-edits'])){ echo $_SESSION['done-edits']; unset($_SESSION['done-edits']); } ?>
       	<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="username" class="control-label">Username<span class="required">*</span></label>
					<div class="controls">
						<input type="text" name="username" class="span6" readonly value="<?=$username; ?>" required />
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="status" class="control-label">Status:<span class="required">*</span></label>
					<div class="controls">
						<?php
							$choice1 = '';
							$choice2 = '';
							if($status == 't'){
								$choice1 = 'selected';
							}else{
								$choice2 = 'selected';
							}
						?>	
						<select name="status" class="span6" required>
							<option value="1" <?php echo $choice1; ?>>Active</option>
							<option value="0" <?php echo $choice2; ?>>Inactive</option>
						</select>
					</div>
				</div>
			</div>
		</div>	
		<div class="row-fluid">
			<div class="span6">
        		<label for="user_role" class="control-label">User Role<span class="required">*</span></label>
				<div class="controls">
					<select name="user_role" class="span6 live_search" required>
						<option value="">--Choose Role--</option>
						<?php

                            $query = "SELECT * FROM user_roles ORDER BY role_name ASC";

                            if ($data = run_query($query))
                            {
                                    while ( $fetch = get_row_data($data) )
                                    {
                            ?>
                            <option value="<?=$fetch['role_id']; ?>" <?php if($fetch['role_id'] === $user_role){ echo 'selected'; } ?>><?php echo $fetch['role_name']; ?></option>";
                            <?php
                                }
                            }
                            ?>
					</select>
				</div>
            </div>
        </div>	

		<input type="hidden" name="action" value="edit_user"/>
		<input type="hidden" name="user_id" value="<?=$id; ?>"/>

		<div class="form-actions">
			<?php
				viewActions($_GET['num'], $_SESSION['role_id']);
			?>
		</div>
	</form>
	<!-- END FORM -->

 <div id="add_property_errorloc" class="error_strings">
            </div>

<!---->
	<script language="JavaScript" type="text/javascript"
	    xml:space="preserve">//<![CDATA[
	//You should create the validator only after the definition of the HTML form
	  var frmvalidator  = new Validator("add_property");
	 frmvalidator.EnableOnPageErrorDisplaySingleBox();
	 frmvalidator.EnableMsgsTogether();

	frmvalidator.addValidation("prop_name","req","Please enter your surname");
	frmvalidator.addValidation("prop_units","req", "Please enter the no of units");
	
	  
    function DoCustomValidation()
    {
	var frm = document.forms["edit_prop"];
	if(frm.prop_name.value == 'Null')
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
	"src/js/add.crm.property.js",
	"src/js/delete.js"
));
?>
