<?php
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Edit Sub-County Details',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
	    array ( 'url'=>'index.php', 'text'=>'Home' ),
	    array ( 'text'=>'Revenue Management' ),
	    array ( 'url'=>'index.php?num=639','text'=>'Manage Sub-County Details' ),
			array ( 'text'=>'Edit Sub-County Details' )
	),
	'pageWidgetTitle' => 'EDIT SUB-COUNTY RECORD'
));

set_css(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css'

));

set_js(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
	'assets/scripts/form-validator.js',
   'src/js/delete.js'
)); 

if(isset($_SESSION['RMC'])){
    echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['RMC']."</p>";
    unset($_SESSION['RMC']);
}

if(isset($_GET['edit_id'])){
  $sub_county_id= $_GET['edit_id'];

  $distinctQuery = "SELECT * FROM sub_county where sub_county_id='".$sub_county_id."'";
  $result =run_query($distinctQuery);
  while($row = get_row_data($result)){
   $sub_county_id =($row['sub_county_id']);
    $sub_county_name = $row['sub_county_name'];
    $county_ref_id = $row['county_ref_id'];
    //var_dump($row );exit;
  }
}
?>    
<!-- BEGIN FORM -->
	<form action="" method="post" id="" enctype="multipart/form-data" class="form-horizontal">
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="sub_county_id" class="control-label"> Sub County Id:<span class="required">*</span></label>
					<div class="controls">
						<input type="text" name="sub_county_id" value="<?=$sub_county_id; ?>" readonly required />
					</div>
				</div>
		    </div>
		    <div class="span6">
				<div class="control-group">
					<label for="sub_county_name" class="control-label"> Sub County Name:<span class="required">*</span></label>
					<div class="controls">
						<input type="text" name="sub_county_name" value="<?=$sub_county_name; ?>" required />
					</div>
				</div>
		    </div>
		</div>

		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
	               <label for="county_ref_id" class="control-label">County Name:<span class="required"></span></label>
	               <div class="controls">
	                  <select name="county_ref_id" id="county_ref_id" required>
	                   <?=get_select_with_selected('county_ref','county_ref_id','county_name',$county_ref_id)?>
	                 </select>
	               </div>
	            </div>
		    </div>
		</div>

	<input type="hidden" name="action" value="edit_sub_county"/>
	<input type="hidden" name="edit_id" value="<?=$sub_county_id; ?>"/>
	<div class="form-actions">

		<?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
	</div>
	</form>
	<!-- END FORM -->