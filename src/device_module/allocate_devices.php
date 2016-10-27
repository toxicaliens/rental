<?php
include_once('src/models/Device_management.php');
$device_mgt = new DeviceManagement;

set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Device Allocations',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Device Management' ),
		array ( 'text'=>'Allocate Devices' )
	)
	
));

if(isset($_POST['imei_no'])){
	$filter_key = $_POST['imei_no'];
}else{
	$filter_key = '';
}
?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-search"></i> Search by IMEI#</h4>
		<span class="tools">
           	<a href="javascript:;" class="icon-chevron-up"></a>
       	</span>
	</div>
	<div class="widget-body form" style="display: none;">
		<form action="" method="post" class="form-horizontal">
			<div class="row-fluid">
				<div class="span6">
					<div class="control-group">
						<label for="imei" class="control-label">IMEI#</label>
						<div class="controls">
							<select class="span12 live_search" name="imei_no" required="required">
								<option value="">--Choose IMEI--</option>
								<?php
									$result = $device_mgt->getAllIMEIs();
									while ($rows = get_row_data($result)) {
								?>
								<option value="<?=$rows['imei_number']; ?>"><?=$rows['imei_number']; ?> - <?=$rows['model_name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="form-actions">
				<button class="btn btn-primary"><i class="icon-search"></i> Search</button>
			</div>
		</form>
	</div>
</div>

<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> Allocate Devices</h4></div>
	<div class="widget-body form">
		<?php
			if(isset($_SESSION['devices'])){
				echo $_SESSION['devices'];
			    unset($_SESSION['devices']);
	     	}
		?>
		<table id="table1" class="table table-bordered">
			<thead>
				<tr>
					<th>ID#</th>
					<th>Device</th>
					<th>IMEI#</th>
					<th>Description</th>
					<th>Customer</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$result = $device_mgt->listAllDevices($filter_key);
					while ($rows = get_row_data($result)) {
				?>
				<tr>
					<td><?=$rows['phone_id']; ?></td>
					<td><?=$rows['model_name']; ?></td>
					<td><?=$rows['imei_number']; ?></td>
					<td><?=$rows['description']; ?></td>
					<td><?=$rows['customer_name']; ?></td>
					<td>
						<?php 
							if($rows['status'] == '1'){ 
						?>
							<span class="label label-success">Issued</span>
						<?php }elseif($rows['status'] == '2'){ ?>
							<span class="label label-success">Not Available</span>
						<?php } ?>
					</td>
					<td>
						<?php 
							if($rows['status'] != '1' && $rows['status'] != '2'){ 
						?>
						<a href="#attach_device" class="btn btn-mini btn-success attach_detach" data-toggle="modal" device_id="<?=$rows['phone_id']; ?>"><i class="icon-paper-clip"></i> Attach</a>
						<?php }elseif($rows['status'] == '1'){
						?>
						<form action="" method="post">
							<input type="hidden" name="device_id" value="<?php echo $rows['phone_id']; ?>"/>
							<input type="hidden" name="action" value="detach_device" />
							<button class="btn btn-mini btn-danger detach_customer" cust_name="<?=$rows['customer_name']; ?>"><i class="icon-remove"></i> Detach</button>
						</form>
						<?php } ?>
					</td>
				</tr>
				<? } ?>
			</tbody>
		</table>
		<div class="clearfix"></div>
	</div>
</div>

<!-- The Modals -->
<form action="" method="post">
	<div id="attach_device" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Attach Customer</h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid">
	            <select name="customer" class="span12 live_search" required="required">
	            	<option value="">--Select Customer--</option>
	            	<?php
	            		$result = $device_mgt->getAllCustomers();
	            		while($rows = get_row_data($result)){
	            	?>
	            	<option value="<?=$rows['mf_id']; ?>"><?=$rows['customer_name']; ?></option>
	            	<?php } ?>
	            </select>     
	        </div>
	    </div>
		<!-- the hidden fields -->
		<input type="hidden" name="device_id" id="device_id"/>
		<input type="hidden" name="action" value="attach_device">
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can532'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav531'); ?>
		</div>
	</div>
</form>
<? set_js(array('src/js/allocate_devices.js')); ?>