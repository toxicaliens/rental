<?php
error_reporting(0);
set_title('Add Menu Item');
/**
 * Set the page layout that will be used
 */
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Add a Menu Item',
	'pageSubTitleText' => 'allow one to add a new menu Item',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'System Manager' ),
		array ( 'text'=>'Add Menu Items' )
	),
	'pageWidgetTitle' => 'Add Menu Item'
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
	<form action="" method="post" id="add_menu_item" enctype="multipart/form-data" class="form-horizontal">
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
					<label for="text" class="control-label">Text:<span class="required">*</span></label>
					<div class="controls">
						<select name="text" required>
							<option value="">--Menu Item Name--</option>
							<?php
								$query = "SELECT * FROM sys_views WHERE sys_view_index <> '#' ORDER BY sys_view_name ASC";
								// var_dump($query);exit;
								$result = run_query();
								if($result){
									while($row = get_row_data($result)){
							?>
							<option value="<?=$row['sys_view_id']; ?>"><?=$row['sys_view_name']; ?></option>
							<?php }} ?>
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
							<option value="">--Parent--</option>
							<?php
								$result = run_query("SELECT * FROM menu WHERE parent_id is null ORDER BY menu_id ASC");
								if($result){
									while($row = get_row_data($result)){
							?>
							<option value="<?=$row['menu_id']; ?>"><?=$row['text']; ?></option>
							<?php }} ?>
						</select>
					</div>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="status" class="control-label">Status: <span class="required">*</span></label>
					<div class="controls">
						<select name="status" required>
							<option value="">--Choose Status--</option>
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		
		<input type="hidden" name="action" value="add_menu_item"/>

		<div class="form-actions">
			<?php
				createActionButton('submit', 1070, $_SESSION['role_id'], 'btn btn-primary', '');
				createActionButton('reset', 1071, $_SESSION['role_id'], 'btn', '');
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
	var frm = document.forms["add_menu_item"];
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
