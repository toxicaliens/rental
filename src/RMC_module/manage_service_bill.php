<?php
    include_once('src/models/RevenueManager.php');
    $revenue_manager = new RevenueManager;

    set_layout("dt-layout.php", array(
        'pageSubTitle' => 'Services Bills',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array (
            array ( 'url'=>'index.php', 'text'=>'Home' ),
            array ( 'text'=>'Revenue Management' ),
            array ( 'text'=>'Services Bills' )
            )
        ));

  set_js(array("src/js/manage_service_bill.js"))
?>
<!-- BEGIN INLINE TABS PORTLET-->
<div class="widget">
    <div class="widget-title">
        <h4><i class="icon-reorder"></i>MANAGE SERVICES BILLS  </h4>
    </div>
        <div class="widget-body form">
            <?php
                $revenue_manager->splash('rev_mg');
                // display all encountered errors
                (isset($_SESSION['warnings'])) ? $revenue_manager->displayWarnings('warnings') : '';

                if(isset($_SESSION['RMC'])){
                    echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['RMC']."</p>";
                unset($_SESSION['RMC']);
                }
            ?>
            <div class="row-fluid">
                <div class="span12">
                    <!--BEGIN TABS-->
                    <div class="tabbable tabbable-custom">
                        <ul class="nav nav-tabs">
                            <li><a href="#tab_1_1" data-toggle="tab">Add Service Bills</a></li>
                            <li class="active"><a href="#tab_1_2" data-toggle="tab">All Service Bills</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane" id="tab_1_1">
                                <?php include "add_service_bill.php"; ?>
                            </div>

                            <div class="tab-pane active" id="tab_1_2">
                                <?php include "services_bills.php"; ?>
                            </div>
                        </div>
                    </div>
                    <!-- END PAGE -->
                </div>
            </div>
      </div>
</div>
<!--END TABS-->
<?php set_js(array('src/js/filter_house.js')); ?>