<table id="table1" class="table table-bordered">
					         <thead>
					          <tr>
					           <th>Bill#</th>
					           <th>Name</th>
                               <th>Description</th>
                               <th>Category</th>
					           <th>Type</th>
					           <th>Interval</th>
                               <th>Amt. Type</th>
                               <th>Rev. Channel</th>
                               <th>Service</th>
                               <th>Code</th>
					           <th>Due Time</th>
                               <th>Amount</th>
                               
                               <th>Edit</th>
					          </tr>
					         </thead>
                                                 
                   <tbody>

 <?
   $distinctQuery = "SELECT s.*, r.* FROM revenue_service_bill s 
   LEFT JOIN revenue_channel r ON r.revenue_channel_id = s.revenue_channel_id
  
   Order by s.revenue_bill_id DESC";
   // var_dump($distinctQuery);exit;
              
   $resultId = run_query($distinctQuery);
   $total_rows = get_num_rows($resultId);


	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$revenue_bill_id =($row['revenue_bill_id']);
		$bill_name = $row['bill_name'];
		$bill_description =($row['bill_description']);
		$bill_category = $row['bill_category'];
		$bill_type =($row['bill_type']);
		$amount_type = $row['amount_type'];
		$bill_code =($row['bill_code']);
		$bill_due_time = $row['bill_due_time'];
		$amount = $row['amount'];
		$revenue_channel_id= $row['revenue_channel_id'];
		$revenue_channel_name= $row['revenue_channel_name'];
		$interval = $row['bill_interval'];
		$service = getBillServiceOption($row['service_channel_id']);
		$product_id= $row['product_id'];
		
		 ?>
		  <tr>
		   <td><?=$revenue_bill_id; ?></td>
           <td><?=$bill_name; ?></td>
           <td><?=$bill_description; ?></td>
           <td><?=$bill_category; ?></td>
           <td><?=$bill_type; ?></td>
           <td><?=$interval; ?></td>
           <td><?=$amount_type; ?></td>
           <td><?=$revenue_channel_name; ?></td>
           <td><?=$service; ?></td>
           <td><?=$bill_code; ?></td>
           <td><?=$bill_due_time; ?></td>
           <td><?=$amount; ?></td>
           
           <td><a id="edit_link" class="btn btn-mini" href="index.php?num=643&edit_id=<?=$revenue_bill_id; ?>">
                   <i class="icon-edit"></i> Edit</a></td>
		  </tr>
		 <?
 	}
	?>
  </tbody>
</table>
<div class="clearfix"></div>