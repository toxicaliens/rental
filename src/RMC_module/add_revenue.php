<!-- BEGIN FORM -->
	<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="revenue_channel_name" class="control-label">Revenue channel name:<span class="required"></span></label>
					<div class="controls">
						<input type="text" name="revenue_channel_name" class="span12" required/>
					</div>
				</div>
			</div>
			<div class="span6">
	          <div class="control-group">
	            <label for="revenue_channel_code" class="control-label">Revenue Channel Code:</label>
	            <div class="controls">
	             <input type="text"  id="revenue_channel_code" name="revenue_channel_code" class="span12" title="e.g. pk_ser for Parking Service" required/>
	            </div>
	          </div>
	        </div>
		</div>

	<div class="form-actions">
        <input type="hidden" name="action" value="add_revenue_channels"/>
		<?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
	</div>
	</form>
	<!-- END FORM -->
