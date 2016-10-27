<div class="widget">
<div class="widget-title"><h4>ADD SUBCOUNTY</h4></div>
 <div class="widget-body form">
<forrm action="" method="post"  class="form-horizontal">
	                                          	
<div class="row-fluid">
      <div class="span6">
          <div class="control-group">
              <label for="sub_county_name" class="control-label">Sub County Name:</label>
              <div class="controls">
              	<input type="text" name="sub_county_name"  required>
              </div>
          </div>
      </div>
      <div class="span6">
          <div class="control-group">
              <label for="county_ref_id" class="control-label">County Name:</label>
              <div class="controls">
                 <select name="county_ref_id" id="county_ref_id" required>
                    <option value="">--Select County--</option>
                    <?php
                    $county_ref_id=run_query("SELECT * from county_ref Order by  county_name");
                               while ($fetch=get_row_data($county_ref_id))
                               {
                               echo "<option value='".$fetch['county_ref_id']."'>".$fetch['county_name']."</option>";
                               }
                               ?>
                </select>
              </div>
          </div>
      </div>
  </div>

<input type="hidden" name="action" id="action" value="addsubcounty" class="packinput">
    <div class="form-actions">
        <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
    </div>
</forrm> 
</div>
</div>          