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
    $query="SELECT m.*, ct.customer_type_name, ul.email, m.email, ad.phone FROM masterfile m 
        LEFT JOIN customer_types ct ON ct.customer_type_id = m.customer_type_id
        LEFT JOIN address ad ON ad.mf_id = m.mf_id
        LEFT JOIN user_login2 ul ON ul.mf_id = m.mf_id
        WHERE m.mf_id = '".$mf_id."' ";
    // var_dump($query); exit;
    $data=run_query($query);
    $total_rows=get_num_rows($data);

    $row=get_row_data($data);
    $full_name = strtoupper($row['surname'].' '.$row['firstname'].' '.$row['middlename']);
    $profile_pic = $row['images_path'];
    $phone = $row['phone'];
    $b_role = $row['b_role'];
    // var_dump($profile_pic);exit;
    if($profile_pic == '' || empty($profile_pic)){
        $profile_pic = 'crm_images/photo.jpg';
    }else{
        $profile_pic = $row['images_path'];
    }

        set_layout("dt-layout.php", array(
            'pageSubTitle' => 'Masterfile Profile',
            'pageSubTitleText' => '',
            'pageBreadcrumbs' => array(
                array('url' => '#', 'text' => 'Home'),
                array('text' => 'MASTETRFILE'),
                array('url' => '?num=729', 'text' => 'All Masterfile'),
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
                                if(isset($_SESSION['mf_warnings'])){
                                    $tab2 = 'active';
                                }
                                else{
                                    $tab1 = 'active';
                                }
                            ?>
                            <li class="<?=$tab1; ?>"><a href="#tab_1_1" data-toggle="tab"><i class="icon-user"></i> Profile Info</a></li>
                            <li class="<?=$tab2; ?>"><a href="#tab_1_2" data-toggle="tab"><i class="icon-map-marker"></i> Manage Addresses</a></li>
                                                        
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane <?=$tab1; ?> profile-classic row-fluid"  id="tab_1_1">
                                <?php include "masterfile_profile_info.php"; ?>
                            </div>

                            <div class="tab-pane <?=$tab2; ?> profile-classic row-fluid" id="tab_1_2">
                                <?php include "manage_addresses.php"; ?>
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
