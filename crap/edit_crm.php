<?php
//get the value
if (isset($_GET['mf_id'])){
	$mf_id=$_GET['mf_id'];
	
	//get the row
	$query="SELECT m.*, ct.customer_type_name, ul.user_role FROM masterfile m 
   	LEFT JOIN customer_types ct ON ct.customer_type_id = m.customer_type_id
   	LEFT JOIN user_login2 ul ON ul.mf_id = m.mf_id
	WHERE m.mf_id = '".$mf_id."' ";

	$data=run_query($query);
	$row=get_row_data($data);
	$surname = $row['surname'];
	$firstname = $row['firstname'];
	$middlename = $row['middlename'];
	$full_name = strtoupper($surname.' '.$firstname.' '.$middlename);

	set_layout("form-layout.php", array(
		'pageSubTitle' => 'Edit Masterfile',
		'pageSubTitleText' => '',
		'pageBreadcrumbs' => array (
			array ( 'url'=>'#', 'text'=>'Home' ),
			array ( 'text'=>'Masterfile' ),
			array ( 'url'=>'?num=801', 'text'=>'All Masterfile' ),
			array ( 'text'=>'edit Masterfile' )
		),
		'pageWidgetTitle'=>'Edit Masterfile: <span style="color:green;">'.$full_name.'</span>'
	));

	set_css(array(
		'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css',
		'assets/plugins/bootstrap-datepicker/css/datepicker.css'
	));
	set_js(array(
		'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
		'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
		'src/js/add.crm.customer.js'
	)); 

	if(isset($_SESSION['done-deal'])){
		echo ($_SESSION['done-deal']);
	    unset ($_SESSION['done-deal']);
	}
}

    //the values
	$email = $row['email'];
	$regdate_stamp = $row['regdate_stamp'];
	$id_passport = $row['id_passport'];
	$images_path = $row['images_path'];
	$company_name = $row['company_name'];
	$firstname = $row['firstname'];
	$middlename = $row['middlename'];
	$user_role=$row['user_role'];

	$gender=$row['gender'];
	$gender1 = '';
	$gender2 = '';
	if($gender == 'Male'){
		$gender1 = 'selected';
	}else{
		$gender2 = 'selected';
	}

	$b_role=$row['b_role'];
	$select1 = '';
	$select2 = '';
	$select3 = '';
	if($b_role == 'client'){
		$select1 = 'selected';
	}else if($b_role == 'staff'){
		$select2 = 'selected';
	}else if($b_role == 'client group'){
		$select3 = 'selected';
	}
	// var_dump($query); exit;
?>

<!-- BEGIN FORM -->
<form action="" method="post" id="add_customer" enctype="multipart/form-data" class="form-horizontal">
    <div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="b_role" class="control-label">Business Role<span class="required">*</span></label>
				<div class="controls">
					<select class="span12" id="b_role" name="b_role" required>
						<option value="client" <?=$select1?> >Client</option>
	                    <option value="staff" <?=$select2?> >Staff</option>
	                    <option value="client group" <?=$select3?> >Client Group</option>
					</select>
				</div>
			</div>
		</div>
	</div>

    <div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="surname" id="variation" class="control-label">Surname</label>
				<div class="controls">
					<input class="span12" type="text" name="surname" value="<?=$surname; ?>" required/>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="regdate_stamp" class="control-label">Start Date<span class="required">*</span></label>
				<div class="controls">
					<input type="text" class="date-picker span12" name="regdate_stamp" value="<?=$regdate_stamp;?>" required />
				</div>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="firstname" class="control-label">First Name*</label>
				<div class="controls">
					<input class="span12" type="text" name="firstname" id="firstname" value="<?=$firstname; ?>"/>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="id_pass" id="id_pass" class="control-label">ID Number<span class="required">*</span></label>
				<div class="controls">
					<input class="span12" type="text" name="id_passport" value="<?=$id_passport; ?>" required />
				</div>
			</div>
		</div>
	</div>

    <div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="middlename" class="control-label">Middle Name</label>
				<div class="controls">
					<input type="text" name="middlename" class="span12" value="<?=$middlename; ?>" id="middlename"/>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="gender" class="control-label">Gender</label>
				<div class="controls">
					<select class="span12" id="gender" name="gender" required>
						<option value="">--choose gender--</option>
						<option value="Male" <?=$gender1?> >Male</option>
                        <option value="Female" <?=$gender2?> >Female</option>
					</select>
				</div>
			</div>
		</div>
	</div>

	<div class="row-fluid">
	    <div class="span6">
			<div class="control-group">
				<label for="email" id="email" class="control-label">Email/Username:</label>
				<div class="controls">
					<input type="email" name="email" id="email2" class="span12" value="<?=$email; ?>" />
				</div>
			</div>
		</div>

	</div>

	<div class="row-fliud">
	    <div class="span6">
			<label class="control-label">IMAGE UPLOAD:</label>
	        <div class="controls">
		        <div class="fileupload fileupload-new" data-provides="fileupload">
		            <div class="fileupload-new thumbnail" style="width: 100px; height: 100px;"><img src="<?=(!empty($images_path)) ? $images_path: 'assets/img/profile/photo.jpg'; ?>" /></div>
		            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100px; max-height: 100px; line-height: 20px;"></div>
		                <div>
		                    <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" name="images_path"/></span>
		                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
		                </div>
		        </div> 
	        </div>
		</div>
		<div class="span6">
        		<label for="user_role" class="control-label">User Role</label>
				<div class="controls">
					<select name="user_role" class="span12 live_search" id="user_role">
						<option value="">--choose role--</option>
						<?php

                            $query = "SELECT * FROM user_roles ORDER BY role_name ASC";

                            if ($data = run_query($query))
                            {
								while ( $fetch = get_row_data($data) )
								{
                            ?>
                            <option value="<?=$fetch['role_id']; ?>" <?php if($fetch['role_id'] === $user_role){ echo 'selected'; } ?>><?php echo $fetch['role_name']; ?></option>";
                            <?php } }  ?>
					</select>
				</div>
            </div>		
    </div>
    <div class="clearfix"></div>
	
	<div class="form-actions">
		<input type="hidden" name="action" value="edit_masterfile"/>
		<input type="hidden" name="mf_id" value="<?php echo $_GET['mf_id']; ?>">
        <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
	</div>
</form>
<!-- END FORM --> 