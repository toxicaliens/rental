<?php
include_once('src/models/SupportTickets.php');
$Support = new SupportTickets;

if(App::isAjaxRequest()){
    $Support->getMaintenanceDetails($_POST['edit_id']);
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
    <div class="widget-title"><h4><i class="icon-comments-alt"></i> All Maintenance Vouchers</h4>
	    <span class="actions">
			<a href="#add_voucher" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i>Add Maintenance Vouchers</a>
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
                <th>Customer Complaint</th>
                <th>Maintenance Name</th>
                <th>Category</th>
                <th>Create User</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Approve</th>
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
                    <td><?php echo $data; ?> </td>
                    <td><?php echo $rows['maintenance_name']; ?></td>
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
                        <?php }?>
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
            <h3 id="myModalLabel1"><i class="icon-comments"></i>Add Maintenance Vouchers</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                Customer Complaint
                <select id="select2_sample2" name="complaint_id" class="span12" >
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
                <select id="select2_sample3" name="category_id" class="span12" required>
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
                <textarea name="maintenance_name" class="span12" required></textarea>
            </div>
        </div>
        <!-- the hidden fields -->
        <input type="hidden" name="action" value="add_voucher"/>
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo650'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav649'); ?>
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
            <h3 id="myModalLabel1">Approve Maintenance Vouchers</h3>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to approve?</p>
        </div>
        <!-- hidden fields -->
<!--        <input type="hidden" name="action" value="approve_voucher"/>-->
        <input type="hidden" id="app_voucher_id" name="voucher_id"/>
        <input type="hidden" name="action"/>
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'],$_GET['num'],'Dec654'); ?>
            <?php createSectionButton($_SESSION['role_id'],$_GET['num'],'App653'); ?>
        </div>
    </div>
</form>

<?php set_js(array('src/js/manage_voucher.js')); }?>