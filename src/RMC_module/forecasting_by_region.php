<?php
include_once 'src/model/RevenueManager.php';
$revenue_manager = new RevenueManager();

if(isset($_SESSION['RMC'])){
      echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['RMC']."</p>";
      unset($_SESSION['RMC']);
  }

?>

	<span class="actions">
		<a href="#add" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Add Forecast</a>
		<a href="#edit" id="edit_btn" class="btn btn-small btn-warning"><i class="icon-edit"></i> Edit</a>
	</span>
	<div class="widget-body form">
		<div class="table-responsive">
			<table id="table3" class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Rev#</th>
						<th>Revenue channel</th>
						<!--function to loop and load the regions-->
						<?php
						$results = $revenue_manager ->getAllregions();
						while($rows=get_row_data($results)){
						?>
						<th><?=$rows['region_name'];?></th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
				   <!--function to loop and load the Revenue Channels-->
					<?php
						$result = $revenue_manager->getAllRevenueChannelsForRegions();
						while($rows = get_row_data($result)){
					?>
					<tr>
						<td><?=$rows['revenue_channel_id']; ?></td>
						<td><?=$rows['revenue_channel_name']; ?></td>
						<!-- function to loop and load the target amount for the specific revenue channel and region-->
						<?php $revenue_manager->populateTargetAmountsForEachRegion($rows['revenue_channel_id']); ?>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="clearfix"></div>
	</div>

<!-- The Modals -->
<form action="" method="post">
	<div id="add" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Add Daily Region Forecast</h3>
		</div>
		<div class="modal-body">
		   <div class="row-fluid">
	            <select name="revenue_channel" class="span12" id="select2_sample2" required>
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
	        </br>
		    <div class="row-fluid">
	            <select name="region" class="span12" id="select2_sample1" required>
		          <option value="">--Choose Region--</option>
		           <?php
		             $array = $revenue_manager ->getAllregions();

					 while($row=get_row_data($array)){
					 // var_dump($row);exit; 
		            ?>
		            <option value="<?=$row['region_id']; ?>"><?=$row['region_name']; ?></option>
		            <?php
		              }
		            ?>
		        </select>    
	        </div>
	        </br>
	        <div class="row-fluid">
	            <label for="target_amount">Amount:</label>
	            <input type="text" name="target_amount" value="" class="span12" required>     
	        </div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="add_region_forecast"/>
		<input type="hidden" name="tab1"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo476'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav478'); ?>
		</div>
	</div>
</form>

<!-- The Modals -->
<form action="" method="post" id="add_each_forecast">
	<div id="add_forecast" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Add Forecast</h3>
		</div>
		<div class="modal-body">
		   <div class="row-fluid">
	            <select name="revenue_channel" class="span12" id="each_revenue" required disabled="disabled">
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
	        </br>
		    <div class="row-fluid">
	            <select name="region" class="span12" id="each_region" required disabled="disabled">
		          <option value="">--Choose Region--</option>
		           <?php
		             $array = $revenue_manager ->getAllregions();
					 while($row=get_row_data($array)){ 
		            ?>
		            <option value="<?=$row['region_id']; ?>"><?=$row['region_name']; ?></option>
		            <?php
		              }
		            ?>
		        </select>    
	        </div>
	        </br>
	        <div class="row-fluid">
	            <label for="target_amount">Amount:</label>
	            <input type="number" name="target_amount" value="" class="span12" required>     
	        </div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="add_each_region_forecast"/>
		<input type="hidden" name="tab1"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo476'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav478'); ?>
		</div>
	</div>
</form>

<form action="" method="post">
	<div id="edit" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Edit Daily Forecasts</h3>
		</div>
		<div class="modal-body">
		   <div class="row-fluid">
	            <select name="revenue_channel" id="reg_rev_chan" class="span12" required>
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
		    <div id="forecasts"></div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="edit_region_forecast"/>
		<input type="hidden" name="tab1"/>
		<input type="hidden" name="edit_id" id="edit_id"/>

		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo476'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav478'); ?>
		</div>
	</div>
</form>
<?php set_js(array('src/js/forecasting.js')); ?>