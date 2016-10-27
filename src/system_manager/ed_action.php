<?php
error_reporting(0);
set_title('Edit Action');
/**
 * Set the page layout that will be used
 */
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Edit Action',
	'pageSubTitleText' => 'allow one to edit an action',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'System Manager' ),
		array ( 'url'=>'?num=all_actions', 'text'=>'Manage System Actions' ),
		array ( 'text'=>'Edit Action' )
	),
	'pageWidgetTitle' => 'Edit&nbsp;Action'
));

set_css(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css',
	'assets/plugins/bootstrap-datepicker/css/datepicker.css'
));
set_js(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
	'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'
)); 
if(isset($_SESSION['done-edits'])){
    echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['done-edits']."</p>";
    unset($_SESSION['done-edits']);
}

if(isset($_GET['del_id'])){
	$del_id = $_GET['del_id'];

	$delete = run_query("DELETE FROM sys_actions WHERE sys_action_id = '".$del_id."'");
	if($delete){
		$_SESSION['done-del'] = '<div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                The item has been successfully deleted!
                            </div>';
        header('location: index.php?num=all_actions');
	}	
}

if(isset($_GET['id'])){
	$action_id = $_GET['id'];

	$query = "SELECT * FROM sys_actions WHERE sys_action_id = '".$action_id."'";
	$result = run_query($query);
	if($result){
		while($row = get_row_data($result)){
			// $sys_action_code = $row['sys_action_code'];
			$sys_action_class = $row['sys_action_class'];
			$sys_action_type = $row['sys_action_type'];
			$sys_action_description = $row['sys_action_description'];
			$sys_view_id = $row['sys_view_id'];
			$sys_action_status = $row['sys_action_status'];
			$sys_action_name = $row['sys_action_name'];
			$sys_button_type = $row['sys_button_type'];
			$others = $row['others'];
			$action1 = '';
			$action2 = '';
			if($sys_button_type == 'form'){
				$action1 = 'selected';
			}elseif($sys_button_type == 'section'){
				$action2 = 'selected';
			}
		}
	}
}
?>    
<!-- BEGIN FORM -->
	<form action="" method="post" id="ed_action" enctype="multipart/form-data" class="horizontal-form">
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
						<input type="text" name="action_name" class="span12" value="<?=$sys_action_name; ?>" autocomplete="off" required/>
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label for="type" class="control-label">Button Type:<span class="required">*</span></label>
					<div class="controls">
						<select name="type" class="span12" required>
							<option value="">--Choose Button Type--</option>
							<?php
								// $query = "SELECT * From sys_actions";
								// $options = run_query($query);
								// while($row = get_row_data($options)){
									$selected_type = $sys_action_type;
									switch($selected_type){
										case 'submit':
											$selected_type = 'submit';
											break;

											case 'reset':
												$selected_type = 'reset';
												break;

												case 'delete':
													$selected_type = 'delete';
													break;

													case 'back':
														$selected_type = 'back';
														break;

														case 'search':
															$selected_type = 'search';
															break;

															case 'button':
																$selected_type = 'button';
																break;
									}
								// }
							?>
							<option value="submit" <?php if($selected_type === 'submit'){ echo 'selected'; } ?>>Submit</option>
							<option value="reset" <?php if($selected_type === 'reset'){ echo 'selected'; } ?>>Reset</option>
							<option value="delete" <?php if($selected_type === 'delete'){ echo 'selected'; } ?>>Delete</option>
							<option value="back" <?php if($selected_type === 'back'){ echo 'selected'; } ?>>Back</option>
							<option value="search" <?php if($selected_type === 'search'){ echo 'selected'; } ?>>Search</option>
							<option value="button" <?php if($selected_type === 'button'){ echo 'selected'; } ?>>Button</option>
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
						<input type="text" name="class" class="span12" value="<?=$sys_action_class; ?>"/>
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label for="action_status" class="control-label">Action Status<span class="required">*</span></label>
					<div class="controls">
						<select name="action_status" class="span12" required>
							<?php
								$choice1 = '';
								$choice2 = '';
								if($sys_action_status == 't'){
									$choice1 = 'selected';
								}else{
									$choice2 = 'selected';
								}
							?>
							<option value="">--Choose Status--</option>
							<option value="1" <?=$choice1; ?>>Active</option>
							<option value="0" <?=$choice2; ?>>Inactive</option>
						</select>
					</div>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="action_status" class="control-label">Action Type<span class="required">*</span></label>
					<div class="controls">
						<select name="button_type" class="span12" required>
							<option value="">--Choose Action Type--</option>
							<option value="form" <?=$action1; ?>>Form Action</option>
							<option value="section" <?=$action2; ?>>Section Action</option>
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
							<option value="<?=$row['sys_view_id']; ?>" <?php if($row['sys_view_id'] === $sys_view_id){ echo 'selected'; } ?>><?=$row['sys_view_name']; ?></option>
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
						<textarea class="span12" name="action_description"><?=$sys_action_description; ?></textarea>
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label for="others" class="control-label">Others:</label>
					<div class="controls">
						<textarea class="span12" name="others"><?=$others; ?></textarea>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="action" value="ed_action"/>
		<input type="hidden" name="action_id" value="<?=$action_id; ?>"/>

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
	  var frmvalidator = new Validator("add_role");
	 frmvalidator.EnableOnPageErrorDisplaySingleBox();
	 frmvalidator.EnableMsgsTogether();

	frmvalidator.addValidation("house_no","req","Please enter your surname");	
	frmvalidator.addValidation("plot_id","req", "Please select the plot_id");
	frmvalidator.addValidation("phone","req", "Please Enter your phone number");
	
	  
    function DoCustomValidation()
    {
	var frm = document.forms["ed_action"];
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
