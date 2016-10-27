<?php
include_once('src/models/SupportTickets.php');
$Support = new SupportTickets;

set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Issued Maintenance Tickets',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Maintenance Tickets' ),
		array ( 'text'=>'My Issued Maintenance Tickets' )
	)
	
));

?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> All My Issued Maintenance Tickets</h4></div>
	<div class="widget-body form">
		<?php
			if(isset($_SESSION['support'])){
				echo $_SESSION['support'];
			    unset($_SESSION['support']);
	     	}
		?>
		<table id="table1" class="table table-bordered">
			<thead>
				<tr>
					<th>Support Ticket</th>
					<th>Customer Account</th>
					<th>Subject</th>
					<th>Issue</th>
					<th>View</th>
					<th>Respond</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$result = $Support ->mySupportTickets();
					while ($rows = get_row_data($result)) {
						 $cust = $rows['customer_account_id'];
                       $data =$Support->getSupportCustomerName($cust);
				?>
				<tr>
					<td><?=$rows['support_ticket_id']; ?></td>
					<td><?=$data; ?></td>
					<td><?=$rows['subject']; ?></td>
					<td><?=$rows['body']; ?></td>
					<td><a href="?num=view_ticket&ticket_id=<?=$rows['support_ticket_id']; ?>" class="btn btn-mini"><i class="icon-eye-open"></i> View</a></td>
					<td> <?php
		                if($rows['status'] == '0'){
		              ?>
					<a href="#respond" class="btn btn-mini btn-success respond" 
			  data-toggle="modal" support_ticket_id="<?=$rows['support_ticket_id']; ?>"
			  subject="<?=$rows['subject']; ?>"><i class="icon-paper-clip"></i> Respond</a></td>
			      <?php }?>
				</tr>
				<? } ?>
			</tbody>
		</table>
		<div class="clearfix"></div>
	</div>
</div>

<!-- The Modals -->
<form action="" method="post">
	<div id="respond" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1"><i class="icon-comments"></i> Respond To Maintenance Tickets</h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid">
				<?php
					$result = $Support->getSupportMessageTypes();
					while($rows = get_row_data($result)){
				?>
	            <label class="checkbox" style="display: inline;">
                    <input type="radio" name="message_type" value="<?=$rows['message_type_id']; ?>"  checked="checked" readonly required/>
                     <?=$rows['message_type_name']; ?>
                </label>
                <?php } ?>
	        </div>
	        <br/>
	        <div class="row-fluid">
	        	<label for="support_ticket_id" class="control-label">Support Ticket</label>
	        	<!-- <input type="text" name="send_to" id="send_to" class="span12" required readonly/> -->
	        	<input type="text" name="support_ticket_id" id="support_ticket_id" class="span12" readonly/>
	        </div>
	        
	        <div class="row-fluid">
	        	<label for="subject">Subject</label>
	        	<input type="text" name="subject" value="" id="subject" class="span12" readonly/>
	        </div>
	        <div class="row-fluid">
	        	<label for="body" class="control-label">Message</label>
	        	<textarea name="body" class="span12" required></textarea>
	        </div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="add_Respond"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'can590'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sen589'); ?>
		</div>
	</div>
</form>
<? set_js(array('src/js/respond.js')); ?>