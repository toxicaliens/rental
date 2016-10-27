<?php
set_title('Manage Menu');
set_layout("dt-layout.php", array(
  'pageSubTitle' => 'Manage Menu',
  'pageSubTitleText' => '',
  'pageBreadcrumbs' => array (
    array ( 'url'=>'index.php', 'text'=>'Home' ),
    array ( 'text'=>'System Manager' ),
    array ( 'text'=>'Manage Menu' )
  )
));
?>
<!-- BEGIN INLINE TABS PORTLET-->
       <form action="" method="post" class="widget">
          <div class="widget-title">
             <h4><i class="icon-reorder"></i>MANAGE MENU ITEMS</h4>                 
          </div>
          <div class="widget-body form">
            <?php
              $tab1 = '';
              $tab2 = '';
              if(isset($_SESSION['mes3'])){
                $tab2 = 'active';
              }else{
                $tab1 = 'active';
              }
            ?>
             <div class="row-fluid">
                <div class="span12">
                   <!--BEGIN TABS-->
                   <div class="tabbable tabbable-custom">
                      <ul class="nav nav-tabs">
                         <li class="<?=$tab1; ?>" ><a href="#tab_2_1" data-toggle="tab">ADD MENU ITEMS</a></li>
                         <li class="<?=$tab2; ?>"><a href="#tab_2_2" data-toggle="tab">ALL MENU ITEMS</a></li>
                      </ul>
                      <div class="tab-content">
                         <div class="tab-pane <?=$tab1; ?>" id="tab_2_1">
                              <?php include "add_sys_menu.php"; ?>
                         </div>

                        <div class="tab-pane <?=$tab2; ?>" id="tab_2_2">
                             <?php include "manage_sys_menu.php"; ?>
                        </div>

                      </div>
                    </div>
                    <!-- END PAGE --> 
                  </div>
                </div>
          </div>
     <!--END TABS-->


