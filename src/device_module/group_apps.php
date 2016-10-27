<?php
	if(isset($_SESSION['manage_apps'])){
		echo $_SESSION['manage_apps'];
		unset($_SESSION['manage_apps']);
	}

	$result = $device_mgt->getallAllocatedGroup($_SESSION['mf_id'], $_GET['group_id']);
	$num_rows = get_num_rows($result);
	if($num_rows >= 1){
?>
<form action="" method="post">
	<table id="table1" class="table table-bordered3">
		<thead>
			<tr>
				<th>Dev.App#</th>
				<th>App#</th>
				<th>App Name</th>
				<th>Status</th>
				<th><input type="checkbox" id="selectall"/> Select All</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$result = $device_mgt->getGroupDevicesApps($_GET['group_id']);
				$count = 1;
				while($rows = get_row_data($result)){
			?>
			<tr>
				<td><?=$rows['device_app_id']; ?></td>
				<td><?=$rows['app_id']; ?></td>
				<td><?=$rows['app_name']; ?></td>
				<td><?=($device_mgt->checkForExistingGroupApp($_GET['group_id'], $rows['app_id'])) ? "<span class=\"label label-success\">Active</span>": "<span class=\"label label-warning\">Inactive</span>"; ?></td>
				<td>
					<input type="checkbox" class="checkbox1" name="status<?=$count; ?>" value="1" <?=($device_mgt->checkForExistingGroupApp($_GET['group_id'], $rows['app_id'])) ? 'checked': ''; ?>/>
					<!-- hidden fields -->
					<input type="hidden" name="edit_id<?=$count; ?>" value="<?=$rows['app_id']; ?>" />
					<input type="hidden" name="group_id" value="<?=$_GET['group_id']; ?>"/>
					<input type="hidden" name="action" value="attach_apps_to_groups"/>
				</td>
			</tr>
			<?php 
				$count++;
				} ?>
		</tbody>
	</table>
	<div class="clearfix"></div>
	<div class="form-actions">
		<?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
	</div>
	<input type="hidden" name="total_apps" value="<?=($count-1); ?>"/>
</form>
<?php
	}else{
?>
<div class="alert alert-warning">
    <button class="close" data-dismiss="alert">×</button>
   	No devices have been attached to this group yet.
</div>
<?php } ?>
<? set_js(array('src/js/select_all.js')); ?>