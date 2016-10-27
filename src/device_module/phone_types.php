<?php
include_once('src/models/Device_management.php');
$Device = new DeviceManagement;

set_layout("dt-layout.php", array(
	'pageSubTitle' => 'GTEL Models',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Device Management' ),
		array ( 'text'=>'Manage Models' )
	)
	
));
?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> Manage Models</h4>
		<span class="actions">
			<a href="#add_types" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Add</a>
			<a href="#edit_types" class="btn btn-small btn-success" id="edit_type_btn"><i class="icon-edit"></i> Edit</a>
			<a href="#delete_types" class="btn btn-small btn-danger" id="del_type_btn"><i class="icon-remove icon-white"></i> Delete</a>
		</span>
	</div>
	</br>
	<?
		if(isset($_SESSION['devices'])){
		echo $_SESSION['devices'];
	    unset($_SESSION['devices']);
     }
	?>
	<div class="widget-body form">
		<table id="table1" class="table table-bordered">
			<thead>
				<tr>
					<th>ID#</th>
					<th>Model Name</th>
					<th>Phone Specs</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$result = $Device->getAllDevices();
					while ($rows = get_row_data($result)) {
				?>
				<tr>
					<td><?=$rows['device_model_id']; ?></td>
					<td><?=$rows['model']; ?></td>
					<td><a href="?num=76&model=<?=$rows['device_model_id']; ?>" class="btn btn-mini"><i class="icon-tags"></i> Phone Specs</a></td>
				</tr>
				<? } ?>
			</tbody>
		</table>
		<div class="clearfix"></div>
	</div>
</div>

<!-- The Modals -->
<form action="" method="post">
	<div id="add_types" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Add Models</h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid">
	            <label for="model_name">Model Name:</label>
	            <input type="text" name="model_name" value="" class="span12" required>     
	        </div>

	        <div class="row-fluid">
	            <label for="insurance_policy">Policy:<span class="required">*</span></label>
	            <select class="span12" name="insurance_policy" required>
	            	<option value="">--choose policy--</option>
	            	<?php
	            		$result = $Device->getPhonePolicyType();
	            		while ($rows = get_row_data($result)){	            			
	            			?>
	            			<option value="<?=$rows['service_channel_id']; ?>"><?=$rows['service_option']; ?></option>
	            		<?php } ?>
	            </select>
	        </div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="add_phone_types"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo525'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav523'); ?>
		</div>
	</div>
</form>

<form action="" method="post">
	<div id="edit_types" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Edit Models</h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid">
	            <label for="model">Model Name:</label>
	            <input type="text" name="model" id="model" value="" class="span12" required>     
	        </div>

	        <div class="row-fluid">
	            <label for="insurance_policy">Policy:<span class="required">*</span></label>
	            <select class="span12 policy" name="insurance_policy" required>
	            	<!-- <option value="">--choose policy--</option> -->
	            	<?php
	            		$result = $Device->getPhonePolicyType();
	            		while ($rows = get_row_data($result)){	            			
	            			?>
	            			<option value="<?=$rows['service_channel_id']; ?>"><?=$rows['service_option']; ?></option>
	            		<?php } ?>
	            </select>
	        </div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="edit_phone_types"/>
		<input type="hidden" id="edit_id" name="edit_id"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can526'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav523'); ?>
		</div>
	</div>
</form>

<form action=""  method="post">
	<div id="delete_types" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Delete Models</h3>
		</div>
		<div class="modal-body">
			<p>Are you sure you want to delete the Model?</p>
		</div>
		<!-- hidden fields -->
		<input type="hidden" name="action" value="delete_phone_type"/>
		<input type="hidden" id="delete_id" name="delete_id"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No527'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes524'); ?>
		</div>
	</div>
</form>
<? set_js(array('src/js/manage_phone_types.js')); ?>