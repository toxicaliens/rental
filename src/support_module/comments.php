<?php
	if(isset($_SESSION['done-deal'])){
		echo ($_SESSION['done-deal']);
		unset ($_SESSION['done-deal']);
	}
?>
<a href="#add_comment" data-toggle="modal" class="btn btn-small btn-success"><i class="icon-plus"></i> Add Comment</a>
<table id="table1" class="table table-bordered">
	<thead>
		<tr>
			<th>Comments</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$result = $supp_tickets->getTicketComments($_GET['ticket_id']);
			while($rows = get_row_data($result)){
			    $created_date = $rows['created'];
                $aDate = explode(".", $created_date);
                $date = $aDate[0];
		?>
		<tr>
			<td><?=$date; ?> | Response by <?=$rows['user_name']; ?><br><?=$rows['body']; ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<form action="" method="post">
	<div id="add_comment" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Add Comment</h3>
		</div>
		<div class="modal-body">
	        <div class="row-fluid">
	            <label for="subject">Comment:</label>
	            <textarea name="comment" value="" class="span12" required></textarea>    
	        </div>	        
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="add_comment"/>
		<input type="hidden" name="subject" value="Ticket#<?=$_GET['ticket_id']; ?> <?=$row['subject']; ?>"/>
		<input type="hidden" name="ticket_id" value="<?=$_GET['ticket_id']; ?>"/>
		<input type="hidden" name="recip_id" value="<?=$row['customer_account_id']; ?>"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo600'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav601'); ?>
		</div>
	</div>
</form>