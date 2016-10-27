<?
set_layout("dt-layout.php", array(
  'pageSubTitle' => 'EDIT SETUP SERVICES',
  'pageSubTitleText' => '',
  'pageBreadcrumbs' => array (
    array ( 'url'=>'index.php', 'text'=>'Home' ),
    array ( 'text'=>'Revenue Management' ),
    array ( 'url'=>'index.php?num=623','text'=>'All Setup channels' ),
    array ( 'text'=>'Edit Setup services' )
  )
));

//population
// populateNullFields('sys_actions', 'sys_button_type', 'section');

set_css(array(
   'assets/plugins/bootstrap-datepicker/css/datepicker.css',
   'src/css/selection_table.css'
));
set_js(array(
   'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
   'assets/scripts/form-validator.js',
   'src/js/add_service_channel_input.js',
   'src/js/delete.js'
)); 

if(isset($_GET['edit_id'])){
  $service_channel_id = $_GET['edit_id'];
  $result ="SELECT * FROM service_channels where service_channel_id='".$service_channel_id."'";
  $data=run_query($result);
  while($row = get_row_data($data)){
    // var_dump($row);exit;
      $revenue_channel_id=$row['revenue_channel_id'];
      $service_channel_id=$row['service_channel_id'];

      $service_option=$row['service_option'];
      $service_option_type=$row['service_option_type'];
      $price=$row['price'];
      $option_code=$row['option_code'];
      $parent_id=$row['parent_id']; 
      $request_type_id=$row['request_type_id'];
      $status=$row['status'];
      $choice1 = '';
      $choice2 = '';
      $choice3 = '';
      if($service_option_type == 'Leaf')
        $choice1 = 'selected';
      elseif($service_option_type == 'Branch')
        $choice2 = 'selected';
      else
        $choice3 = 'selected';
}
}
$class1 = '';
$class2 = '';
if(isset($_POST['service_id'])){
    $class2 = 'active';
}elseif(isset($_POST['delete_id'])){
    $class2 = 'active';
}else{
    $class1 = 'active';
}
?>

         <!-- BEGIN INLINE TABS PORTLET-->
        <div class="widget">
          <div class="widget-title">
             <h4><i class="icon-reorder"></i>EDIT SERVICE CHANNELS</h4>                 
          </div>
          <div class="widget-body form">
            <?php
              if(isset($_SESSION['RMC'])){
                echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['RMC']."</p>";
                unset($_SESSION['RMC']);
              }
            ?>
             <div class="row-fluid">
                <div class="span12">
                   <!--BEGIN TABS-->
                   <div class="tabbable tabbable-custom">
                      <ul class="nav nav-tabs">
                         <li class="<?=$class1; ?>" ><a href="#tab_2_1" data-toggle="tab">EDIT SERVICE CHANNELS</a></li>
                      </ul>
                      <div class="tab-content">
                         <div class="tab-pane <?=$class1; ?>" id="tab_2_1">
                              <? include "edit_service_channels.php"; ?>
                         </div>

                      </div>
                    </div>
                    <!-- END PAGE --> 
                  </div>
                </div>
          </div>
        </div>
     <!--END TABS-->


