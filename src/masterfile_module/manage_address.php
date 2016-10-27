<?php
    include_once ('src/models/Masterfile.php');
    $mf = new Masterfile();

    set_title('Add Manage Address');

    set_layout("dt-layout.php", array(
      'pageSubTitle' => 'Manage Address Types',
      'pageSubTitleText' => '',
      'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'text'=>'Masterfile' ),
        array ( 'text'=>'Manage Address' )
      )
    ));

    $mf->splash('mf');
    (isset($_SESSION['warnings'])) ? $mf->displayWarnings('warnings') : '';
?>

<!-- BEGIN INLINE TABS PORTLET-->
<form action="" method="post" class="widget">
<div class="widget-title">
   <h4><i class="icon-book"></i>MANAGE ADDRESS TYPES</h4>
</div>
<div class="widget-body form">
   <div class="row-fluid">
      <div class="span12">
         <!--BEGIN TABS-->
         <div class="tabbable tabbable-custom">
            <ul class="nav nav-tabs">
               <li class="active"><a href="#tab_1_1" data-toggle="tab">ADD ADDRESS TYPE </a></li>
               <li><a href="#tab_1_2" data-toggle="tab">ALL ADDRESS TYPES</a></li>
            </ul>
            <div class="tab-content">
               <div class="tab-pane active" id="tab_1_1">
                    <?php include "add_address_type.php"; ?>
               </div>

              <div class="tab-pane" id="tab_1_2">
                   <?php include "address_type.php"; ?>
              </div>

            </div>
          </div>
          <!-- END PAGE -->
        </div>
      </div>
</div>
<!--END TABS-->


