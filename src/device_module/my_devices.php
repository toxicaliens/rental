<?php
include_once('src/models/Device_management.php');
$device_mgt = new DeviceManagement;

set_layout("dt-layout.php", array(
	'pageSubTitle' => 'My Devices',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Device Management' ),
		array ( 'text'=>'Manage My Devices' )
	)
	
));

if(isset($_POST['imei_no'])){
	$filter_key = $_POST['imei_no'];
}else{
	$filter_key = '';
}
?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> All My Devices</h4></div>
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
					<th>Manage</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$result = $device_mgt->listMyDevices();
					while ($rows = get_row_data($result)) {
				?>
				<tr>
					<td><?=$rows['phone_id']; ?></td>
					<td><?=$rows['model_name']; ?></td>
					<td><?=$rows['imei_number']; ?></td>
					<td><?=$rows['description']; ?></td>
					<td><a target="_blank" href="?num=74&device_id=<?=$rows['phone_id']; ?>" class="btn btn-mini attach_detach"><i class="icon-paper-clip"></i> Manage Device</a></td>
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