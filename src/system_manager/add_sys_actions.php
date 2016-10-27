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
						<select name="view_name" class="span12" id="select2_sample1" required>
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