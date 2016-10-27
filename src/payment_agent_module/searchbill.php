<?
set_layout("dt-layout.php", array(
  'pageSubTitle' => 'Search for a Bill',
  'pageSubTitleText' => 'Over the counter bills',
  'pageBreadcrumbs' => array (
    array ( 'url'=>'index.php', 'text'=>'Home' ),
    array ( 'url'=>'?num=139', 'text'=>'Payment and Bills' ),
    array ( 'text'=>'Pay Bill' )
  )
  
));

if(isset($_SESSION['done-add'])){
  echo $_SESSION['done-add'];
  unset($_SESSION['done-add']);
}
?>

<script type="text/javascript">
		$(document).ready(
			function() {
				$("#table1").ingrid({
					url: 'searchbill.php',
					height: 200,
					totalRecords: <?=1;?>,
					pageNumber: 1,
					recordsPerPage: 0,
					colWidths: [120,150,150,145,100,150,70]
				});
			}
		);
	</script>

<div>
  <div style="clear:both;"> </div>
</div>

<div class="widget">
  <div class="widget-title">
    <h4><i class="icon-search"></i> Search for Bills</h4>
  </div>
  <div class="widget-body form">

     <form name="cdetails" method="post" action="" class="form-horizontal">
      <div class="row-fluid">
        <div class="span6">
          <div class="control-group">
            <label for="account_type" class="control-label">Revenue Channel:<span class="required">*</span></label>
            <div class="controls">
              <select name="service_account_type" class="packinput span12">
                 <option value="">--Select Service Account Type--</option>
                 <option value="All">All Bills</option>
                 <?php
                        $categories=run_query("select * from revenue_channel");
                         while ($fetch=get_row_data($categories))
                         {
                         echo "<option value='".$fetch['revenue_channel_id']."'>".$fetch['revenue_channel_name']."</option>";
                         }
                 ?>
             </select>
            </div>
          </div>
        </div>  
      </div>
      <div class="row-fluid">
        <div class="span6">
          <div class="control-group">
            <label for="account_no" class="control-label">House Number:<span class="required">*</span></label>
            <div class="controls">
              <input type="text" name="service_account" value="" required class="span12 m-wrap popovers" data-trigger="hover">
            </div>
          </div>
        </div>
      </div>
      <div class="form-actions">
        <input type="hidden" name="details"/>
        <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
      </div>
</form>
</fieldset>

<?
if(isset($_POST['details'])){
  $_POST['details'] == "GO"
?>
<fieldset><legend class="table_fields">BILLS</legend>
    <?
  $service_account_type = $_POST['service_account_type']; 
  $serviceaccount = trim($_POST['service_account']);

    if($service_account_type == ''){
        echo "<font color=red><b>ERROR:</b></font> Account type was not selected";
    }elseif($serviceaccount ==""){
        echo "<font color=red><b>ERROR:</b></font> Account Number was not added";
    }else{
        if($service_account_type == 'All'){
            $distinctQuery = "select c.*, s.* from " . DATABASE . ".customer_bills c
             LEFT JOIN service_channels s ON s.service_channel_id = c.service_channel_id
             where service_account='$serviceaccount'";
        }else{
        $distinctQuery = "select c.*, s.* from " . DATABASE . ".customer_bills c
             LEFT JOIN service_channels s ON s.service_channel_id = c.service_channel_id
             where service_account='$serviceaccount' AND s.revenue_channel_id = '" . $service_account_type . "'";
        }
         $resultId = run_query($distinctQuery);
         $total_rows = get_num_rows($resultId);
         if($total_rows > 0)
    {
    ?>

<table id="table1" class="table table-bordered">
  <thead>
  <tr>
   <th>B.ID#</th>
    <th>Bill Amount</th>
   <th>B.Date</th>
   <th>Service Account</th>
   <th>Bill Balance</th>
   <th>Status</th>
   <th>Action</th>
  </tr>
 </thead>
 <tbody>

 <?
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['bill_id']);
		$service_bill_id = trim($row['bill_id']);
    $serviceaccount = $row['service_account'];
		$bill_date = date("d-m-Y H:i:s", strtotime($row['bill_date']));
		$status = $row['bill_status'];
		// $agent_id = $row['agent_id'];
		$bill_amount = $row['bill_balance'];
		// $clamping_flag = $row['clamping_flag'];
        $price = $row['price'];
		 ?>
		  <tr>
		   
		   <td><?=$trans_id; ?></td>
              <td><?=$price; ?></td>
		   <td><?=$bill_date; ?></td>
       <td><?=$serviceaccount; ?></td>
       <td>Ksh. <?=number_format($bill_amount,2); ?></td>
       <td><?=($status=='0') ? 'Not Paid': 'Paid'; ?></td>
       <td><?php echo ($bill_amount > 0)? '<a href=index.php?num=140&bill_id='.$trans_id.' class="btn btn-mini">
        <i class="icon-money"></i> Pay</a>':'' ?>
        </td>
		  </tr>
		 <?

	}
 }
 // elseif($service_account_type == "3")
 //     {
 //        echo checkbusinessaccountstatus($serviceaccount);
 //     }
 // elseif($service_account_type == "4")
 //     {
 //        echo checklandratesaccountstatus($serviceaccount);
 //     }
 // elseif($service_account_type == "5")
 //     {
 //        echo checkhouserentaccountstatus($serviceaccount);
 //     }
  else{
      echo "No bill to settle";
  }
}
 
	?>
  </tbody>
</table>
<?}?>

    <div class="clearfix"></div>
  </div>
</div>


