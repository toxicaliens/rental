<?php
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Edit County Details',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
	    array ( 'url'=>'index.php', 'text'=>'Home' ),
	    array ( 'text'=>'Revenue Management' ),
	    array ( 'url'=>'index.php?num=639','text'=>'Manage County Details' ),
			array ( 'text'=>'Edit County Details' )
	),
	'pageWidgetTitle' => 'EDIT COUNTY RECORD'
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
  $county_ref_id= $_GET['edit_id'];
  $result =run_query("SELECT * FROM county_ref where county_ref_id='".$county_ref_id."'");
  while($row = get_row_data($result)){
    $county_ref_id=$row['county_ref_id'];
    $county_name=$row['county_name'];
    $county_logo=$row['county_logo']; 
    //var_dump($row );exit;
  }
}
?>    
<!-- BEGIN FORM -->
	<form action="" method="post" id="" enctype="multipart/form-data" class="form-horizontal">
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="county_name" class="control-label">County Name:<span class="required">*</span></label>
					<div class="controls">
						<input type="text" name="county_name" value="<?=$county_name; ?>" required />
					</div>
				</div>
		    </div>
		    <div class="span6">
				<label class="control-label">IMAGE UPLOAD:</label>
	            <div class="controls">
		            <div class="fileupload fileupload-new" data-provides="fileupload">
		                <div class="fileupload-new thumbnail" style="width: 100px; height: 100px;"><img src='data:image/JPG;base64,<?php echo base64_encode(file_get_contents("assets/img/logo/photo.jpg")); ?>'></div>
		                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100px; max-height: 100px; line-height: 20px;"></div>
		                    <div>
		                        <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" name="profile-pic"/></span>
		                        <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
		                    </div>
		            </div> 
	            </div>
	        </div>  
		</div>

	<input type="hidden" name="action" value="edit_county"/>
	<input type="hidden" name="county_ref_id" value="<?=$county_ref_id; ?>"/>
	<div class="form-actions">

		<?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
	</div>
	</form>
	<!-- END FORM -->