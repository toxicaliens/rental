<?php
/**
 * Created by PhpStorm.
 * User: JOEL
 * Date: 7/13/2016
 * Time: 11:57 AM
 */
    include_once ('src/models/Masterfile.php');
    $mf = new Masterfile();

    set_title('Manage Address');

	if(isset($_GET['mf_id'])){
        $mf_id = $_GET['mf_id'];
        $query = "SELECT a.*, c.county FROM address a
		LEFT JOIN county_ref c ON c.mf_id=a.mf_id
		WHERE a.mf_id = '".$mf_id."' ";
    }

    // display all encountered errors
    $mf->splash('mf');
    (isset($_SESSION['mf_warnings'])) ? $mf->displayWarnings('mf_warnings') : '';

?>

    <!-- delete shd not have data toggle -->
    <a href="#add_address" data-toggle="modal" class="btn btn-small btn-primary tooltips m-wrap" data-trigger="hover" data-original-title="Add New Address"><i class="icon-plus"></i></a>&nbsp;
    <a href="#edit_address" id="edit_btn" class="btn btn-small btn-warning tooltips m-wrap" data-trigger="hover" data-original-title="Edit Address"><i class="icon-edit"></i></a>&nbsp;
    <a href="#delete_address" id="del_btn" class="btn btn-small btn-danger tooltips m-wrap" data-trigger="hover" data-original-title="Delete Address"><i class="icon-trash"></i></a>

    <table id="table1" class="live_table table table-bordered">
        <thead>
        <tr>
            <th>Address#</th>
            <th>Postal Address</th>
            <th>County</th>
            <th>Town</th>
            <th>Ward</th>
            <th>Street</th>
            <th>Building</th>
            <th>House No.</th>
            <th>Type</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $result = $mf->getCustomerAddresses($_GET['mf_id']);
        while ($rows = get_row_data($result)) {
            ?>
            <tr>
                <td><?php echo $rows['address_id']; ?></td>
                <td><?php echo $rows['postal_address']; ?></td>
                <td><?php echo $rows['county_name']; ?></td>
                <td><?php echo $rows['town']; ?></td>
                <td><?php echo $rows['ward']; ?></td>
                <td><?php echo $rows['street']; ?></td>
                <td><?php echo $rows['building']; ?></td>
                <td><?php echo $rows['house_no']; ?></td>
                <td><?php echo $rows['address_type_name']; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <!-- begin add address modal -->
    <form action="" method="post">
        <div id="add_address" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Add New Address</h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <input type="hidden" name="mf_id" value="<?=$_GET['mf_id']; ?>" class="span12" required>
                </div>
                <div class="control-group">
                    <label for="county" class="control-label">County:</label>
                    <div class="controls">
                        <select name="county" class="span12 live_search" required>
                            <option value="">--Select County--</option>
                            <?php
                            $counties = $mf->getAllCounties();
                            $counties = $counties['all'];
                            if(count($counties)){
                                foreach ($counties as $county){
                                    ?>
                                    <option value="<?php echo $county['county_ref_id']; ?>">
                                        <?php echo $county['county_name']; ?>
                                    </option>
                                <?php }} ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label for="town" class="control-label">Town:</label>
                    <div class="controls">
                        <input type="text" name="town" value="<?php echo $mf->get('town');?>" class="span12" required>
                    </div>
                </div>

                <div class="control-group">
                    <label for="address_type_id" class="control-label">Address Type:</label>
                    <div class="controls">
                        <select name="address_type_id" class="span12 live_search" required>
                            <option value="">--Choose Address type--</option>
                            <?php
                            $query = "SELECT * From address_types ORDER BY address_type_name ASC";
                            $options = run_query($query);
                            while($row = get_row_data($options)){
                                $address_type_id = $rows['address_type_id'];
                                $address_type_name = $rows['address_type_name'];
                                ?>
                                <option value="<?=$row['address_type_id']; ?>" <?=($row['address_type_id'] == $address_type_name) ? 'selected' : ''; ?> ><?=$row['address_type_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label for="postal_address" class="control-label">Postal Address:</label>
                    <div class="controls">
                        <input type="text" name="postal_address" value="<?php echo $mf->get('postal_address');?>" class="span12" required>
                    </div>
                </div>

                <div class="control-group">
                    <label for="postal_code" class="control-label">Postal Code:</label>
                    <div class="controls">
                        <input type="number" name="postal_code" value="<?php echo $mf->get('postal_code');?>" class="span12" required>
                    </div>
                </div>

                <div class="control-group">
                    <label for="ward" class="control-label">Ward:</label>
                    <div class="controls">
                        <input type="text" name="ward" value="<?php echo $mf->get('ward');?>" class="span12">
                    </div>
                </div>

                <div class="control-group">
                    <label for="street" class="control-label">Street:</label>
                    <div class="controls">
                        <input type="text" name="street" value="<?php echo $mf->get('street');?>" class="span12">
                    </div>
                </div>

                <div class="control-group">
                    <label for="building" class="control-label">Building:</label>
                    <div class="controls">
                        <input type="text" name="building" value="<?php echo $mf->get('building');?>" class="span12">
                    </div>
                </div>

                <div class="control-group">
                    <label for="house_no" class="control-label">House No:</label>
                    <div class="controls">
                        <input type="text" name="house_no" value="<?php echo $mf->get('house_no');?>" class="span12">
                    </div>
                </div>

                <div class="control-group">
                    <label for="phone" class="control-label">Phone No:</label>
                    <div class="controls">
                        <input type="integer" name="phone" value="<?php echo $mf->get('phone');?>" class="span12" required>
                    </div>
                </div>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="add_customer_address"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo700'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav701'); ?>
            </div>
        </div>
    </form>
    <!-- end add address modal -->

    <!-- begin of edit modal -->
    <form action="" method="post">
        <div id="edit_address" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Edit Address</h3>
            </div>
            <div class="modal-body">
                <div class="control-group">
                    <label for="county" class="control-label">County:</label>
                    <div class="controls">
                        <select name="county_ref_id" class="span12 live_search" id="county_ref_id" required>
                            <?php
                            $counties = $mf->getAllCounties();
                            $counties = $counties['all'];
                            if(count($counties)){
                                foreach ($counties as $county){
                                    ?>
                                    <option value="<?php echo $county['county_ref_id']; ?>"
                                        <?php echo ($county['county_ref_id'] == $county['county_ref_id']) ? 'selected': ''; ?>>
                                        <?php echo $county['county_name']; ?>
                                    </option>
                                <?php }} ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label for="address_type_id" class="control-label">Address Type:</label>
                    <div class="controls">
                        <select name="address_type_id" class="span12 live_search" id="address_type_id" required>
                            <?php
                            $addresses = $mf->getAllAddressType();
                            $addresses = $addresses['all'];
                            if(count($addresses)){
                                foreach ($addresses as $address){
                                    ?>
                                    <option value="<?php echo $address['address_type_id']; ?>"
                                        <?php echo ($address['address_type_id'] == $address['address_type_id']) ? 'selected': ''; ?>>
                                        <?php echo $address['address_type_name']; ?></option>
                                <?php }} ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label for="town" class="control-label">Town:</label>
                    <div class="controls">
                        <input type="text" name="town" id="town" value="<?php echo $mf->get('town');?>" class="span12" required>
                    </div>
                </div>

                <div class="control-group">
                    <label for="postal_address" class="control-label">Postal Address:</label>
                    <div class="controls">
                        <input type="text" name="postal_address" id="postal_address" value="" class="span12" required>
                    </div>
                </div>

                <div class="control-group">
                    <label for="postal_code" class="control-label">Postal Code:</label>
                    <div class="controls">
                        <input type="number" name="postal_code" id="postal_code" value="<?php echo $mf->get('postal_code');?>" class="span12" required>
                    </div>
                </div>

                <div class="control-group">
                    <label for="ward" class="control-label">Ward:</label>
                    <div class="controls">
                        <input type="text" name="ward" id="ward" value="<?php echo $mf->get('ward');?>" class="span12">
                    </div>
                </div>

                <div class="control-group">
                    <label for="street" class="control-label">Street:</label>
                    <div class="controls">
                        <input type="text" name="street" id="street" value="<?php echo $mf->get('street');?>" class="span12">
                    </div>
                </div>

                <div class="control-group">
                    <label for="building" class="control-label">Building:</label>
                    <div class="controls">
                        <input type="text" name="building" id="building" value="<?php echo $mf->get('building');?>" class="span12">
                    </div>
                </div>

                <div class="control-group">
                    <label for="house_no" class="control-label">House No:</label>
                    <div class="controls">
                        <input type="text" name="house_no" id="house_no" value="<?php echo $mf->get('house_no');?>" class="span12">
                    </div>
                </div>

                <div class="control-group">
                    <label for="phone" class="control-label">Phone No:</label>
                    <div class="controls">
                        <input type="integer" name="phone" id="phone" value="<?php echo $mf->get('phone');?>" class="span12" required>
                    </div>
                </div>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="edit_customer_address"/>
            <input type="hidden" id="edit_id" name="address_id"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can702'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav703'); ?>
            </div>
        </div>
    </form>
    <!-- end of edit modal -->

    <!-- delete modal -->
    <form action=""  method="post">
        <div id="delete_address" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Delete Address</h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the address (<span id="postal_addr"></span>)?</p>
            </div>

            <input type="hidden" name="action" value="delete_customer_address"/>
            <input type="hidden" id="delete_id" name="delete_id"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No704'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes705'); ?>
            </div>
        </div>
    </form>
    <!-- end of delete modal -->

    <!-- js script -->
<?php set_js(array('src/js/manage_address.js')); ?>