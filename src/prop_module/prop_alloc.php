<a href="#add_house_spec" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Attach</a>

<?php
            $prop->splash('prop_service_allocation');
            (isset($_SESSION['warnings'])) ? $prop->displayWarnings('warnings') : '';

            if(isset($_SESSION['prop_service_allocation'])){
                echo $_SESSION['prop_service_allocation'];
                unset($_SESSION['prop_service_allocation']);
            }
            ?>

            <table class="live_table table table-bordered">
                <thead>
                <tr>
                    <th>#Id</th>
                    <th>Attribute</th>
                    <th>Value</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (isset($_GET['prop_id'])) {
                $data = $prop->getAllocDetails($_GET['prop_id']);
                if (count($data)) {
//                    var_dump($data);die;
                    foreach ($data as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row['unit_alloc_id'] ?></td>
                            <td><?php echo $prop->getAttrNameByID($row['prop_attr_id']); ?></td>
                            <td><?php echo $row['value']; ?></td>
                            <td><a href="#edit_house_spec" class="btn btn-mini btn-success edit_spec_btn" data-toggle="modal" edit-id="<?php echo $row['unit_alloc_id']; ?>" id=""><i class="icon-edit"></i> Edit</a></td>
                            <td><a href="#delete_house_spec" class="btn btn-mini btn-danger del_spec_btn" data-toggle="modal" delete-id="<?php echo $row['unit_alloc_id']; ?>" id=""><i class="icon-remove icon-white"></i> Detach</a></td>
                        </tr>
                    <?php
                } } }?>
                </tbody>
            </table>
            <div class="clearfix"></div>
    <!--  add allocation modals -->
    <form action="" method="post" class="form-horizontal">
        <div id="add_house_spec" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
             aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Attach  a property attribute</h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <select class="span12 live_search" name="attribute_id" required="required">
                        <option value="">--Select Specifications--</option>
                        <?php
                        $data = $prop->listAllAttributes();

                        if(count($data)){
                            foreach($data as $row){
                                //if(!$data = $house->checkIfHouseAttributeisAttached($_GET['hos_id'],$row['attribute_id'])){
                                    ?>
                                    <option value="<?=$row['prop_attr_id']; ?>"><?=$row['prop_attr_name']; ?></option>
                                <?php }}?>

                    </select>
                </div>
                <div class="row-fluid">
                    <label for="attribute_value">Spec Value:</label>
                    <input type="text" name="attribute_value"  class="span12" required>
                </div>
                <input type="hidden" name="prop_id" value="<?php if (isset($_GET['prop_id'])) {
                    echo $id = $_GET['prop_id'];}?>"/>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="attch_prop_attr"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo745'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav744'); ?>
            </div>
        </div>
    </form>

    <!-- edit modal -->
    <form action="" method="post" class="form-horizontal">
        <div id="edit_house_spec" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Edit Property Attribute</h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <label for="attribute_value">Spec Value:</label>
                    <input type="text" name="attribute_value" id="attribute_value" value="" class="span12" required>
                </div>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="edit_house_prop_attr"/>
            <input type="hidden" id="edit_id" name="edit_id"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo747'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav746'); ?>
            </div>
        </div>
    </form>

    <!-- detech modal -->
    <form action=""  method="post">
        <div id="delete_house_spec" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Detach property attribute</h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to Detach the Selected Attribute?</p>
            </div>
            <input type="hidden" name="action" value="delete_prop_attr"/>
            <input type="hidden" id="delete_id" name="delete_id"/>
            <div class="modal-footer">
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No749'); ?>
                <?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes748'); ?>
            </div>
        </div>
    </form>
    <? set_js(array('src/js/house_specifications.js')); ?>
