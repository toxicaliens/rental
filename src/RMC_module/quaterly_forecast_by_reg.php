<table class="table table-bordered">
			<thead>
				<tr>
					<th>Revenue channel</th>
					<!--function to loop and load the regions-->
					<?php
					$results = $revenue_manager ->getAllregions();
					while($rows=get_row_data($results)){
					?>
					<th><?=$rows['region_name'];?></th>
					<?php } ?>
					
				</tr>
			</thead>
			<tbody>
			   <!--function to loop and load the Revenue Channels-->
				<?php
			$result = $revenue_manager->getAllRevenueChannelsForRegions();
			while($rows = get_row_data($result)){
				?>
				<tr>
					<td><?=$rows['revenue_channel_name']; ?></td>
					<!-- function to loop and load the target amount for the specific revenue channel and region-->
					<?php $revenue_manager->populateQuaterlyTargetAmountsForEachRegion($rows['revenue_channel_id']); ?>
					
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<div class="clearfix"></div>