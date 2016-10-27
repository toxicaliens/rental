<?
include_once('src/models/Visits.php');
$visits = new Visits;
set_layout("dt-layout.php", array(
  'pageSubTitle' => 'Visit Profile',
  'pageSubTitleText' => '',
  'pageBreadcrumbs' => array (
    array ( 'url'=>'index.php', 'text'=>'Home' ),
    array ( 'text'=>'Visits' ),
    array ( 'url'=>'index.php?num=7','text'=>'Manage Visits' ),
    array ( 'text'=>'Visit Profile' )
  )
));

set_css(array(
  'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css'
));

set_js(array(
  'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
)); 

//get the value
$visit_id=$_GET['visit_id'];
if (isset($visit_id))
{
    //get the row
    $query = "SELECT m.*, v.* FROM visits v
      LEFT JOIN masterfile m ON m.mf_id = v.mf_id
            WHERE visit_id ='$visit_id'";
    $data=run_query($query);
    $total_rows=get_num_rows($data);
}

$con=1;
$total=0;

$row=get_row_data($data);

        //the values
        $visit_id=$row['visit_id'];
    $surname=$row['surname'];
    $firstname=$row['firstname'];
    $middlename=$row['middlename'];
        $visit_date =$row['visit_date'];
        $status = $row['visit_status'];
        $age_in_yrs = $row['age_in_yrs'];      
    $age_in_months=$row['age_in_months'];
    $fullname = strtoupper($row['surname'].' '.$row['firstname'].' '.$row['middlename']);
    $status = '';
      if($row['visit_status'] == '1'){
        $status = 'Active';
      }else{
        $status = 'Inactive';
      }
    $mf_id = $row['mf_id'];
?>
<!-- BEGIN INLINE TABS PORTLET-->
                     <form action="" method="post" class="widget">
                        <div class="widget-title">
                           <h4><i class="icon-user"></i>Patient Name: <span style="color:green;"><b><?=$fullname; ?></b></span> 
                            Visit Date: <span style="color:green;"><b><?=$visit_date; ?></b></span>
                           </h4>                 
                        </div>
                        <div class="widget-body">
                          <?php
                            $tab1 = '';
                            $tab2 = '';
                            $tab3 = '';
                            $tab4 = '';
                            $tab5 = '';
                            if(isset($_SESSION['visit_profile'])){
                              $tab2 = 'active';
                            }elseif(isset($_SESSION['medical_report'])){
                              $tab4 = 'active';
                            }elseif (isset($_SESSION['pay_bill'])) {
                              $tab5 = 'active';
                            }elseif (isset($_SESSION['pharmacy'])) {
                              $tab3 = 'active';
                            }else{
                              $tab1 = 'active';
                            }
                          ?>
                           <div class="row-fluid">
                              <div class="span12">
                                 <!--BEGIN TABS-->
                                 <div class="tabbable tabbable-custom">
                                    <ul class="nav nav-tabs">
                                       <li class="<?=$tab1; ?>"><a href="#tab_1_1" data-toggle="tab">Visit Details </a></li>
                                       <li class="<?=$tab2; ?>"><a href="#tab_1_2" data-toggle="tab">Services</a></li>
                                       <li class="<?=$tab3; ?>"><a href="#tab_1_3" data-toggle="tab">Pharmacy</a></li>
                                       <li class="<?=$tab4; ?>"><a href="#tab_1_4" data-toggle="tab">Medical Report</a></li>
                                       <li class="<?=$tab5; ?>"><a href="#tab_1_5" data-toggle="tab">Bills</a></li>
                                       <li><a href="#tab_1_6" data-toggle="tab">Payments</a></li>
                                    </ul>
                                    <div class="tab-content">
                                       <div class="tab-pane profile-classic row-fluid <?=$tab1; ?>" id="tab_1_1">
                                            <?php include "details.php"; ?>
                                       </div>

                                      <div class="tab-pane profile-classic row-fluid <?=$tab2; ?>" id="tab_1_2">
                                           <?php include "visit_services.php"; ?>
                                      </div>

                                      <div class="tab-pane row-fluid <?=$tab3; ?>" id="tab_1_3">
                                           <?php include "pharmacy.php"; ?>
                                      </div>

                                      <div class="tab-pane row-fluid <?=$tab4; ?>" id="tab_1_4">
                                           <?php include "medical_report.php"; ?>
                                      </div>

                                      <div class="tab-pane row-fluid <?=$tab5; ?>" id="tab_1_5">
                                           <?php include "patient_bills.php"; ?>
                                      </div>

                                      <div class="tab-pane row-fluid" id="tab_1_6">
                                           <?php include "payments.php"; ?>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- END PAGE --> 
                                </div>
                              </div>
                        </div>
                   <!--END TABS-->
<?php set_js(array("src/js/visit_profile.js")); ?>

