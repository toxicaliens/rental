<?php
require_once 'src/models/ReceivedQuotes.php';
$quotes = new ReceivedQuotes();
        set_title('My quotes');
        set_layout("dt-layout.php", array(
            'pageSubTitle' => 'My Quotations',
            'pageSubTitleText' => '',
            'pageBreadcrumbs' => array (
                array ( 'url'=>'#', 'text'=>'Home' ),
                array (  'text'=>'Support Tickets' ),
                array ( 'text'=>'My Quotes' )
            )

        ));
        ?>
        <div class="widget">
            <div class="widget-title"><h4><i class="icon-reorder"></i> <span style="color: green;">My Quotations</span></h4></div>
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
                                    <li class="<?php echo $tab1; ?>"><a href="#tab_1_1" data-toggle="tab"><i class="icon-info-sign"></i> Pending Quotations</a></li>
                                    <li class="<?php echo $tab2; ?>"><a href="#tab_1_2" data-toggle="tab"><i class="icon-bar-chart"></i> Approved Quotations</a></li>

                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane <?php echo $tab1; ?> profile-classic row-fluid"  id="tab_1_1">
                                        <?php include "pending_quotations.php"; ?>
                                    </div>

                                    <div class="tab-pane <?php echo $tab2; ?> profile-classic row-fluid" id="tab_1_2">
                                        <?php include "approved_quotations.php"; ?>
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
    <?php ?>