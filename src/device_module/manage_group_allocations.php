<?php
include_once('src/models/Device_management.php');
$Device = new DeviceManagement;

set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Manage Phone Specifications',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Device Management' ),
		array ( 'url'=>'?num=71', 'text'=>'Manage Models' ),
		array ( 'text'=>'Manage Phone Specifications' )
	)
	
));

$rows = $Device->getModelDetails($_GET['model']);
?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> GTEL Model: <span style="color: green;"><?php echo $rows['model']; ?></span></h4>
		<span class="actions">
			<a href="#group_allo_add" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Attach</a>
			<a href="#edit_group" class="btn btn-small btn-success" id="edit_group_btn"><i class="icon-edit"></i> Edit</a>
			<a href="#delete_group" class="btn btn-small btn-danger" id="del_group_btn"><i class="icon-remove icon-white"></i> Remove</a>
		</span>
	</div>
	</br>
	<div class="widget-body form">
		<?
			if(isset($_SESSION['model'])){
			echo $_SESSION['model'];
		    unset($_SESSION['model']);
	     }
		?>
		<table id="table1" class="table table-bordered">
			<thead>
				<tr>
				    <th>#Id</th>
					<th>Specs</th>
					<th>Value</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$result = $Device->getallModelAttributes($_GET['model']);
					while ($rows = get_row_data($result)) {
				?>
				<tr>
				    <td><?=$rows['attribute_id']; ?></td>
					<td><?=$rows['name']; ?></td>
					<td><?=$rows['attribute_value']; ?></td>
				</tr>
				<? } ?>
			</tbody>
		</table>
		<div class="clearfix"></div>
	</div>
</div>

<!-- allocation modals -->
<form action="" method="post" class="form-horizontal">
	<div id="group_allo_add" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Attach  Phone Specifications</h3>
		</div>
		<div class="modal-body">         
	        <div class="row-fluid">
	            <select class="span12 live_search" name="attribute_id" required="required">
					<option value="">--Select Specifications--</option>
					<?php
						$result = $Device->listAllAttributes();
						while($rows = get_row_data($result)){
        	          if(!$data = $Device->checkIfModelAttributeisAttached($_GET['model'],$rows['attribute_id'])){
					?>
					 <option value="<?=$rows['attribute_id']; ?>"><?=$rows['name']; ?></option>
		            <?php } }?>
				</select>
	       	</div> 
	       	<br>
	       	<div class="row-fluid">
	            <label for="attribute_value">Spec Value:</label>
	            <input type="text" name="attribute_value" id="value" value="" class="span12" required>     
	        </div>
	       	<input type="hidden" name="device_model_id" value="<?=$_GET['model']; ?>"/> 
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="add_model_attribute"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo543'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav542'); ?>
		</div>
	</div>
</form>

<!-- edit modal -->
<form action="" method="post" class="form-horizontal">
	<div id="edit_group" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Edit Phone Specifications</h3>
		</div>
		<div class="modal-body">         
	        <!-- <div class="row-fluid">
	            <select class="span12 live_search" name="attribute_id" required="required">
					<option value="">--Select Specifications--</option>
					<?php
						// $result = $Device->listAllAttributes();
						// while($rows = get_row_data($result)){
        	          // if(!$data = $Device->checkIfModelAttributeisAttached($_GET['model'],$rows['attribute_id'])){
					?>
					 <option value="<? // =$rows['attribute_id']; ?>"><? // =$rows['name']; ?></option>
		            <?php // } }?>
				</select>
	       	</div> 
	       	<br> -->
	       	<div class="row-fluid">
	            <label for="attribute_value">Spec Value:</label>
	            <input type="text" name="attribute_value" id="attribute_value" value="" class="span12" required>     
	        </div>
	       	<input type="hidden" name="device_model_id" value="<?=$_GET['model']; ?>"/> 
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="edit_model_attribute"/>
		<input type="hidden" id="edit_id" name="edit_id"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo543'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav542'); ?>
		</div>
	</div>
</form>

<!-- detech modal -->
<form action=""  method="post">
	<div id="delete_group" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Detach Phone Specifications</h3>
		</div>
		<div class="modal-body">
			<p>Are you sure you want to Detach the Selected Specifications?</p>
		</div>
		<input type="hidden" name="action" value="delete_model_attributes"/>
		<input type="hidden" id="delete_id" name="delete_id"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No546'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes545'); ?>
		</div>
	</div>
</form>

<? set_js(array('src/js/group_allocations.js')); ?>