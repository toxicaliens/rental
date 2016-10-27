<?php
require_once 'src/models/Accounts.php';
$acc = new Accounts();

if(App::isAjaxRequest()) {
    $acc->getBankByBankId($_POST['edit_id']);
}else{
    set_title('Add Bank');
    /**
     * Set the page layout that will be used
     */
    set_layout("dt-layout.php", array(
        'pageSubTitle' => 'Bank Details',
        'pageSubTitleText' => 'Allows one to manage banks',
        'pageBreadcrumbs' => array(
            array('url' => 'index.php', 'text' => 'Home'),
            array('text' => 'ACCOUNTS'),
            array('text' => 'Add Bank')
        ),
        'pageWidgetTitle' => 'Bank Details'
    ));
    // additional files
    set_css(array(
        'src/js/datetime_picker/jquery.datetimepicker.css',
        'src/css/bootstrap-datepicker.min.css'
    ));
    set_js(array(
        'src/js/bootstrap-datepicker.min.js',
        'src/js/datetime_picker/jquery.datetimepicker.js'
    ));
    
?>
    <div class="widget">
        <div class="widget-title"><h4><i class="icon-reorder"></i> Bank Details</h4>
		<span class="actions">
			<a href="#add_bank" class="btn btn-small btn-primary" data-toggle="modal"><i class="icon-plus"></i> Add Bank</a>
		</span>
        </div>
        <div class="widget-body">
            <?php
            $acc->splash('acc');
            (isset($_SESSION['warnings'])) ? $acc->displayWarnings('warnings') : '';
            ?>
            <table id="table1" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Bank#</th>
                        <th>Bank Name</th>
                        <th>Status</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $rows = $acc->getAllBank();
                $rows = $rows['all'];

                if(count($rows)){
                    foreach ($rows as $row){;
                        ?>
                        <tr>
                            <td><?php echo $row['bank_id']; ?></td>
                            <td><?php echo $row['bank_name']; ?></td>
                            <td><?php echo ($row['status'] == 't') ? 'Active': 'Inactive'; ?></td>
                            <td><a href="#update_bank" class="btn btn-mini btn-warning edit_bank" edit-id="<?php echo $row['bank_id']; ?>" data-toggle="modal"><i class="icon-edit"></i> Edit</a> </td>
                            <td><a href="#del_bank" class="btn btn-mini btn-danger del_bank" edit-id="<?php echo $row['bank_id']; ?>" data-toggle="modal"><i class="icon-trash"></i> Delete</a></td>
                        </tr>
                    <?php }} ?>
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>

    <!-- The Modals -->
    <form action="" method="post">
        <div id="add_bank" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Add Bank Details </h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <label for="bank_name">Name:</label>
                    <input type="text" name="bank_name" class="span12" value="<?php echo $acc->get('bank_name'); ?>"/>
                </div>

                <div class="row-fluid">
                    <label for="created_at">Date:</label>
                    <input type="text" name="created_at" class="span12" id="datetimepicker2" value="<?php echo $acc->get('created_at'); ?>"/>
                </div>

                <div class="row-fluid">
                    <label for="status">Status:</label>
                    <select name="status" class="span12">
                        <option value="">--Choose Status--</option>
                        <option value="1"<?php if(isset($_POST['status']) && $_POST['status'] == 1) echo 'selected'; ?>>Active</option>
                        <option value="0"<?php if(isset($_POST['status']) && $_POST['status'] == 0) echo 'selected'; ?>>Inactive</option>
                    </select>
                </div>

            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="add_bank"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo674'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav675'); ?>
            </div>
        </div>
    </form>

    <form action="" method="post">
        <div id="update_bank" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Update Bank Details </h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <label for="bank_name">Name:</label>
                    <input type="text" name="bank_name" id="bank_name" class="span12" value="<?php echo $acc->get('bank_name'); ?>"/>
                </div>

                <div class="row-fluid">
                    <label for="created_at">Date Created:</label>
                    <input type="date" name="created_at" id="datetimepicker22" class="span12 created_at" value="<?php echo $acc->get('created_at'); ?>"/>
                </div>

                <div class="row-fluid">
                    <label for="status">Status:</label>
                    <select name="status" class="span12" id="status">
                        <option value="">--Choose Status--</option>
                        <option value="1"<?php if(isset($_POST['status']) && $_POST['status'] == 1) echo 'selected'; ?>>Active</option>
                        <option value="0"<?php if(isset($_POST['status']) && $_POST['status'] == 0) echo 'selected'; ?>>Inactive</option>
                    </select>
                </div>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="edit_bank"/>
            <input type="hidden" name="edit_id" id="edit_id"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can676'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav677'); ?>
            </div>
        </div>
    </form>

    <form action="" method="post">
        <div id="del_bank" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Delete Bank Details </h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the selected bank?</p>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="delete_bank"/>
            <input type="hidden" name="delete_id" id="delete_id"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No678'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes679'); ?>
            </div>
        </div>
    </form>
    <?php set_js(array('src/js/bank.js')); } ?>