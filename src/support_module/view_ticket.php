<?php
  include_once "src/models/SupportTickets.php";
  $supp_tickets = new SupportTickets();

  set_layout("dt-layout.php", array(
     'pageSubTitle' => 'View Maintenance Ticket',
     'pageSubTitleText' => '',
     'pageBreadcrumbs' => array (
        array ( 'url'=>'#', 'text'=>'Home' ),
        array ( 'text'=>'Maintenance Tickets' ),
        array ( 'url'=>'?num=all_support', 'text'=>'All Maintenance Tickets' ),
        array ( 'url'=>'?num=issued_tickets', 'text'=>'Issued Support Tickets'),
        array ( 'text'=>'View Maintenance Ticket' )
     )
  ));

  set_css(array(
     'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css',
      'assets/css/pages/profile.css'
  ));

  set_js(array(
     'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
  ));

  $row = $supp_tickets->getTicketDetails($_GET['ticket_id']);
?>

<div class="widget">
  <div class="widget-title"><h4><i class="icon-comment-alt"></i> <span style="color: green;"><?=$row['subject']; ?></span></h4></div>
  <div class="widget-body form">
  <!-- BEGIN INLINE TABS PORTLET-->
  <form enctype="multipart/form-data" class="form-horizontal" method="post" id= "" class="widget">
  <div class="row-fluid">
      <div class="span12">
          <!--BEGIN TABS-->
          <div class="tabbable tabbable-custom">
              <ul class="nav nav-tabs">
                  <?php
                    $tab1 = 'active';
                    $tab2 = '';
                    if(isset($_SESSION['done-deal'])){
                      $tab2 = 'active';
                      $tab1 = '';
                    }
                  ?>
                <li class="<?=$tab1; ?>"><a href="#tab_1_1" data-toggle="tab"><i class="icon-user"></i> Ticket Details</a></li>
                <li class="<?=$tab2; ?>"><a href="#tab_1_2" data-toggle="tab"> Comments</a></li>

             </ul>
                                   
          <div class="tab-content">
              <div class="tab-pane <?=$tab1; ?> profile-classic row-fluid"  id="tab_1_1">
                 <?php include "ticket_details.php"; ?>
              </div> 

              <div class="tab-pane <?=$tab2; ?> profile-classic row-fluid" id="tab_1_2">
                 <?php include "comments.php"; ?>
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
<?php
  set_js(array('src/js/view_ticket.js'));
?>