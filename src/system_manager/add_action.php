<?php
error_reporting(0);
set_title('Add Action');
/**
 * Set the page layout that will be used
 */
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Add an Action',
	'pageSubTitleText' => 'allow one to add a new action',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'System Manager' ),
		array ( 'text'=>'Add an Action' )
	),
	'pageWidgetTitle' => 'Add&nbsp;Action'
));

set_css(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css',
	'assets/plugins/bootstrap-datepicker/css/datepicker.css'
));
set_js(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
	'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'
)); 
if(isset($_SESSION['done-add'])){
    echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['done-add']."</p>";
    unset($_SESSION['done-add']);
}
?>    
<!-- BEGIN FORM -->
	<form action="" method="post" id="add_action" enctype="multipart/form-data" class="horizontal-form">
		<div class="alert alert-error hide">
            <button class="close" data-dismiss="alert">×</button>
            You have some form errors. Please check below.
        </div>
        <div class="alert alert-success hide">
            <button class="close" data-dismiss="alert">×</button>
            Your form validation is successful!
        </div>
        <?php if(isset($_SESSION['mes2'])){ echo $_SESSION['mes2']; unset($_SESSION['mes2']); } ?>                              
        <div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="action_name" class="control-label">Action Name:<span class="required">*</span></label>
					<div class="controls">
						<input type="text" name="action_name" value="Save" class="span12" autocomplete="off" required/>
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label for="type" class="control-label">Button Type:<span class="required">*</span></label>
					<div class="controls">
						<select name="type" class="span12" required>
							<!-- <option value="">--Choose Button Type--</option> -->
							<option value="submit">Submit</option>
							<option value="delete">Delete</option>
							<option value="reset">Reset</option>
							<option value="back">Back</option>
							<option value="search">Search</option>
							<option value="button">Button</option>
						</select>
					</div>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="class" class="control-label">Class:<span class="required">*</span></label>
					<div class="controls">
						<!-- <select name="class" multiple="multiple">
								<option value="btn" selected>btn</option>
								<option value="btn-primary">btn-primary</option>
								<option value="btn-danger">btn-danger</option>
								<option value="btn-warning">btn-warning</option>
								<option value="delete">delete</option>
						</select> -->
						<input type="text" name="class" value="btn btn-primary" class="span12" required>
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label for="action_status" class="control-label">Action Status<span class="required">*</span></label>
					<div class="controls">
						<select name="action_status" class="span112" required>
							<!-- <option value="">--Choose Status--</option> -->
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
					<label for="action_type" class="control-label">Action Type:</label>
					<div class="controls">
						<select name="button_type" class="span12" required>
							<option value="">--Choose Action Type--</option>
							<option value="form">Form Action</option>
							<option value="section">Section Action</option>
						</select>
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label for="view_name" class="control-label">View Name:<span class="required">*</span></label>
					<div class="controls">
						<select name="view_name" class="span12" id="select2_sample79" required>
							<option value="">--Choose View--</option>
							<?php
								$query = "SELECT * From sys_views ORDER BY sys_view_name ASC";
								$options = run_query($query);
								while($row = get_row_data($options)){
							?>
							<option value="<?=$row['sys_view_id']; ?>"><?=$row['sys_view_name']; ?></option>
							<?php
								}
							?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="action_description" class="control-label">Action Description:</label>
					<div class="controls">
						<textarea name="action_description" class="span12"></textarea>
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label for="others" class="control-label">Others:</label>
					<div class="controls">
						<textarea name="others" class="span12"></textarea>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="action" value="add_action"/>

		<div class="form-actions">
			<?php
				viewActions($_GET['num'], $_SESSION['role_id']);
			?>
		</div>
	</form>
 <div id="add_property_errorloc" class="error_strings">
            </div>

<!---->
	<script language="JavaScript" type="text/javascript"
	    xml:space="preserve">//<![CDATA[
	//You should create the validator only after the definition of the HTML form
	  var frmvalidator = new Validator("add_role");
	 frmvalidator.EnableOnPageErrorDisplaySingleBox();
	 frmvalidator.EnableMsgsTogether();

	frmvalidator.addValidation("house_no","req","Please enter your surname");
	frmvalidator.addValidation("plot_id","req", "Please select the plot_id");
	frmvalidator.addValidation("phone","req", "Please Enter your phone number");
	
	  
    function DoCustomValidation()
    {
	var frm = document.forms["add_view"];
	if(frm.phone.value == 'Null')
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
	"assets/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js",
	"assets/scripts/form-validator.js",
	"src/js/add.crm.property.js",
	"src/js/multiselect.js"
));
?>
