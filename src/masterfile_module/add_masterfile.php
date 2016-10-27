<?php
    include_once('src/models/Masterfile.php');
    $mf = new Masterfile();

    include_once('src/models/Accounts.php');
    $acc = new Accounts();

    if(App::isAjaxRequest()){
        $acc->getBankBranchesByBankId($_POST['bank_id']);
    }else{
        set_layout("wizard-layout.php", array(
          'pageSubTitle' => 'Add Masterfile',
          'pageSubTitleText' => '',
          'pageBreadcrumbs' => array (
            array ( 'url'=>'index.php', 'text'=>'Home' ),
            array ( 'text'=>'Add masterfile' )
          ),
           'pageWidgetTitle'=>'Add Masterfile Record'
        ));
        set_js(array(
          'src/js/submit_wizard_form.js',
          'src/js/add_masterfile.js'
        ));
?>
<div class="widget box blue" id="form_wizard_1">
   <div class="widget-title">
      <h4>
         <i class="icon-reorder"></i> Add Masterfile Details - <span class="step-title">Step 1 of 2</span>
      </h4>
   </div>
   <div class="widget-body form">
      <?php
        $mf->splash('mf');
        // display all encountered errors
        (isset($_SESSION['mf_warnings'])) ? $mf->displayWarnings('mf_warnings') : '';
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
                        <span class="desc"><i class="icon-ok"></i> Personal Details</span>   
                        </a>
                     </li>
                     <li class="span3">
                        <a href="#tab2" data-toggle="tab" class="step <?php echo (isset($_SESSION['tab2'])) ? 'active' : ''; ?>">
                        <span class="number">2</span>
                        <span class="desc"><i class="icon-ok"></i> Address Details</span>   
                        </a>
                     </li>
                      <li class="span3">
                          <a href="#tab3" data-toggle="tab" class="step <?php echo (isset($_SESSION['tab3'])) ? 'active' : ''; ?>">
                              <span class="number">3</span>
                              <span class="desc"><i class="icon-ok"></i>Account Details</span>
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
                  <h3 class="form-section">Provide personal details</h3>
                  <?php include "personal_details.php"; ?>
               </div>

               <div class="tab-pane <?php echo (isset($_SESSION['tab2'])) ? 'active' : ''; ?>" id="tab2">
                  <h3 class="form-section">Provide address details</h3>
                  <?php include "address_details.php"; ?>
               </div>

                <div class="tab-pane <?php echo (isset($_SESSION['tab3'])) ? 'active' : ''; ?>" id="tab3">
                    <h3 class="form-section">Provide account details</h3>
                    <?php include "account_details.php"; ?>
                </div>
            </div>

            <div class="form-actions clearfix">
                <input type="hidden" name="action" value="add_masterfile"/>
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
<?php } ?>