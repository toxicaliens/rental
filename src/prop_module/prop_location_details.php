
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label for="county" class="control-label">County*:</label>
            <div class="controls">
                <select name="county" class="span12 select2" selected ="<?php echo $prop->get('county'); ?>">
                    <option value="">--Select county--</option>
                    <?php
                    $counties = $prop->selectQuery('county_ref','county_ref_id,county_name');
                    if(count($counties)){
                        foreach($counties as $county){
                            ?>
                        <option value="<?php echo $county['county_ref_id']?>"><?php echo $county['county_name']?></option>
                            <?php
                        }
                    }
                    ?>
                </select>

            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <label for="town" class="control-label">Region*:</label>
            <div class="controls">
                <input type="text" name="region" id="t-c" class="span12" value="<?php echo $prop->get('region'); ?>"/>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label for="town" class="control-label">Town/City*:</label>
            <div class="controls">
                <input type="text" name="town_city" id="t-c" class="span12" value="<?php echo $prop->get('town_city'); ?>"/>
            </div>
        </div>
    </div>

    <div class="span6">
        <div class="control-group">
            <label for="location" class="control-label">Street:</label>
            <div class="controls">
                <input type="text" name="street" id="street" class="span12" value="<?php echo $prop->get('street'); ?>"/>
            </div>
      </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label for="building-number" class="control-label">Building Number</label>
            <div class="controls">
                <input type="text" name="building_number" class="span12">
            </div>
        </div>
    </div>

    <div class="span6">
        <div class="control-group">
            <label for="lr_no" class="control-label">Land Reg. No*:</label>
            <div class="controls">
                <input type="text" name="lr_no" id="lr_no" class="span12" value="<?php echo $prop->get('lr_no'); ?>"/>
            </div>
        </div>

    </div>

</div>
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label for="longitude" class="control-label">Longitude</label>
            <div class="controls">
                <input type="text" name="longitude" class="span12" >
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <label for="longitude" class="control-label">Latitude</label>
            <div class="controls">
                <input type="text" name="latitude" class="span12" >
            </div>
        </div>
    </div>
</div>
