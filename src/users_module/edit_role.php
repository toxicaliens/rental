<?php
error_reporting(0);
set_title('Edit User Role');
/**
 * Set the page layout that will be used
 */
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Edit User Role Details',
	'pageSubTitleText' => 'allow one to edit role info',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'System Manager' ),
		array ( 'text'=>'Edit Roles' )
	),
	'pageWidgetTitle' => 'User Role Details'
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

	//get the value
$id=$_GET['id'];
if (isset($id))
{
//get the row
$query="SELECT * FROM ".DATABASE.".user_roles WHERE role_id='$id'";
$data=run_query($query);
$total_rows=get_num_rows($data);
}
$con=1;
$total=0;

$row=get_row_data($data);

//the values
$role_id = $row['role_id'];
$role_name = $row['role_name'];
$role_status = $row['role_status'];
?>    
<!-- BEGIN FORM -->
	<form action="" method="post" id="add_property" enctype="multipart/form-data" class="form-horizontal">
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
					<label for="role_name" class="control-label">Role Name:<span class="required">*</span></label>
					<div class="controls">
						<input type="text" name="role_name" value="<?=$role_name; ?>" autocomplete="off" required/>
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
							if($role_status == 't'){
								$choice1 = 'selected';
							}else{
								$choice2 = 'selected';
							}
						?>
						<select name="status">
							<option value="">--Choose Status--</option>
							<option value="1" <?=$choice1; ?>>Active</option>
							<option value="0" <?=$choice2; ?>>Inactive</option>
						</select>
					</div>
				</div>
			</div>
		</div>

		<input type="hidden" name="action" value="edit_role"/>
		<input type="hidden" name="role_id" value="<?=$role_id; ?>"/>

		<div class="form-actions">
			<?php
				viewActions($_GET['num'], $_SESSION['role_id']);
			?>
		</div>
	</form>
	<!-- END FORM -->
