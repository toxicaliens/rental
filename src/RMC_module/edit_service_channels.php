<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
      <div class="row-fluid">
         <div class="span6">
            <div class="control-group">
               <label for="revenue_channel_id" class="control-label">Revenue channel name:<span class="required"></span></label>
               <div class="controls">
                <select id="select2_sample80" class="span12 select2" name="revenue_channel_id" readonly >
                    <?=get_select_with_selected('revenue_channel','revenue_channel_id','revenue_channel_name',$revenue_channel_id)?>
                  </select>
               </div>
            </div>
         </div>
         <div class="span6">
            <div class="control-group">
               <label for="service_option" class="control-label">Service Option:<span class="required"></span></label>
               <div class="controls">
                  <input type="text"  name="service_option" value="<?=$service_option; ?>" class="span12" required />
               </div>
            </div>
          </div>
      </div>
      
      <div class="row-fluid">
         <div class="span6">
            <div class="control-group">
               <label for="service_option_type" class="control-label">Service Option Type:<span class="required"></span></label>
               <div class="controls">
                  <select name="service_option_type" id="service_option_type" class="span12" required>
                    <option value="Branch" <?=$choice2; ?>>Branch</option>
                     <option value="Leaf" <?=$choice1; ?>>Leaf</option>
                     <option value="Root" <?=$choice3; ?>>Root</option>
                  </select>
               </div>
            </div>
         </div>   
         <div class="span6">
            <div class="control-group">
               <label for="option_code" class="control-label">Option Code:<span class="required"></span></label>
               <div class="controls">
                 <input type="text"  name="option_code" value="<?=$option_code; ?>" class="span12" required />
               </div>
            </div>
         </div>
        </div>
         
   <div class="row-fluid">
      <div class="span6">
        <div class="control-group">
           <label for="parent_id" class="control-label">Parent Id:</label>
           <div class="controls">
              <select name="parent_id" class="span12">
                <option value="0">No Parent</option>
                <?=get_select_with_selected('service_channels','service_channel_id','service_option',$parent_id)?>
              </select>
           </div>
        </div>
      </div>
      <div class="span6">
        <div class="control-group">
           <label for="request_type_id" class="control-label">Request Type:<span class="required"></span></label>
           <div class="controls">
              <select name="request_type_id" class="span12" required>
                <?=get_select_with_selected('request_types','request_type_id','request_type_name',$request_type_id)?>
              </select>
           </div>
        </div>
      </div>   
   </div>

    <div class="row-fluid">
      <div class="span6">
            <div class="control-group">
               <label for="price" class="control-label">Price:<span class="required"></span></label>
               <div class="controls">
                  <input type="number" id="price" name="price" value="<?=$price; ?>" class="span12" />
               </div>
            </div>
      </div>
      <div class="span6">
        <div class="control-group">
           <label for="price" class="control-label">Status:</label>
           <div class="controls">
              <select name="status" class="span12">
                <option <?if($status=='t'){?>selected="selected"<?}?> value="1">Active</option>
                <option <?if($status=='f'){?>selected="selected"<?}?> value="0">Inactive</option>
              </select>
           </div>
        </div>
      </div>
   </div>

   <div class="form-actions">
      <input type="hidden" name="action" value="edit_setup_channels"/>
      <input type="hidden" name="service_channel_id" value="<?=$service_channel_id; ?>"/>
      <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
   </div>
</form>