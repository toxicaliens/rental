<?php
include_once('src/models/SupportTickets.php');
$Support = new SupportTickets;
if(App::isAjaxRequest()){
    if(isset($_POST['action'])){
        switch ($_POST['action']){
            case'get-edit-ailments':
                if(!empty($_POST['edit_id'])){
                    $result = $Support->selectQuery('expense_bill_items','*',"expense_id = '".$_POST['edit_id']."'");
                    echo json_encode($result);
                }
        }
    }
}else{
set_layout("dt-layout.php", array(
    'pageSubTitle' => 'Manage Expense bill items',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'text'=>'Maintenance Tickets' ),
        array ( 'text'=>'Manage Expense bill items' )
    )
));
?>
<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> Manage Expense bill items</h4>
        <span class="actions">
			<a href="#add_category" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Add</a>
			<a href="#edit_category" class="btn btn-small btn-success" id="edit_expense_btn"><i class="icon-edit"></i> Edit</a>
			<a href="#delete_category" class="btn btn-small btn-danger"  id="del_expense_btn"><i class="icon-remove icon-white"></i> Delete</a>
		</span>
    </div>

    <div class="widget-body form">
        <?php
        $Support->splash('support');
        // display all encountered errors
        (isset($_SESSION['support_error'])) ? $Support->displayWarnings('support_error') : '';
        ?>
        <table id="table1" class="table table-bordered">
            <thead>
            <tr>
                <th>ID#</th>
                <th>Expense Name</th>
                <th>Expense Code</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $results = $Support->selectQuery('expense_bill_items','*'," created_by = '".$_SESSION['mf_id']."'");
            if(count($results)){
                foreach ($results as $result){
                ?>
                <tr>
                    <td><?php echo $result['expense_id']; ?></td>
                    <td><?php echo $result['expense_name']; ?></td>
                    <td><?php echo $result['code']; ?></td>
                </tr>
            <?php }}?>
            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
</div>

<!-- The Modals -->
<form action="" method="post">
    <div id="add_category" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Add Expense items</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <label for="category_name">Expense Name:</label>
                <input type="text" name="expense_name" autocomplete="off" value="" class="span12" required>
            </div>

            <div class="row-fluid">
                <label for="category_code">Expense Code:</label>
                <input type="text" name="code" autocomplete="off" value="" class="span12" required>
            </div>
        </div>
        <!-- the hidden fields -->
        <input type="hidden" name="action" value="add_expense"/>
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo768'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav767'); ?>
        </div>
    </div>
</form>
<!-- edit modal -->
<form action="" method="post">
    <div id="edit_category" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Edit Expense Category</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <label for="category_name">Expense Name:</label>
                <input type="text" name="expense_name" id="expense_name" value="" class="span12" required>
            </div>

            <div class="row-fluid">
                <label for="category_code">Expense Code:</label>
                <input type="text" name="code" id="expense_code" value="" class="span12" required>
            </div>
        </div>
        <!-- the hidden fields -->
        <input type="hidden" name="action" value="edit_expense_item"/>
        <input type="hidden" id="edit_id" name="edit_id"/>
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can646'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav645'); ?>
        </div>
    </div>
</form>
<!-- delete modal -->
<form action=""  method="post">
    <div id="delete_category" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Delete Voucher</h3>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete the Expense Category?</p>
        </div>
        <!-- hidden fields -->
        <input type="hidden" name="action" value="delete_expense_category"/>
        <input type="te" id="delete_id" name="delete_id"/>
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No648'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes647'); ?>
        </div>
    </div>
</form>
<?php set_js(array('src/js/expense_categories.js')); }?>

