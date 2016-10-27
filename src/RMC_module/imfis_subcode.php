<?
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Manage IFMIS Subcodes',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Revenue Management' ),
		array ( 'text'=>'Manage IFMIS Subcodes' )
	)
));

?>

         <!-- BEGIN INLINE TABS PORTLET-->
       <form action="" method="post" class="widget">
          <div class="widget-title">
             <h4><i class="icon-reorder"></i>MANAGE IFMIS SUBCODES </h4>                 
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
                         <li><a href="#tab_2_1" data-toggle="tab">ADD IFMIS SUBCODES </a></li>
                         <li class="active"><a href="#tab_2_2" data-toggle="tab">ALL IFMIS SUBCODES</a></li>
                      </ul>
                      <div class="tab-content">
                         <div class="tab-pane" id="tab_2_1">
                              <? include "add_subcodes.php"; ?>
                         </div>

                        <div class="tab-pane active" id="tab_2_2">
                             <? include "subcode_ifmis.php"; ?>
                        </div>

                      </div>
                    </div>
                    <!-- END PAGE --> 
                  </div>
                </div>
          </div>
     <!--END TABS-->


