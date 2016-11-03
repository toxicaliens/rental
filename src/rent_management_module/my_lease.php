<?php
    require_once 'src/models/LeaseAgreement.php';
    $lease = new LeaseAgreement();

    set_title('MY LEASE');
    set_layout("dt-layout.php", array(
        'pageSubTitle' => 'My Lease',
        'pageSubTitleText' => 'All Leases for logged in Property Manager',
        'pageBreadcrumbs' => array (
            array ( 'url'=>'#', 'text'=>'Home' ),
            array ( 'text'=>'My Lease' )
        )
    ));
?>
<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> <span style="color: green;"><?php echo $lease->getUser();?></span></h4></div>
    <div class="widget-body form">
        <?php
        // display all encountered errors
        $lease->splash('lease');
        (isset($_SESSION['warnings'])) ? $mf->displayWarnings('warnings') : '';
        ?>
        <table id="table1" style="width: 100%" class="table table-bordered">
            <thead>
            <tr>
                <th>Lease#</th>
                <th>Tenant</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Manage</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $rows = $lease->getMyLease();

            if(count($rows)){
                foreach ($rows as $row){
                    $lease_id = $row['lease_id'];
                    $tenant_name = $row['tenant_name'];
                    $start_date = $row['start_date'];
                    $end_date = $row['end_date'];
                    $status = $row['status'];
                    $tenant = $row['tenant'];
                    $house_id = $row['house_id'];
                    ?>
                    <tr>
                        <td><?php echo $lease_id; ?></td>
                        <td><?php echo $tenant_name; ?></td>
                        <td><?php echo $start_date; ?></td>
                        <td><?php echo $end_date; ?></td>
                        <td><?php echo ($row['status'] == 't') ? 'Active' : 'Inactive'?></td>
                        <td><a href="index.php?num=6012&tenant=<?php echo $tenant; ?>&unit=<?php echo $house_id?>&lease=<?php echo $lease_id?>"
                               class="btn btn-mini"><i class="icon-edit"></i> Manage</a></td>
                    </tr>
                <?php }} ?>
            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
</div>