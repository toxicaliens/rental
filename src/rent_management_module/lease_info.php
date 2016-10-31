<ul class="unstyled span10">
    <li><span>Lease#: </span><?php echo $lease_id; ?></li>
    <li><span>Tenant: </span><?php echo $tenant_name; ?></li>
    <li><span>Plot: </span><?php echo $plot_name; ?></li>
    <li><span>House: </span><?php echo $house_number; ?></li>
    <li><span>Lease Type: </span><?php echo $lease_type; ?></li>
    <li><span>Start Date: </span><?php echo $start_date; ?></li>
    <li><span>End Date: </span><?php echo $end_date; ?></li>
    <li><span>Status: </span><?php echo ($row['status'] == 't') ? 'Active' : 'Inactive'?></li>
</ul>

