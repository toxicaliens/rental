<form action="" method="post"  class="form-horizontal">
	                                          	
 <div class="row-fluid">
         <div class="span6">
            <div class="control-group">
               <label for="bank_name" class="control-label">Bank Name:<span class="required"></span></label>
               <div class="controls">
                 <input class="span12" type="text" name="bank_name" required /> 
               </div>
            </div>
         </div>
         <div class="span6">
            <div class="control-group">
               <label for="bank_branch" class="control-label">Bank Branch:<span class="required"></span></label>
               <div class="controls">
                  <input class="span12" type="text" name="bank_branch" required />
               </div>
            </div>
          </div>
      </div>
      
      <div class="row-fluid">
         <div class="span6">
            <div class="control-group">
               <label for="ifmis_bank_code" class="control-label">IFMIS Bank Code:<span class="required"></span></label>
               <div class="controls">
                  <input class="span12" type="text" name="ifmis_bank_code" required />
               </div>
            </div>
         </div>   
         <div class="span6">
            <div class="control-group">
               <label for="ifmis_bank_branch_code" class="control-label">IFMIS Branch Code:<span class="required"></span></label>
               <div class="controls">
                  <input class="span12" type="text" name="ifmis_bank_branch_code" required/>
               </div>
            </div>
         </div>
        </div>
         
   <div class="row-fluid">
         <div class="span6">
            <div class="control-group">
               <label for="bank_account_number" class="control-label">Account number:<span class="required"></span></label>
               <div class="controls">
                 <input class="span12" type="number" name="bank_account_number"  required/>
               </div>
            </div>
      </div> 
   </div>

   <div class="form-actions">
      <input class="span12" type="hidden" name="action" value="add_bank_details"/>
      <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
   </div>
</form>         