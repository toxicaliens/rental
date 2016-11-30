<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 24/10/16
 * Time: 13:39
 */
require_once('src/models/Plots.php');
require 'vendor/autoload.php';
require 'vendor/Carbon/Carbon.php';
$carbon = new Carbon\Carbon();
//use Carbon\Carbon;
$property_ledger = new Plots();
if (App::isAjaxRequest()){

}else{
    set_title('Vacant Units');
    set_layout("dt-layout.php", array(
        'pageSubTitle' => 'SVacant Units',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array (
            array ( 'url'=>'#', 'text'=>'Home' ),
            array ( 'text'=>'Property manager' ),
            array ( 'text'=>'Vacant Units' )
        ),
        'pageWidgetTitle'=>'<i class="icon-reorder"></i>All Vacant Units'
    ));

    set_css(array(
        'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css'
    ));

    set_js(array(
        'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
    ));

    ?>
    <div class="widget" >

        <div class="widget-title"><h4><i class="icon-reorder"></i> All Vacant Units</h4>
            <?php
//            echo $howOldAmI = $carbon->createFromDate(1995, 5, 21)->age;
//            printf("Now: %s", $carbon->now());
            ?>
        </div>
        <div class="widget-body form">
            <form action="" class="form-horizontal" method="post">
                <div class="row-fluid span12">
                    <div class="control-group span6">
                        <label class="control-label span2">Property Name: </label>
                        <div class="controls">

                            <select class="span10 live_search" name="property_id" required>
                                <option value="">Select a property</option>
                                <?php
                                if($_SESSION['role_name'] == SystemAdmin){
                                    $results = $property_ledger->selectQuery('plots','plot_id,plot_name');
                                }else{
                                    $results = $property_ledger->selectQuery('plots','plot_id,plot_name'," pm_mfid = '".$_SESSION['mf_id']."'");
                                }
                                if(count($results)){
                                    foreach ($results as $result){
                                        ?>
                                        <option value="<?php echo $result['plot_id']?>"><?php echo $result['plot_name'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>

                        </div>
                    </div>

                    <div class="control-group span4" >
                        Search: <button class="btn btn-primary btn-small"><i class="icon-search"></i> </button>
                    </div>
                    <div class="span1">

                    </div>
                </div>
            </form>
            <table class="table table-hover table-bordered" id="table1">
                <thead>
                <tr>
                    <th class="center-align">ID</th>
                    <th class="center-align">Unit Number</th>
                    <th class="center-align">Vacant Since</th>
                </tr>
                </thead>
                <tbody>
                <?php
                ;$total_debit = 0;
                $total_credit = 0;
                if(isset($_POST['property_id'])) {
                    $records = $property_ledger->selectQuery('houses', '*', " plot_id = '" . $_POST['property_id'] . "' AND vacant IS TRUE ");
//                    var_dump($records);
//    }else{
//        $records = $property_ledger->selectQuery('ledger', '*', " created_by = '". $_SESSION['mf_id']."' ");
//    }
                    if(count($records)){
                        $count = 0;
                        foreach ($records as $record){
                            $count++
                            ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $record['house_number']; ?></td>
                                <td><?php echo $carbon->createFromTimestamp(strtotime($record['vacant_since']))->diffForHumans(); ?></td>
                            </tr>
                        <?php }}} ?>
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>

<?php }?>
