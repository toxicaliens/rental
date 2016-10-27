<?php
	include_once ('src/models/Masterfile.php');
	$mf = new Masterfile();

	set_title('Edit Address');
	set_layout("form-layout.php", array(
		'pageSubTitle' => 'Edit Address Type',
		'pageSubTitleText' => '',
		'pageBreadcrumbs' => array (
			array ( 'url'=>'#', 'text'=>'Home' ),
			array ( 'text'=>'MASTERFILE' ),
			array ( 'url'=>'?num=727', 'text'=>'Manage Address Types' ),
			array ( 'text'=>'Edit Address Type' )
		),

		'pageWidgetTitle'=>'&nbspEdit Address Type'
	));

	set_css(array(
		'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css'
	));
	set_js(array(
		'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js'
	));

	$mf->splash('mf');
	// display all encountered errors
	(isset($_SESSION['mf_warnings'])) ? $mf->displayWarnings('mf_warnings') : '';

	//get the value
	if (isset($_GET['address_type_id'])){
	$address=$_GET['address_type_id'];
	$query="SELECT * FROM address_types WHERE address_type_id='".$address."'";
	$data=run_query($query);
	$total_rows=get_num_rows($data);
	}
	$con=1;
	$total=0;

	$row=get_row_data($data);

	//the values
	$address_type_name = $row['address_type_name'];
	$address_type_id = $row['address_type_id'];
	$status = $row['status'];
	$check1 = '';
	$check2 = '';
	if($status == '1'){
		$check1 = 'selected';
	}else{
		$check2 = '0';
	}
?>
<!-- BEGIN FORM -->
<form action="" id="edit_crm" method="post" enctype="multipart/form-data" class="form-horizontal">
   <div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="address_type_name" class="control-label">Address Type Name:</label>
				<div class="controls">
					<input type="text" name="address_type_name" value="<?php echo $address_type_name; ?>"/>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="status" class="control-label">Status<span class="required">*</span></label>
				<div class="controls">
					<select class="span12" id="status" name="status" required>
						<option value="1" <?php echo $check1?> >Active</option>
                        <option value="0" <?php echo $check2?> >Inactive</option>
					</select>
				</div>
			</div>
		</div>		
	</div>
	<div class="form-actions">
		<input type="hidden" name="action" value="edit_address_type"/>
		<input type="hidden" name="address_type_id" value="<?php echo $address; ?>"/>
        <?php ViewActions($_GET['num'], $_SESSION['role_id']); ?>  
	</div>			
</form>
<!-- END FORM -->
<?php set_js(array("src/js/delete.js")); ?>