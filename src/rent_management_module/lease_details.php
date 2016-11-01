<?php
    require_once 'src/models/LeaseAgreement.php';
    $lease = new LeaseAgreement();

    $rows = $lease->leaseInfo();

    if(count($rows)){
    foreach ($rows as $row){
    $lease_id = $row['lease_id'];
    $tenant_name = $row['tenant_name'];
    $start_date = $row['start_date'];
    $end_date = $row['end_date'];
    $status = $row['status'];
    $plot_name = $row['plot_name'];
    $house_number = $row['house_number'];
    $lease_type = $row['lease_type'];


    set_title('LEASE DETAILS');
    set_layout("dt-layout.php", array(
        'pageSubTitle' => 'Lease Details',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array (
            array ( 'url'=>'#', 'text'=>'Home' ),
            array ( 'url'=>'?num=6011', 'text'=>'My Lease' ),
            array ( 'text'=>'Lease Details' )
        )

    ));
?>
<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> <span style="color: green;">My Leases</span></h4></div>
    <div class="widget-body form">
        <!-- BEGIN INLINE TABS PORTLET-->
        <form enctype="multipart/form-data" class="form-horizontal" method="post" id= "" class="widget">
            <div class="row-fluid">
                <div class="span12">
                    <!--BEGIN TABS-->
                    <div class="tabbable tabbable-custom">
                        <ul class="nav nav-tabs">
                            <?php
                                $tab1 = '';
                                $tab2 = '';
                                if(isset($_SESSION['warnings'])){
                                    $tab2 = 'active';
                                }
                                else{
                                    $tab1 = 'active';
                                }
                            ?>
                            <li class="<?php echo $tab1; ?>"><a href="#tab_1_1" data-toggle="tab"><i class="icon-info-sign"></i> Lease Details</a></li>
                            <li class="<?php echo $tab2; ?>"><a href="#tab_1_2" data-toggle="tab"><i class="icon-bar-chart"></i> Statement</a></li>

                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane <?php echo $tab1; ?> profile-classic row-fluid"  id="tab_1_1">
                                <?php include "lease_info.php"; ?>
                            </div>

                            <div class="tab-pane <?php echo $tab2; ?> profile-classic row-fluid" id="tab_1_2">
                                <?php include "my_lease_statement.php"; ?>
                            </div>
                        </div>
                    </div>
                    <!--END TABS-->
                    <!-- END PAGE -->
                </div>
            </div>
        </form>
    </div>
</div>
<?php }} ?>