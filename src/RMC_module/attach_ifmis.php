<?php

set_layout("form-layout.php", array(
	'pageSubTitle' => 'ATTACH  IFMIS CODES',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Revenue Management' ),
    array ( 'url'=>'index.php?num=620','text'=>'All Revenue Channel Record' ),
		array ( 'text'=>'Attach IFMIS Codes' )
	),
	'pageWidgetTitle' => 'ATTACH  IFMIS CODES TO A REVENUE CHANNEL '
));

set_css(array(
   'assets/plugins/bootstrap-datepicker/css/datepicker.css'
));
set_js(array(
   'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
   'assets/scripts/form-validator.js',
   'src/js/filter_ifmis.js'
   
)); 
if(isset($_SESSION['RMC'])){
    echo "<p style='color:#33FF33; font-size:16px;'>".$_SESSION['RMC']."</p>";
    unset($_SESSION['RMC']);
}
if(isset($_GET['edit_id'])){
  $revenue_channel_id = $_GET['edit_id'];
  $result = run_query("SELECT * FROM revenue_channel where revenue_channel_id=$revenue_channel_id");
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
      <h1 id="show_query"></h1>
      <div class="row-fluid">
         <div class="span6">
          <div class="control-group">
            <label for="ifmis_options" class="control-label">Subcode:</label>
            <div class="controls">
              <select name="subcode_id" id="ifmis_options" >
              </select>
            </div>
          </div>
        </div>
        <div class="span6">
          <div class="control-group">
            <label for="Status" class="control-label">Status:</label>
            <div class="controls">
              <select name="Status" id="Status" required>
                 <option value="">--select status--</option>
                 <option value="True">Attached</option>
                 <option value="False">Not Attached</option>
              </select>
            </div>
          </div>
        </div>
      </div>
         
   <div class="form-actions">
      <input type="hidden" name="action" value="attach_ifmis"/>
      <input type="hidden" name="revenue_channel_id" value="<?=$revenue_channel_id; ?>"/>
      <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
   </div>
   </form>
   <!-- END FORM -->