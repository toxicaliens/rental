<div class="row-fluid">
    <?php if($_SESSION['role_name'] == LandLord){ ?>
        <div class="span6">
            <div class="control-group">
                <label for="property_manager" class="control-label">Property Manager:</label>
                <div class="controls">
                    <select name="property_manager" id="property_manager" class="span12 live_search">
                        <option value="">--Choose Property Manager--</option>
                        <?php
                        $pms = $prop->getAllMyPm();
                        if(count($pms)){
                            foreach ($pms as $pm){
                                ?>
                                <option value="<?php echo $pm['mf_id']; ?>"
                                    <?php echo ($pm['mf_id'] == $prop->get('property_manager')) ? 'selected' : ''; ?>>
                                    <?php echo $pm['full_name']; ?></option>
                            <?php }} ?>
                    </select>
                </div>
            </div>
        </div>
    <?php } else if($_SESSION['role_name'] == PM){ ?>
        <div class="span6">
            <div class="control-group">
                <label for="landlord" class="control-label">Landlord:</label>
                <div class="controls">
                    <select name="landlord" id="landlord" class="span12 live_search">
                        <option value="">--Choose Landlord--</option>
                        <?php
                        $landlord = $prop->getAllMyLandlords();
                        if(count($landlord)){
                            foreach ($landlord as $landy){
                                ?>
                                <option value="<?php echo $landy['mf_id']; ?>"
                                    <?php echo ($landy['mf_id'] == $prop->get('landlord')) ? 'selected' : ''; ?>>
                                    <?php echo $landy['full_name']; ?>
                                </option>
                            <?php }} ?>
                    </select>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label for="plot_name" class="control-label">Property Name: <span>*</span></label>
            <div class="controls">
                <input type="text" name="plot_name" id="name" class="span12" />
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <label for="property_type" class="control-label">Property Category:<span>*</span></label>
            <div class="controls">
                <select name="property_type" id="property_type" class="span12 live_search">
                    <option id="property_typ" value="">--Choose a property Category--</option>
                    <?php
                    $data = $prop->getPlotType();
                    if(count($data)){
                        foreach ($data as $dat){
                            ?><option value="<?php echo $dat['plot_type_id']; ?>"><?php echo $dat['plot_type_name'];?></option>
                        <?php }} ?>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label for="option_type" class="control-label">Property Type:<span>*</span></label>
            <div class="controls">
                <select name="option_type" id="option_type" class="span12 live_search" disabled>
                </select>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <label for="units" class="control-label">Units/Houses:</label>
            <div class="controls">
                <input type="number" min="1" id="units" name="units" class="span12" >
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span6">
        <label for="property-code" class="control-label">Property Code</label>
        <div class="controls">
            <input type="text" name="property_code" class="span12" value="<?php echo $prop->get('property_code') ?>" id="property-code">
        </div>
    </div>
</div>
