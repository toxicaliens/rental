<?php
    require_once 'src/models/Accounts.php';
    $acc = new Accounts();

    require_once 'src/models/Masterfile.php';
    $mf = new Masterfile();

    if(App::isAjaxRequest()) {
        $acc->getBranchByBranchId($_POST['edit_id']);
    }else{
        set_title('Add Bank Branch');
        /**
         * Set the page layout that will be used
         */
        set_layout("dt-layout.php", array(
            'pageSubTitle' => 'Bank Branches',
            'pageSubTitleText' => 'Allows one to manage bank branches',
            'pageBreadcrumbs' => array(
                array('url' => 'index.php', 'text' => 'Home'),
                array('text' => 'ACCOUNTS'),
                array('text' => 'Add Branch')
            ),
            'pageWidgetTitle' => 'Branch Details'
        ));

?>
    <div class="widget">
        <div class="widget-title"><h4><i class="icon-reorder"></i> Bank Branches</h4>
		<span class="actions">
			<a href="#add_branch" class="btn btn-small btn-primary" data-toggle="modal"><i class="icon-plus"></i> Add Branch</a>
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
                        <th>Branch#</th>
                        <th>Branch Name</th>
                        <th>Branch Code</th>
                        <th>Status</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $rows = $acc->getAllBranches();
                $rows = $rows['all'];

                if(count($rows)){
                    foreach ($rows as $row){;
                ?>
                    <tr>
                        <td><?php echo $row['branch_id']; ?></td>
                        <td><?php echo $row['branch_name']; ?></td>
                        <td><?php echo $row['branch_code']; ?></td>
                        <td><?php echo ($row['status'] == 't') ? 'Active': 'Inactive'; ?></td>
                        <td><a href="#update_branch" class="btn btn-mini btn-warning edit_branch" edit-id="<?php echo $row['branch_id']; ?>" data-toggle="modal"><i class="icon-edit"></i> Edit</a> </td>
                        <td><a href="#del_branch" class="btn btn-mini btn-danger del_branch" edit-id="<?php echo $row['branch_id']; ?>" data-toggle="modal"><i class="icon-trash"></i> Delete</a></td>
                    </tr>
                    <?php }} ?>
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>

    <!-- The Modals -->
    <form action="" method="post">
        <div id="add_branch" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Add Bank Branch </h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <label for="bank_name">Bank:</label>
                    <select name="bank_id" class="span12 live_search" id="bank_name">
                        <option value="">--Choose Bank--</option>
                        <?php
                        $banks = $acc->getAllBank();
                        $banks = $banks['all'];
                        if(count($banks)){
                            foreach ($banks as $bank){
                                ?>
                                <option value="<?php echo $bank['bank_id']; ?>" <?php echo ($mf->get('bank_name') == $bank['bank_id']) ? 'selected': ''; ?>><?php echo $bank['bank_name']; ?></option>
                            <?php }} ?>
                    </select>
                </div>
                
                <div class="row-fluid">
                    <label for="branch_name">Name:</label>
                    <input type="text" name="branch_name" class="span12" value="<?php echo $acc->get('branch_name'); ?>"/>
                </div>

                <div class="row-fluid">
                    <label for="branch_code">Branch Code:</label>
                    <input type="text" name="branch_code" class="span12" value="<?php echo $acc->get('branch_code'); ?>"/>
                </div>

                <div class="row-fluid">
                    <label for="created_at">Date:</label>
                    <input type="date" name="created_at" class="span12" value="<?php echo $acc->get('created_at'); ?>"/>
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
            <input type="hidden" name="action" value="add_branch"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo680'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav681'); ?>
            </div>
        </div>
    </form>

    <form action="" method="post">
        <div id="update_branch" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Update Branch </h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <label for="bank_id">Bank:</label>
                    <select name="bank_id" class="span12" id="bank_id">
                        <option value="">--Choose Bank--</option>
                        <?php
                        $banks = $acc->getAllBank();
                        $banks = $banks['all'];
                        if(count($banks)){
                            foreach ($banks as $bank){
                                ?>
                                <option value="<?php echo $bank['bank_id']; ?>"
                                    <?php echo ($mf->get('bank_name') == $bank['bank_id']) ? 'selected': ''; ?>>
                                    <?php echo $bank['bank_name']; ?>
                                </option>
                            <?php }} ?>
                    </select>
                </div>

                <div class="row-fluid">
                    <label for="branch_name">Branch Name:</label>
                    <input type="text" name="branch_name" id="branch_name" class="span12" value="<?php echo $acc->get('branch_name'); ?>"/>
                </div>
                <div class="row-fluid">
                    <label for="branch_code">Branch Code:</label>
                    <input type="text" name="branch_code" id="branch_code" class="span12" value="<?php echo $acc->get('branch_code'); ?>"/>
                </div>
                <div class="row-fluid">
                    <label for="created_at">Date Created:</label>
                    <input type="date" name="created_at" id="created_at" class="span12" value="<?php echo $acc->get('created_at'); ?>"/>
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
            <input type="hidden" name="action" value="edit_branch"/>
            <input type="hidden" name="edit_id" id="edit_id"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can682'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav683'); ?>
            </div>
        </div>
    </form>

    <form action="" method="post">
        <div id="del_branch" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Delete Branch </h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the selected branch?</p>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="delete_branch"/>
            <input type="hidden" name="delete_id" id="delete_id"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No684'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes685'); ?>
            </div>
        </div>
    </form>
    <?php set_js(array('src/js/branch.js')); } ?>