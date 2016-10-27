<?php
include_once('src/models/BillingFiles.php');
$b_file = new BillingFiles();

set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Billing Files',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Payments & Bills' ),
		array ( 'text'=>'All Billing Files' )
	)
));
?>

<div class="widget">
  <div class="widget-title"><h4><i class="icon-money"></i> Filters</h4>
    <span class="tools">
      <a href="javascript::void();"><i class="<?php echo (!isset($_POST['date_range'])) ? 'icon-chevron-up': 'icon-chevron-down'; ?>"></i></a>
    </span>
  </div>
  <div class="widget-body form" <?php echo (!isset($_POST['date_range'])) ? 'style="display: none;"': ''; ?>">
    <form action="" method="post" class="form-horizontal">
      <div class="row-fluid">
        <div class="span6">
          <div class="control-group">
            <label for="date_range" class="control-label">Date Range:</label>
            <div class="controls">
              <div class="input-prepend input-append">
                 <span class="add-on"><i class="icon-calendar"></i></span>
                 <input type="text" name="date_range" class="m-wrap m-ctrl-medium date-range" required value="<?php echo (isset($_POST['date_range'])) ? $_POST['date_range'] : ''; ?>" />
                 <button class="btn"><i class="icon-search"></i></button>
              </div>             
            </div>
          </div>
        </div>
      </div>
    </form>    
  </div>
</div>

<div class="widget">
  <div class="widget-title"><h4><i class="icon-reorder"></i> All Billing Files</h4></div>
  <div class="widget-body">

<table id="table1" class="table table-bordered">
 <thead>
  <tr>
   <th>BF#</th>
   <th>Start Date</th>
   <th>Service Account</th>
   <th>B.Amount</th>
   <th>B.Balance</th>
    <th>View Bills</th>
  </tr>
 </thead>
 <tbody>
 <?php
    $date_range = (isset($_POST['date_range'])) ? $b_file->getFromAndToDates($_POST['date_range']) : '';
    $condition = (isset($_POST['date_range'])) ? $b_file->filterBillingFiles($date_range[0], $date_range[1]) : '';
    
    $distinctQuery = "SELECT 
    c.*, sc.service_option
    from customer_billing_file c
   LEFT JOIN service_channels sc ON sc.service_channel_id = c.service_bill_id
   WHERE c.status IS TRUE $condition";
   $resultId = run_query($distinctQuery);
   $total_rows = get_num_rows($resultId);


	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['billing_file_id']);
		$bill_amt = $row['billing_amount'];
		$serviceaccount = $row['service_account'];
        $bill_balance = $row['billing_amount_balance'];

		 ?>
		  <tr>
        <td><?=$trans_id; ?></td>
        <td><?php echo $row['start_date']; ?></td>
		    <td><?=$serviceaccount; ?></td>
            <td><?=$bill_amt; ?></td>
            <td><?=$bill_balance; ?></td>
              <td><a href="<?php echo '?num=171&&b_id='.$trans_id ?>" class="btn btn-default btn-small"  ">View bills</a></td>
		  </tr>
		 <?
 	}
	?>
  </tbody>
</table>
<div class="clearfix"></div>
</div>
</div>