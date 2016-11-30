<?php
include_once('src/models/SupportTickets.php');
include_once('src/models/ReceivedQuotes.php');
$Support = new SupportTickets;
$quote = new ReceivedQuotes();


if(App::isAjaxRequest()){
    if(isset($_POST['action'])&&!empty($_POST['action'])){
        switch ($_POST['action']){
            case 'get-units':
                $id = $_POST['id'];
                if($id != '') {
                    $units = $Support->selectQuery('houses', 'house_id,house_number', "plot_id = '" . $id . "'");
                    echo json_encode($units);
                }
        }
    }
//    $Support->getMaintenanceDetails($_POST['edit_id']);
}else{
    set_layout("dt-layout.php", array(
        'pageSubTitle' => 'All Maintenance Vouchers',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array (
            array ( 'url'=>'index.php', 'text'=>'Home' ),
            array ( 'text'=>'Maintenance Vouchers' ),
            array ( 'text'=>'All Maintenance Vouchers' )
        )
    ));

    ?>
    <div class="widget">
        <div class="widget-title"><h4><i class="icon-comments-alt"></i> All Maintenance Tickets</h4>

        </div>
        <div class="widget-body form">
            <?php
            $Support->splash('support');
            // display all encountered errors
            (isset($_SESSION['support_error'])) ? $Support->displayWarnings('support_error') : '';
            ?>
            <table id="table1" style="width: 100%" class="table table-bordered">
                <thead>
                <tr>
                    <th>ID#</th>
                    <th>Maintenance Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Create User</th>
                    <th>Submit Quotation</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $result = $Support->getMaintenanceVoucherForContractors();
                while($rows = get_row_data($result)){
                    $data = $Support->getCompliansName($rows['complaint_id']);
                    ?>
                    <tr>
                        <td><?php echo $rows['voucher_id']; ?></td>
                        <td><?php echo $rows['maintenance_name']; ?></td>
                        <td><?php echo $rows['maintenance_description']; ?> </td>
                        <td><?php echo $rows['category_name']; ?></td>
                        <td><?php echo $rows['customer_name']; ?></td>
                        <td>
                            <?php
                            if(!$quote->checkIfVoucherHasBeenWon($rows['voucher_id'])){
                                if($rows['approve_status'] == 't'){
                                    ?>
                                    <a href="#add-quotation"  class="btn btn-mini btn-success raise-quotation"
                                       data-toggle="modal" voucher_id="<?=$rows['voucher_id']; ?>"><i class="icon-paper-clip"></i> Create Quotation</a>
                            <?php }}?>
                        </td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>

    <!-- The Modals -->
    <form action=""  method="post">
    <form action="" method="post">
        <div id="add-quotation" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1"><i class="icon-comments"></i> Add Quotation</h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <label for="bid_amount" class="control-label">Bid Amount</label>
                    <input type="number" name="bid_amount" class="span12" required="true">
                </div>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="add_quotation"/>
            <input type="hidden" name="maintenance_id" id="maintenance_id" >
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo762'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav761'); ?>
            </div>
        </div>
    </form>

    <?php set_js(array('src/js/manage_voucher.js')); }?>