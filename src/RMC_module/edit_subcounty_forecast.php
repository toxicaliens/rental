<?php
include_once('src/model/RevenueManager.php');
$revenue_manager = new RevenueManager();

set_layout("form-layout.php", array(
	'pageSubTitle' => 'Edit Sub-County Forecast',
	'pageSubTitleText' => 'Edit all subcounty target amounts in the selected revenue channel',
	'pageBreadcrumbs' => array (
	    array ( 'url'=>'index.php', 'text'=>'Home' ),
	    array ( 'text'=>'Revenue Management' ),
	    array ( 'url'=>'index.php?num=646','text'=>'Daily Forecast' ),
		array ( 'text'=>'Edit Sub-County Forecast' )
	),
	'pageWidgetTitle' => $revenue_manager->getRevenueName($_GET['rev_id'])
));
?>

<form action="" method="post" class="form-horizontal">
	<?php
		// a function to get all the subcounties together with their target amounts
		$result = $revenue_manager->getSubcountyForecastsByRevenueChannel($_GET['rev_id']);
		while($rows = get_row_data($result)){
	?>
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="subcounty" class="control-label"><?=ucwords($rows['sub_county_name']); ?></label>
					<div class="controls">
						<input type="number" name="target_amt" min="1" value="<?=$rows['target_amount']; ?>" class="span12" />
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	<!-- hidden fields -->
	<input type="hidden" name="action" value="edit_subcounty_forecast"/>

	<div class="form-actions">
		<?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
	</div>
</form>