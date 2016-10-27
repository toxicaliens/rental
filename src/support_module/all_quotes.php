<?php
include_once('src/models/Quotes.php');
$Quotes = new Quotes;

if(App::isAjaxRequest()){
	$Quotes->getQuoteDataFromQuoteId($_POST['quote_id']);
}else{
	set_layout("dt-layout.php", array(
		'pageSubTitle' => 'Manage Quotations',
		'pageSubTitleText' => '',
		'pageBreadcrumbs' => array (
			array ( 'url'=>'index.php', 'text'=>'Home' ),
			array ( 'text'=>'Maintenance Tickets' ),
			array ( 'text'=>'Manage Quotations' )
		)
	));

?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-comments-alt"></i> All Quaotations</h4>
	    <span class="actions">
			<a href="#add-quotation" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i>Add a Quotation</a>
		</span>
	</div>
	<div class="widget-body form">
	<?php 
		if(isset($_SESSION['quotes'])){
			echo $_SESSION['quotes'];
			unset($_SESSION['quotes']);
		     }
	?>
	
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			<tr>
			  	<th>ID#</th>
				<th>Bid Amount</th>

				<th>Bid Date</th>
				<th>Status</th>
				<th>Job Status</th>
				<th>Edit</th>
				<th>Delete</th>
				<th>Task</th>

				<!-- <th>View</th> -->
			</tr>
 		</thead>
 	<tbody>
	 		<?php

	 		$result = $Quotes->allQuotations($_SESSION['mf_id']);

	 		while ($rows = get_row_data($result)) {

	 		?>
		<tr>
				<td><?php echo $rows['qoute_id'] ;?></td>
				<td><?php echo $rows['bid_amount'] ; ?></td>

				<td><?php echo $rows['bid_date'] ;?></td>
				<td><?php echo ($rows['bid_status'] == 't') ? 'Approved':'Pending'  ;?></td>
				<td><?php echo $Quotes->checkIfQuoteWasApproved($rows['bid_status'], $rows['job_status']); ?></td>
				<td><a href="#edit-quotation" class="btn btn-mini btn-warning edit_quot" edit-id="<?php echo $rows['qoute_id']; ?>" data-toggle="modal"><i class="icon-edit"></i> Edit</a></td>
				<td><a href="#delete_quotaion" class="btn btn-mini btn-danger del_quot" edit-id="<?php echo $rows['qoute_id']; ?>" data-toggle="modal"><i class="icon-trash"></i> Delete</a></td>
				<td><?php echo ($rows['bid_status'] == 't') ? '<a href="#mark-complete" class="btn btn-mini btn-success mark-complete" edit-id="<?php  ?>" data-toggle="modal"><i class="icon-tick"></i> Mark as complete</a>':'' ;?></td>

		</tr>
		<?php
			}
		?>

  </tbody>

</table>
<div class="clearfix"></div>
</div>
</div>

<!-- The Modals -->
<form action="" method="post">
	<div id="add-quotation" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1"><i class="icon-comments"></i> Add Quotation</h3>
		</div>
		<div class="modal-body">
	        <div class="row-fluid">
	        	Quation

	        </div>

	        <div class="row-fluid">
	        	<label for="bid_amount" class="control-label">Bid Amount</label>
	        	<input type="number" name="bid_amount" class="span12" required="true">
	        </div>

	        <div class="row-fluid">
	        <label for="maintainance" class="control-label">Maintainance</label>
	        	 <select name="maintainance" class="span12" required="required">
	            	<option value="">--Select Maintainance--</option>
	            	<?php
	            		$result = $Quotes->getAllMaintainance();
	            		while($rows = get_row_data($result)){
	            	?>
	            	<option value="<?=$rows['voucher_id']; ?>"><?=$rows['maintenance_name']; ?></option>
	            	<?php } ?>
	            </select>
	        </div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="add_quotation"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo656'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav655'); ?>
		</div>
	</div>
</form>
  <!-- modal for edit -->
<form action="" method="post">
	<div id="edit-quotation" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1"><i class="icon-comments"></i> Edit Quotation</h3>
		</div>
		<div class="modal-body">
	        <div class="row-fluid">
	        	Quotation

	        </div>

	        <div class="row-fluid">
	        	<label for="bid_amount" class="control-label">Bid Amount</label>
	        	<input type="number" name="bid_amount" id="bid_amount" class="span12" required="true">
	        </div>

	        <div class="row-fluid">
	        <label for="maintainance" class="control-label">Maintainance</label>
	        	 <select name="maintainance" id="add-maintenance" class="span12" required="required">
	            	<option value="">--Select Maintainance--</option>
	            	<?php
	            		$result = $Quotes->getAllMaintainance();
	            		while($rows = get_row_data($result)){
	            	?>
	            	<option value="<?=$rows['voucher_id']; ?>"><?=$rows['maintenance_name']; ?></option>
	            	<?php } ?>
	            </select>
	        </div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="edit_quotation"/>
		<input type="hidden" name="edit_id" id="edit_id"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo658'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav657'); ?>
		</div>
	</div>
</form>

<!-- delete modal -->
<form action=""  method="post">
    <div id="delete_quotaion" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Delete Quotation</h3>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete the quotation?</p>
        </div>
        <!-- hidden fields -->
        <input type="hidden" name="action" value="delete_quotation"/>
        <input type="hidden" id="delete_id" name="delete_id"/>
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No659'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes660'); ?>
        </div>
    </div>
</form>


<!-- mark as complete modal -->
<form action=""  method="post">
    <div id="mark-complete" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Mark job as complete</h3>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to mark this job as complete?</p>
        </div>
        <!-- hidden fields -->
        <input type="hidden" name="action" value="mark_complete"/>
        <input type="hidden" id="delete_id" name="mark_complete"/>
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No659'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes660'); ?>
        </div>
    </div>
</form>
<? set_js(array('src/js/quotation.js')); } ?>