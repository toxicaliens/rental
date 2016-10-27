<div class="widget">
<div class="widget-title"><h4>SETUP SERVICES</h4></div>
 <div class="widget-body form">
<!-- BEGIN FORM -->
   <forrm action="" method="post" enctype="multipart/form-data" class="form-horizontal">
      <div class="row-fluid">
         <div class="span6">
            <div class="control-group">
               <label for="revenue_channel_id" class="control-label">Revenue channel name:<span class="required"></span></label>
               <div class="controls">
                 <select name="revenue_channel_id" id="revenue_channel_id" required>
                     <option value="">Choose Revenue Name</option>
                     <?php
                $revenue_channel_id=run_query("SELECT * from revenue_channel Order by revenue_channel_name");
                while ($fetch=get_row_data($revenue_channel_id))
                {
                echo "<option value='".$fetch['revenue_channel_id']."'>".$fetch['revenue_channel_name']."</option>";
                }
                ?></select>
               </div>
            </div>
         </div>
         <div class="span6">
            <div class="control-group">
               <label for="service_option" class="control-label">Service Option Name:<span class="required"></span></label>
               <div class="controls">
                  <input type="text" name="service_option" required />
               </div>
            </div>
          </div>
      </div>
      
      <div class="row-fluid">
         <div class="span6">
            <div class="control-group">
               <label for="service_option_type" class="control-label">Service Option Type:<span class="required"></span></label>
               <div class="controls">
                  <select name="service_option_type" id="service_option_type" required>
                     <option value="">--Choose Option Type--</option>
                     <option value="Branch">Branch</option>
                     <option value="Leaf">Leaf</option>
                  </select>
               </div>
            </div>
         </div>   
         <div class="span6">
            <div class="control-group">
               <label for="option_code" class="control-label">Option Code:<span class="required"></span></label>
               <div class="controls">
                  <input type="text" name="option_code" required/>
               </div>
            </div>
         </div>
        </div>
         
   <div class="row-fluid">
         <div class="span6">
            <div class="control-group">
               <label for="parent_id" class="control-label">Parent Id:<span class="required"></span></label>
               <div class="controls">
                  <select name="parent_id" >
                     <option value="0">NO PARENT</option>
                    <?php
              $parent_id=run_query("SELECT * from service_channels where service_option_type ='Branch' Order by service_option");
                while ($fetch=get_row_data($parent_id))
                {
                echo "<option value='".$fetch['service_channel_id']."'>".$fetch['service_option']."</option>";
                }
                ?></select>
               </div>
            </div> 
      </div>
       <div class="span6">
            <div class="control-group">
               <label for="request_type_id" class="control-label">Request Type:<span class="required"></span></label>
               <div class="controls">
                  <select name="request_type_id" required>
                    <option value="">--Select Request Type--</option>
                     <?php
              $request_type_id=run_query("SELECT * from request_types Order by request_type_name");
                while ($fetch=get_row_data($request_type_id))
                {
                echo "<option value='".$fetch['request_type_id']."'>".$fetch['request_type_name']."</option>";
                }
                ?>
                  </select>
               </div>
            </div>
         </div>   
      
   </div>

    <div class="row-fluid">
      <div class="span6">
            <div class="control-group">
               <label for="price" class="control-label">Price:</label>
               <div class="controls">
                  <input type="number" name="price" id="price"/>
               </div>
            </div>
      </div>
      <div class="span6">
        <div class="control-group">
           <label for="price" class="control-label">Status:</label>
           <div class="controls">
              <select name="status">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </select>
           </div>
        </div>
      </div>
    </div>

   <div class="form-actions">
      <input type="hidden" name="action" value="add_setup_channels"/>
      <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
   </div>
   </forrm>
   <!-- END FORM -->
</div>
</div>          