<?php
include_once 'src/models/Plots.php';
include_once 'src/models/House.php';
$prop = new Plots();
$House = new House();
if(App::isAjaxRequest()){
    if(isset($_POST['action'])) {
        $action = $_POST['action'];
        switch ($action) {
            case 'edit-house-details':
                $result = $House->selectQuery('houses','*'," house_id = '".$_POST['house_id']."' ");
                echo json_encode($result[0]);
                break;
            case 'edit-property-attribute';
                $result = $prop->selectQuery('property_attr_alloc','value',"unit_alloc_id ='".$_POST['edit_id']."' ");
                echo json_encode($result[0]);
                break;
            case 'attach_service_to_property':
                logAction($action, $_SESSION['sess_id'], $_SESSION['mf_id']);
                $json = $prop->attachPropertyService($_POST['service_id'], $_POST['prop_id']);
                echo json_encode($json);
                break;

            case 'detach_service_from_property':
                logAction($action, $_SESSION['sess_id'], $_SESSION['mf_id']);

                $json = $prop->detachPropertyService($_POST['service_id'], $_POST['prop_id']);
                echo json_encode($json);
                break;
            case 'check_attached':
                logAction($action, $_SESSION['sess_id'], $_SESSION['mf_id']);
                //echo $_POST['prop_id'];
                $house_services = $prop->selectQuery('property_services', '*', "plot_id = '" .$_POST['prop_id']."'");
                // collect all the service ids attached to the selected house
                $hs_service_ids = array();
                if(count($house_services)){
                    foreach ($house_services as $house_service){
                        $hs_service_ids[] = $house_service['service_channel_id'];
                    }
                }

                $return = array();
                $leaf_services = $House->getAllServices(Leaf_Service);
                if(count($leaf_services)){
                    foreach ($leaf_services as $leaf_service){
                        if(in_array($leaf_service['service_channel_id'], $hs_service_ids)){
                            $return[] = $leaf_service['service_channel_id'];
                        }
                    }
                }

                echo json_encode($return);
                //echo json_encode($ajax);
                break;
        }


    }else if(isset($_GET['action'])) {
        $action = $_GET['action'];
        switch ($action){
            case 'search_services':
                $key = strtolower(trim($_GET['search_key']));

                $services = $prop->selectQuery('service_channels', 'service_option, option_code, service_channel_id, price',
                    "service_option_type = '".leaf."' AND status IS TRUE
                    AND (lower(service_option) LIKE '%".$key."%' OR lower(option_code) LIKE '%".$key."%')");
                $return = array();
                if(count($services)){
                    foreach($services as $service){
                        $return[] = array(
                            'service_option' => $service['service_option'],
                            'service_channel_id' => $service['service_channel_id'],
                            'price' => $service['price'],
                            'option_code' => $service['option_code']
                        );
                    }
                }
                echo json_encode($return);
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
        (isset($_GET['house_id']))? array ( 'url'=>'?num=view_houses', 'text'=>'All units') :array ( 'url'=>'?num=3001', 'text'=>'All Properties'),
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
    'assets/css/pages/profile.css',
    'src/css/fancy-checkbox.css',
    'src/css/sticky.css'
));

set_js(array(
    'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
));


?>

<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> <span style="color: green;"><?php $House->getAppropriateName(); ?></span></h4>
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
                            $tab4 = "";
                            if(isset($_SESSION['p_services'])){
                                $tab2 = 'active';
                            }elseif (isset($_SESSION['p_units']) || isset($_POST['tab-three'])){
                                $tab3= 'active';
                            }elseif (isset($_SESSION['prop_attr'])){
                                $tab4 = 'active';
                            }
                            else{
                                $tab1 = 'active';
                            }
                            ?>
                            <li class="<?=$tab1; ?>"><a href="#tab_1_1" data-toggle="tab"><i class="icon-user"></i> Property Info</a></li>
                            <li class="<?=$tab2; ?>"><a href="#tab_1_2" data-toggle="tab"><i class="icon-barcode"></i> Property services</a></li>
                            <li class="<?=$tab3; ?>"><a href="#tab_1_3" data-toggle="tab"><i class="icon-list-alt"></i> Property units</a></li>
                            <li class="<?=$tab4; ?>"><a href="#tab_1_4" data-toggle="tab"><i class="icon-sitemap"></i> Property Attributes</a></li>

                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane <?=$tab1; ?> profile-classic row-fluid"  id="tab_1_1">

                                <?php if(isset($_GET['prop_id'])){
                                    include_once 'property_profile_info.php';
                                }
                                ?>
                            </div>

                            <div class="tab-pane <?=$tab2; ?> profile-classic row-fluid" id="tab_1_2">
                                <?php if(isset($_GET['prop_id'])){
                                    include_once 'property_service_info.php';
                                }
                                ?>
                            </div>

                            <div class="tab-pane <?=$tab3; ?> profile-classic row-fluid" id="tab_1_3">
                                <?php if(isset($_GET['prop_id'])){
                                    include_once "property_units.php";
                                }
                                ?>
                            </div><div class="tab-pane <?=$tab4; ?> profile-classic row-fluid" id="tab_1_4">
                                <?php if(isset($_GET['prop_id'])){
                                    include_once "prop_alloc.php";
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
<?php set_js(array('src/js/property_profile.js')); } ?>
