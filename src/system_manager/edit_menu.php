<?php
set_title('Edit Menu Details');
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Edit Menu',
	'pageSubTitleText' => 'allow one to edit menu items',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'System Manager' ),
		array ( 'url'=>'?num=manage_menu', 'text'=>'Manage Menu' ),
		array ( 'text'=>'Edit Menu Item')
	),
	'pageWidgetTitle' => 'Edit Menu Item'
));

set_css(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css',
	'assets/plugins/bootstrap-datepicker/css/datepicker.css'
));
set_js(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
	'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'
));

/**
 * Set page layout
 */
	if(isset($_GET['id'])){
		$menu_id = $_GET['id'];
		$result = run_query("SELECT * FROM menu WHERE menu_id = '".$menu_id."'");
		$row = get_row_data($result);
		$status=$row['status'];
		$view_id=$row['view_id'];
		$sequence=$row['sequence'];
	}
?>
		<?php if(isset($_SESSION['done-edits'])){ echo $_SESSION['done-edits']; unset($_SESSION['done-edits']); } ?>
		<form name="add_menu" method="post" action="" class="form-horizontal">
			<div class="row-fluid">
				<div class="span6">
					<div class="control-group">
						<label for="menu_name" class="control-label">Menu Name:<span class="required">*</span></label>
						<div class="controls">
							<input type="text" name="menu_name" class="span12" value="<?=$row['text']; ?>" required/>
						</div>
					</div>
				</div>
				<div class="span6">
					<div class="control-group">
						<label for="icon" class="control-label">Icon:</label>
						<div class="controls">
							<input type="text" value="<?=$row['icon']; ?>" class="span12" name="icon"/>
						</div>
					</div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span6">
					<div class="control-group">
						<label for="view" class="control-label">View:</label>
						<div class="controls">
							<select name="view" class="span12">
								<option value="">--Attach to View--</option>
								<?php
									$run = run_query("SELECT * FROM sys_views ORDER BY sys_view_name ASC");
									while($row=get_row_data($run)){
										$text=$row['sys_view_name'];
										$sys_view_id=$row['sys_view_id'];
								?>
								<option value="<?=$sys_view_id; ?>" <?php if($sys_view_id === $view_id){ echo 'selected'; } ?>><?=$text; ?></option>
								<?php	
									}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="span6">
					<div class="control-group">
						<label for="status" class="control-label">Status:</label>
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
							<select name="status" class="span12">
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
						<label for="status" class="control-label">Sequence:</label>
						<div class="controls">	
							<input type="number" name="sequence" min="0" class="span12" value="<?=$sequence; ?>"/>
						</div>
					</div>
				</div>
			</div>

			<input type="hidden" name="menu_id" value="<?=$menu_id; ?>" />
			<input name="action" type="hidden" value="edit_menu_details" />
			
			<div class="form-actions">
				<?php
					viewActions($_GET['num'], $_SESSION['role_id']);
				?>
			</div>
		</form>
		</div>
	</div>
		<!-- END PAGE --> 

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