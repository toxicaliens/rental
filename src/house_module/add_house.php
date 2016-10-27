<?php
	include_once 'src/models/House.php';
	$House = new House();
	set_title('Add a House');
	/**
	 * Set the page layout that will be used
	 */
	set_layout("form-layout.php", array(
		'pageSubTitle' => 'Add property',
		'pageSubTitleText' => 'Allows one to add a house',
		'pageBreadcrumbs' => array(
			array('url' => 'index.php', 'text' => 'Home'),
			array('text' => 'PROPERTY MANAGEMENT'),
			array('url' => '?num=view_houses', 'text' => 'All Units' ),
			array('text' => 'Add house')
		),
		'pageWidgetTitle' => 'Add House Details'
	));
	$House->splash('house');
	(isset($_SESSION['warnings'])) ? $House->displayWarnings('warnings') : '';

?>

<form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="group_name" class="control-label">Plot:</label>
				<div class="controls">
					<select name="plot" class="span12" required="required">
						<option value="">--Select plot--</option>
						<?php
							$plots = $House->getAllProperties();
							if(count($plots)){
								foreach ($plots as $plot) {
						?>
						<option value="<?php echo $plot['plot_id']; ?>"><?php echo $plot['plot_name']; ?></option>
						<?php }} ?>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
			<label for="group_name" class="control-label">House Number:</label>
				<div class="controls">
			<input type="text" name="house_number" value="" class="span12" required>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
			<label for="group_name" class="control-label">Rent Amount:</label>
				<div class="controls">
			<input type="number" name="rent_amount" value="" class="span12" required>
				</div>
			</div>
		</div>
	</div>
	<!--hidden fields-->
	<input type="hidden" name="action" value="add_house"/>
	<input type="hidden" name="created_by" value="<?php echo $_SESSION['mf_id'];?>"/>
	<div class="form-actions">
		<?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
	</div>
</form>
