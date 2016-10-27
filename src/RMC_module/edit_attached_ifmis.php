<?php

set_layout("form-layout.php", array(
	'pageSubTitle' => ' EDIT ATTACHED  IFMIS CODES',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Revenue Management' ),
    array ( 'url'=>'index.php?num=620','text'=>'All Attached IFMIS Records' ),
		array ( 'text'=>'Edit Attached IFMIS Codes' )
	),
	'pageWidgetTitle' => 'EDIT ATTACHED  IFMIS CODES FOR A REVENUE CHANNEL '
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
if(isset($_GET['edit_id'])){
  $revenue_channel_id = $_GET['edit_id'];
  $result = run_query("SELECT * FROM revenue_channel where revenue_channel_id='".$revenue_channel_id."'");
  while($row = get_row_data($result)){
    $revenue_channel_id = $row['revenue_channel_id'];
    $revenue_channel_name = $row['revenue_channel_name'];
    $head_code_id=$row['head_code_id'];
    $subcode_id=$row['subcode_id'];
    $status=$row['status'];
  }
}
?>
<!-- BEGIN FORM -->
   <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
      <div class="row-fluid">
         <div class="span6">
            <div class="control-group">
               <label for="revenue_channel_name" class="control-label">Head Code Name:<span class="required"></span></label>
               <div class="controls">
                 <input type="text" name="revenue_channel_name" value="<?=$revenue_channel_name; ?>" readonly required />
               </div>
            </div>
         </div>
         <div class="span6">
            <div class="control-group">
               <label for="head_code_id" class="control-label">Head Code:<span class="required"></span></label>
               <div class="controls">
                  <select name="head_code_id" id="head_code_id" required>
                   <?=get_select_with_selected('ifmis_headcodes','head_code_id','head_code_name',$head_code_id)?>
                  </select>
                </div>
            </div>
         </div>
      </div>

      <div class="row-fluid">
         <div class="span6">
          <div class="control-group">
            <label for="subcode_id" class="control-label">Subcode:</label>
            <div class="controls">
              <select name="subcode_id" id="subcode_id" required>
                <?php
                  $result = run_query("SELECT * FROM ifmis_subcodes WHERE subcode_id = '".$subcode_id."'");
                  $array = get_row_data($result);
                  $subcode_id = $array['subcode_id'];
                  $job_name = $array['subcode_name'];
                  echo "<option value=\"$subcode_id\">$subcode_name</option>";
                ?>           
              </select>
            </div>
          </div>
        </div>
      </div>
         
   <div class="form-actions">
      <input type="hidden" name="action" value="edit_attached_ifmis"/>
      <input type="hidden" name="revenue_channel_id" value="<?=$revenue_channel_id; ?>"/>
      <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
   </div>
   </form>
   <!-- END FORM -->