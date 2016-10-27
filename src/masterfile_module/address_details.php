<!-- BEGIN FORM -->
<form name="form1" method="post" action="">
    <div class="row-fluid">
      <div class="span6">
        <div class="control-group">
          <label for="county" class="control-label">County:<span>*</span></label>
          <div class="controls">
            <select name="county" class="span12" id="select2_sample79" >
              <option value="">--Choose County--</option>
              <?php
                $query = "SELECT * From county_ref ORDER BY county_name ASC";
                $options = run_query($query);
                while($row = get_row_data($options)){
              ?>
              <option value="<?=$row['county_ref_id']; ?>" <?php echo ($mf->get('county') == $row['county_ref_id']) ? 'selected': ''; ?>><?=$row['county_name']; ?></option>

              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="span6">
        <div class="control-group">
          <label for="town" class="control-label">Town/city:<span>*</span></label>
          <div class="controls">
            <input type="text" name="town" id="town" class="span12" maxlength="30" value="<?php echo $mf->get('town'); ?>" >
          </div>
        </div>
      </div>
    </div>

    <div class="row-fluid">
      <div class="span6">
        <div class="control-group">
          <label for="ward" class="control-label">Ward</label>
          <div class="controls">
              <input type="text" name="ward" class="span12" maxlength="30" value="<?php echo $mf->get('ward'); ?>" >
          </div>
        </div>
      </div>
      <div class="span6">
        <div class="control-group">
          <label for="street" class="control-label">Street:</label>
          <div class="controls">
              <input type="text" name="street" class="span12" maxlength="30" value="<?php echo $mf->get('street'); ?>" >
          </div>
        </div>
      </div>
    </div>

    <div class="row-fluid">
      <div class="span6">
        <div class="control-group">
          <label for="building" class="control-label">Building:</label>
          <div class="controls">
            <input type="text" name="building" class="span12" maxlength="30" value="<?php echo $mf->get('building'); ?>" >
          </div>
        </div>
      </div>
      <div class="span6">
        <div class="control-group">
          <label for="phone_number" class="control-label">Phone Number:<span>*</span></label>
          <div class="controls">
            <input type="number" name="phone_number" class="span12" maxlength="10" id="phone" value="<?php echo $mf->get('phone_number'); ?>" />
          </div>
        </div>
      </div>
    </div>

    <div class="row-fluid">
      <div class="span6">
        <div class="control-group">
          <label for="postal_address" class="control-label">P.O Box:<span>*</span></label>
          <div class="controls">
            <input type="text" name="postal_address" class="span12" maxlength="6" id="box" value="<?php echo $mf->get('postal_address'); ?>" />
          </div>
        </div>
      </div>
      <div class="span6">
        <div class="control-group">
          <label for="postal_code" class="control-label">Postal code:<span>*</span></label>
          <div class="controls">
            <input type="text" name="postal_code" class="span12" maxlength="6" id="postal_code" value="<?php echo $mf->get('postal_code'); ?>" />
          </div>
        </div>
      </div>
    </div>

    <div class="row-fluid">

      <div class="span6">
        <div class="control-group">
          <label for="address_type_id" class="control-label">Address Type:<span>*</span></label>
          <div class="controls">
            <select name="address_type_id" id="address_type_id" class="span12">
              <option value="">--Choose Address type--</option>
              <?php
                $query = run_query("SELECT * FROM address_types ORDER BY address_type_name");
                  if ( $query !== false )
                    {
                      while ( $fetch = get_row_data($query) )
                            {
                    ?>
                    <option value="<?=$fetch['address_type_id']; ?>" <?php echo ($fetch['address_type_id'] == $mf->get('address_type_id')) ? 'selected': ''; ?>><?=$fetch['address_type_name']; ?></option>
                    <?php } }
                    ?>
            </select>
          </div>
        </div>
      </div>
    </div>
</form>
<!-- END FORM -->