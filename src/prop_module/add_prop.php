<?php
    include_once 'src/models/Plots.php';
    $prop = new Plots();

    if(App::isAjaxRequest()) {
        if (!empty($_POST['edit_id'])){
            $prop->getPlotByPlotId($_POST['edit_id']);
        }
        if (!empty($_POST['id'])) {
            $prop->getOptionDataById($_POST['id']);
        }
    }else{
    set_title('Add Property Wizard');
    /**
     * Set the page layout that will be used
     */
    set_layout("wizard-layout.php", array(
        'pageSubTitle' => 'Add Property',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array (
            array ( 'url'=>'index.php', 'text'=>'Home' ),
            array ( 'text'=>'Property Management' ),
            array ( 'text'=>'Add Properties' )
        ),
        'pageWidgetTitle'=>'Add Property Record'
    ));
    set_js(array(
        'src/js/submit_wizard_form.js',
        'src/js/add_property.js',
        'src/js/plots.js'
    ));

?>
<div class="widget box blue" id="form_wizard_1">
    <div class="widget-title">
        <h4>
            <i class="icon-reorder"></i> Add Property Details <span class="step-title">Step 1 of 2</span>
        </h4>
    </div>
    <div class="widget-body form">
        <?php
        $prop->splash('plots');
        // display all encountered errors
        (isset($_SESSION['warnings'])) ? $prop->displayWarnings('warnings') : '';
        ?>

        <div class="alert alert-error hide">
            <button class="close" data-dismiss="alert">&times;</button>
            You have some form errors. Please check below.
        </div>
        <div class="alert alert-success hide">
            <button class="close" data-dismiss="alert">&times;</button>
            Your form validation is successful!
        </div>
        <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
            <div class="alert alert-error hide">
                <button class="close" data-dismiss="alert">&times;</button>
                You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
                <button class="close" data-dismiss="alert">&times;</button>
                Your form validation is successful!
            </div>

            <div class="form-wizard">
                <div class="navbar steps">
                    <div class="navbar-inner">
                        <ul class="row-fluid">
                            <li class="span3">
                                <a href="#tab1" data-toggle="tab" class="step <?php echo (isset($_SESSION['tab1'])) ? 'active' : ''; ?>">
                                    <span class="number">1</span>
                                    <span class="desc"><i class="icon-ok"></i> Property Details</span>
                                </a>
                            </li>
                            <li class="span3">
                                <a href="#tab2" data-toggle="tab" class="step <?php echo (isset($_SESSION['tab2'])) ? 'active' : ''; ?>">
                                    <span class="number">2</span>
                                    <span class="desc"><i class="icon-ok"></i> Location Details</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="bar" class="progress progress-success progress-striped">
                    <div class="bar"></div>
                </div>
                <div class="tab-content">

                    <div class="tab-pane <?php  echo (isset($_SESSION['tab1'])) ? 'active' : ''; ?>" id="tab1">
                        <h3 class="form-section">Provide Property details</h3>
                        <?php include "add_prop_details.php"; ?>
                    </div>

                    <div class="tab-pane <?php echo (isset($_SESSION['tab2'])) ? 'active' : ''; ?>" id="tab2">
                        <h3 class="form-section">Provide address details</h3>
                        <?php include "prop_location_details.php"; ?>
                    </div>
                </div>

                <div class="form-actions clearfix">
                    <input type="hidden" name="action" value="add_property"/>
                    <a href="javascript:;" class="btn button-previous">
                        <i class="icon-angle-left"></i> Back
                    </a>
                    <a href="javascript:;" class="btn btn-primary blue button-next">
                        Continue <i class="icon-angle-right"></i>
                    </a>
                    <button id="submit_wizard_contents" class="btn btn-success button-submit">
                        Submit <i class="icon-ok"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php  } ?>
