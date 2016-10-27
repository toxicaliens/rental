<?php

set_layout("form-layout.php", array(
	'pageSubTitle' => 'SETUP HEADCODES',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Revenue Management' ),
		array ( 'text'=>'Setup IFMIS Headcodes' )
	),
	'pageWidgetTitle' => 'SETUP IFMIS HEADCODES '
));

set_css(array(
   'assets/plugins/bootstrap-datepicker/css/datepicker.css'
));
set_js(array(
   'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
   // 'assets/scripts/form-validator.js',
   'src/js/checkforexistingheadcodename.js'
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
               <label for="head_code_name" class="control-label">Head Code Name:<span class="required"></span></label>
               <div class="controls">
                 <input type="text" name="head_code_name" required />
               </div>
            </div>
         </div>
         <div class="span6">
            <div class="control-group">
               <label for="ifmis_code" class="control-label">IFMIS Code:<span class="required"></span></label>
               <div class="controls">
                  <input type="text" name="ifmis_code" required />
               </div>
            </div>
          </div>
      </div>
         
   <div class="form-actions">
      <input type="hidden" name="action" value="add_head_ifmis"/>
      <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
   </div>
   </form>
   <!-- END FORM -->