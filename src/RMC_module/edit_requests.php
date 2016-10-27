<?php
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Edit Request Details',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
	    array ( 'url'=>'index.php', 'text'=>'Home' ),
	    array ( 'text'=>'Revenue Management' ),
	    array ( 'url'=>'index.php?num=638','text'=>'Requests Management' ),
			array ( 'text'=>'Edit Request Details' )
	),
	'pageWidgetTitle' => 'EDIT REQUESTS 	'
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
  $request_type_id= $_GET['edit_id'];

  $distinctQuery = "SELECT * FROM request_types where request_type_id='".$request_type_id."'";
  $result =run_query($distinctQuery);
  while($row = get_row_data($result)){
    $request_type_id = trim($row['request_type_id']);
    $request_type_name = $row['request_type_name'];
    $request_type_code = $row['request_type_code'];
    //var_dump($row );exit;
  }
}
?>    
<!-- BEGIN FORM -->
	<form action="" method="post" id="" enctype="multipart/form-data" class="form-horizontal">
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="request_type_id" class="control-label"> Request Id:<span class="required">*</span></label>
					<div class="controls">
						<input type="text" name="request_type_id" value="<?=$request_type_id; ?>" readonly required />
					</div>
				</div>
		    </div>
		    <div class="span6">
				<div class="control-group">
					<label for="request_type_name" class="control-label"> Request Name:<span class="required">*</span></label>
					<div class="controls">
						<input type="text" name="request_type_name" value="<?=$request_type_name; ?>" required />
					</div>
				</div>
		    </div>
		</div>

		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
	               <label for="request_type_code" class="control-label">Request Code:<span class="required"></span></label>
	               <div class="controls">
	                  <input type="text" name="request_type_code" value="<?=$request_type_code; ?>" required />
	               </div>
	            </div>
		    </div>
		</div>

	<input type="hidden" name="action" value="edit_requests"/>
	<input type="hidden" name="edit_id" value="<?=$request_type_id; ?>"/>
	<div class="form-actions">

		<?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
	</div>
	</form>
	<!-- END FORM -->