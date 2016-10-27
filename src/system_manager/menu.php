<?php
set_title('Menu');
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Manage Menu',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Reports' ),
		array ( 'text'=>'Menu' )
	)
	
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
?>
		<!-- BEGIN PAGE -->  
	        <div class="span12">
				<div class="row-fluid">
				<!-- BEGIN PAGE TITLE -->
				
				<!-- END PAGE TITLE -->

				<!-- BEGIN BREADCRUMBS -->
<?php

?>
				<div class="row-fluid">
					<div class="span12">
						<div class="row-fluid">
							<div class="widget">
								<div class="widget-title"><h4>Add Menu Items</h4></div>
								<div class="widget-body form">
									<?php if(isset($_SESSION['mes2'])){ echo $_SESSION['mes2']; unset($_SESSION['mes2']); } ?>
									<form name="add_menu" method="post" action="" class="form-horizontal">
										<div class="control-group">
											<label for="parent" class="control-label">Parent:<span class="required">*</span></label>
											<div class="controls">
												<select name="parent" required>
													<option value="null">No Parent</option>
													<?php
														$run = run_query("SELECT * FROM menu WHERE parent_id is null");
														while($row=get_row_data($run)){
															$text=$row['text'];
															$menu_id=$row['menu_id'];
															echo "<option value=\"$menu_id\">$text</option>";
														}
													?>
												</select>
											</div>
										</div>
										<div class="control-group">
											<label for="menu_name" class="control-label">Menu Name:<span class="required">*</span></label>
											<div class="controls">
												<input type="text" name="menu_name" required/>
											</div>
										</div><!-- 
										<div class="control-group">
											<label for="class" class="control-label">CSS Class:</label>
											<div class="controls">
												<input type="text" name="class"/>
											</div>
										</div> -->
										<div class="control-group">
											<label for="icon" class="control-label">Icon:</label>
											<div class="controls">
												<input type="text" name="icon"/>
											</div>
										</div>
										<div class="control-group">
											<label for="sequence" class="control-label">Sequence:<span class="required">*</span></label>
											<div class="controls">
												<input type="number" min="0" name="sequence" required/>
											</div>
										</div>
										<div class="control-group">
											<label for="view" class="control-label">View:<span class="required">*</span></label>
											<div class="controls">
												<select name="view" required>
													<option value="">--Attach to View--</option>
													<?php
														$run = run_query("SELECT * FROM sys_views ORDER BY sys_view_name ASC");
														while($row=get_row_data($run)){
															$text=$row['sys_view_name'];
															$view_id=$row['sys_view_id'];
															echo "<option value=\"$view_id\">$text</option>";
														}
													?>
												</select>
											</div>
										</div>
										<div class="control-group">
											<label for="status" class="control-label">Status:</label>
											<div class="controls">
												<select name="status">
													<option value="1">Active</option>
													<option value="0">Inactive</option>
												</select>
											</div>
										</div>

										
										<input name="action" type="hidden" value="add_menu_item" />
										
										<div class="form-actions">
											<?php
												$role_id = getCurrentUserRoleId($_SESSION['sys_name']);
												viewActions($_GET['num'], $role_id);
											?>
										</div>
									</form>
								</div>
							</div>
							<!-- prev code was here -->
						</div>
					</div>
				</div>
				<!-- END PAGE CONTENT -->
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
	"src/js/add.crm.customer.js",
	"src/js/add.crm.customer.js"
));
?>