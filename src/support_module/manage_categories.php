<?php
include_once('src/models/SupportTickets.php');
$Support = new SupportTickets;
    set_layout("dt-layout.php", array(
        'pageSubTitle' => 'Manage Voucher Categories',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array (
            array ( 'url'=>'index.php', 'text'=>'Home' ),
            array ( 'text'=>'Maintenance Tickets' ),
            array ( 'text'=>'Manage Voucher Categories' )
        )
    ));
?>
<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> Manage Voucher Categories</h4>
		<span class="actions">
			<a href="#add_category" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Add</a>
			<a href="#edit_category" class="btn btn-small btn-success" id="edit_category_btn"><i class="icon-edit"></i> Edit</a>
			<a href="#delete_category" class="btn btn-small btn-danger" id="del_category_btn"><i class="icon-remove icon-white"></i> Delete</a>
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
                <th>Category Name</th>
                <th>Category Code</th>
            </tr>
            </thead>
            <tbody>
                <?php
                $result = $Support->getVoucherCategories();
                while($rows = get_row_data($result)){
                ?>
                <tr>
                    <td><?php echo $rows['category_id']; ?></td>
                    <td><?php echo $rows['category_name']; ?></td>
                    <td><?php echo $rows['category_code']; ?></td>
                </tr>
            <?php }?>
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
            <h3 id="myModalLabel1">Add Voucher Category</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <label for="category_name">Category Name:</label>
                <input type="text" name="category_name" value="" class="span12" required>
            </div>

            <div class="row-fluid">
                <label for="category_code">Category Code:</label>
                <input type="text" name="category_code" value="" class="span12" required>
            </div>
        </div>
        <!-- the hidden fields -->
        <input type="hidden" name="action" value="add_category"/>
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo644'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav645'); ?>
        </div>
    </div>
</form>
<!-- edit modal -->
<form action="" method="post">
    <div id="edit_category" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Edit Voucher Category</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <label for="category_name">Category Name:</label>
                <input type="text" name="category_name" id="category_name" value="" class="span12" required>
            </div>

            <div class="row-fluid">
                <label for="category_code">Category Code:</label>
                <input type="text" name="category_code" id="category_code" value="" class="span12" required>
            </div>
        </div>
        <!-- the hidden fields -->
        <input type="hidden" name="action" value="edit_category"/>
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
            <p>Are you sure you want to delete the Voucher Category?</p>
        </div>
        <!-- hidden fields -->
        <input type="hidden" name="action" value="delete_category"/>
        <input type="hidden" id="delete_id" name="delete_id"/>
        <div class="modal-footer">
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No648'); ?>
            <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes647'); ?>
        </div>
    </div>
</form>
<?php set_js(array('src/js/manage_category.js')); ?>

