<?
set_title('Maintenance');
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Maintenance',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'System Manager' ),
		array ( 'text'=>'Maintenance' )
	)
));

set_css(array(
  'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css',
  'assets/plugins/bootstrap-datepicker/css/datepicker.css'
));
?>
<!-- BEGIN INLINE TABS PORTLET-->
       <form action="" method="post" class="widget">
          <div class="widget-title">
             <h4><i class="icon-reorder"></i>Database Maintenance</h4>                 
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
                         <li class="<?=$tab1; ?>" ><a href="#tab_2_1" data-toggle="tab">Backup/Restore</a></li>
                      </ul>
                      <div class="tab-content">
                         <div class="tab-pane <?=$tab1; ?>" id="tab_2_1">
                              <? include "db_controls.php"; ?>
                         </div>

                      </div>
                    </div>
                    <!-- END PAGE --> 
                  </div>
                </div>
          </div>
     <!--END TABS-->


