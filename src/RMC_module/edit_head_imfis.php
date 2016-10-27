<?php

set_layout("form-layout.php", array(
	'pageSubTitle' => 'EDIT HEADCODES',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Revenue Management' ),
		array ( 'url'=>'index.php?num=629','text'=>'All IFMIS Head Records' ),
    array ( 'text'=>'Edit IFMIS Headcodes' )
	),
	'pageWidgetTitle' => 'EDIT IFMIS HEADCODES '
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
  $head_code_id = $_GET['edit_id'];
  $result = run_query("SELECT * FROM ifmis_headcodes where head_code_id='".$head_code_id."'");
  while($row = get_row_data($result)){
    $head_code_id=$row['head_code_id'];
    $head_code_name=$row['head_code_name'];
    $ifmis_code=$row['ifmis_code']; 
  }
}
?>
<!-- BEGIN FORM -->
   <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
      <div class="row-fluid">
         <div class="span6">
            <div class="control-group">
               <label for="head_code_name" class="control-label">Head Code Name:<span class="required"></span></label>
               <div class="controls">
                 <input type="text" name="head_code_name" value="<?=$head_code_name; ?>"  required />
               </div>
            </div>
         </div>
         <div class="span6">
            <div class="control-group">
               <label for="ifmis_code" class="control-label">IFMIS Code:<span class="required"></span></label>
               <div class="controls">
                  <input type="text" name="ifmis_code" value="<?=$ifmis_code; ?>" required />
               </div>
            </div>
          </div>
      </div>
         
   <div class="form-actions">
      <input type="hidden" name="action" value="edit_head_ifmis"/>
      <input type="hidden" name="head_code_id" value="<?=$head_code_id; ?>"/>
      <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
   </div>
   </form>
   <!-- END FORM -->