<!-- modal trigger buttons -->
<a href="#" data-toggle="modal" />

	<a href="#add_subcounty" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Add Forecast</a>
	<a href="#edit_subcounty" id="sub_edit_btn" class="btn btn-small btn-warning"><i class="icon-edit"></i> Edit</a>

	<!-- add modal -->
	<form action="" method="post">
		<div id="add_subcounty" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 id="myModalLabel1">Add Sub County Forecast</h3>
			</div>
			<div class="modal-body">
		   <div class="row-fluid">
	            <select name="revenue_channel" class="span12 live_search" required>
		          <option value="">--Choose Revenue Channel--</option>
		           <?php
		             $array = $revenue_manager ->getAllRevenueChannels();
					 while($row=get_row_data($array)){ 
		            ?>
		            <option value="<?=$row['revenue_channel_id']; ?>"><?=$row['revenue_channel_name']; ?></option>
		            <?php
		              }
		            ?>
		        </select>    
	        </div>
	        <br/>
		    <!-- <div class="row-fluid">
	            <select name="county" class="span12 live_search" id="county" required>
		          	<option value="">--Choose County--</option>
		           	<?php
		     //         	$array = $revenue_manager ->getAllCounties();
					 	// while($row=get_row_data($array)){ 
		            ?>
		            <option value="<?//=$row['county_ref_id']; ?>"><?//=$row['county_name']; ?></option>
		            <?php
		              //}
		            ?>
		        </select>    
	        </div>
	        <br/> -->
		    <div class="row-fluid">
	            <select name="subcounty" class="span12 live_search" id="subcounty" required>
		          <option value="">--Choose Subcounty--</option>
		           <?php
		             $array = $revenue_manager ->getAllSubcounties();
					 while($row=get_row_data($array)){ 
		            ?>
		            <option value="<?=$row['sub_county_id']; ?>"><?=$row['sub_county_name']; ?></option>
		            <?php
		              }
		            ?>
		        </select>    
	        </div>
	        <br/>
	        <div class="row-fluid">
	            <label for="target_amount">Target Amount:</label>
	            <input type="number" name="target_amount" value="" min="1" class="span12" required>     
	        </div>
		</div>
			<!-- the hidden fields -->
			<input type="hidden" name="action" value="add_subcounty_forecast"/>
			<input type="hidden" name="tab2"/>
			<div class="modal-footer">
				<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo475'); ?>
				<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav477'); ?>
			</div>
		</div>
	</form>

	<form action="" method="post" id="add_each_sub_forecast">
		<div id="add_sub_forecast" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 id="myModalLabel1">Add Forecast</h3>
			</div>
			<div class="modal-body">
		   <div class="row-fluid">
	            <select name="revenue_channel" class="span12" id="each_sub_revenue" required disabled="disabled">
		          <option value="">--Choose Revenue Channel--</option>
		           <?php
		             $array = $revenue_manager ->getAllRevenueChannels();
					 while($row=get_row_data($array)){ 
		            ?>
		            <option value="<?=$row['revenue_channel_id']; ?>"><?=$row['revenue_channel_name']; ?></option>
		            <?php
		              }
		            ?>
		        </select>    
	        </div>
	        <br/>
		    <!-- <div class="row-fluid">
	            <select name="county" class="span12 live_search" id="county" required>
		          	<option value="">--Choose County--</option>
		           	<?php
		     //         	$array = $revenue_manager ->getAllCounties();
					 	// while($row=get_row_data($array)){ 
		            ?>
		            <option value="<?//=$row['county_ref_id']; ?>"><?//=$row['county_name']; ?></option>
		            <?php
		              //}
		            ?>
		        </select>    
	        </div>
	        <br/> -->
		    <div class="row-fluid">
	            <select name="subcounty" class="span12" id="each_subcounty" required disabled="disabled">
		          <option value="">--Choose Subcounty--</option>
		           <?php
		             $array = $revenue_manager ->getAllSubcounties();
					 while($row=get_row_data($array)){ 
		            ?>
		            <option value="<?=$row['sub_county_id']; ?>"><?=$row['sub_county_name']; ?></option>
		            <?php
		              }
		            ?>
		        </select>    
	        </div>
	        <br/>
	        <div class="row-fluid">
	            <label for="target_amount">Target Amount:</label>
	            <input type="number" name="target_amount" value="" min="1" class="span12" required>     
	        </div>
		</div>
			<!-- the hidden fields -->
			<input type="hidden" name="action" value="add_each_sub_forecast"/>
			<input type="hidden" name="tab2"/>
			<div class="modal-footer">
				<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo475'); ?>
				<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav477'); ?>
			</div>
		</div>
	</form>

	<form action="" method="post">
		<div id="edit_subcounty" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 id="myModalLabel1">Edit Sub County Forecast(s)</h3>
			</div>

			<div class="modal-body">
			   	<div class="row-fluid">
		            <select name="revenue_channel" id="sub_rev_chan" class="span12" required>
			          <option value="">--Choose Revenue Channel--</option>
			           <?php
			             $array = $revenue_manager ->getAllRevenueChannels();
						 while($row=get_row_data($array)){ 
			            ?>
			            <option value="<?=$row['revenue_channel_id']; ?>"><?=$row['revenue_channel_name']; ?></option>
			            <?php
			              }
			            ?>
			        </select>    
		        </div>
		        <div id="subcounty_forecasts"></div>

			</div>

			<!-- the hidden fields -->
			<input type="hidden" name="action" value="edit_subcounty_forecast"/>
			<input type="hidden" name="tab2"/>
			<div class="modal-footer">
				<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo475'); ?>
				<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav477'); ?>
			</div>
		</div>
	</form>

<!-- forecasting table for subcounty -->
<table id="table4" class="table table-striped table-hover">
	<thead>
		<tr>
			<th>Rev#</th>
			<th>Revenue Channels</th>
			<?php
				$result = $revenue_manager->getAllSubcounties();
				while($rows = get_row_data($result)){
			?>
			<th><?=ucwords($rows['sub_county_name']); ?></th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php
			$result = $revenue_manager->getAllRevenueChannelsForSubcounty();
			while($rows = get_row_data($result)){
		?>
		<tr>
			<td><?=ucwords($rows['revenue_channel_id']); ?></td>
			<td><?=ucwords($rows['revenue_channel_name']); ?></td>
			<?php $revenue_manager->populateTargetAmountsForEachSubcounty($rows['revenue_channel_id']); ?>
		</tr>
		<?php } ?>
	</tbody>
</table>
