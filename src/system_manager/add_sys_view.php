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
				viewActions($_GET['num'], $_SESSION['role_id']);
			?>
		</div>
	</form>
	<!-- END FORM -->