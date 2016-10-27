<div class="row-fluid">
    <div class="span8">
        <div class="control-group">
            <label for="group_name" class="control-label">Plot:</label>
            <div class="controls">
                <select name="plot" class="span12" required="required">
                    <option value="">--Select plot--</option>
                    <?php
                    $plots = $House->getAllProperties();
                    if(count($plots)){
                        foreach ($plots as $plot) {
                            ?>
                            <option value="<?php echo $plot['plot_id']; ?>"><?php echo $plot['plot_name']; ?></option>
                        <?php }} ?>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span8">
        <div class="control-group">
            <label for="group_name" class="control-label">Unit Number:</label>
            <div class="controls">
                <input type="text" name="house_number" value="" class="span12" required>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span8">
        <div class="control-group">
            <label for="group_name" class="control-label">Rent Amount:</label>
            <div class="controls">
                <input type="number" name="rent_amount" value="" class="span12" required>
            </div>
        </div>
    </div>
</div>
<!--				hidden fields-->
<input type="hidden" name="action" value="add_house"/>
<input type="hidden" name="created_by" value="<?php echo $_SESSION['mf_id'];?>"/>