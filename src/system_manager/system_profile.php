<?php
	include_once('src/models/SystemProfile.php');
	$system = new SystemProfile();
	set_title('Set Profile | Oriems');
	set_layout('dt-layout.php', array(
			'pageSubTitle' => 'System Profile',
			'pageSubTitleText' => '',
			'pageBreadcrumbs' => array(
				array('url'=>'index.php', 'text'=>'Home'),
				array('text'=>'System Manager'),
				array('text'=>'System Profile')
			)
		)
	);
?>

<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> System Settings</h4>
		<span class="actions">
			<a href="#add_setting" class="btn btn-small btn-primary" data-toggle="modal"><i class="icon-plus"></i> Add Setting</a>
		</span>
	</div>
	<div class="widget-body form">
	<?php
		if(isset($_SESSION['setting'])){
			echo $_SESSION['setting'];
			unset($_SESSION['setting']);
		}
	?>
	<table id="table1" class="table table-bordered">
		<thead>
			<tr>
				<th>Setting#</th>
				<th>Setting Name</th>
				<th>Setting Value</th>
				<th>Setting Code</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$rows = $system->getSystemData();
				if(count($rows)){
					foreach ($rows as $row) {
			?>
			<tr>
				<td><?php echo $row['setting_id']; ?></td>
				<td><?php echo $row['setting_name']; ?></td>
				<td><?php echo $row['setting_value']; ?></td>
				<td><?php echo $row['setting_code']; ?></td>
				<td><a href="#edit_setting" class="btn btn-mini edit_btn" edit-id="<?php echo $row['setting_id']; ?>" data-toggle="modal"><i class="icon-edit"></i> Edit</a></td>
				<td><a href="#delete_setting" class="btn btn-mini delete_btn" delete-id="<?php echo $row['setting_id']; ?>" data-toggle="modal"><i class="icon-trash"></i> Delete</a></td>
			</tr>
			<?php
					}
				}
			?>
		</tbody>
	</table>
	<div class="clearfix"></div>
</div>

<!-- begin modals -->
<form action="" method="post">
	<div id="add_setting" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1"><i class="icon-plus"></i> Add Setting </h3>
		</div>
		<div class="modal-body">
		    <div class="row-fluid">
	            <label for="setting_name">Name:</label>
	           	<input type="text" name="setting_name" required class="span12" />
	        </div>
	        <div class="row-fluid">
	            <label for="setting_value">Value:</label>
	           	<input type="text" name="setting_value" required class="span12" />
	        </div>
	        <div class="row-fluid">
	            <label for="setting_code">Code:</label>
	           	<input type="text" name="setting_code" required class="span12" />
	        </div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="add_setting"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo637'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav636'); ?>
		</div>
	</div>
</form>
<form action="" method="post">
	<div id="edit_setting" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1"><i class="icon-edit"></i> Edit Setting </h3>
		</div>
		<div class="modal-body">
		    <div class="row-fluid">
	            <label for="setting_name">Name:</label>
	           	<input type="text" name="setting_name" id="setting_name" required class="span12" />
	        </div>
	        <div class="row-fluid">
	            <label for="setting_value">Value:</label>
	           	<input type="text" name="setting_value" id="setting_value" required class="span12" />
	        </div>
	        <div class="row-fluid">
	            <label for="setting_code">Code:</label>
	           	<input type="text" name="setting_code" id="setting_code" required class="span12" />
	        </div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="edit_setting"/>
		<input type="hidden" name="edit_id" id="edit_id" />
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can638'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav640'); ?>
		</div>
	</div>
</form>
<form action="" method="post">
	<div id="delete_setting" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1"><i class="icon-trash"></i> Delete Setting </h3>
		</div>
		<div class="modal-body">
			<p>Are you sure you want to delete the selected setting?</p>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="delete_setting"/>
		<input type="hidden" name="delete_id" id="delete_id" />
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No639'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes641'); ?>
		</div>
	</div>
</form>
<!-- end modals -->
<?php set_js(array('src/js/settings.js')); ?>