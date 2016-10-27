<?php
include_once('src/models/Device_management.php');
$device_mgt = new DeviceManagement();

set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Manage Device',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'#', 'text'=>'Home' ),
		array ( 'text'=>'Device Management' ),
		array (  'url'=>'?num=75', 'text'=>'Manage Groups' ),
		array ( 'text'=>'Manage Apps' )
	),
	'pageWidgetTitle'=>'Group Apps Management'
));

set_css(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css'
));

set_js(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
)); 

$rows = $device_mgt->getGroupDetails($_GET['group_id']);
?>
<div class="widget">
  <div class="widget-title">
    <h4><i class="icon-order"></i>Group Name: <span style="color:green;"><?=$rows['group_name']; ?> </span></h4>
  </div>
  <div class="widget-body form">
    <!-- BEGIN INLINE TABS PORTLET-->
    <div class="row-fluid">
      <div class="span12">
        <div class="tabbable tabbable-custom">
           <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1_2" data-toggle="tab">Group Apps</a></li>
           </ul>
                                 
        <div class="tab-content">            
           <div class="tab-pane active" id="tab_1_2">   
              <?php include "group_apps.php"; ?>
           </div>
          
        </div>
        																
        </div>
        <!--END TABS-->
        <!-- END PAGE --> 
      </div>
    </div>
  </div>
</div>