<?php
include_once('src/models/Reports.php');
$report = new Reports;
set_layout("dt-layout.php", array(
    'pageSubTitle' => 'All Units',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'text'=>'REPORTS' ),
        array('text'=>'Property Units')
    )
));

set_css(array(
    'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css',
    'assets/plugins/bootstrap-datepicker/css/datepicker.css',
    'assets/css/pages/invoice.css'
));
set_js(array(
    'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
    'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
    'assets/plugins/data-tables/jquery.dataTables.js',
    'assets/plugins/data-tables/DT_bootstrap.js',
    'src/js/daily_staff_summary.js'
));

?>

<div class="widget hidden-print">
    <div class="widget-title">
        <h4><i class="icon-reorder"></i> Filters</h4>
        <span class="tools">
      <a href="javascript:;" class="icon-chevron-up"></a>
    </span>
    </div>
    <div class="widget-body form" style="display: none;">
        <?php
        //            $post_day = '';
        //            if(isset($_POST['date'])){
        //                $post_day = date('Y-m-d', strtotime($_POST['date']));
        //                $rev_id = $_POST['rev_id'];
        //            }else{
        //                $post_day = date('Y-m-d');
        //                $rev_id = '';
        //            }
        ?>
        <form action="" method="POST" class="form-horizontal">
            <!-- <h3 class="form-section">Person Info</h3> -->
            <div class="row-fluid">
                <div class="span6 offset2">
                    <div class="control-group">
                        <label for="view_name" class="control-label">Filter By:<span class="required">*</span></label>
                        <div class="controls">
                            <select name="filter_by" class="span12" id="filter_by" required>
                                <option value="">choose value to filter by</option>
                                <option value="property">Property</option>
                                <option value="landlord">Landlord</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid" style="display: none" id="landlord">
                <div class="span6 offset2">
                    <div class="control-group">
                        <label for="view_name" class="control-label">Landlord:<span class="required">*</span></label>
                        <div class="controls">
                            <select name="landlord_id" class="span12 live_search" id="landlord_id">
                                <option value="">--Choose a Landlord--</option>
                                <?php
                                if($_SESSION['role_name'] != SystemAdmin){
                                    $condition = "created_by = '".$_SESSION['mf_id']."' AND b_role = 'land_lord'";
                                }else{
                                    $condition = "b_role = 'land_lord'";
                                }
                                $results = $report->selectQuery('masterfile','*',$condition);
                                //                                    var_dump($results);die;
                                if(count($results)){
                                    foreach($results as $result){
                                        ?>
                                        <option value="<?php echo $result['mf_id']?>"><?php echo $result['surname'].' '.$result['middlename'].' '.$result['firstname'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid" style="display: none" id="property">
                <div class="span6 offset2">
                    <div class="control-group">
                        <label for="view_name" class="control-label">Property:<span class="required">*</span></label>
                        <div class="controls">
                            <select name="property_id" class="span12 live_search" id="property_id" >
                                <option value="">--Choose a property--</option>
                                <?php
                                if($_SESSION['role_name'] != SystemAdmin){
                                    $condition = "created_by = '".$_SESSION['mf_id']."'";
                                }else{
                                    $condition = Null;
                                }
                                $results = $report->selectQuery('plots','*',$condition);
                                //                                    var_dump($results);die;
                                if(count($results)){
                                    foreach($results as $result){
                                        ?>
                                        <option value="<?php echo $result['plot_id']?>"><?php echo $result['plot_name'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="span6 offset2">
                Search: <button class="btn btn-default btn-small"><i class="icon-search"></i> </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="widget">
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <div id="page">
            <div class="invoice">
                <table class="table table-condensed" style="margin:0px;">
                    <tr>
                        <td style="text-align: center">
                            <!--                                <h3><strong>--><?php //echo usp_name; ?><!--</strong></h3>-->
                            <h4><strong> All Units</strong></h4>
                        <td>
                    </tr>
                </table>
                <table class="table table-bordered table-condensed" style="margin:0px;">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>House Number</th>
                        <th>Rent Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total = 0;
                    if (isset($_POST['property_id']) || isset($_GET['property_id']) || isset($_POST['landlord_id'])){
                        if(!empty($_POST['property_id'])){
                            $property_id = $_POST['property_id'];
                            $condition = "plot_id = '".$property_id."'";
                        }else if(!empty($_GET['property_id'])){
                            $property_id = $_GET['property_id'];
                            $condition = "plot_id = '".$property_id."'";
                        }else if(!empty($_POST['landlord_id'])){
                            $property_id = $_POST['landlord_id'];
                            $condition = "landlord_mf_id = '".$property_id."'";
                        }else{
                            $property_id = '';
                        }

                        $reports = $report->selectQuery('houses_and_plots','*',$condition);

                        if(count($reports)){
//                            print_r($reports);die;
                            $count = 0;

                            foreach ($reports as $result){
                                $total = $total + $result['rent_amount'];
                                $count++
                                ?>
                                <tr>
                                    <td><?php echo $count ?></td>
                                    <td><?php echo $result['house_number']?></td>
                                    <td><?php echo number_format($result['rent_amount'],2)?></td>
                                </tr>
                                <?php
                            }}
                    }
                    ?>
                    <tr>
                        <th colspan="2" style="text-align: right">Totals</th>
                        <th><?php echo 'Ksh '.number_format($total,2)?></th>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-condensed" style="margin:0px;">
                    <tbody>
                    <tr>
                        <td class="hidden-480">
                            <br />
                            <br />
                            <a class="btn btn-success btn-large hidden-print pull-right" onclick="javascript:window.print();">Print <i class="icon-print icon-big"></i></a>
                        <td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
<?php set_js(array('src/js/all_units.js'));  ?>

