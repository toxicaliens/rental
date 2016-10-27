<?php
include_once('src/models/Device_management.php');
$Device = new DeviceManagement;

set_layout("dt-layout.php", array(
	'pageSubTitle' => 'All Customer Accounts',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Device Management' ),
		array ( 'text'=>'All Phones' )
	)
	
));
?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> Manage Customer Accounts</h4>
		<span class="actions">
			<a href="#add_phone" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Add</a>
			<a href="#edit_phone" class="btn btn-small btn-success" id="edit_phone_btn"><i class="icon-edit"></i> Edit</a>
			<a href="#delete_phone" class="btn btn-small btn-danger" id="del_phone_btn"><i class="icon-remove icon-white"></i> Delete</a>
		</span>
	</div>
	</br>
	<div class="widget-body form">
	 	<?php $Device->splash('phone');	?>
		<table id="table1" class="table table-bordered">
			<thead>
				<tr>
					<th>ID#</th>
					<th>Model</th>
					<th>IMEI No:</th>
					<th>Customer</th>
					<th>Acc. Code</th>
					<th>Referee</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$result = $Device->getAllPhones();
					while ($rows = get_row_data($result)) {
				?>
				<tr>
					<td><?=$rows['customer_account_id']; ?></td>
					<td><?=$rows['model']; ?></td>
					<td><?=$rows['imei']; ?></td>
					<td><?=$rows['customer_name']; ?></td>
					<td><?=$rows['customer_code']; ?></td>
					<td><?=$Device->getReferee($rows['referee_mf_id']); ?></td>
					
				</tr>
				<? } ?>
			</tbody>
		</table>
		<div class="clearfix"></div>
	</div>
</div>

<!-- The Modals -->
<form action="" method="post">
	<div id="add_phone" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Add Phones </h3>
		</div>
		<div class="modal-body">
		     <div class="row-fluid">
	            <label for="model_id">Model:</label>
	            <select name="model_id" id="" class="span12" required>
	               <option value="">--Choose Model--</option>
	            	<?php
	            		//get all devices
	            		$result = $Device->getDeviceName();
	            		while ($rows = get_row_data($result)) {
	            	?>
	            	<option value="<?=$rows['device_model_id']; ?>"><?=$rows['model']; ?></option>
	            	<?php } ?>
	            </select>     
	        </div>
		   
			<div class="row-fluid">
	            <label for="imei">IMEI Number:</label>
	            <input type="text" name="imei" value="" class="span12" required>     
	        </div>

            <div class="row-fluid" style="margin-bottom: 10px;">
				<label for="customer_code" class="control-label">Customer Code:<span class="required">*</span> </label>
				<div class="controls">
					<input type="text" class="span12" name="customer_code" required />
				</div>
			</div>

	        <div class="row-fluid">
	            <select name="customer" class="span12 live_search" id="select_customer" required="required">
	            	<option value="">--Select Customer--</option>
	            	<?php
	            		$result = $Device->getAllCustomers();
	            		while($rows = get_row_data($result)){
	            	?>
	            	<option value="<?=$rows['mf_id']; ?>"><?=$rows['customer_name']; ?> (<?=$rows['id_passport']; ?>)</option>
	            	<?php } ?>
	            </select>     
	        </div>
            <br>
            <div class="row-fluid" style="margin-bottom: 10px;">
	            <label for="issued_phone">Issued Phone No:</label>
	            <input type="number" name="issued_phone" value="" min="0" class="span12" required>     
	        </div>
	        <div class="row-fluid" style="margin-bottom: 10px;">
	        	<!-- <label for="referee_mf_id">Referee</label> -->
	        	<select name="referee" class="span12" id="referee" title="Choose Referee">
	        		<option value="">--Choose Referee--</option>
	        	</select>
	        </div>
	        <div class="row-fluid">
	        	<label for="repayment_date">Repayment Due Date(Monthly):</label>
	        	<input type="number" min="0" class="span12" name="repayment_due_date" max="31" />
	        </div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="add_phone"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo529'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav528'); ?>
		</div>
	</div>
</form>

<!-- edit model -->
<form action="" method="post">
	<div id="edit_phone" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Edit Phones </h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid">
	            <label for="imei">IMEI Number:</label>
	            <input type="text" name="imei" id="imei" class="span12" required>     
	        </div>

            <div class="row-fluid">
                <label for="issued_phone">Issue Phone:</label>
                <input type="text" name="issued_phone" id="issued_phone" class="span12" required/>
            </div>
		</div>
		
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="edit_phone"/>
		<input type="hidden" id="edit_id" name="edit_id"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can533'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav528'); ?>
		</div>
	</div>
</form>

<form action=""  method="post">
	<div id="delete_phone" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Delete Phones</h3>
		</div>
		<div class="modal-body">
			<p>Are you sure you want to delete the Phone?</p>
		</div>
		<input type="hidden" name="status" id="status"/>
		<input type="hidden" name="action" value="delete_phone"/>
		<input type="hidden" id="delete_id" name="delete_id"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No535'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes534'); ?>
		</div>
	</div>
</form>

<? set_js(array('src/js/manage_phone.js')); ?>
