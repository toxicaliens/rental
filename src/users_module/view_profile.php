<?php
set_title('Users Details');
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Users Details',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'#', 'text'=>'Home' ),
		array ( 'text'=>'User Management' ),
		array ( 'text'=>'All Users' ),
		array ( 'text'=>'Users Profile' )
	),
	'pageWidgetTitle'=>'Users Details'
));

set_css(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css'
));

set_js(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
)); 

//get the value
$user=$_GET['user'];
if (isset($user))
{
    //get the row
    $query="SELECT * FROM user_login2 WHERE user_id = '$user'";
    $data=run_query($query);
    $total_rows=get_num_rows($data);
}

$con=1;
$total=0;

while($row=get_row_data($data)){
  $id = $row['user_id'];
  $username = $row['username'];
  $email=$row['email'];
  $status=$row['user_active']; 
  if($status == 't'){
    $status = 'Active';
  }else{
    $status = 'Inactive';
  }
  $user_role=$row['user_role'];
}
?>
<div class="widget">
  <div class="widget-title"><h4><i class="reorder"></i> <?=$username; ?></h4></div>
  <div class="widget-body">
<!-- BEGIN INLINE TABS PORTLET-->
<form enctype="multipart/form-data" class="form-horizontal" method="post" id= "" class="widget">
<div class="row-fluid">
    <div class="span12">
        <!--BEGIN TABS-->
        <div class="tabbable tabbable-custom">
           <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1_1" data-toggle="tab">Overview</a></li>
              <li><a href="#tab_1_2" data-toggle="tab">Audit Trail</a></li>
           </ul>
                                 
            <div class="tab-content">
                <div class="tab-pane profile-classic row-fluid active" id="tab_1_1">
                   <?php include "user_profile.php"; ?>
                </div>   
                
                <div class="tab-pane profile-classic" id="tab_1_2">   
                    <?php include "audit_trail.php"; ?>
                </div>
              
            </div>                      
        </div>
        <!--END TABS-->
        <!-- END PAGE --> 
    </div>
</div>
</form>
</div>
</div>                                 



