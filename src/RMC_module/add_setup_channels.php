<?php

set_layout("form-layout.php", array(
  'pageSubTitle' => 'SETUP SERVICES',
  'pageSubTitleText' => '',
  'pageBreadcrumbs' => array (
    array ( 'url'=>'index.php', 'text'=>'Home' ),
    array ( 'text'=>'Revenue Management' ),
    array ( 'url'=>'index.php?num=623','text'=>'All Service Options' ),
    array ( 'text'=>'Setup services' )
  ),
  'pageWidgetTitle' => 'SETUP NEW SERVICES '
));

set_css(array(
   'assets/plugins/bootstrap-datepicker/css/datepicker.css'
));
set_js(array(
   'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
   'assets/scripts/form-validator.js'
)); 
if(isset($_SESSION['RMC'])){
    echo "<p style='color:#33FF33; font-size:16px;'>".$_SESSION['RMC']."</p>";
    unset($_SESSION['RMC']);
}
?>
<!-- BEGIN FORM -->
   <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
      <div class="row-fluid">
         <div class="span6">
            <div class="control-group">
               <label for="revenue_channel_id" class="control-label">Revenue channel name:<span class="required"></span></label>
               <div class="controls">
                 <select class="span12" id="select2_sample80" class="span7 select2" name="revenue_channel_id" id="revenue_channel_id" required>
                     <option value="">--Choose Revenue Name--</option>
                     <?php
                        $revenue_channel_id=run_query("SELECT * from revenue_channel Order by revenue_channel_name");
                        while ($fetch=get_row_data($revenue_channel_id))
                        {
                        echo "<option value='".$fetch['revenue_channel_id']."'>".$fetch['revenue_channel_name']."</option>";
                        }
                    ?>
                 </select>
               </div>
            </div>
         </div>
         <div class="span6">
            <div class="control-group">
               <label for="service_option" class="control-label">Service Option Name:<span class="required"></span></label>
               <div class="controls">
                  <input class="span12" type="text" name="service_option" required />
               </div>
            </div>
          </div>
      </div>
      
      <div class="row-fluid">
         <div class="span6">
            <div class="control-group">
               <label for="service_option_type" class="control-label">Service Option Type:<span class="required"></span></label>
               <div class="controls">
                  <select class="span12" name="service_option_type" id="service_option_type" required>
                     <option value="">--Choose Option Type--</option>
                     <option value="Branch">Branch</option>
                     <option value="Leaf">Leaf</option>
                     <option value="Root">Root</option>
                  </select>
               </div>
            </div>
         </div>
          <div class="span6">
            <div class="control-group">
               <label for="option_code" class="control-label">Option Code:<span class="required"></span></label>
               <div class="controls">
                  <input class="span12" type="text" name="option_code" required/>
               </div>
            </div>
         </div>   
              
        </div>
         
   <div class="row-fluid">
         <div class="span6">
            <div class="control-group">
               <label for="parent_id" class="control-label">Parent Id:<span class="required"></span></label>
               <div class="controls">
                  <select class="span12" name="parent_id" >
                     <option value="0">NO PARENT</option>
                    <?php
              $parent_id=run_query("SELECT * from service_channels Order by service_option");
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
                  <select class="span12" name="request_type_id" required>
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
                  <input class="span12" type="number" name="price" id="price" value="0" />
               </div>
            </div>
      </div>
      <div class="span6">
        <div class="control-group">
           <label for="price" class="control-label">Status:</label>
           <div class="controls">
              <select class="span12" name="status">
                <option value="1">Active</option>
                <option value="0" selected="selected">Inactive</option>
              </select>
           </div>
        </div>
      </div>
    </div>

   <div class="form-actions">
      <input class="span12" type="hidden" name="action" value="add_setup_channels"/>
      <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
   </div>
   </form>
   <!-- END FORM -->