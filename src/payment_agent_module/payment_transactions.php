<?
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Payments',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Payments & Bills' ),
		array ( 'text'=>'Payments' )
	)
));
   $distinctQuery2 = "select count(transaction_id) as total_transactions from ".DATABASE.".transactions";
   $resultId2 = run_query($distinctQuery2);
   $arraa = get_row_data($resultId2);
   $total_rows2 = $arraa['total_transactions'];
 ?>

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
   <th>Receipt Number</th>
   <th>T. Date</th>
   <th>Agent</th>
   <th>Revenue Channel</th>
   <th>Reciepts</th>
  </tr>
 </thead>
 <tbody>

 <?
   $distinctQuery = "select t.*, t.transaction_date::bigint AS tranc_date, m.*, r.* from ".DATABASE.".transactions t
   LEFT JOIN masterfile m ON m.mf_id = t.agent_id
   LEFT JOIN revenue_channel r ON r.revenue_channel_id = t.service_type_id
  ";
  //var_dump($distinctQuery);exit;
   $resultId = run_query($distinctQuery);
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['transaction_id']);
    $cashpaid= $row['cash_paid'];
		$details = $row['details'];
		$receiptnumber = $row['receiptnumber'];
    $tdate = date("d-m-Y H:i:s", $row['tranc_date']);
		$agent = $row['surname'].' '.$row['firstname'].' '.$row['middlename'];
    $service_type = $row['service_type_id'];
		$revenue_channel_name = $row['revenue_channel_name'];
		
		 ?>
		  <tr>
		   <td><?=$trans_id; ?></td>
		   <td><?=$cashpaid; ?></td>
		   <td><?=$details; ?></td>
       <td><?=$receiptnumber; ?></td>
       <td><?=$tdate; ?></td>
		   <td><?=$agent; ?></td>
       <td><?=$revenue_channel_name; ?></td>
       <td>
         <a id="edit_link" class="btn btn-mini" href="index.php?num=170&trans=<?=$trans_id; ?>">
            <i class="icon-print"></i> Reciepts</a>
       </td>                             
		  </tr>
		 <?
 	}
	?>
  </tbody>
</table>
<div class="clearfix"></div>
</div>
</div>