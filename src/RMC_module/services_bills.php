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

 <?php
    $service_bills = $revenue_manager->getAllServiceBills();
    if(count($service_bills)){
        foreach ($service_bills as $row){
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
		
		 ?>
		  <tr>
		   <td><?php echo $revenue_bill_id; ?></td>
           <td><?php echo $bill_name; ?></td>
           <td><?php echo $bill_description; ?></td>
           <td><?php echo $bill_category; ?></td>
           <td><?php echo $bill_type; ?></td>
           <td><?php echo $interval; ?></td>
           <td><?php echo $amount_type; ?></td>
           <td><?php echo $revenue_channel_name; ?></td>
           <td><?php echo $service; ?></td>
           <td><?php echo $bill_code; ?></td>
           <td><?php echo $bill_due_time; ?></td>
           <td><?php echo $amount; ?></td>
           
           <td><?php echo ($bill_code != 'MR')? '<a id="edit_link" class="btn btn-mini" href="index.php?num=643&edit_id='.$revenue_bill_id.'">
                   <i class="icon-edit"></i> Edit</a>':''?></td>
		  </tr>
		 <?
 	}}
	?>
  </tbody>
</table>
<div class="clearfix"></div>