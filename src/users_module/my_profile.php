<?php
require_once 'src/models/SystemProfile.php';

$profile = new SystemProfile();
if(App::isAjaxRequest()){
//    echo $_POST['action'];
    if(isset($_POST['action'])){
        $action = $_POST['action'];
        switch ($action){
            case 'change-email':
//                echo json_encode($new_email = $_POST['email_address']);
                if(!empty($_POST['email_address'])) {
                    $result = $profile->changeEmail($_POST['email_address']);
                    echo json_encode($result);
                }
                break;
            case 'reset-code':
                if(!empty($_POST['reset_email_code'])){
                    $result = $profile->verifyEmailChange($_POST['reset_email_code']);
//                    var_dump($result);
                    echo json_encode($result);
                }
                break;
            case'change-phone_number':
                if(!empty($_POST['phone_number'])){
//                    echo $_POST['phone_number'];
                    $result = $profile->resetPhoneNumber($_POST['phone_number']);
                    echo json_encode($result);
                }
                break;
            case 'confirm-phone-reset':
                if(!empty($_POST['confirmation_code'])){
                    $result = $profile->confirmResetPhoneNumber($_POST['confirmation_code']);
                    echo json_encode($result);
                }
        }
    }
}else{
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

$tab1 = '';
$tab2 = '';
$tab3 = '';
if(isset($_POST['tab2'])){
  $tab2 = 'active';
}elseif (isset($_SESSION['client_settings']) || isset($_POST['tab3'])){
    $tab3 = 'active';
}else{
    $tab1='active';
}
?>
  
<!-- BEGIN INLINE TABS PORTLET-->
<div class="row-fluid">
    <div class="span12">
        <!--BEGIN TABS-->
        <div class="tabbable tabbable-custom">
           <ul class="nav nav-tabs">
              <li class="<?=$tab1; ?>"><a href="#tab_1_1" data-toggle="tab">Profile Info</a></li>
              <li class="<?=$tab2; ?>"><a href="#tab_1_2" data-toggle="tab">Change Password</a></li>
              <li class="<?=$tab3; ?>"><a href="#tab_1_3" data-toggle="tab">Client Settings</a></li>
<!--               <li><a href="#tab_1_3" data-toggle="tab">Customer Bills</a></li>-->
           </ul>
                                 
        <div class="tab-content">
            <div class="tab-pane profile-classic row-fluid <?=$tab1; ?>" id="tab_1_1">
               <?php include "profile_info.php"; ?>
            </div> 

             <div class="tab-pane profile-classic row-fluid <?=$tab2; ?>" id="tab_1_2">
               <?php include "account_settings.php"; ?>
            </div>

           <div class="tab-pane row-fluid profile-account <?= $tab3?> "  id="tab_1_3">
               <?php include "client_setting.php"; ?>
            </div>
        </div>
                                        
        </div>
        <!--END TABS-->
        <!-- END PAGE --> 
    </div>
</div>

<?php set_js(array('src/js/my_profile.js')); } ?>

