<?php
include_once('src/models/Reports.php');
$report = new Reports;
set_layout("dt-layout.php", array(
    'pageSubTitle' => 'Units in Arrears',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'text'=>'REPORTS' ),
        array('text'=>'Units in Arrears')
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
                <div class="span6">
                    <div class="control-group">
                        <label for="view_name" class="control-label">Property:<span class="required">*</span></label>
                        <div class="controls">
                            <select name="land_lord" class="span12">
                                <option value="">--Choose a Property--</option>
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
                <div class="control-group span4" >
                    Search: <button class="btn btn-default btn-small"><i class="icon-search"></i> </button>
                </div>
            </div>
            <div class="form-actions">
                <!--                    --><?php //viewActions($_GET['num'], $_SESSION['role_id']); ?>
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
                            <h4><strong> All Properties</strong></h4>
                        <td>
                    </tr>
                </table>
                <table class="table table-bordered table-condensed" style="margin:0px;">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Property Name</th>
                        <th class="hidden-print">View Units</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($_POST['land_lord'])){
                        $reports = $report->selectQuery('plots','*',"landlord_mf_id = '".$_POST['land_lord']."'");

                        if(count($reports)){
//                            print_r($reports);die;
                            $count = 0;
                            foreach ($reports as $result){
                                $count++
                                ?>
                                <tr>
                                    <td><?php echo $count ?></td>
                                    <td><?php echo $result['plot_name']?></td>
                                    <td class="hidden-print"><a class="btn btn-default btn-mini" href="<?php echo '?num=6007&&property_id='.$result['plot_id'] ?>">View units</a></td>
                                </tr>

                                <?php
                            }}
                    }
                    ?>

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
