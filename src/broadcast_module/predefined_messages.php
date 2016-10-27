<?php
	include_once('src/models/Broadcast.php');
	$broadcast = new Broadcast;

	set_title('Predefined Messages');
	set_layout('dt-layout.php', array(
		'pageSubTitle' => 'Predefined Messages',
		'pageSubTitleText' => '',
		'pageBreadcrumbs' => array (
			array ( 'url'=>'index.php', 'text'=>'Home' ),
			array ( 'text'=>'Broadcast' ),
			array ( 'text'=>'Predefined Messages' )
		)
		
	));
?>

<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> Predefined Messages</h4>
		<span class="actions">
			<a href="#add_message" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Add</a>
			<a href="#edit_message" class="btn btn-small btn-success" id="edit_mess_btn"><i class="icon-edit"></i> Edit</a>
			<a href="#del_message" class="btn btn-small btn-danger" id="del_mess_btn"><i class="icon-remove icon-white"></i> Delete</a>
		</span>
	</div>

	<div class="widget-body form">
		<?php
			if(isset($_SESSION['predefined'])){
				echo $_SESSION['predefined'];
				unset($_SESSION['predefined']);
			}
		?>
		<table id="table1" class="table table-bordered">
			<thead>
				<tr>
					<th>ID#</th>
					<th>Notification Type</th>
					<th>Message</th>

				</tr>
			</thead>
			<tbody>
				<?php
					$result = $broadcast->getAllPredefinedMessages();
					while ($rows = get_row_data($result)) {
				?>
				<tr>
					<td><?php echo $rows['predefined_mess_id']; ?></td>
					<td><?php echo $rows['notification_type']; ?></td>
					<td><?php echo $rows['predefined_message']; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<div class="clearfix"></div>
	</div>
</div>

<!-- modal for add -->
<form action="" method="post">
	<div id="add_message" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1"><i class="icon-plus"></i> Predefine a Message</h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid">
				<label for="notification_type">Notification Type</label>
				<input type="text" name="notification_type" class="span12" required>
			</div>
	        <div class="row-fluid">
	        	<label for="body" class="control-label">Message</label>
	        	<textarea name="message" class="span12" required></textarea>
	        </div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="add_pre_message"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo610'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav612'); ?>
		</div>
	</div>
</form>
<!--modal for edit-->
<form action="" method="post">
	<div id="edit_message" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1"><i class="icon-edit"></i> Edit Message</h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid">
				<label for="notification_type">Notification Type</label>
				<input type="text" name="notification_type" id="notification_type" class="span12" required>
			</div>
	        <div class="row-fluid">
	        	<label for="body" class="control-label">Message</label>
	        	<textarea name="message" id="pre_message" class="span12" required></textarea>
	        </div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="edit_id" id="edit_id"/>
		<input type="hidden" name="action" value="edit_pre_message"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo613'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav614'); ?>
		</div>
	</div>
</form>

<form action="" method="post">
	<div id="del_message" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1"><i class="icon-trash"></i> Delete Message</h3>
		</div>
		<div class="modal-body">
	        <p>Are you sure you want to delete the selected message?</p>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="delete_id" id="delete_id">
		<input type="hidden" name="action" value="del_pre_message"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No615'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes616'); ?>
		</div>
	</div>
</form>

<?php
	set_js(array('src/js/predefined_messages.js') );
?>
