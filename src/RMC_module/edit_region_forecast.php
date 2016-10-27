<?php
include_once('src/model/RevenueManager.php');
$revenue_manager = new RevenueManager();

set_layout("form-layout.php", array(
	'pageSubTitle' => 'Edit Forecasts By Region',
	'pageSubTitleText' => 'Edit all Region target amounts in the selected revenue channel',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Revenue Management' ),
		array ( 'url'=>'index.php?num=646','text'=>'Revenue Forecasts' ),
    array ( 'text'=>'Edit Region Forecasts' )
	),
	'pageWidgetTitle' => $revenue_manager->getRevenueName($_GET['rev_id'])
));

if(isset($_SESSION['RMC'])){
    echo "<p style='color:#33FF33; font-size:16px;'>".$_SESSION['RMC']."</p>";
    unset($_SESSION['RMC']);
}

?>

<form action="" method="post" class="form-horizontal">
  <?php
    // a function to get all the subcounties together with their target amounts
    $result = $revenue_manager->getRegionForecastsByRevenueChannel($_GET['rev_id']);
    while($rows = get_row_data($result)){
  ?>
    <div class="row-fluid">
      <div class="span6">
        <div class="control-group">
          <label for="region" class="control-label"><?=$rows['region_name']; ?></label>
          <div class="controls">
            <input type="number" name="target_amt" min="1" value="<?=$rows['target_amount']; ?>" class="span12" />
          </div>
        </div>
      </div>
    </div>
  <?php } ?>
  <!-- hidden fields -->
  <input type="hidden" name="action" value="edit_region_forecast"/>

  <div class="form-actions">
    <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
  </div>
</form>