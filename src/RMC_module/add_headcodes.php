<form action="" method="post"  class="form-horizontal">
	                                          	
<div class="row-fluid">
         <div class="span6">
            <div class="control-group">
               <label for="head_code_name" class="control-label">Head Code Name:<span class="required"></span></label>
               <div class="controls">
                 <input type="text" name="head_code_name" class="span12" required />
               </div>
            </div>
         </div>
         <div class="span6">
            <div class="control-group">
               <label for="ifmis_code" class="control-label">IFMIS Code:<span class="required"></span></label>
               <div class="controls">
                  <input type="text" name="ifmis_code" class="span12" required />
               </div>
            </div>
          </div>
      </div>
         
   <div class="form-actions">
      <input type="hidden" name="action" value="add_head_ifmis"/>
      <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
   </div>
</form>         