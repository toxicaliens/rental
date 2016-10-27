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
				<th><input type="checkbox" id="selectall"/> Select All</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$result = $device_mgt->getDeviceApps($_GET['device_id']);
				while($rows = get_row_data($result)){
			?>
			<tr>
				<td><?=$rows['device_app_id']; ?></td>
				<td><?=$rows['app_id']; ?></td>
				<td><?=$rows['app_name']; ?></td>
				<td><?=($rows['active'] == 't') ? "<span class=\"label label-success\">Active</span>": "<span class=\"label label-warning\">Inactive</span>"; ?></td>
				<td>
					<input type="checkbox" class="checkbox1" name="status<?=$rows['device_app_id']; ?>" value="1" <?=($rows['active'] == 't') ? 'checked': ''; ?>/>
					<!-- hidden fields -->
					<input type="hidden" name="edit_id<?=$rows['device_app_id']; ?>" value="<?=$rows['device_app_id']; ?>" />
					<input type="hidden" name="device_id" value="<?=$_GET['device_id']; ?>"/>
					<input type="hidden" name="action" value="manage_apps"/>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<div class="clearfix"></div>
	<div class="form-actions">
		<?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
	</div>
</form>

<? set_js(array('src/js/select_all.js')); ?>