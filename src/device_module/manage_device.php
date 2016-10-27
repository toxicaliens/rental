<?php
include_once('src/models/Device_management.php');
$device_mgt = new DeviceManagement();

set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Manage Device',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'#', 'text'=>'Home' ),
		array ( 'text'=>'Device Management' ),
		array (  'url'=>'?num=73', 'text'=>'My Devices' ),
		array ( 'text'=>'Profile' )
	),
	'pageWidgetTitle'=>'<i class="icon-reorder"></i>Manage Device'
));

set_css(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css'
));

set_js(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
)); 

$rows = $device_mgt->getDeviceDetails($_GET['device_id']);
?>
<div class="widget">
  <div class="widget-title"><h4><i class="icon-order"></i> Device Name: <span style="color:green;"><?=$rows['description']; ?> </span>IMEI#: <span style="color: green;"><?=$rows['imei_number']; ?></span></h4></div>
  <div class="widget-body form">
    <!-- BEGIN INLINE TABS PORTLET-->
    <div class="row-fluid">
      <div class="span12">
        <!--BEGIN TABS-->
        <?php
          $tab1 = '';
          $tab2 = '';
          if(isset($_POST['action'])){
            $tab2 = 'active';
          }else{
            $tab1 = 'active';
          }
        ?>
        <div class="tabbable tabbable-custom">
           <ul class="nav nav-tabs">
              <li class="<?=$tab1; ?>"><a href="#tab_1_1" data-toggle="tab">Device Details</a></li>
              <li class="<?=$tab2; ?>"><a href="#tab_1_2" data-toggle="tab">Device Apps</a></li>
           </ul>
                                 
        <div class="tab-content">
           <div class="tab-pane row-fluid <?=$tab1; ?> profile-classic" id="tab_1_1">
              <?php include "device_details.php"; ?>
            </div>   
            
           <div class="tab-pane <?=$tab2; ?>" id="tab_1_2">   
              <?php include "manage_apps.php"; ?>
           </div>
          
        </div>
        																
        </div>
        <!--END TABS-->
        <!-- END PAGE --> 
      </div>
    </div>
  </div>
</div>