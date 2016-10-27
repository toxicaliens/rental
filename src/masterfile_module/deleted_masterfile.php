<?php
	include_once('src/models/Masterfile.php');
	$mf = new Masterfile();

	set_layout("dt-layout.php", array(
		'pageSubTitle' => 'Masterfile',
		'pageSubTitleText' => '',
		'pageBreadcrumbs' => array (
			array ( 'url'=>'index.php', 'text'=>'Home' ),
			array ( 'text'=>'masterfile' ),
			array ( 'text'=>'Deleted Masterfile' )
		)
	));
?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> Deleted Masterfile</h4></div>
	<div class="widget-body form">
		<?php
			// display all encountered errors
			$mf->splash('mf');
			(isset($_SESSION['mf_warnings'])) ? $mf->displayWarnings('mf_warnings') : '';

		if(isset($_SESSION['done-deal'])){
			echo $_SESSION['done-deal'];
			unset($_SESSION['done-deal']);
		}
		?>

		<div class="alert alert-success" style="display: none" id="flash">
			<button class="close" data-dismiss="alert"></button>
			<strong>Success!</strong> The Masterfile has been successfully restored.
		</div>
		<table id="table1" style="width: 100%" class="table table-bordered">
			<thead>
			<tr>
				<th>MF#</th>
				<th>Start Date</th>
				<th>Surname</th>
				<th>First Name</th>
				<th>Customer Type</th>
				<th>B. Role</th>
				<th>Restore</th>
				<th>Delete</th>
			</tr>
			</thead>
			<tbody>
			<?php

			$distinctQuery = "SELECT m.*, ul.username, c.customer_type_name FROM masterfile m 
		   LEFT JOIN user_login2 ul ON ul.mf_id = m.mf_id
		   LEFT JOIN customer_types c ON c.customer_type_id = m.customer_type_id
		   WHERE active IS NOT TRUE ";
			$resultId = run_query($distinctQuery);
			$total_rows = get_num_rows($resultId);
			$con = 1;
			$total = 0;
			while($row = get_row_data($resultId))     {
				$mf_id = $row['mf_id'];
				$regdate_stamp = $row['regdate_stamp'];
				$surname = $row['surname'];
				$firstname = $row['firstname'];
				$customer_type_name = $row['customer_type_name'];
				$b_role = $row['b_role'];
				?>
				<tr>
					<td><?=$mf_id; ?></td>
					<td><?=$regdate_stamp; ?></td>
					<td><?=$surname; ?></td>
					<td><?=$firstname; ?></td>
					<td><?=$customer_type_name; ?></td>
					<td><?=$b_role; ?></td>
					<td><a href="javascript:void();" class="btn btn-mini restore_masterfile" mf_id="<?=$mf_id; ?>"><i class="icon-undo"></i> Restore</a></td>
					<td><a href="#delete_masterfile" class="btn btn-mini btn-danger delete_masterfile" data-toggle="modal" mf_id="<?=$mf_id; ?>"><i class="icon-remove"></i> Delete Forever</a></td>
				</tr>
			<?php }	?>

			</tbody>
		</table>
		<div class="clearfix"></div>
	</div>
</div>

<form action=""  method="post">
	<div id="delete_masterfile" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Delete Masterfile</h3>
		</div>
		<div class="modal-body">
			<p>Are you sure you want to permanently delete the Masterfile?</p>
		</div>
		<input type="hidden" name="status" id="status"/>
		<input type="hidden" name="action" value="delete_masterfile"/>
		<input type="hidden" id="delete_id" name="delete_id" required/>
		<div class="modal-footer">
			<button class="btn" aria-hidden="true" data-dismiss="modal">No</button>
			<button class="btn btn-primary">Yes</button>
		</div>
	</div>
</form>

<?php set_js(array('src/js/deleted_masterfile.js')); ?>
