<?php
set_layout("profile-layout.php", array(
	'pageSubTitle' => 'My Profile',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'#', 'text'=>'Home' ),
		array ( 'text'=>'My Profile' )
	),
    'pageWidgetTitle'=>'<i class="icon-user"></i> MY PROFILE SETTINGS'
));

set_css(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css',
    'assets/css/pages/profile.css'
));

set_js(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
)); 

$query="SELECT m.*, u.*, ur.role_name, a.phone FROM masterfile m
LEFT JOIN user_login2 u ON u.mf_id = m.mf_id
LEFT JOIN user_roles ur ON ur.role_id = u.user_role
LEFT JOIN address a ON a.mf_id = m.mf_id
WHERE m.mf_id = '".$_SESSION['mf_id']."'
";
// var_dump($query);exit;
$data=run_query($query);
$total_rows=get_num_rows($data);

$con=1;
$total=0;

$row=get_row_data($data);
$profile_pic = $row['images_path'];
if($profile_pic == '' || empty($profile_pic)){
  $profile_pic = 'crm_images/photo.jpg';
}

$class1 = '';
$class2 = '';
$tab = 1;
if(isset($_POST['action'])){
  $tab = 2;
}

if($tab == 1){
  $class1 = 'active';
}else{
  $class2 = 'active';
}
?>
  
<!-- BEGIN INLINE TABS PORTLET-->
<form enctype="multipart/form-data" class="form-horizontal" method="post" id= "" class="widget">
<div class="row-fluid">
    <div class="span12">
        <!--BEGIN TABS-->
        <div class="tabbable tabbable-custom">
           <ul class="nav nav-tabs">
              <li class="<?=$class1; ?>"><a href="#tab_1_1" data-toggle="tab">Profile Info</a></li>
              <li class="<?=$class2; ?>"><a href="#tab_1_2" data-toggle="tab">Account Settings</a></li>
              <!-- <li><a href="#tab_1_3" data-toggle="tab">Customer Bills</a></li> -->
           </ul>
                                 
        <div class="tab-content">
            <div class="tab-pane profile-classic row-fluid <?=$class1; ?>" id="tab_1_1">
               <?php include "profile_info.php"; ?>
            </div> 

             <div class="tab-pane profile-classic row-fluid <?=$class2; ?>" id="tab_1_2">
               <?php include "account_settings.php"; ?>
            </div>

            <!-- <div class="tab-pane row-fluid profile-account" id="tab_1_3">
               <?php //include "customer_bills.php"; ?>
            </div> -->              
        </div>
                                        
        </div>
        <!--END TABS-->
        <!-- END PAGE --> 
    </div>
</div>
</form>

