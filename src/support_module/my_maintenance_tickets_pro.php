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
            <span class="actions">
			<a href="#add_voucher" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i>Add Maintenance Ticket</a>
		</span>
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
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Approve</th>
                    <th>Submit Quotation</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $result = $Support->getMaintenanceVoucher();
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
                            //                        var_dump($rows['approve_status']);exit;
                            if($rows['approve_status'] == 'f'){
                                ?>
                                <a href="#edit_voucher" class="btn btn-mini btn-warning edit_voc"
                                   data-toggle="modal" voucher_id="<?=$rows['voucher_id']; ?>"><i class="icon-edit"></i> Edit</a>
                            <?php } ?>
                        </td>
                        <td>
                            <?php
                            if($rows['approve_status'] == 'f') {
                                ?>
                                <a href="#delete_voucher" class="btn btn-mini btn-danger delete_voc"
                                   data-toggle="modal" voucher_id="<?= $rows['voucher_id']; ?>"><i class="icon-trash"></i>
                                    Delete</a>
                            <?php } ?>
                        </td>
                        <td>
                            <?php
                            if($rows['approve_status'] == 'f'){
                                ?>
                                <a href="#approve_voucher" class="btn btn-mini btn-success approve_voc"
                                   data-toggle="modal" voucher_id="<?=$rows['voucher_id']; ?>"><i class="icon-paper-clip"></i> Approve</a>
                            <?php }else{
                                echo 'Approved';
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if(!$quote->checkIfVoucherHasBeenWon($rows['voucher_id'])){
                                if($rows['approve_status'] == 't'){
                                    ?>
                                    <a href="#add-quotation"  class="btn btn-mini btn-success raise-quotation"
                                       data-toggle="modal" voucher_id="<?=$rows['voucher_id']; ?>"><i class="icon-paper-clip"></i> Create Quotation</a>
                                <?php }}else{
                                echo 'Job unavailable';
                            } ?>
                        </td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>

    <!-- The Modals -->
    <form action="" method="post">
        <div id="add_voucher" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1"><i class="icon-comments"></i>Add Maintenance voucher</h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
<!--                    Customer Complaint-->
<!--                    <select id="select2_sample2" name="complaint_id" class="span12" >-->
<!--                        <option value="">--Select Complaint--</option>-->
<!--                        --><?php
//                        $data = $Support->allMaintenanceTickets();
//                        while($rows = get_row_data($data)){
//                            ?>
<!--                            <option value="--><?//=$rows['maintenance_ticket_id']; ?><!--">--><?//=$rows['body']; ?><!--</option>-->
<!--                        --><?php //} ?>
<!--                    </select>-->
                </div>
                <label for="property_id">Property</label>
                <div class="row-fluid" style="margin-bottom: 10px">
                    <select id="property_id" name="property_id" class="span12 live_search" required>
                        <option value="">--Select Property--</option>
                        <?php
                            if($_SESSION['role_name'] != SystemAdmin){
                                $condition = "pm_mfid = '".$_SESSION['mf_id']."'";
                            }else{
                                $condition = Null;
                            }
                            $datas = $Support->selectQuery('plots','plot_id,plot_name',$condition);
                            if(count($datas)){
                                foreach ($datas as $data){
                                    ?>
                                    <option value="<?php echo $data['plot_id']?>"><?php echo $data['plot_name']?></option>
                                    <?php
                                }
                            }

                        ?>
                    </select>
                </div>

                <label for="unit_id">Unit</label>
                <div class="row-fluid" style="margin-bottom: 10px">
                    <select id="unit_id" name="unit_id" class="span12 live_search">
                        <option value="">--Select unit--</option>

                    </select>
                </div>


                <label for="">Categories</label>
                <div class="row-fluid">
                    <select  name="category_id" class="span12 live_search" required>
                        <option value="">--Select Category--</option>
                        <?php
                        $data = $Support->getVoucherCategories();
                        while($rows = get_row_data($data)){
                            ?>
                            <option value="<?=$rows['category_id']; ?>"><?=$rows['category_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="row-fluid">
                    <label for="maintenance_name" class="control-label">Maintenance Name</label>
                    <input type="text" name="maintenance_name" required id="maintenance_name" class="span12">
                </div>
                <div class="row-fluid">
                    <label for="maintenance_description" class="control-label">Maintenance Description</label>
                    <textarea name="maintenance_description" class="span12" required></textarea>
                </div>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="add_voucher"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo758'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav756'); ?>
            </div>
        </div>
    </form>

    <form action="" method="post">
        <div id="edit_voucher" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1"><i class="icon-comments"></i>Edit Maintenance Vouchers</h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    Customer Complaint
                    <select name="complaint_id" class="span12 complaint_id" >
                        <option value="">--Select Complaint--</option>
                        <?php
                        $data = $Support->allMaintenanceTickets();
                        while($rows = get_row_data($data)){
                            ?>
                            <option value="<?=$rows['maintenance_ticket_id']; ?>"><?=$rows['body']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <label for="">Categories</label>
                <div class="row-fluid">
                    <select name="category_id" class="span12 category_id" required>
                        <option value="">--Select Category--</option>
                        <?php
                        $data = $Support->getVoucherCategories();
                        while($rows = get_row_data($data)){
                            ?>
                            <option value="<?=$rows['category_id']; ?>"><?=$rows['category_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="row-fluid">
                    <label for="maintenance_name" class="control-label">Maintenance Description</label>
                    <textarea name="maintenance_name" id="maintenance_name" class="span12" required></textarea>
                </div>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="edit_voucher"/>
            <input type="hidden" name="voucher_id" id="vouch_id" />
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo650'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav649'); ?>
            </div>
        </div>
    </form>

    <!-- delete modal -->
    <form action=""  method="post">
        <div id="delete_voucher" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Delete Maintenance Vouchers</h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the Maintenance Vouchers?</p>
            </div>
            <!-- hidden fields -->
            <input type="hidden" name="action" value="delete_voucher"/>
            <input type="hidden" id="voucher_id" name="voucher_id"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'],$_GET['num'],'No651'); ?>
                <?php createSectionButton($_SESSION['role_id'],$_GET['num'],'Yes652'); ?>
            </div>
        </div>
    </form>

    <form action=""  method="post">
        <div id="approve_voucher" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Approve Maintenance ticket</h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to approve this ticket?</p>
            </div>
            <!-- hidden fields -->
            <!--        <input type="hidden" name="action" value="approve_voucher"/>-->
            <input type="hidden" id="app_voucher_id" name="voucher_id"/>
            <input type="hidden" name="action"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'],$_GET['num'],'Dec760'); ?>
                <?php createSectionButton($_SESSION['role_id'],$_GET['num'],'App759'); ?>
            </div>
        </div>
    </form>

    <form action="" method="post">
        <div id="add-quotation" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1"><i class="icon-comments"></i> Add Quotation</h3>
            </div>
            <div class="modal-body">
                <label for="contractor">Contractor</label>
                <div class="row-fluid" style="margin-bottom: 10px">
                    <select name="contractor_id" id="contractor" class="span12 live_search">
                        <option value="">--Select a contractor--</option>
                        <?php
                            $contractors = $Support->selectQuery('masterfile','surname,mf_id'," b_role = 'contractor' AND created_by = '".$_SESSION['mf_id']."'");
                            if(count($contractors)){
                                foreach ($contractors as $contractor){
                                    ?>
                                    <option value="<?php echo $contractor['mf_id']?>"><?php echo $contractor['surname']?></option>
                                    <?php
                                }
                            }
                        ?>
                        ?>
                    </select>
                </div>
                <div class="row-fluid">
                    <label for="bid_amount" class="control-label">Bid Amount</label>
                    <input type="number" name="bid_amount" class="span12" required="true">
                </div>


            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="add_quotation_pm"/>
            <input type="hidden" name="maintenance_id" id="maintenance_id" >
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo758'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav756'); ?>
            </div>
        </div>
    </form>

    <?php set_js(array('src/js/manage_voucher.js')); }?>