<?php
error_reporting(0);
set_title('Add View');
/**
 * Set the page layout that will be used
 */
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Add A View',
	'pageSubTitleText' => 'allow one to add a new view',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'System Manager' ),
		array ( 'text'=>'Add View' )
	),
	'pageWidgetTitle' => 'Add View'
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
	<form action="" method="post" id="add_view" enctype="multipart/form-data" class="form-horizontal">
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
					<label for="view_name" class="control-label">View Name:<span class="required">*</span></label>
					<div class="controls">
						<input type="text" name="view_name" class="span12" autocomplete="off" required/>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="view_index" class="control-label">View Index:<span class="required">*</span></label>
					<div class="controls">
						<input type="text" name="view_index" class="span12" required/>
					</div>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="view_url" class="control-label">View URL:<span class="required">*</span></label>
					<div class="controls">
						<input type="text" name="view_url" class="span12" required/>
					</div>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="view_status" class="control-label">View Status:<span class="required">*</span></label>
					<div class="controls">
						<select name="view_status" required class="span12">
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
					<label for="parent" class="control-label">Parent:<span class="required">*</span></label>
					<div class="controls">
						<select name="parent" class="span12" required>
							<option value="NULL">--No Parent--</option>
							<?php
								$result = run_query("SELECT * FROM sys_views WHERE parent is null");
								while($row = get_row_data($result)){
									$sys_view_id = $row['sys_view_id'];
									$view_name = $row['sys_view_name'];
							?>
							<option value="<?=$sys_view_id; ?>"><?=$view_name; ?></option>
							<?php
								}
							?>
						</select>
					</div>
				</div>
			</div>
		</div>

		<input type="hidden" name="action" value="add_view"/>

		<div class="form-actions">
			<?php
				$role_id = getCurrentUserRoleId($_SESSION['sys_name']);
				viewActions($_GET['num'], $role_id);
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
	"assets/scripts/form-validator.js",
	"src/js/add.crm.property.js"
));
?>
