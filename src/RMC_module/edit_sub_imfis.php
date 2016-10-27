<?php

set_layout("form-layout.php", array(
  'pageSubTitle' => 'EDIT SUBCODES',
  'pageSubTitleText' => '',
  'pageBreadcrumbs' => array (
    array ( 'url'=>'index.php', 'text'=>'Home' ),
    array ( 'text'=>'Revenue Management' ),
    array ( 'url'=>'index.php?num=632','text'=>'All IFMIS Subcode Records' ),
    array ( 'text'=>'Edit IFMIS Subcodes' )
  ),
  'pageWidgetTitle' => 'EDIT IFMIS SUBCODES '
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
  $subcode_id = $_GET['edit_id'];
  $result = run_query("SELECT * FROM ifmis_subcodes where subcode_id='".$subcode_id."'");
  while($row = get_row_data($result)){
    $subcode_id=$row['subcode_id'];
    $subcode_name=$row['subcode_name'];
    $head_code_id=$row['head_code_id'];
    $ifmis_subcode=$row['ifmis_subcode'];
  }
}
?>
<!-- BEGIN FORM -->
   <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
      <div class="row-fluid">
         <div class="span6">
            <div class="control-group">
               <label for="subcode_name" class="control-label">Subcode Name:<span class="required"></span></label>
               <div class="controls">
                 <input type="text" name="subcode_name" value="<?=$subcode_name; ?>"  required />
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
               <label for="ifmis_subcode" class="control-label">IFMIS Subcode:<span class="required"></span></label>
               <div class="controls">
                  <input type="text" name="ifmis_subcode" value="<?=$ifmis_subcode; ?>" required />
               </div>
            </div>
          </div>
        </div>
          
   <div class="form-actions">
      <input type="hidden" name="action" value="edit_sub_ifmis"/>
      <input type="hidden" name="subcode_id" value="<?=$subcode_id; ?>"/>
      <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
   </div>
   </form>
   <!-- END FORM -->