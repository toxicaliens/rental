<?php
include_once 'src/models/Plots.php';
$prop = new Plots();
$house = new House();

if(App::isAjaxRequest()) {
	if (!empty($_POST['edit_id'])){
		$prop->getPlotByPlotId($_POST['edit_id']);
	}
	if (!empty($_POST['id'])) {
		$prop->getOptionDataById($_POST['id']);
	}

//ajax for attaching a service to a property
if(isset($_POST['action'])) {
	$action = $_POST['action'];
	switch ($action) {
		case 'attach_service_to_property':
			logAction($action, $_SESSION['sess_id'], $_SESSION['mf_id']);
			$json = $prop->attachPropertyService($_POST['service_id'], $_POST['prop_id']);
			echo json_encode($json);
			break;

		case 'detach_service_from_property':
			logAction($action, $_SESSION['sess_id'], $_SESSION['mf_id']);

			$json = $prop->detachPropertyService($_POST['service_id'], $_POST['prop_id']);
			echo json_encode($json);
			break;
		case 'check_attached':
			logAction($action, $_SESSION['sess_id'], $_SESSION['mf_id']);
			//echo $_POST['prop_id'];
			$house_services = $prop->selectQuery('property_services', '*', "plot_id = '" .$_POST['prop_id']."'");
			// collect all the service ids attached to the selected house
			$hs_service_ids = array();
			if(count($house_services)){
				foreach ($house_services as $house_service){
					$hs_service_ids[] = $house_service['service_channel_id'];
				}
			}

			$return = array();
			$leaf_services = $house->getAllServices(Leaf_Service);
			if(count($leaf_services)){
				foreach ($leaf_services as $leaf_service){
					if(in_array($leaf_service['service_channel_id'], $hs_service_ids)){
						$return[] = $leaf_service['service_channel_id'];
					}
				}
			}

			echo json_encode($return);
			//echo json_encode($ajax);
			break;
	}
}
}else{
	set_title('Property Management');
	/**
	 * Set the page layout that will be used
	 */
	set_layout("dt-layout.php", array(
		'pageSubTitle' => 'Property Manager',
		'pageSubTitleText' => 'Allows one to manage properties',
		'pageBreadcrumbs' => array(
			array('url' => 'index.php', 'text' => 'Home'),
			array('text' => 'PROPERTY'),
			array('text' => 'Property Manager')
		),
		'pageWidgetTitle' => 'Property Details'
	));

?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> Property Manager</h4>
		<span class="actions">
			 <div class="btn-group">
                 <a class="btn btn-small btn-primary" ><i class="icon-list"></i> Actions</a>
                 <a class="btn btn-small btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span>
                 </a>
                 <ul class="dropdown-menu">
                    <li><a href="?num=add_prop"><i class="icon-plus"></i> Add</a></li>
                    <li><a href="#update_prop"" class=" edit_prop "><i class="icon-trash"></i> Edit</a></li>
                    <li><a href="#del_prop79" class="del_prop"><i class="icon-remove"></i> Delete</a></li>
                 </ul>
            </div>
<!--			<a href="#attach_services"  class="btn btn-small btn-success attach_service"><i class="icon-paper-clip"></i> Attach a service</a>-->

		</span>
	</div>
	<div class="widget-body">
		<?php
			//print_r($prop->getPropertyDataByRole());
			$prop->splash('plots');
			(isset($_SESSION['warnings'])) ? $prop->displayWarnings('warnings') : '';
		?>
		<table id="table1" class="table table-bordered">
			<thead>
				<tr>
					<th>P No#</th>
					<th>Name</th>
					<th>Property Category</th>
					<th>Units/Houses</th>
					<th>Property Manager</th>
					<th>LandLord</th>
					<th>Profile</th>

				</tr>
			</thead>
			<tbody>
			<?php
				$plots = $prop->getPropertyDataByRole();
				if(count($plots)){
					foreach ($plots as $plot){
			?>
				<tr>
					<td><?php echo $plot['plot_id']; ?></td>
					<td><?php echo $plot['plot_name']; ?></td>
					<td><?php if(!empty($plot['prop_type'])){echo $prop->getName($plot['prop_type']);}?></td>
					<td><?php echo $plot['units']; ?></td>
					<td><?php echo $prop->getFullName($plot['pm_mfid']); ?></td>
					<td><?php echo $prop->getFullName($plot['landlord_mf_id']); ?></td>
					<td><a href="?num=5001&&prop_id=<?php echo $plot['plot_id'];?>" class="btn btn-mini"><i class="icon-eye-open"></i> Profile</a></td>


				</tr>
			<?php }} ?>
			</tbody>
		</table>
		<div class="clearfix"></div>
	</div>
</div>

<!-- The Modals -->

<!-- modal for edit-->
<form action="" method="post">
		<div id="update_prop" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel1">Edit Property </h3>
			</div>
			<div class="modal-body">
				<label for="property_type">Property Type:</label>
				<div class="row-fluid" style="margin-bottom: 10px;">
					<select name="property_type1" id="property_type" class="span12 live_search">
						<option id="property_typ" value="">--Choose a property type--</option>
						<?php
						$data = $prop->getPlotType();
						if(count($data)){
							foreach ($data as $dat){
								?><option value="<?php echo $dat['plot_type_id']; ?>"><?php echo $dat['plot_type_name'];?></option>
							<?php }} ?>
					</select>
				</div>
				<label for="option_type">Option Type:</label>
				<div class="row-fluid" style="margin-bottom: 10px;">
					<select name="option_type" id="option_type" class="span12 live_search" disabled>
						<!--					<option value="">--Choose an option type--</option>-->

					</select>
				</div>
				<div class="row-fluid">
					<label for="plot_name">Name:</label>
					<input type="text" name="plot_name" id="name" class="span12" value="<?php echo $prop->get('name'); ?>"/>
				</div>

				<div class="row-fluid">
					<label for="location">Location:</label>
					<input type="text" name="location" id="location" class="span12" value="<?php echo $prop->get('name'); ?>"/>
				</div>
				<div class="row-fluid">
					<label for="lr_no">Land Reg. No:</label>
					<input type="text" name="lr_no" id="lr_no" class="span12" value="<?php echo $prop->get('name'); ?>"/>
				</div>
				<div class="row-fluid">
					<label for="units">Units/Houses:</label>
					<input type="number" min="1" id="units" name="units" class="span12" value="<?php echo $prop->get('units'); ?>"/>
				</div>
				<div class="row-fluid">
					<label for="payment_code">Payment Code:</label>
					<input type="text" name="payment_code" id="payment_code" class="span12" value="<?php echo $prop->get('payment_code'); ?>"/>
				</div>
				<div class="row-fluid">
					<label for="paybill_number">Paybill Number:</label>
					<input type="text" name="paybill_number" id="pay_bill" class="span12" value="<?php echo $prop->get('paybill_number'); ?>"/>
				</div>
				<label for="property_manager">Property Manager:</label>
				<div class="row-fluid" style="margin-bottom: 10px;">
					<select name="property_manager" id="property_manager" class="span12 live_search">
						<option value="">--Choose PM--</option>
						<?php
						$pms = $prop->getAllMasterfile("b_role = '".Property_Manager."'");
						$pms = $pms['all'];
						if(count($pms)){
							foreach ($pms as $pm){
								?>
								<option value="<?php echo $pm['mf_id']; ?>" <?php echo ($pm['mf_id'] == $prop->get('property_manager')) ? 'selected' : ''; ?>><?php echo $pm['full_name']; ?></option>
							<?php }} ?>
					</select>
				</div>

				<label for="landlord">Landlord:</label>
				<div class="row-fluid">
					<select name="landlord" id="landlord" class="span12 live_search">
						<option value="">--Choose Landlord--</option>
						<?php
						$landlord = $prop->getAllMasterfile("b_role = '".Landlord."'");
						$landlord = $landlord['all'];
						if(count($landlord)){
							foreach ($landlord as $landy){
								?>
								<option value="<?php echo $landy['mf_id']; ?>" <?php echo ($landy['mf_id'] == $prop->get('landlord')) ? 'selected' : ''; ?>><?php echo $landy['full_name']; ?></option>
							<?php }} ?>
					</select>
				</div>
			</div>
			<!-- the hidden fields -->
			<input type="hidden" name="action" value="edit_property"/>
			<input type="hidden" id="edit_id" value="">
			<input type="hidden" id="edt">
			<div class="modal-footer">
				<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo669'); ?>
				<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav668'); ?>
			</div>
		</div>
	</form>


	<!-- delete modal -->
<form action=""  method="post">
		<div id="del_prop79" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel1">Delete property</h3>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to delete this property?</p>
			</div>
			<!-- hidden fields -->
			<input type="hidden" name="action" value="delete_property"/>
			<input type="hidden" id="delete_id" name="delete_id"/>
			<input type="hidden" id="del-id">
			<div class="modal-footer">
				<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No673'); ?>
				<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes672'); ?>
			</div>
		</div>
	</form>

	<!--    modal for attaching services-->
	<form action="" method="post" id="service_form">
		<div id="attach_services" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h3 id="myModalLabel1">Attach/Detach services to property</h3>
			</div>
			<div class="modal-body">
				<div class="alert alert-success" style="display: none;" id="attach-success">
					<button class="close" data-dismiss="alert">&times;</button>
					<strong>Success!</strong> Successfully attached the service.
				</div>
				<div class="alert alert-success" style="display: none;" id="detach-success">
					<button class="close" data-dismiss="alert">&times;</button>
					<strong>Success!</strong> Successfully detached the service.
				</div>
				<div class="alert alert-error" style="display: none;" id="attach-fail">
					<button class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> Failed to attach the selected service.
				</div>
				<div class="warnings"></div>
				<div class="alert alert-success" id="status" style="display: none">
					<button class="close" data-dismiss="alert">×</button>
					<div class="row-fluid">
						<div id="message"></div>
					</div>
				</div>
				<?php
				$results = $house->getAllServices('Leaf');
				if(count($results)){
					foreach ($results as $result){

						?>
						<div class="row-fluid">
							<label for="service" class="control-group"></label>
							<input type="checkbox" id="service" name="" class="service" value="<?php echo $result['service_channel_id'];?>"> <?php echo $result['service_option'].'        Amount:<strong>Ksh. </strong> '.number_format($result['price']) ;?>
						</div>
					<?php  } }?>
			</div>

			<!-- the hidden fields -->
			<!--        <input type="hidden" name="action" value="attach_service">-->
			<input type="hidden" name="attach_services" id="attach_service">
			<div class="modal-footer">
			</div>
		</div>
	</form>
<?php set_js(array('src/js/plots.js')); } ?>