<div class="widget">
<div class="widget-title"><h4>ADD COUNTY</h4></div>
 <div class="widget-body form">
<forrm action="" method="post"  class="form-horizontal">
                                                
<div class="row-fluid">
      <div class="span12">
          <div class="control-group">
              <label for="county_name" class="control-label">County Name:</label>
              <div class="controls">
                <input type="text" name="county_name"  required>
              </div>
          </div>
      </div>
      <!-- <div class="span6">
              <label class="control-label">County Logo:</label>
                    <div class="controls">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style="width: 100px; height: 100px;"><img src="assets/img/profile/photo.jpg" /></div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100px; max-height: 100px; line-height: 20px;"></div>
                            <div>
                                <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" name="logo"/></span>
                                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                            </div>
                    </div> 
                    </div> 
        </div> -->  
  </div>

<input type="hidden" name="action" id="action" value="addcounty" class="packinput">
    <div class="form-actions">
        <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
    </div>
</forrm> 
</div>
</div>          