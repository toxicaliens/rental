<?php
include_once 'src/model/RevenueManager.php';
$revenue_manager = new RevenueManager();

set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Revenue Forecasting',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Revenue Management' ),
		array ( 'text'=>'Revenue Forecasting' )
	)
));

?>

         <!-- BEGIN INLINE TABS PORTLET-->
       <form action="" method="post" class="widget">
          <div class="widget-title">
             <h4><i class="icon-money"></i> Revenue Forecasting</h4>                 
          </div>
          <div class="widget-body form">
             <div class="row-fluid">
                <div class="span12">
                   <!--BEGIN TABS-->
                   <div class="tabbable tabbable-custom">
                      <ul class="nav nav-tabs">
                        <?php
                          $tab1 = '';
                          $tab2 = '';
                          if(isset($_POST['tab1'])){
                            $tab1 = 'active';
                          }elseif(isset($_POST['tab2'])){
                            $tab2 = 'active';
                          }else{
                            $tab1 = 'active';
                          }
                        ?>
                         <li class="active"><a href="#tab_2_1" data-toggle="tab">Daily Forecast</a></li>
                         <li><a href="#tab_2_2" data-toggle="tab">Monthly Forecast</a></li>
                         <li><a href="#tab_2_3" data-toggle="tab">Quaterly Forecast</a></li>
                         <li><a href="#tab_2_4" data-toggle="tab">Semi-Annual Forecast</a></li>
                         <li><a href="#tab_2_5" data-toggle="tab">Annual Forecast</a></li>
                      </ul>
                      <div class="tab-content">
                         <div class="tab-pane active" id="tab_2_1">
                              <? include "daily.php"; ?>
                         </div>

                        <div class="tab-pane" id="tab_2_2">
                             <? include "mothly.php"; ?>
                        </div>

                        <div class="tab-pane" id="tab_2_3">
                              <? include "quaterly.php"; ?>
                         </div>

                        <div class="tab-pane" id="tab_2_4">
                             <? include "semi_annual.php"; ?>
                        </div>

                        <div class="tab-pane" id="tab_2_5">
                              <? include "annual.php"; ?>
                         </div>

                      </div>
                    </div>
                    <!-- END PAGE --> 
                  </div>
                </div>
          </div>
     <!--END TABS-->


