<?php
require_once 'src/models/RevenueManager.php';
$revenue = new RevenueManager();
if (App::isAjaxRequest()){
	if(isset($_POST['action'])){
		$action = $_POST['action'];
		switch ($action){
			case 'edit_channel':
				logAction($action,$_SESSION['sess_id'], $_SESSION['mf_id']);
				$id = $_POST['edit_id'];
				$results = $revenue->getRevenueChannelById($id);
				//var_dump($results);
				echo json_encode($results);
				break;
			case 'delete_channel':
				logAction($action,$_SESSION['sess_id'], $_SESSION['mf_id']);
				$id =$_POST['delete_id'];
				$results = $revenue->deleteRevenueChannel($id);
				//echo json_encode($results);
		}
	}
}else{
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Revenue Channel Records',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Revenue Management' ),
		array ( 'text'=>'All Revenue Channel Records' )
	)
	
));

?>
   <div class="widget">
  <div class="widget-title">
    <h4><i class="icon-reorder"></i>REVENUE CHANNELS</h4>
    <span class="actions">
		<button class="btn btn-small btn-primary" data-toggle="modal" data-target="#add_rev">Add new</button>
		<button class="btn btn-small btn-primary"  id="edit-channel"  data-target="#edit_rev">Edit</button>
		<a href="" class="btn btn-small btn-danger"  id="delete-channel">Delete</a>
		<input type="hidden" id="delete_id">

      </span>
    </div>
 <div class="widget-body">
	<?php
		if(isset($_SESSION['RMC'])){
			echo $_SESSION['RMC'];
			unset($_SESSION['RMC']);
 		}

	?>
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
	  	<tr>
		  	<th>Revenue Channel #</th>
			<th>Revenue Channel Name</th>
		  	<th>Revenue Channel Code</th>
		</tr>
 		</thead>
 	<tbody>
 <?php
  $channels = $revenue->getAllRevenueChannels();
 //var_dump($channels);die;
 if (count($channels)) {
 	foreach($channels as $channel){
 ?>
		<tr>
			<td><?php echo $channel['revenue_channel_id']?></td>
			<td><?php echo $channel['revenue_channel_name']?></td>
			<td><?php echo $channel['revenue_channel_code']?></td>
	  	</tr>
  <?php } }?>
  </tbody>
</table>

<div class="clearfix"></div>
</div>
</div>
<!--modal for add-->
<form action="" method="post">
	<div id="add_rev" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Add New Revenue Channel </h3>
		</div>
		<div class="modal-body">

				<div class="control-group">
					<label for="revenue_channel_name" autocomplete="off" class="control-label">Revenue channel name:<span class="required"></span></label>
					<div class="controls">
						<input type="text" name="revenue_channel_name" class="span12" required/>
					</div>
				</div>
				<div class="control-group">
					<label for="revenue_channel_code" class="control-label">Revenue Channel Code:</label>
					<div class="controls">
						<input type="text"  id="revenue_channel_code" autocomplete="off" name="revenue_channel_code" class="span12" title="e.g. pk_ser for Parking Service" required/>
					</div>
				</div>
<!--			hidden fields-->
			<input type="hidden" name="action" value="add_revenue_channels"/>

		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
			<button class="btn btn-primary">Yes</button>
		</div>
	</div>
</form>

<!--modal for edit-->

<form action="" method="post">
	<div id="edit_rev" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Edit Revenue Channel </h3>
		</div>
		<div class="modal-body">

			<div class="control-group">
				<label for="revenue_channel_name" class="control-label">Revenue channel name:<span class="required"></span></label>
				<div class="controls">
					<input type="text" id="rev_name" name="revenue_channel_name" class="span12"/>
				</div>
			</div>
			<div class="control-group">
				<label for="revenue_channel_code" class="control-label">Revenue Channel Code:</label>
				<div class="controls">
					<input type="text"  id="rev_code" name="revenue_channel_code" class="span12" title="e.g. pk_ser for Parking Service" required/>
				</div>
			</div>
			<!--			hidden fields-->
			<input type="hidden" name="action" value="edit_revenue_channels"/>
			<input type="hidden" name="revenue_channel_id" id="editid">

		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
			<button class="btn btn-primary">Yes</button>
		</div>
	</div>
</form>
<?php set_js(array('src/js/all_rmc.js')); } ?>