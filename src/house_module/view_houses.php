<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 19/07/16
 * Time: 14:02
 */
include_once 'src/models/Plots.php';
$prop = new Plots();
include_once 'src/models/House.php';
$House = new House();
if(app::isAjaxRequest()){
    if(isset($_POST['action'])){
        $action = $_POST['action'];
        switch ($action){
            case 'attach_service_to_house':
                logAction($action,$_SESSION['sess_id'], $_SESSION['mf_id']);
                $json = $House->attachService($_POST['service_id'],$_POST['house_id']);
                echo json_encode($json);
                break;

            case 'detach_service_from_house':
                logAction($action,$_SESSION['sess_id'], $_SESSION['mf_id']);

                $json = $House->detachService($_POST['service_id'],$_POST['house_id']);
                echo json_encode($json);
                break;
            case 'check_attached':
                logAction($action,$_SESSION['sess_id'], $_SESSION['mf_id']);
                $house_services = $House->selectQuery('house_services','*',"house_id = '".$_POST['house_id']."'");
                // collect all the service ids attached to the selected house
                $hs_service_ids = array();
                if(count($house_services)){
                    foreach ($house_services as $house_service){
                        $hs_service_ids[] = $house_service['service_channel_id'];
                    }
                }

                $return = array();
                $leaf_services = $House->getAllServices(Leaf_Service);
                if(count($leaf_services)){
                    foreach ($leaf_services as $leaf_service){
                        if(in_array($leaf_service['service_channel_id'], $hs_service_ids)){
                            $return[] = $leaf_service['service_channel_id'];
                        }
                    }
                }

                echo json_encode($return);
                break;
        }
    }

    if(isset($_POST['edit_id'])) {
        $House->getHouseDataFromId($_POST['edit_id']);
    }
}else{
set_title('View House Details');
set_layout("dt-layout.php", array(
    'pageSubTitle' => 'Houses',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'#', 'text'=>'Home' ),
        array ( 'text'=>'House Details' )
    ),
    'pageWidgetTitle'=>'<i class="icon-reorder"></i>View House'
));

set_css(array(
    'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css'
));

set_js(array(
    'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
));
?>

<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> Manage Houses</h4>
        <span class="actions">
            <div class="btn-group">
                 <a class="btn btn-small btn-primary" ><i class="icon-list"></i> Actions</a>
                 <a class="btn btn-small btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="icon-caret-down"></span>
                 </a>
                 <ul class="dropdown-menu">
                    <li><a href="#add_house" data-toggle="modal"><i class="icon-plus"></i> Add</a></li>
                    <li><a href="#edit-house" class="edit_house"><i class="icon-trash"></i> Edit</a></li>
                    <li><a href="#delete-house" class="delete-house"><i class="icon-remove"></i> Delete</a></li>
                 </ul>
            </div>
            <a href="#attach_services"  class="btn btn-small btn-success attach_service"><i class="icon-paper-clip"></i> Attach a service</a>
        </span>
    </div>

    <div class="widget-body form">
        <?php
        if(isset($_SESSION['houses'])){
            echo $_SESSION['houses'];
            unset($_SESSION['houses']);
        }
        ?>
        <table id="table1" class="table table-bordered">
            <thead>

            <tr>
                <th>ID#</th>
                <th>House Number</th>
                <th>Rent</th>
                <th>Plot</th>
                <th>Tenant</th>
                <th>Allocate</th>
                <th>Profile</th>
            </tr>
            </thead>
            <tbody>
                <?php

                $rows = $House->getHouseData();
                if($rows){
                foreach($rows as $row){
                    $full_name = trim($row['full_name']);
                ?>
               <tr>
                    <td><?php echo $row['house_id']; ?></td>
                    <td><?php echo $row['house_number']; ?></td>
                    <td><?php echo $row['rent_amount']; ?></td>
                    <td><?php echo $row['plot_name']; ?></td>
                    <td><?php echo ($full_name != '') ? $full_name : 'Vacant'; ?></td>
                    <td><a href="?num=house_alloc&&house_id=<?php echo $row['house_id'];?>" class="btn  btn-mini">View/attach attribute</a> </td>
                    <td><a href="?num=900&&house_id=<?php echo $row['house_id'];?>" class="btn btn-mini"><i class="icon-eye-open"></i> Profile</a></td>
                </tr>

            <?php }}?>
            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
</div>

<!-- modal for add -->
<form action="" method="post">
    <div id="add_house" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Add A House</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">

                <label for="group_name">Plot:</label>
                <select name="plot" class="span12" required="required">
                    <option value="">--Select plot--</option>
                    <?php
                   // $plots = $House->getAllProperties();
                    $plots = $prop->getPropertyDataByRole();
                    if(count($plots)){
                        foreach ($plots as $plot) {
                            ?>
                            <option value="<?php echo $plot['plot_id']; ?>"><?php echo $plot['plot_name']; ?></option>
                        <?php }} ?>
                </select>
            </div>
            <div class="row-fluid">
                <label for="group_name">House Number:</label>
                <input type="text" name="house_number" value="" class="span12" required>
            </div>
            <div class="row-fluid">
                <label for="group_name">Rent Amount:</label>
                <input type="number" name="rent_amount" value="" class="span12" required>
            </div>

        </div>
        <!-- the hidden fields -->
        <input type="hidden" name="action" value="add_house"/>
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo695'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav694'); ?>
        </div>
    </div>
</form>

<!--modal for edit-->
<form action="" method="post">
    <div id="edit-house" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Edit House</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <label for="group_name">Plot:</label>
                <select id="plt" name="plot" class="span12" required="required">
                    <option value="">--Select plot--</option>
                    <?php
                    //$plots = $House->getAllProperties();
                    $plots = $prop->getPropertyDataByRole();
                    if(count($plots)){
                    foreach ($plots as $plot) {
                        ?>
                        <option value="<?=$plot['plot_id']; ?>"><?=$plot['plot_name']; ?></option>
                    <?php } }?>
                </select>
            </div>
            <div class="row-fluid">
                <label for="group_name">House Number:</label>
                <input id="hse" type="text" name="house_number" value="" class="span12" required>
            </div>
            <div class="row-fluid">
                <label for="group_name">Rent Amount:</label>
                <input type="number" id="rent-amount" name="rent_amount" value="" class="span12" required>
            </div>


        </div>
        <!-- the hidden fields -->
        <input type="hidden" name="action" value="edit_house"/>
        <input type="hidden" id="edit">
        <input type="hidden" name="edit_id" id="edit_h">
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo697'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav696'); ?>
        </div>
    </div>
</form>
<!--modal for delete-->
<form action=""  method="post">
    <div id="delete-house" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Delete House</h3>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this house?</p>
        </div>
        <!-- hidden fields -->
        <input type="hidden" name="action" value="delete_house"/>
        <input type="hidden" id="delete_id" name="delete_id"/>
        <input type="hidden" id="del_id">
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No699'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes698'); ?>
        </div>
    </div>
</form>
<!--    modal for attaching services-->
<form action="" method="post" id="service_form">
    <div id="attach_services" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel1">Attach Services to house</h3>
        </div>
        <div class="modal-body">
            <div class="alert alert-success" style="display: none;" id="attach-success">
                <button class="close" data-dismiss="alert">&times;</button>
                <strong>Success!</strong> Successfully attached the service.
            </div>
            <div class="alert alert-success" style="display: none;" id="detach-success">
                <button class="close" data-dismiss="alert">&times;</button>
                <strong>Success!</strong> Successfully detached the service.
            </div>
            <div class="alert alert-error" style="display: none;" id="attach-fail">
                <button class="close" data-dismiss="alert">&times;</button>
                <strong>Error!</strong> Failed to attach the selected service.
            </div>
            <div class="warnings"></div>
            <div class="alert alert-success" id="status" style="display: none">
                <button class="close" data-dismiss="alert">×</button>
                <div class="row-fluid">
                <div id="message"></div>
                </div>
            </div>
            <?php
            $results = $House->getAllServices('Leaf');
              if(count($results)){
                  foreach ($results as $result){

            ?>
            <div class="row-fluid">
                <label for="service" class="control-group"></label>
                <input type="checkbox" id="service" name="" class="service" value="<?php echo $result['service_channel_id'];?>"> <?php echo $result['service_option'].'        Amount:<strong>Ksh. </strong> '.number_format($result['price']) ;?>
            </div>
                  <?php } }?>
        </div>

        <!-- the hidden fields -->
<!--        <input type="hidden" name="action" value="attach_service">-->
        <input type="hidden" name="attach_services" id="attach_service">
        <div class="modal-footer">
        </div>
    </div>
</form>

<?php set_js(array('src/js/house.js')); } ?>
