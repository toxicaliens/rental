<?
set_layout("form-layout.php", array(
    'pageSubTitle' => 'Select a Customer',
    'pageSubTitleText' => 'Select the customer you want to attach the bill to',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'url'=>'#', 'text'=>'Payment & Bills' ),
        array ( 'url'=>'index.php?num=146', 'text'=>'Bills' )
    ),
    'pageWidgetTitle'=>'Select Customer - Step 1 of 2'
));

if(isset($_POST['mf_id'])){
    $_SESSION['cus_mf_id'] = $_POST['mf_id'];
        
    App::redirectTo('index.php?num=150');
}
?>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
	//initiate validator on load
	$(function() {
		// validate contact form on keyup and submit
		$("#parking_bills").validate({
			//set the rules for the fild names
			rules: {
				bill_due_date: {
					required: true,
				},
				bill_amt: {
					required: true,

				},
				service_account: {
                                       required: true,
				},
			},
			//set messages to appear inline
			messages: {
				bill_due_date: "Please enter due date",
				bill_amt: "Please enter amount",
				service_account: "Please enter service account",
			}
		});
	});
</script>
<div>

        <div style="float:right; width:100%; text-align:left;">

        </div>
        <div style="clear:both;"> </div>

    </div>
<br/>
                                                    
                                                    <!-- BEGIN FORM -->

    <form name="select_customer" id="select_customer" method="post" action="" class="form-horizontal">

    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label for="packlabel" class="control-label">Customer</label>
                <div class="controls">
                  <select id="select2_sample2" name="mf_id" class="packinput span12">
                    <option value="">--Select Customer--</option>
                    <?php
                        $categories=run_query("SELECT * from masterfile WHERE b_role = 'client'");
                         while ($fetch=get_row_data($categories))
                         {
                         echo "<option value='".$fetch['mf_id']."'>".$fetch['surname']." ".$fetch['firstname']." ".$fetch['middlename']."</option>";
                         }
                    ?>
                     </select>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
       <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
       <a href="?num=722" class="btn btn-success btn-small"><i class="icon-plus"></i> Add New Client</a>
      </div>           

                                       
</form>
                                    <!-- END FORM -->

<?php
//argDump($query);exit;
/**
 * Using jQuery Validator Plugin
 */
set_css(array("assets/plugins/bootstrap-datepicker/css/datepicker.css"));
set_js(array(
    "assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js",
    "assets/scripts/form-validator.js",
    "src/js/add.crm.customer.js",
    "src/js/go_back.js"
));