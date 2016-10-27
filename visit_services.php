<?php
	if(isset($_SESSION['visit_profile'])){
		echo $_SESSION['visit_profile'];
		unset($_SESSION['visit_profile']);
	}
?>
<a href="#add" data-toggle="modal" class="btn btn-small btn-primary" id="pay_btn"><i class="icon-plus"></i> Add</a>
<a href="#delete" class="btn btn-small btn-danger" id="del_vs_btn"><i class="icon-remove icon-white"></i> Remove</a>
</br></br>
<table id="table17" class="table table-bordered">
	<thead>
		<tr>
			<th>ID#</th>
			<th>Service Name</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php
			if(isset($_GET['visit_id'])){
				$result = $visits->getServices($_GET['visit_id']);
				while ($rows = get_row_data($result)) {
					$amount = $rows['quantity'] * $rows['price'];
		?>	
		<tr>
			<td><?=$rows['service_id']; ?></td>
			<td><?=$rows['service_option']; ?></td>
			<td><?=$rows['quantity']; ?></td>
			<td><?=$rows['price']; ?></td>
			<td><?=$amount; ?></td>
		</tr>
		<?php
				}
			}
		?>
	</tbody>
</table>
<!-- The modals -->
<form action="" method="post">
	<div id="add" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="myModalLabel1">Add Service</h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid">
	            <!-- <label for="visit_name">Patient:</label> -->
	            <select name="service_chan" class="span12" id="select2_sample15" required>
	            	<option value="">--Choose Service--</option>
					<?php
						$result = $visits->getAllServiceOption();
						while ($rows = get_row_data($result)) {
					?>
					<option value="<?=$rows['service_channel_id']; ?>"><?=$rows['service_option'].' - '.$rows['option_code']; ?></option>
					<?php }	?>
				</select>     
	        </div>
	        <br/>
	        <div>
	        	<label for="price">price</label>
	        	<input type="text" name="price" id="select_price" class="span12" value="" readonly/>
	        </div>
	        <br/>
	        <div>
	        	<label for="quantity">Quantity</label>
	        	<input type="number" name="quantity" class="span12" reqiured/>
	        </div>       
	       
	        <div class="row-fluid">
	        	<label for="desc">Description:</label>
	        	<textarea name="desc" class="span12" style="font-style: italic"></textarea>
	        </div>

		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="mf_id" value="<?=$mf_id; ?>"/>
		<input type="hidden" name="visit_id" value="<?=$_GET['visit_id']; ?>"/>
		<input type="hidden" name="action" value="add_visit_service"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo511'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav512'); ?>
		</div>
	</div>
</form>

<form action="" id="delete_visit" method="post">
	<div id="delete" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Remove Service</h3>
		</div>
		<div class="modal-body">
			<p>Are you sure you want to delete the selected service?</p>
		</div>
		<!-- hidden fields -->
		<input type="hidden" name="action" value="remove_visit_service"/>
		<input type="hidden" name="visit_id" value="<?=$_GET['visit_id']; ?>"/>
		<input type="hidden" id="delete_id" name="delete_id"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No522'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes521'); ?>
		</div>
	</div>
</form>

<!-- additional js -->
<?php set_js(array("src/js/price.js")); ?>