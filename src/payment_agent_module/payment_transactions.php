<?php
include_once('src/models/Transactions.php');

set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Payments',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Payments & Bills' ),
		array ( 'text'=>'Payments' )
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
    <h4><i class="icon-reorder"></i> Payments</h4>
  </div>
  <div class="widget-body">

<table id="table1" class="table table-bordered">
 <thead>
  <tr>
   <th>Trans#</th>
   <th>Cash Paid</th>
   <th>Details</th>
   <th>Customer Acc#</th>
   <th>T. Date</th>
  </tr>
 </thead>
 <tbody>

 <?php
    $date_range = (isset($_POST['date_range'])) ? Transactions::getFromAndToDates($_POST['date_range']) : '';
    $condition = (isset($_POST['date_range'])) ? Transactions::filterTransactions($date_range[0], $date_range[1]) : '';

    $distinctQuery = "select t.*, m.*  from ".DATABASE.".transactions t
    LEFT JOIN masterfile m ON m.mf_id = t.mf_id WHERE transaction_id IS NOT NULL $condition";
    $resultId = run_query($distinctQuery);
	  while($row = get_row_data($resultId)){
		$trans_id = trim($row['transaction_id']);
    $cashpaid= $row['cash_paid'];
		$details = $row['details'];
		$receiptnumber = $row['service_account'];
    $tdate = $row['transaction_date'];
		$agent = $row['surname'].' '.$row['firstname'].' '.$row['middlename'];
		
		?>
		  <tr>
		   <td><?=$trans_id; ?></td>
		   <td><?=$cashpaid; ?></td>
		   <td><?=$details; ?></td>
       <td><?=$receiptnumber; ?></td>
       <td><?=$tdate; ?></td>       
                                      
		  </tr>
		 <?
 	}
	?>
  </tbody>
</table>
<div class="clearfix"></div>
</div>
</div>