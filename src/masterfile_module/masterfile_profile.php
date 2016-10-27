<?php
/**
 * Created by PhpStorm.
 * User: JOEL
 * Date: 7/13/2016
 * Time: 11:33 AM
 */

    include_once "src/models/Masterfile.php";
    $mf= new Masterfile();

    //get the value
    $mf_id=$_GET['mf_id'];
    //get the row
    $query="SELECT m.*, ba.*, b.bank_name, br.branch_name, ct.customer_type_name, ul.email, m.email, ad.phone FROM masterfile m 
        LEFT JOIN customer_types ct ON ct.customer_type_id = m.customer_type_id
        LEFT JOIN address ad ON ad.mf_id = m.mf_id
        LEFT JOIN user_login2 ul ON ul.mf_id = m.mf_id
        LEFT JOIN bank_account ba ON ba.mf_id = m.mf_id
        LEFT JOIN banks b ON b.bank_id = ba.bank_id
        LEFT JOIN bank_branch br ON br.branch_id = br.branch_id
        WHERE m.mf_id = '".$mf_id."' ";
    // var_dump($query); exit;
    $data=run_query($query);
    $total_rows=get_num_rows($data);

    $row=get_row_data($data);
    $full_name = strtoupper($row['surname'].' '.$row['firstname'].' '.$row['middlename']);
    $phone = $row['phone'];
    $b_role = $row['b_role'];
    $profile_pic = $row['images_path'];
    $bank_name = $row['bank_name'];
    $branch_name = $row['branch_name'];
    $pin_no = $row['pin_no'];
    // var_dump($profile_pic);exit;
    if(!empty($profile_pic)){
        $profile_pic = 'assets/img/profile/photo.jpg';
    }else{
        $profile_pic = $row['images_path'];
    }

        set_layout("dt-layout.php", array(
            'pageSubTitle' => 'Masterfile Profile',
            'pageSubTitleText' => '',
            'pageBreadcrumbs' => array(
                array('url' => '#', 'text' => 'Home'),
                array('text' => 'MASTERFILE'),
                array('url' => '?num=731', 'text' => 'My Masterfile'),
                array('text' => 'Masterfile Profile')
            )
        ));

        set_css(array(
            'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css',
            'assets/css/pages/profile.css'
        ));

        set_js(array(
            'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
        ));
?>

<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> <span style="color: green;"><?php echo $full_name; ?></span></h4></div>
    <div class="widget-body form">
        <!-- BEGIN INLINE TABS PORTLET-->
        <form enctype="multipart/form-data" class="form-horizontal" method="post" id= "" class="widget">
            <div class="row-fluid">
                <div class="span12">
                    <!--BEGIN TABS-->
                    <div class="tabbable tabbable-custom">
                        <ul class="nav nav-tabs">
                            <?php
                                $tab1 = '';
                                $tab2 = '';
                                $tab3 = '';
                                if(isset($_SESSION['mf_warnings'])){
                                    $tab2 = 'active';
                                }
                                else{
                                    $tab1 = 'active';
                                }
                            ?>
                            <li class="<?php echo $tab1; ?>"><a href="#tab_1_1" data-toggle="tab"><i class="icon-user"></i> Profile Info</a></li>
                            <li class="<?php echo $tab2; ?>"><a href="#tab_1_2" data-toggle="tab"><i class="icon-map-marker"></i> Manage Addresses</a></li>
                            <?php
                                if($b_role == 'land_lord') { ?>
                                    <li class="<?php echo $tab3; ?>"><a href="#tab_1_3" data-toggle="tab"><i class="icon-briefcase"></i> Bank Account Details</a></li>
                                <?php
                                    }elseif($b_role == 'contractor'){
                            ?>
                            <li class="<?php echo $tab3; ?>"><a href="#tab_1_3" data-toggle="tab"><i class="icon-briefcase"></i> Bank Account Details</a></li>
                            <?php } ?>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane <?php echo $tab1; ?> profile-classic row-fluid"  id="tab_1_1">
                                <?php include "masterfile_profile_info.php"; ?>
                            </div>

                            <div class="tab-pane <?php echo $tab2; ?> profile-classic row-fluid" id="tab_1_2">
                                <?php include "manage_addresses.php"; ?>
                            </div>

                            <div class="tab-pane <?php echo $tab3; ?> profile-classic row-fluid" id="tab_1_3">
                                <?php include "account_profile.php"; ?>
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
