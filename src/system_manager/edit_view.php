<?php
error_reporting(0);
set_title('Edit View');
/**
 * Set the page layout that will be used
 */
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Edit A View',
	'pageSubTitleText' => 'allow one to add a new view',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'System Manager' ),
		array ( 'url' =>'?num=all_views', 'text'=>'Manage System View' ),
		array ( 'text'=>'Edit View' )
	),
	'pageWidgetTitle' => 'Edit View'
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

if(isset($_GET['del'])){
	$del = $_GET['del'];
	$delete= "DELETE FROM sys_views WHERE sys_view_id='$del'";
	if(run_query($delete)){
		header('location: index.php?num=all_views');
		$_SESSION['done-del'] = '<div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                The item has been successfully deleted!
                            </div>';
	}

}

if(isset($_GET['id'])){
	$view = $_GET['id'];

	//get the row
	$query="SELECT * FROM ".DATABASE.".sys_views WHERE sys_view_id='$view'";
	$data=run_query($query);
	$total_rows=get_num_rows($data);
	}
	$con=1;
	$total=0;

	while($row=get_row_data($data)){

	//the values
	$sys_view_id = $row['sys_view_id'];
    $view_name = $row['sys_view_name'];
    $view_index = $row['sys_view_index'];
    $view_url = $row['sys_view_url'];
    $view_status = $row['sys_view_status'];
    $view_parent = $row['parent'];
    $choice1 = '';
    $choice2 = '';
    if($view_status == 't'){
    	$choice1 = 'selected';
    }else{
    	$choice2 = 'selected';
    }
}

?>    
<!-- BEGIN FORM -->
	<form action="" method="post" id="edit_view" enctype="multipart/form-data" class="form-horizontal">
		<div class="alert alert-error hide">
            <button class="close" data-dismiss="alert">×</button>
            You have some form errors. Please check below.
        </div>
        <div class="alert alert-success hide">
            <button class="close" data-dismiss="alert">×</button>
            Your form validation is successful!
        </div>
        <?php if(isset($_SESSION['done-edits'])){ echo $_SESSION['done-edits']; unset($_SESSION['done-edits']); } ?>                              
        <div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="view_name" class="control-label">View Name:<span class="required">*</span></label>
					<div class="controls">
						<input type="text" name="view_name" value="<?=$view_name; ?>" autocomplete="off" required/>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="view_index" class="control-label">View Index:<span class="required">*</span></label>
					<div class="controls">
					<input type="text" name="view_index" value="<?=$view_index; ?>" required/>
					</div>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="view_url" class="control-label">View URL:<span class="required">*</span></label>
					<div class="controls">
						<input type="text" name="view_url" value="<?=$view_url; ?>" required/>
					</div>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="view_status" class="control-label">View Status<span class="required">*</span></label>
					<div class="controls">
						<select name="view_status" required>
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
					<label for="parent" class="control-label">Parent:<span class="required">*</span></label>
					<div class="controls">
						<select name="parent" required>
							<option value="NULL">--No Parent--</option>
							<?php
								$result = run_query("SELECT * FROM sys_views WHERE parent is null");
								while($row = get_row_data($result)){
									$sys_view_id2 = $row['sys_view_id'];
									$view_name = $row['sys_view_name'];
							?>
							<option value="<?=$sys_view_id2; ?>" <?php if($sys_view_id2 == $view_parent){ echo 'selected'; } ?>><?=$view_name; ?></option>
							<?php
								}
							?>
						</select>
					</div>
				</div>
			</div>
		</div>
		
		<input type="hidden" name="action" value="edit_view"/>
		<input type="hidden" name="view_id" value="<?=$sys_view_id; ?>"/>

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
	
	frmvalidator.setEditnlValidationFunction(DoCustomValidation);
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
