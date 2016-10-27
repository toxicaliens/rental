<?php
	include_once('src/models/Broadcast.php');
	$broadcast = new Broadcast;
if(App::isAjaxRequest()){
	if (isset($_POST['action'])){
		$action = $_POST['action'];
		switch ($action){
			case 'all_tenants':
				$result = $broadcast->getTenantGroup();
				echo json_encode($result);
				break;
		}
	}

}else{

	set_title('Send Broadcast');
	set_layout("dt-layout.php", array(
		'pageSubTitle' => 'Broadcasts',
		'pageSubTitleText' => '',
		'pageBreadcrumbs' => array (
			array ( 'url'=>'index.php', 'text'=>'Home' ),
			array ( 'text'=>'Broadcast' ),
			array ( 'text'=>'Send a Broadcast' )
		)
		
	));
?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-rss"></i> Broadcast</h4>
		<span class="actions">
			<a href="#add_types" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Add</a>
			<!-- <a href="#edit_types" class="btn btn-small btn-success" id="edit_type_btn"><i class="icon-edit"></i> Edit</a> -->
			<!-- <a href="#delete_types" class="btn btn-small btn-danger" id="del_type_btn"><i class="icon-remove icon-white"></i> Delete</a> -->
		</span>
	</div>
	</br>
	<div class="widget-body form">
		<?php
			$broadcast->splash('broadcast');
			(isset($_SESSION['warnings'])) ? $broadcast->displayWarnings('warnings') : '';
		?>
		<table id="table1" class="table table-bordered">
			<thead>
				<tr>
					<th>ID#</th>
					<th>From</th>
					<th>Subject</th>
					<th>Body</th>
					<th>To</th>
					<th>Type</th>
					<th>Created</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$result = $broadcast->getAllBroadcasts();
					while ($rows = get_row_data($result)) {
				?>
				<tr>
					<td><?php echo $rows['message_id']; ?></td>
					<td><?php //echo $broadcast->getUser($rows['sender']); ?></td>
					<td><?php echo $rows['subject']; ?></td>
					<td><?php echo $rows['body']; ?></td>
					<td title="<?php echo $broadcast->getCustomerNames($rows['recipients'], $rows['message_type_id']); ?>"><span><?=substr($broadcast->getCustomerNames($rows['recipients'], $rows['message_type_id']),0,100); ?></span></td>
					<td><?php echo $broadcast->getMessageTypeName($rows['message_type_id']); ?></td>
					<td><?php echo $rows['created']; ?></td>
					<td><?php echo ($rows['status'] == 0) ? 'Pending': 'Sent'; ?></td>
				</tr>
				<?php } ?>
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
			<h3 id="myModalLabel1"><i class="icon-rss"></i> Broadcast</h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid">
				<?php
					$result = $broadcast->getMessageTypes();
					while($rows = get_row_data($result)){
				?>
	            <label class="checkbox" style="display: inline;">
                    <input type="radio" name="broad_cast_type" <?=($rows['message_type_code'] == 'INBOX') ? 'checked': ''; ?> value="<?=$rows['message_type_id']; ?>" required/> <?=$rows['message_type_name']; ?>
                </label>
                <?php } ?>
	        </div>
	        <br/>
	        <div class="row-fluid">
	        	<label for="send_to" class="control-label">Send to</label>
	        	<select name="send_to" class="span12" required id="send_to">
	        		<option value="">--Choose--</option>
					<option value="Client Groups">Client Groups</option>
					<option value="Specific">Specific Customers</option>
	        	</select>
	        </div>
	        <div class="row-fluid" style="margin-bottom: 10px; display: none;" id="specific">
	        	Recipients
		        <select id="select2_sample2" name="recipients[]" class="span12 specific_customers" multiple>
		            <?php 
		            	$results = $broadcast->selectQuery('masterfile','mf_id, surname, middlename, firstname');
						if (count($results)){
					foreach ($results as $result){
						?>
						<option value="<?php echo $result['mf_id']?>"><?php echo $result['surname'].' '.$result['firstname'].' '.$result['middlename'] ?></option>
						<?php
						}}
		            	?>
		        </select>
	        </div>
	        <div class="row-fluid" style="margin-bottom: 10px; display: none;" id="client_group">
	        	Client Groups
		        <select name="client_groups[]" id="select2_sample3" class="span12 client_groups" multiple >
					<option value="">--Select client Group--</option>
		            <option value="all_tenants">All tenants</option>
					<option value="all_contractors">All contractors</option>
					<option value="all_landlords">All landlords</option>
		        </select>
	        </div>
	        <div class="row-fluid">
	        	<label for="subject">Subject</label>
	        	<input type="text" name="subject" class="span12" required/>
	        </div>
	        <div class="row-fluid" style="margin-bottom:10px;">
	        	<label for="message_type" class="control-label">Message Type:</label>
	        	<select name="message_type" class="span12" required id="message_type">
	        		<option value="">--Choose--</option>
	        		<option value="custom">Custom Message</option>
	        		<option value="predefined">Predefined Message</option>
	        	</select>
	        </div>
	        <div class="row-fluid" style="display: none;" id="custom_message">
	        	<label for="body" class="control-label">Message</label>
	        	<textarea name="body" class="span12"></textarea>
	        </div>
	        <div class="row-fluid" style="display: none;" id="predefined_message">
	        	<select name="pre_message" class="span12 live_search">
	        		<option value="">--Select a Message--</option>
					<?php
					$notifications = $broadcast->selectQuery('predefined_message','predefined_message,notification_type');
					if (count($notifications)){
						foreach ($notifications as $notification){
					?>
							<option value="<?php echo $notification['predefined_message'] ?>"><?php echo $notification['notification_type']?></option>
							<?php }} ?>
		        </select>
	        </div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="add_broadcast"/>
		<input type="hidden" name="client_g" id="clients-groups">
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can579'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sen582'); ?>
		</div>
	</div>
</form>
<? set_js(array('src/js/manage_broadcast.js')); } ?>