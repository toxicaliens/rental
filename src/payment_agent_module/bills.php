<?php
include_once('src/models/Bills.php');

set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Bills',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Payments & Bills' ),
		array ( 'text'=>'Bills' )
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
  <div class="widget-title">
    <h4>Customer Details</h4>
  </div>
  <div class="widget-body form">

   <table id="table1" class="table table-bordered">
 <thead>
  <tr>
   <th>Bill#</th>
   <th>Service</th>
   <th>Bill Date</th>
   <th>Bill Amount</th>
   <th>Tenant</th>
   <th>B.Amount</th>
   <th>B.Due Date</th>
   <th>Service Account</th>
   <th>B.Balance</th>
   <th>Status</th>
   <th>Action</th>
  </tr>
 </thead>
 <tbody>

<?php
  $date_range = (isset($_POST['date_range'])) ? Bills::getFromAndToDates($_POST['date_range']) : '';
  $condition = (isset($_POST['date_range'])) ? Bills::filterBills($date_range[0], $date_range[1]) : '';

  $distinctQuery = "select c.*, m.*, sc.service_option, sc.price from ".DATABASE.".customer_bills c
  LEFT JOIN masterfile m ON m.mf_id = c.mf_id
  LEFT JOIN service_channels sc ON sc.service_channel_id = c.service_channel_id
  WHERE bill_status <> '2' $condition;";
  $resultId = run_query($distinctQuery);
  $total_rows = get_num_rows($resultId);

	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['bill_id']);
    $duedate= $row['bill_due_date'];
    $bill_date = $row['bill_date'];
		$customer_id = $row['mf_id'];
    $full_name = $row['surname'].' '.$row['firstname'].' '.$row['middlename'];
		$bill_amt = $row['bill_amount'];
        // $bstatus = $row['bill_status'];
		$serviceaccount = $row['service_account'];
    $bill_balance = $row['bill_balance'];
    $serviceaccounttype = $row['service_option'];
    $price = $row['price'];

 ?>
      <tr>
        <td><?=$trans_id; ?></td>
        <td><?=$serviceaccounttype; ?></td>
        <td><?php echo $bill_date; ?></td>
        <td><?=number_format($price, 2); ?></td>
        <td><?=$full_name; ?></td>
        <td><?=$bill_amt; ?></td>
        <td><?php echo $duedate; ?></td>
        <td><?=$serviceaccount; ?></td>
        <td><?=($bill_balance > 0) ? $bill_balance : 0; ?></td>
        <td><?=($row['bill_status']=='0') ? 'Not Paid': 'Paid'; ?></td>
        <td><?php echo ($bill_balance > 0 )? '<a href=index.php?num=140&bill_id='.$trans_id.'"class="btn btn-mini">
                    <i class="icon-money"></i> Pay</a>':'';?> </td>
		  </tr>
		 <?
 	}
	?>
  </tbody>
</table>
<div class="clearfix"></div>
</div>
</div>