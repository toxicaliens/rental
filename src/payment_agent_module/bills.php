 <?
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Bills',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Payments & Bills' ),
		array ( 'text'=>'Bills' )
	)
));
   $distinctQuery2 = "select count(bill_id) as total_bills from ".DATABASE.".customer_bills";
   $resultId2 = run_query($distinctQuery2);
   $arraa = get_row_data($resultId2);
   $total_rows2 = $arraa['total_bills'];
 ?>

<div class="widget">
  <div class="widget-title">
    <h4>Customer Details</h4>
    <span class="actions">
        <a href="index.php?num=163" class="btn btn-primary btn-small">NEW</a>
    </span>
  </div>
  <div class="widget-body">

   <table id="table1" class="table table-bordered">
 <thead>
  <tr>
   <th>Bill#</th>
   <th>B.Due date</th>
   <th>Customer Name</th>
   <th>B.Amount</th>
   <th>Service Account</th>
   <th>B.Balance</th>
   <th>Action</th>
  </tr>
 </thead>
 <tbody>

 <?
   $distinctQuery = "select c.*, m.* from ".DATABASE.".customer_bills c
   LEFT JOIN masterfile m ON m.mf_id = c.mf_id
  ";
   $resultId = run_query($distinctQuery);
   $total_rows = get_num_rows($resultId);


	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['bill_id']);
                $duedate= date("d-m-Y H:i:s",strtotime($row['bill_due_date']));
		$customer_id = $row['mf_id'];
    $full_name = $row['surname'].' '.$row['firstname'].' '.$row['middlename'];
		$bill_amt = $row['bill_amount'];
                // $bstatus = $row['bill_status'];
		$serviceaccount = $row['service_account'];
                $bill_balance = $row['bill_balance'];
//                $serviceaccounttype = $row['service_account_type'];


		 ?>
		  <tr>
		    <td><?=$trans_id; ?></td>
		    <td><?=$duedate; ?></td>
		    <td><?=$full_name; ?></td>
        <td><?=$bill_amt; ?></td>
        <td><?=$serviceaccount; ?></td>
        <td><?=$bill_balance; ?></td>
        <td><a href=index.php?num=140&bill_id=<?=$trans_id; ?> class="btn btn-mini">
                    <i class="icon-money"></i> Pay</a></td>
		  </tr>
		 <?
 	}
	?>
  </tbody>
</table>
<div class="clearfix"></div>
</div>
</div>