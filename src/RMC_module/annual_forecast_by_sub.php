<!-- forecasting table for subcounty -->
<table class="table table-bordered">
	<thead>
		<tr>
			<th>Revenue Channels</th>
			<?php
				$result = $revenue_manager->getAllSubcounties();
				while($rows = get_row_data($result)){
			?>
			<th><?=ucwords($rows['sub_county_name']); ?></th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php
			$result = $revenue_manager->getAllRevenueChannelsForSubcounty();
			while($rows = get_row_data($result)){
		?>
		<tr>
			<td><?=ucwords($rows['revenue_channel_name']); ?></td>
			<?php $revenue_manager->populateAnnualTargetAmountsForEachSubcounty($rows['revenue_channel_id']); ?>
		</tr>
		<?php } ?>
	</tbody>
</table>
<div class="clearfix"></div>
