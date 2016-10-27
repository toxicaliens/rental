<?php
include_once('src/models/LeaseAgreement.php');
$lease = new LeaseAgreement();

set_title('Lease Agreement');
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Lease Agreement',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'CRM' ),
		array ( 'text'=>'Lease Agreement' )
	)
	
));
?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> Lease Agreement</h4>
		<span class="actions">
			<a href="#add_lease" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Add</a>
			<!-- <a href="#edit_phone" class="btn btn-small btn-success" id="edit_phone_btn"><i class="icon-edit"></i> Edit</a> -->
			<!-- <a href="#delete_phone" class="btn btn-small btn-danger" id="del_phone_btn"><i class="icon-remove icon-white"></i> Delete</a> -->
		</span>
	</div>
	</br>
	<div class="widget-body form">
		<?php
			if(isset($_SESSION['lease_agreement'])){
				echo $_SESSION['lease_agreement'];
				unset($_SESSION['lease_agreement']);
			}
		?>
		<table id="table1" class="table table-bordered">
			<thead>
				<tr>
					<th>ID#</th>
					<th>Tenant</th>
					<th>House</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>View Statement</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$rowz = $lease->getAllLeaseAgreements();
					if(count($rowz)){
						foreach ($rowz as $rows) {
				?>
				<tr>
					<td><?=$rows['lease_id']; ?></td>
					<td><?=$rows['tenant']; ?></td>
					<td><?=$rows['house_number']; ?></td>
					<td><?=$rows['start_date']; ?></td>
					<td><?=$rows['end_date']; ?></td>	
					<td><a href="?num=view_statement&tenant_id=<?php echo $rows['tenant']; ?>" class="btn btn-mini"><i class="icon-eye-open"></i> View</td>
				</tr>
				<? }} ?>
			</tbody>
		</table>
		<div class="clearfix"></div>
	</div>
</div>

<!-- The Modals -->
<form action="" method="post">
	<div id="add_lease" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Add Lease Agreement </h3>
		</div>
		<div class="modal-body">
		     <div class="row-fluid">
	            <label for="tenant">Tenant:</label>
	            <select name="tenant" class="span12 live_search" required>
	               	<option value="">--Choose Tenant--</option>
	            	<?php
	            		$tenants = $lease->getMfByBrole(Tenant);
	            		if(count($tenants)){
	            			foreach ($tenants as $tenant) {
	            	?>
	            	<option value="<?php echo $tenant['mf_id']; ?>"><?php echo $tenant['surname'].' '.$tenant['firstname'].' '.$tenant['middlename'].' ('.$tenant['id_passport'].')'; ?></option>
	            	<?php }} ?>
	            </select>     
	        </div>
		   
			<div class="row-fluid">
	            <label for="houses">House:</label>
	            <select name="house" class="span12 live_search" required>
	               	<option value="">--Choose House--</option>
					<?php
					$house=run_query("SELECT * from houses_and_plots");
					while ($fetch=get_row_data($house))
					{?>
						<option value="<?php echo $fetch['house_id']; ?>"><?php echo $fetch['house_number'].' - '.$fetch['plot_name']; ?></option>

	            	<?php }?>
	            </select>     
	        </div>

            <div class="row-fluid" style="margin-bottom: 10px;">
				<label for="customer_code" class="control-label">Start Date:<span class="required">*</span> </label>
				<div class="controls">
					<input type="date" name="start_date" required class="span12" />
				</div>
			</div>

			<div class="row-fluid" style="margin-bottom: 10px;">
				<label for="customer_code" class="control-label">End Date:<span class="required">*</span> </label>
				<div class="controls">
					<input type="date" name="end_date" required class="span12" />
				</div>
			</div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="add_lease_agreement"/>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			<button class="btn btn-primary">Add</button>
		</div>
	</div>
</form>

<!-- <? //set_js(array('src/js/manage_phone.js')); ?> -->