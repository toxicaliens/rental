<?php
  include_once('src/models/Airtime.php');
  $airtime = new Airtime();

	set_title('Airtime Claims');
	set_layout("dt-layout.php", array(
		'pageSubTitle' => 'Airtime Claims',
		'pageSubTitleText' => '',
		'pageBreadcrumbs' => array (
			array ( 'url'=>'index.php', 'text'=>'Home' ),
			array ( 'text'=>'Airtime' ),
			array ( 'text'=>'Airtime Claims' )
		)
	));
?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> Airtime Claims</h4></div>
	<div class="widget-body form">
		<table id="table1" class="table table-bordered">
			<thead>
				<tr>
					<th>Claim#</th>
					<th>Airtime Amount</th>
					<th>Serial</th>
					<th>Claimed</th>
					<th>Customer</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$result = $airtime->getAirtimeClaims();
					while ($rows = get_row_data($result)) {
				?>
				<tr>
					<td><?=$rows['airtime_claim_id']; ?></td>
					<td><?=$rows['airtime_amount']; ?></td>
					<td><?=$rows['airtime_serial_no']; ?></td>
					<td><?=($rows['claimed'] == 't') ? 'Consumed': 'Not Consumed'; ?></td>
					<td><?=$airtime->getCustomerNameFromMfid($rows['mf_id']); ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<div class="clearfix"></div>
	</div>
</div>