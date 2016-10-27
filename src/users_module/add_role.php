<?php
set_title('Manage User Roles');
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Manage User Roles',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'#', 'text'=>'Home' ),
		array ( 'text'=>'User Management' ),
		array ( 'text'=>'Manage User Roles' )
	),
	'pageWidgetTitle'=>'Users Details'
));

set_css(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css'
));

set_js(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
)); 
?>
<div class="widget">
  <div class="widget-title"><h4><i class="reorder"></i> Manage User Roles</h4></div>
  <div class="widget-body form">
<!-- BEGIN INLINE TABS PORTLET-->
<div class="row-fluid">
    <div class="span12">
        <!--BEGIN TABS-->
        <div class="tabbable tabbable-custom">
           <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1_1" data-toggle="tab">Add User Role</a></li>
              <li><a href="#tab_1_2" data-toggle="tab">All User Roles</a></li>
           </ul>
                                 
            <div class="tab-content">
                <div class="tab-pane profile-classic row-fluid active" id="tab_1_1">
                   <?php include "add_role_form.php"; ?>
                </div>   
                
                <div class="tab-pane profile-classic" id="tab_1_2">   
                    <?php include "all_roles.php"; ?>
                </div>
              
            </div>                      
        </div>
        <!--END TABS-->
        <!-- END PAGE --> 
    </div>
</div>
</div>
</div>                                 



