<?php 
if(isset($_SESSION['done-add'])){
    echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['done-add']."</p>";
    unset($_SESSION['done-add']);
} ?>
<form action="" method="post" id="add_role" enctype="multipart/form-data" class="form-horizontal">
	<div class="alert alert-error hide">
        <button class="close" data-dismiss="alert">×</button>
        You have some form errors. Please check below.
    </div>
    <div class="alert alert-success hide">
        <button class="close" data-dismiss="alert">×</button>
        Your form validation is successful!
    </div>                           
    <div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="role_name" class="control-label">Role Name:<span class="required">*</span></label>
				<div class="controls">
					<input type="text" class="span12" name="role_name" autocomplete="off" required/>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="role_name" class="control-label">Role Status<span class="required">*</span></label>
				<div class="controls">
					<select name="status" class="span12">
						<option value="1">Active</option>
						<option value="0">Inactive</option>
					</select>
				</div>
			</div>
		</div>
	</div>
	
	<input type="hidden" name="action" value="add_role"/>

	<div class="form-actions">
		<?php
			viewActions($_GET['num'], $_SESSION['role_id']);
		?>
	</div>
</form>