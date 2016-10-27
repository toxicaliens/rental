<?php
include_once('src/models/SupportTickets.php');
$Support = new SupportTickets;

set_layout("dt-layout.php", array(
	'pageSubTitle' => 'All Maintenance Tickets',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Maintenance' ),
		array ( 'text'=>'All Maintenance Tickets' )
	)
));

?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-comments-alt"></i> All Maintenance Tickets</h4>
	    <span class="actions">
			<a href="#add_support" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i>Add Maintenance Ticket</a>
		</span>
	</div>
	<div class="widget-body form">
		<?php
		$Support->splash('support');
		// display all encountered errors
		(isset($_SESSION['support_error'])) ? $Support->displayWarnings('support_error') : '';
		?>
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			<tr>
			  	<th>ID#</th>
				<th>Category</th>
				<th>Complaint</th>
				<th>Reported By</th>
				<th>Status</th>
				<th>reported time</th>
			</tr>
 		</thead>
 	<tbody>
	 	<?php
			$result = $Support->allMaintenanceTickets();
			while ($rows = get_row_data($result)) {
				$time = $rows['reported_time'];
				$aDate = explode(" ", $time);
                    $date = $aDate[0];

		?>
		<tr>
			<td><?=$rows['maintenance_ticket_id']; ?></td>
			<td><?=$rows['category_name']; ?></td>
			<td><?=$rows['body']; ?></td>
			<td><?=$rows['customer_name']; ?></td>
			<td>
			<?php
			  if($rows['status'] == '1'){
		        echo 'Closed';
		      }else{
		        echo'Open';
		      }
			 ?>
			 </td>
			<td><?=$date; ?></td>
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
	<div id="add_support" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1"><i class="icon-comments"></i> Add Maintenance Ticket (Complains)</h3>
		</div>
		<div class="modal-body">
			<label for="">Categories</label>
			<div class="row-fluid">
				<select id="select2_sample3" name="category_id" class="span12" required>
					<option value="">--Select Category--</option>
					<?php
					$data = $Support->getVoucherCategories();
					while($rows = get_row_data($data)){
						?>
						<option value="<?=$rows['category_id']; ?>"><?=$rows['category_name']; ?></option>
					<?php } ?>
				</select>
			</div>

	        <div class="row-fluid">
	        	<label for="body" class="control-label">Message</label>
	        	<textarea name="body" class="span12" required></textarea>
	        </div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="add_support"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can592'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav591'); ?>
		</div>
	</div>
</form>
