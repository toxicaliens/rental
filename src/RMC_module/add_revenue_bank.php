<?php

set_layout("form-layout.php", array(
  'pageSubTitle' => 'Bank Records',
  'pageSubTitleText' => '',
  'pageBreadcrumbs' => array (
    array ( 'url'=>'index.php', 'text'=>'Home' ),
    array ( 'text'=>'Revenue Management' ),
    array ( 'text'=>'Add Bank Records' )
  ),
  'pageWidgetTitle' => 'ADD BANK DETAILS '
));

set_css(array(
   'assets/plugins/bootstrap-datepicker/css/datepicker.css'
));
set_js(array(
   'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
   "assets/scripts/form-validator.js"
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
               <label for="bank_name" class="control-label">Bank Name:<span class="required"></span></label>
               <div class="controls">
                 <input type="text" name="bank_name" required /> 
               </div>
            </div>
         </div>
         <div class="span6">
            <div class="control-group">
               <label for="bank_branch" class="control-label">Bank Branch:<span class="required"></span></label>
               <div class="controls">
                  <input type="text" name="bank_branch" required />
               </div>
            </div>
          </div>
      </div>
      
      <div class="row-fluid">
         <div class="span6">
            <div class="control-group">
               <label for="ifmis_bank_code" class="control-label">IFMIS Bank Code:<span class="required"></span></label>
               <div class="controls">
                  <input type="text" name="ifmis_bank_code" required />
               </div>
            </div>
         </div>   
         <div class="span6">
            <div class="control-group">
               <label for="ifmis_bank_branch_code" class="control-label">IFMIS Branch Code:<span class="required"></span></label>
               <div class="controls">
                  <input type="text" name="ifmis_bank_branch_code" required/>
               </div>
            </div>
         </div>
        </div>
         
   <div class="row-fluid">
         <div class="span6">
            <div class="control-group">
               <label for="bank_account_number" class="control-label">Account number:<span class="required"></span></label>
               <div class="controls">
                 <input type="number" name="bank_account_number"  required/>
               </div>
            </div>
      </div> 
   </div>

   <div class="form-actions">
      <input type="hidden" name="action" value="add_bank_details"/>
      <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
   </div>
   </form>
   <!-- END FORM -->