
<table id="table1" class="live_table table table-bordered">
    <thead>
        <tr>
            <th>Tenant#</th>
            <th>Tenant</th>
            <th>Plot</th>
            <th>House</th>
            <th>Lease Type</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $rows = $lease->leaseInfo($_GET['tenant']);

            if(count($rows)){
                foreach ($rows as $row){
                    $lease_id = $row['lease_id'];
                    $full_name = $row['full_name'];
                    $start_date = $row['start_date'];
                    $end_date = $row['end_date'];
                    $status = $row['status'];
                    $plot_name = $row['plot_name'];
                    $house_number = $row['house_number'];
                    $lease_type = $row['lease_type'];
                    ?>
                <tr>
                    <td><?php echo $lease_id; ?></td>
                    <td><?php echo $full_name; ?></td>
                    <td><?php echo $plot_name; ?></td>
                    <td><?php echo $house_number; ?></td>
                    <td><?php echo $lease_type; ?></td>
                    <td><?php echo $start_date; ?></td>
                    <td><?php echo $end_date; ?></td>
                    <td><?php echo ($row['status'] == 't') ? 'Active' : 'Inactive'?></td>
                </tr>
            <?php }} ?>
    </tbody>
</table>