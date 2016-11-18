<?php
  if(isset($_SESSION['change_password'])){
    echo $_SESSION['change_password'];
    unset($_SESSION['change_password']);
  }
?>
<form action="" method="post"  class="form-horizontal">                                          
<div class="row-fluid">
      <div class="span6">
          <div class="control-group">
              <label for="old_password" class="control-label">Current Password:</label>
              <div class="controls">
               <input type="password" name="old_password"  class="m-wrap span8" required>
              </div>
          </div>
      </div>
</div>
<div class="row-fluid">
      <div class="span6">
          <div class="control-group">
              <label for="password" class="control-label">New Password:</label>
              <div class="controls">
                <input type="password" name="password"  class="m-wrap span8"   required>
              </div>
          </div>
      </div>

</div>
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label for="pass_again" class="control-label">Re-type New Password:</label>
            <div class="controls">
                <input type="password" name="pass_again"  class="m-wrap span8"   required>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="cur_mf_id" value="<?=$_SESSION['mf_id']; ?>"/>
<input type="hidden" name="action" id="action" value="change_password" class="packinput">
<input type="hidden" name="tab2">
    <div class="form-actions">
        <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
    </div>
</form>         