<?php

set_layout("form-layout.php", array(
	'pageSubTitle' => 'SETUP SUBCODES',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Revenue Management' ),
		array ( 'text'=>'Setup IFMIS subcodes' )
	),
	'pageWidgetTitle' => 'SETUP IFMIS SUBCODES '
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
               <label for="subcode_name" class="control-label">Subcode Name:<span class="required"></span></label>
               <div class="controls">
                 <input type="text" name="subcode_name" required />
               </div>
            </div>
         </div>
         <div class="span6">
            <div class="control-group">
               <label for="head_code_id" class="control-label">Head Code:<span class="required"></span></label>
               <div class="controls">
                  <select name="head_code_id" id="head_code_id" required>
                    <option value="">--Choose Headcode--</option>
                    <?php
                    $head_code_id=run_query("SELECT * from ifmis_headcodes Order by head_code_name");
                               while ($fetch=get_row_data($head_code_id))
                               {
                               echo "<option value='".$fetch['head_code_id']."'>".$fetch['head_code_name']."</option>";
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
               <label for="ifmis_subcode" class="control-label">IFMIS Subcode:<span class="required"></span></label>
               <div class="controls">
                  <input type="text" name="ifmis_subcode" required />
               </div>
            </div>
          </div>
      </div>
         
   <div class="form-actions">
      <input type="hidden" name="action" value="add_sub_ifmis"/>
      <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
   </div>
   </form>
   <!-- END FORM -->