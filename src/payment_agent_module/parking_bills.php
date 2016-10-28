<?php
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Parking Bills',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Parking' ),
		array ( 'text'=>'Parking Bills' )
	)
));
   $distinctQuery2 = "SELECT count(bill_id) as total_parking_bills 
                                                    from customer_bills 
                                                    where service_account_type='1'";
   $resultId2 = run_query($distinctQuery2);	
   $arraa = get_row_data($resultId2);
   $total_rows2 = $arraa['total_parking_bills'];
 ?>

 <div class="widget">
    <div class="widget-title">
     <!--  <span class="actions">
          <a href="index.php?num=119" class="btn btn-primary btn-small">NEW</a>
      </span> -->
    </div>
    <div class="widget-body">

<div>
                    
    <div style="float:right; width:100%; text-align:left;">

  <span style="color:#33FF33"><?php if (isset($msg)) echo $msg; ?></span>
    </div>
    <div style="clear:both;"> </div>

</div>
<br/>

   <table id="table1"  class="table table-bordered">
 <thead>
  <tr>
   <th>B.ID#</th>
   <th>CAR#</th>
   <th>B.Date</th>
   <th>Bill Balance</th>
   <th>Bill Name</th>
   <th>Bill Amount</th>
   <th>STATUS</th>
   <th>Due.Date</th>
   <th>Customer</th>
   <th>Edit</th>
  </tr>
 </thead>
 <tbody>
 
 <?
   $distinctQuery = "select c.*, m.*, r.* from ".DATABASE.".customer_bills c
   LEFT JOIN masterfile m ON m.mf_id = c.mf_id
   LEFT JOIN revenue_channel r ON r.revenue_channel_id = c.revenue_channel_id
    where revenue_channel_code='".Parking_service."' Order by bill_id DESC";
 //$distinctQuery = "select * from ".DATABASE.".customer_bills Order by bill_id DESC";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['bill_id']);
		$ref_id = trim($row['service_account']);
		$service_bill_id = trim($row['service_bill_id']);
		
		$bill_date = date("d-m-Y",strtotime($row['bill_date']));
		$due_date = date("d-m-Y",strtotime($row['bill_due_date']));
		//$end_date = date("d-m-Y H:i:s",$row['time_out']);
		$customer_name = $row['surname'].' '.$row['firstname'].' '.$row['middlename'];
		//$parking_type = $row['parking_type_id'];
		$status = $row['bill_status'];
    $bill_balance = $row['bill_balance'];
    if(empty($bill_balance)){
      $bill_balance = 0;
    }
		//$agent_id = $row['agent_id'];
		$bill_amount = $row['bill_amt'];
		//$clamping_flag = $row['clamping_flag'];
    $mf_id =$row['mf_id'];
		 ?>
		  <tr>
		   <td><?=$trans_id; ?></td>
       <td><?=$ref_id; ?></td>
		   <td><?=$bill_date; ?></td>
       <td><?=$bill_balance; ?></td>
       <td><?=getServiceBillName($service_bill_id); ?></td>
       <td>Ksh. <?=number_format($bill_amount,2); ?></td>
		   <td><? echo ($status==0)?"PENDING":"PAID"; ?></td>
       <td><?=$due_date; ?></td>
       <td><?=$customer_name; ?></td>
       <td><?='<a id="edit_link" class="btn btn-mini" href="index.php?num=120&edit_id='.$trans_id.'">
       <i class="icon-edit"></i> Edit</a>'?></td>      

		  </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>

      <div class="clearfix"></div>
    </div>
  </div>