<?
set_layout("dt-layout.php", array(
  'pageSubTitle' => 'Manage County Details',
  'pageSubTitleText' => '',
  'pageBreadcrumbs' => array (
    array ( 'url'=>'index.php', 'text'=>'Home' ),
    array ( 'text'=>'Revenue Management' ),
    array ( 'text'=>'Manage County Details' )
  )
));

set_css(array(
  'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css'
));
set_js(array(
  'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js'
  
)); 

?>

                       <!-- BEGIN INLINE TABS PORTLET-->
                     <form action="" method="post" class="widget">
                        <div class="widget-title">
                           <h4><i class="icon-reorder"></i>MANAGE COUNTY DETAILS  </h4>                 
                        </div>
                        <div class="widget-body">
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
                                       <li><a href="#tab_1_1" data-toggle="tab">ADD COUNTY INFO </a></li>
                                       <li class="active"><a href="#tab_1_2" data-toggle="tab">ALL COUNTY DETAILS</a></li>
                                    </ul>
                                    <div class="tab-content">
                                       <div class="tab-pane" id="tab_1_1">
                                            <? include "add_county.php"; ?>
                                       </div>

                                      <div class="tab-pane active" id="tab_1_2">
                                           <? include "county_details.php"; ?>
                                      </div>

                                    </div>
                                  </div>
                                  <!-- END PAGE --> 
                                </div>
                              </div>
                        </div>
                   <!--END TABS-->


