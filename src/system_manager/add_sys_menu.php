<?php
	if(isset($_SESSION['mes2'])){
    echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['mes2']."</p>";
    unset($_SESSION['mes2']);
}
?>
<form name="add_menu" method="post" action="" class="form-horizontal">
	<div class="row-fluid">
      <div class="span6">
          <div class="control-group">
			   <label for="parent" class="control-label">Parent:<span class="required">*</span></label>
			   <div class="controls">
					<select name="parent" class="span12" required>
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
      </div>
      <div class="span6">
        <div class="control-group">
		<label for="menu_name" class="control-label">Menu Name:<span class="required">*</span></label>
			<div class="controls">
				<input type="text" name="menu_name" class="span12" required/>
			</div>
		</div>
      </div>
  </div>

  <div class="row-fluid">
      <div class="span6">
            <div class="control-group">
				<label for="icon" class="control-label">Icon:</label>
				<div class="controls">
					<input type="text" name="icon" class="span12"/>
				</div>
		    </div>
      </div>
      <div class="span6">
            <div class="control-group">
				<label for="sequence" class="control-label">Sequence:<span class="required">*</span></label>
				<div class="controls">
					<input type="number" min="0" name="sequence" class="span12" required/>
				</div>
			</div>
      </div>
  </div>

  <div class="row-fluid">
      <div class="span6">
            <div class="control-group">
				<label for="view" class="control-label">View:<span class="required">*</span></label>
				<div class="controls">
					<select name="view" id="select2_sample1" class="span12" required>
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
      </div>
      <div class="span6">
          <div class="control-group">
				<label for="status" class="control-label">Status:</label>
				<div class="controls">
					<select name="status" class="span12">
						<option value="1">Active</option>
						<option value="0">Inactive</option>
					</select>
				</div>
			</div>
      </div>
  </div>

	<input name="action" type="hidden" value="add_menu_item" />
	
	<div class="form-actions">
	   <?php
			viewActions($_GET['num'], $_SESSION['role_id']);
		?>
	</div>
</form>