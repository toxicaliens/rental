<?php
	include_once('src/models/Device_management.php');
	$device_mgt = new DeviceManagement;

	set_layout("dt-layout.php", array(
		'pageSubTitle' => 'Active Group Apps',
		'pageSubTitleText' => '',
		'pageBreadcrumbs' => array (
			array ( 'url'=>'index.php', 'text'=>'Home' ),
			array ( 'text'=>'Device Management' ),
			array ( 'url'=>'?num=75', 'text'=>'Manage Groups' ),
			array ( 'text'=>'Active Group Apps' )
		)
	));

	$rows = $device_mgt->getGroupDetails($_GET['group_id']);
?>
<div class="widget">
  <div class="widget-title">
    <h4><i class="icon-order"></i>Group Name: <span style="color:green;"><?=$rows['group_name']; ?> </span></h4>
  </div>
  <div class="widget-body form">
    <?php
	if(isset($_SESSION['manage_apps'])){
		echo $_SESSION['manage_apps'];
		unset($_SESSION['manage_apps']);
	}
?>
<form action="" method="post">
	<table id="table1" class="table table-bordered">
		<thead>
			<tr>
				<th>Dev.App#</th>
				<th>App#</th>
				<th>App Name</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$result = $device_mgt->getActiveGroupDevicesApps($_GET['group_id']);
				$count = 1;
				while($rows = get_row_data($result)){
			?>
			<tr>
				<td><?=$rows['device_group_app_allocation_id']; ?></td>
				<td><?=$rows['app_id']; ?></td>
				<td><?=$rows['app_name']; ?></td>
				<td><?=($device_mgt->checkForExistingGroupApp($_GET['group_id'], $rows['app_id'])) ? "<span class=\"label label-success\">Active</span>": "<span class=\"label label-warning\">Inactive</span>"; ?></td>
			</tr>
			<?php 
				$count++;
				} ?>
		</tbody>
	</table>
	<div class="clearfix"></div>
	</form>
  </div>
</div>