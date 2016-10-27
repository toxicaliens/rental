<?php
  include_once('src/models/Airtime.php');
  $airtime = new Airtime();

	set_title('Airtime Vouchers');
	set_layout("dt-layout.php", array(
		'pageSubTitle' => 'Airtime Vouchers',
		'pageSubTitleText' => '',
		'pageBreadcrumbs' => array (
			array ( 'url'=>'index.php', 'text'=>'Home' ),
			array ( 'text'=>'Airtime' ),
			array ( 'text'=>'Airtime Vouchers' )
		)
	));
?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> Airtime Vouchers</h4></div>
	<div class="widget-body form">
		<table id="table1" class="table table-bordered">
			<thead>
				<tr>
					<th>Voucher#</th>
					<th>Serail#</th>
					<th>Denom.</th>
					<th>Status</th>
					<th>Customer</th>
					<th>Expiry Date</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$result = $airtime->getAllVouchers();
					while ($rows = get_row_data($result)) {
				?>
				<tr>
					<td><?=$rows['airtime_voucher_id']; ?></td>
					<td><?=$rows['voucher_serial']; ?></td>
					<td><?=$rows['value']; ?></td>
					<td><?=($rows['voucher_status'] == 't') ? 'Consumed': 'Not Consumed'; ?></td>
					<td><?=$airtime->getCustomerNameFromMfid($rows['mf_id']); ?></td>
					<td><?=$rows['expiry_date']; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<div class="clearfix"></div>
	</div>
</div>