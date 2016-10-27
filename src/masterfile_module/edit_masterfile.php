<?php
    include_once('src/models/Masterfile.php');
    $mf = new Masterfile();
    $row = $mf->getAllMasterfile("mf_id = '".sanitizeVariable($_GET['mf_id'])."'");
    $row = $row['specific'];

    $full_name = $row['surname'].' '.$row['firstname'].' '.$row['middlename'];
    set_layout("form-layout.php", array(
        'pageSubTitle' => 'Edit Masterfile',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array (
            array ( 'url'=>'#', 'text'=>'Home' ),
            array ( 'text'=>'Masterfile' ),
            array ( 'url'=>'?num=729', 'text'=>'All Masterfile' ),
            array ( 'text'=>'edit Masterfile' )
        ),
        'pageWidgetTitle'=> 'Edit Masterfile: <span style="color:#008000;">' .$full_name.'</span>'
    ));

    set_css(array(
        'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css',
        'assets/plugins/bootstrap-datepicker/css/datepicker.css'
    ));
    set_js(array(
        'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
        'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
        'src/js/add_masterfile.js'
    ));

    //the values

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
    if($b_role == 'tenant'){
        $select1 = 'selected';
    }else if($b_role == 'contractor'){
        $select2 = 'selected';
    }else if($b_role == 'land_lord'){
        $select3 = 'selected';
    }else if($b_role == 'property_manager'){
        $select3 = 'selected';
    }

    $mf->splash('mf');
    // display all encountered errors
    (isset($_SESSION['mf_warnings'])) ? $mf->displayWarnings('mf_warnings') : '';
?>
<!--display error & successful msg-->
<div class="alert alert-error hide">
    <button class="close" data-dismiss="alert">&times;</button>
    You have some form errors. Please check below.
</div>
<div class="alert alert-success hide">
    <button class="close" data-dismiss="alert">&times;</button>
    Your form validation is successful!
</div>

<!-- BEGIN FORM -->
<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label for="b_role" class="control-label">Business Role<span class="required">*</span></label>
                <div class="controls">
                    <select class="span12" id="b_role" name="b_role" required>
                        <option value="tenant" <?php echo $select1?> >Tenant</option>
                        <option value="contractor" <?php echo $select2?> >Contractor</option>
                        <option value="land_lord" <?php echo $select3?> >Land Lord</option>
                        <option value="property_manager" <?php echo $select3?> >Property Manager</option>
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
                    <input class="span12" type="text" name="surname" value="<?php echo $row['surname']; ?>" required/>
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="control-group">
                <label for="regdate_stamp" class="control-label">Start Date<span class="required">*</span></label>
                <div class="controls">
                    <input type="text" class="date-picker span12" name="regdate_stamp" value="<?php echo $row['regdate_stamp']; ?>" required />
                </div>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label for="firstname" class="control-label">First Name*</label>
                <div class="controls">
                    <input class="span12" type="text" name="firstname" id="firstname" value="<?php echo $row['firstname']; ?>"/>
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="control-group">
                <label for="id_pass" id="id_pass" class="control-label">ID Number<span class="required">*</span></label>
                <div class="controls">
                    <input class="span12" type="text" name="id_passport" value="<?php echo $row['id_passport']; ?>" required />
                </div>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label for="middlename" class="control-label">Middle Name</label>
                <div class="controls">
                    <input type="text" name="middlename" class="span12" value="<?php echo $row['middlename']; ?>" id="middlename"/>
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="control-group">
                <label for="gender" class="control-label">Gender</label>
                <div class="controls">
                    <select class="span12" id="gender" name="gender" required>
                        <option value="">--choose gender--</option>
                        <option value="Male" <?php echo $gender1?> >Male</option>
                        <option value="Female" <?php echo $gender2?> >Female</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label for="customer_type_id" class="control-label">Masterfile Type</label>
                <div class="controls">
                    <select name="customer_type_id" class="span12 live_search" id="customer_type_id">
                        <option value="">--choose masterfile type--</option>
                        <?php
                        $mf_types = $mf->getAllMasterfileType();
                        if(count($mf_types)){
                            foreach ($mf_types as $mf_type){
                                ?>
                                <option value="<?php echo $mf_type['customer_type_id']; ?>" <?php echo ($mf_type['customer_type_id'] == $row['customer_type_id']) ? 'selected': ''; ?>><?php echo $mf_type['customer_type_name']; ?></option>
                            <?php }} ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="control-group">
                <label for="house" class="control-label">House:</label>
                <div class="controls">
                    <select name="house" id="house" class="span12 live_search">
                        <option value="">--Choose House--</option>
                        <?php
                            $houses = $mf->getAllHouses();
                            $houses = $houses['all'];
                            $tenant_house = $mf->getAllHouses("tenant_mf_id = '".$_GET['mf_id']."'");
                            $tenant_hs_id = $tenant_house['specific'];
                            if(count($houses)){
                                foreach ($houses as $house){
                        ?>
                            <option value="<?php echo $house['house_id']; ?>"
                            <?php echo ($tenant_hs_id['house_id'] == $house['house_id']) ? 'selected': ''; ?>>
                            <?php echo $house['house_number'].' ('.$house['plot_name'].')'; ?></option>
                        <?php }} ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row-fliud">
        <div class="span6">
            <label class="control-label">IMAGE UPLOAD:</label>
            <div class="controls">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-new thumbnail" style="width: 100px; height: 100px;"><img src="<?php echo (!empty($row['images_path'])) ? $row['images_path']: 'assets/img/profile/photo.jpg'; ?>" /></div>
                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100px; max-height: 100px; line-height: 20px;"></div>
                    <div>
                        <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
                            <input type="file" name="images_path"/></span>
                        <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="span6">
            <label for="user_role" class="control-label" id="userole">User Role</label>
            <div class="controls">
                <select name="user_role" class="span12 live_search" id="user_role">
                    <option value="">--choose role--</option>
                    <?php
                        $us_roles = $mf->getAllUserRoles();
                        if(count($us_roles)){
                            foreach ($us_roles as $us_role){
                    ?>
                    <option value="<?php echo $us_role['role_id']; ?>" <?php echo ($us_role['role_id'] == $row['user_role']) ? 'selected': ''; ?>><?php echo $us_role['role_name']; ?></option>
                    <?php }} ?>
                </select>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- hidden fields -->
    <input type="hidden" name="mf_id" value="<?php echo $_GET['mf_id']; ?>">

    <div class="form-actions">
        <input type="hidden" name="action" value="edit_masterfile"/>
        <input type="hidden" name="mf_id" value="<?php echo $_GET['mf_id']; ?>">
        <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
    </div>
</form>
<!-- END FORM -->