<?php
include_once('src/models/GpayWallet.php');
$gpay = new GpayWallet;

set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Gpay Customer Balances',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Gpay Wallet' ),
		array ( 'text'=>'Manage Customer Balances' )
	)
	
));
?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> Manage Customer Balances</h4>
		<span class="actions">
			<a href="#add_balance" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Add</a>
			<a href="#edit_balance" class="btn btn-small btn-success" id="edit_type_btn"><i class="icon-edit"></i> Edit</a>
			<a href="#delete_balance" class="btn btn-small btn-danger" id="del_type_btn"><i class="icon-remove icon-white"></i> Delete</a>
		</span>
	</div>
	</br>
	<div class="widget-body form">
		<?php
			if(isset($_SESSION['customer_balance'])){
				echo $_SESSION['customer_balance'];
			    unset($_SESSION['customer_balance']);
	     	}
		?>
		<table id="table1" class="table table-bordered">
			<thead>
				<tr>
					<th>ID#</th>
					<th>Customer Name</th>
					<th>Balance</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$result = $gpay->getCustomerBalances();
					while ($rows = get_row_data($result)) {
				?>
				<tr>
					<td><?=$rows['mf_id']; ?></td>
					<td><?=$rows['customer_name']; ?></td>
					<td><?=number_format($rows['balance'], 2); ?></td>
				</tr>
				<? } ?>
			</tbody>
		</table>
		<div class="clearfix"></div>
	</div>
</div>

<!-- The Modals -->
<form action="" method="post">
	<div id="add_balance" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Add Customer Balance</h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid" style="margin-bottom: 10px;">
	            <select name="customer" class="span12 live_search" required>
	            	<option value="">--Choose Customer--</option>
	            	<?php
	            		$result = $gpay->getAllCustomers();
	            		while ($rows = get_row_data($result)) {
	            	?>
	            	<option value="<?=$rows['mf_id']; ?>"><?=$rows['customer_name']; ?></option>
	            	<?php } ?>
	            </select>     
	        </div>
	        <div class="row-fluid">
	        	<label for="balance">Balance:</label>
	        	<input type="number" step="0.01" min="0" class="span12" name="balance" required/>
	        </div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="add_customer_balance"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo593'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav594'); ?>
		</div>
	</div>
</form>

<form action="" method="post">
	<div id="edit_balance" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Edit Customer Balance</h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid" style="margin-bottom: 10px;">
	            <select name="customer" class="span12" id="customer" required>
	            	<option value="">--Choose Customer--</option>
	            	<?php
	            		$result = $gpay->getAllCustomers();
	            		while ($rows = get_row_data($result)) {
	            	?>
	            	<option value="<?=$rows['mf_id']; ?>"><?=$rows['customer_name']; ?></option>
	            	<?php } ?>
	            </select>     
	        </div>
	        <div class="row-fluid">
	        	<label for="balance">Balance:</label>
	        	<input type="number" step="0.01" min="0" class="span12" name="balance" required id="balance" />
	        </div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="edit_customer_balance"/>
		<input type="hidden" name="edit_id" id="edit_id"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can595'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav596'); ?>
		</div>
	</div>
</form>

<form action=""  method="post">
	<div id="delete_balance" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Delete Customer Balance</h3>
		</div>
		<div class="modal-body">
			<p>Are you sure you want to delete the Balance?</p>
		</div>
		<!-- hidden fields -->
		<input type="hidden" name="action" value="delete_customer_balance"/>
		<input type="hidden" id="delete_id" name="delete_id"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No597'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes598'); ?>
		</div>
	</div>
</form>
<? set_js(array('src/js/customer_balance.js')); ?>