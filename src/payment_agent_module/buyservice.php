<?
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'COUNTY CASHIER: Buy Service',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Cash Office' ),
		array ( 'text'=>'Buy Service' ),
    'pageWidgetTitle' => 'Buy Service'
	)
));

if(isset($_SESSION['done-add'])){
      echo $_SESSION['done-add'];
      unset($_SESSION['done-add']);
   }

   $distinctQuery2 = "select count(bill_id) as total_bills from ".DATABASE.".customer_bills";
   $resultId2 = run_query($distinctQuery2);
   $arraa = get_row_data($resultId2);
   $total_rows2 = $arraa['total_bills'];
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
<?php //ccncashagent name of the table from which buy services are supposed to be fetched ?>
<div>
    <div style="clear:both;"> </div>
</div>
<br/>

<div class="widget">
  <div class="widget-title">
    <h4><i class="icon-reorder"></i> Search for Bills</h4>
  </div>
  <div class="widget-body">

     <form name="cdetails" method="post" action="" class="form-horizontal">
      <div class="row-fluid">
        <div class="span6">
          <div class="control-group">
            <label for="account_type" class="control-label">Account Type<span class="required">*</span></label>
            <div class="controls">
              <select name="service_account_type" class="packinput span12">
                 <option value="0">--Select Service Account Type--</option>
                 <?php
                        $categories=run_query("select * from service_account_types");
                         while ($fetch=get_row_data($categories))
                         {
                         echo "<option value='".$fetch['service_account_type_id']."'>".$fetch['service_account_type_name']."</option>";
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
            <label for="account_no" class="control-label">Account Number<span class="required">*</span></label>
            <div class="controls">
              <input type="text" name="service_account" value="" required class="span12 m-wrap popovers" data-trigger="hover" data-content="Enter the Plate Number if account type is Parking i.e. KAR145U" data-original-title="For Example">
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
  $serviceaccount = $_POST['service_account'];

    if($service_account_type == 0){
        echo "<font color=red><b>ERROR:</b></font> Account type was not selected";
    }elseif($serviceaccount ==""){
        echo "<font color=red><b>ERROR:</b></font> Account Number was not added";
    }else{

 $distinctQuery = "select * from ".DATABASE.".customer_bills where service_account='$serviceaccount' AND bill_status='0' Order by bill_id DESC";
 //echo $distinctQuery;
 $resultId = run_query($distinctQuery);
 $total_rows = get_num_rows($resultId);
 if($total_rows > 0)
 {
    ?>

   <table id="table1" class="table table-bordered">
 <thead>
  <tr>
 
   <th>B.ID#</th>
   <th>B.Date</th>
   <th>Bill Name</th>
   <th>Bill Amount</th>
   <th>STATUS</th>
   <th>Due.Date</th>
   <th>ACTION</th>

  </tr>
 </thead>
 <tbody>

 <?
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['bill_id']);
		$service_bill_id = trim($row['service_bill_id']);

		$bill_date = date("d-m-Y H:i:s", strtotime($row['bill_date']));
		$due_date = date("d-m-Y H:i:s", strtotime($row['bill_due_date']));
		// $end_date = date("d-m-Y H:i:s",$row['time_out']);

		// $parking_type = $row['parking_type_id'];
		$status = $row['bill_status'];
		// $agent_id = $row['agent_id'];
		$bill_amount = $row['bill_balance'];
		// $clamping_flag = $row['clamping_flag'];
		 ?>
		  <tr>
		   
		   <td><?=$trans_id; ?></td>
		   <td><?=$bill_date; ?></td>
                   <td><?=getServiceBillName($service_bill_id); ?></td>
                   <td>Ksh. <?=number_format($bill_amount,2); ?></td>
		   <td><? echo ($status==0)?"PENDING":"PAID"; ?></td>
                   <td><?=$due_date; ?></td>
                   <td><?='<a href=index.php?num=140&bill_id='.$trans_id.'&amount='.$bill_amount.'><span id=modifytool>PAY</span></a>'?></td>

		  </tr>
		 <?

	}
 }
 elseif($service_account_type == "3")
     {
        echo checkbusinessaccountstatus($serviceaccount);
     }
 elseif($service_account_type == "4")
     {
        echo checklandratesaccountstatus($serviceaccount);
     }
 elseif($service_account_type == "5")
     {
        echo checkhouserentaccountstatus($serviceaccount);
     }
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
