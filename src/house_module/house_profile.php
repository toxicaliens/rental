<?php
include_once 'src/models/House.php';
include_once 'src/models/Plots.php';
$house = new House();
$prop = new Plots();
if(App::isAjaxRequest()){
    if(isset($_POST['action'])) {
        $action = $_POST['action'];
        switch ($action) {
            case 'edit-house-attr':
                $result = $house->selectQuery('house_attr_allocations','attr_value',"house_attr_id = '".$_POST['edit_id']."' ");
                echo json_encode($result[0]);
                break;

        }


    }
}else{


set_layout("dt-layout.php", array(
    'pageSubTitle' => 'Profiles',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'#', 'text'=>'Home' ),
        array ( 'text'=>'PROPERTY MANAGER' ),
        (isset($_GET['house_id']))? array ( 'url'=>'?num=3001', 'text'=>'All Properties') :array ( 'url'=>'?num=3001', 'text'=>'All Properties'),
        (isset($_GET['house_id']))? array ( 'text'=>'Unit Profile' ) : array ( 'text'=>'Property Profile' )

    )
));
//if(isset($_GET['house_id'])){
//    'url'=>'?num=view_houses', 'text'=>'All units';
//        }else if(isset($_GET['prop_id'])){
//    include_once 'src/prop_module/property_profile_info.php';
//}
set_css(array(
    'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css',
    'assets/css/pages/profile.css'
));

set_js(array(
    'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
));


?>

<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> <span style="color: green;"><?php $house->getAppropriateName(); ?></span></h4>
    </div>
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
                            if(isset($_SESSION['h_services'])){
                                $tab2 = 'active';
                            }elseif(isset($_SESSION['house_attr']) || isset($_POST['unit_attributes'])){
                                $tab3 = 'active';
                            }
                            else{
                                $tab1 = 'active';
                            }
                            ?>
                            <li class="<?php echo $tab1; ?>"><a href="#tab_1_1" data-toggle="tab"><i class="icon-user"></i> Profile Info</a></li>
                            <li class="<?php echo $tab2; ?>"><a href="#tab_1_2" data-toggle="tab"><i class="icon-map-marker"></i> Unit services</a></li>
                            <li class="<?php echo $tab3; ?>"><a href="#tab_1_3" data-toggle="tab"><i class="icon-map-marker"></i> Unit Attributes</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane <?=$tab1; ?> profile-classic row-fluid"  id="tab_1_1">

                                <?php if(isset($_GET['house_id'])){
                                    include_once "house_profile_info.php";
                                }
                                ?>
                            </div>

                            <div class="tab-pane <?=$tab2; ?> profile-classic row-fluid" id="tab_1_2">
                                <?php if(isset($_GET['house_id'])){
                                    include "house_services_info.php";
                                }
                                ?>
                            </div>   <div class="tab-pane <?=$tab3; ?> profile-classic row-fluid" id="tab_1_3">
                                <?php if(isset($_GET['house_id'])){
                                    include "house_alloc.php";
                                }
                                ?>
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
    <?php set_js(array('src/js/house_profile.js')); } ?>