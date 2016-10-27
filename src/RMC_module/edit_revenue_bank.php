<?php

set_layout("form-layout.php", array(
  'pageSubTitle' => ' Edit Bank Records',
  'pageSubTitleText' => '',
  'pageBreadcrumbs' => array (
    array ( 'url'=>'index.php', 'text'=>'Home' ),
    array ( 'text'=>'Revenue Management' ),
    array ( 'url'=>'index.php?num=626','text'=>'All Revenue Bank Accounts' ),
    array ( 'text'=>'Edit Bank Records' )
  ),
  'pageWidgetTitle' => 'EDIT BANK DETAILS '
));

set_css(array(
   'assets/plugins/bootstrap-datepicker/css/datepicker.css'
));
set_js(array(
   'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
   'assets/scripts/form-validator.js',
   'src/js/delete.js'
)); 
if(isset($_SESSION['RMC'])){
    echo "<p style='color:#33FF33; font-size:16px;'>".$_SESSION['RMC']."</p>";
    unset($_SESSION['RMC']);
}

if(isset($_GET['edit_id'])){
	$revenue_bank_id = $_GET['edit_id'];
	$result = run_query("SELECT * FROM revenue_banks where revenue_bank_id='".$revenue_bank_id."'");
	while($row = get_row_data($result)){
		$revenue_bank_id=$row['revenue_bank_id'];
	    $bank_name=$row['bank_name'];
	    $bank_branch=$row['bank_branch'];
	    $bank_account_number=$row['bank_account_number'];
	    $ifmis_bank_code=$row['ifmis_bank_code'];
	    $ifmis_bank_branch_code=$row['ifmis_bank_branch_code'];	
	}
}
?>
<!-- BEGIN FORM -->
   <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
      <div class="row-fluid">
         <div class="span6">
            <div class="control-group">
               <label for="bank_name" class="control-label">Bank Name:<span class="required"></span></label>
               <div class="controls">
                 <input type="text" name="bank_name" value="<?=$bank_name; ?>" readonly required /> 
               </div>
            </div>
         </div>
         <div class="span6">
            <div class="control-group">
               <label for="bank_branch" class="control-label">Bank Branch:<span class="required"></span></label>
               <div class="controls">
                  <input type="text" name="bank_branch" value="<?=$bank_branch; ?>"  required />
               </div>
            </div>
          </div>
      </div>
      
      <div class="row-fluid">
         <div class="span6">
            <div class="control-group">
               <label for="ifmis_bank_code" class="control-label">IFMIS Bank Code:<span class="required"></span></label>
               <div class="controls">
                  <input type="text" name="ifmis_bank_code" value="<?=$ifmis_bank_code; ?>" required />
               </div>
            </div>
         </div>   
         <div class="span6">
            <div class="control-group">
               <label for="ifmis_bank_branch_code" class="control-label">IFMIS Branch Code:<span class="required"></span></label>
               <div class="controls">
                  <input type="text" name="ifmis_bank_branch_code" value="<?=$ifmis_bank_branch_code; ?>" required/>
               </div>
            </div>
         </div>
        </div>
         
   <div class="row-fluid">
         <div class="span6">
            <div class="control-group">
               <label for="bank_account_number" class="control-label">Account number:<span class="required"></span></label>
               <div class="controls">
                 <input type="number" name="bank_account_number"  value="<?=$bank_account_number; ?>"   required/>
               </div>
            </div>
      </div> 
   </div>

   <div class="form-actions">
      <input type="hidden" name="action" value="edit_bank_details"/>
      <input type="hidden" name="revenue_bank_id" value="<?=$revenue_bank_id; ?>"/>
      <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
   </div>
   </form>
   <!-- END FORM -->