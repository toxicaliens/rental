 <?php
	include_once "src/models/Masterfile.php";
	$masterfile = new Masterfile();

	//get the value
	if (isset($_GET['acc_id'])){
		$acc_id=$_GET['acc_id'];

	$full_name = $masterfile->getAccountDetails($acc_id);

	set_layout("dt-layout.php", array(
		'pageSubTitle' => 'Payments and Bills',
		'pageSubTitleText' => '',
		'pageBreadcrumbs' => array (
			array ( 'url'=>'index.php', 'text'=>'Home' ),
			array ( 'text'=>'Payments & Bills' ),
			array ( 'url' =>'?num=168', 'text'=>'All Billing File' )
		)
	));

	}
?>

<div class="widget">
	<div class="widget-title"><h4 style="color:green;"><i class="icon-reorder"></i> <?=$full_name['customer_name']; ?></h4></div>
	<div class="widget-body">

		<table class="table table-bordered table-hover live_table">
			<thead>
				<tr>
					<th>BF#</th>
					<th>B.Date</th>
					<th>B.Amount</th>
					<th>B.Amount Paid</th>
					<th>B.Balance</th>
					<th>B.Due Date</th>
					<th>B.Status</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$bills = $masterfile->getCustomerBillsForPhone($acc_details['customer_code']);
					if(count($bills)){
						foreach($bills as $rows){
				?>
				<tr>
					<td><?php echo $rows['bill_id']; ?></td>
					<td><?php echo $rows['bill_date']; ?></td>
					<td><?php echo $rows['bill_amount']; ?></td>
					<td><?php echo $rows['bill_amount_paid']; ?></td>
					<td><?php echo $rows['bill_balance']; ?></td>
					<td><?php echo $rows['bill_due_date']; ?></td>
					<td><?php echo ($rows['bill_status'] == 'f') ? 'Pending' : 'Paid'; ?></td>
				</tr>
				<?php }} ?> 
			</tbody>
		</table> 
		<div class="clearfix"></div>
	</div>
</div>