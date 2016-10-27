<form name="form1" method="post" action="" class="form-horizontal">
    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label for="address_type_name" class="control-label">Address Type Name:<span class="required"></span></label>
                <div class="controls">
                    <input type="text" name="address_type_name" autocomplete="off" required/>
                </div>
            </div> 
        </div>
          
    </div>

    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label for="status" class="control-label">Status:<span class="required">*</span></label>
                <div class="controls">
                    <select name="status" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="action" id="action" value="add_address_type">
    <div class="form-actions">
        <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
    </div>
</form>
