<?
if(isset($_GET['service_name']) && $_GET['serv_id']){
  $service_name = $_GET['service_name'];
  $service_id = $_GET['serv_id'];
  $price = $_GET['price'];
  $rev_id = $_GET['rev_id'];
}
set_layout("form-layout.php", array(
    'pageSubTitle' => 'Buy Service',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'url'=>'#', 'text'=>'PAYMENT & BILLS' ),
        array ( 'url'=>'?num=165', 'text'=>'Buy Service' ),
        array ( 'url'=>'?num=166&rev_id='.$rev_id, 'text'=>'Buy Service Tree' ),
        array ( 'text'=>'Buy Service')
    ),
    'pageWidgetTitle'=>'Buy Service - '.$service_name.' Price: '.$price
));

if(isset($_SESSION['parking'])){
  echo $_SESSION['parking'];
  unset($_SESSION['parking']);
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

<form name="parking_bills" id="parking_bills" method="post" action="" class="form-horizontal">
    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label for="service_account" class="control-label">Service Account</label>
                <div class="controls">
                    <input type="text" class="span12" name="service_account" required/>
                </div>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label for="cash_received" class="control-label">Cash Received</label>
                <div class="controls">
                    <input type="number" class="span12" readonly value="<?=$price; ?>" name="cash_received" required/>
                </div>
            </div>
        </div>
    </div>
    <?php
        //get the revenue_channel_code
        $result = run_query("SELECT revenue_channel_code FROM revenue_channel WHERE revenue_channel_id = '".$rev_id."'");
        $rows = get_row_data($result);
        $revenue_channel_code = $rows['revenue_channel_code'];
    ?>

    <?php
        //get the service_option_code
        $result = run_query("SELECT option_code FROM service_channels WHERE revenue_channel_id = '".$rev_id."'");
        $rows = get_row_data($result);
        $service_option_code = $rows['option_code'];
    ?>
    <input type="hidden" name="revenue_channel_code" value="<?=$revenue_channel_code; ?>"/>
    <input type="hidden" name="service_id" value="<?=$service_id; ?>"/>
    <input type="hidden" name="service_option_code" value="<?=$service_option_code; ?>"/>
    <input type="hidden" name="action" value="buy_service_form"/>
    <input type="hidden" name="price" value="<?=$price; ?>">
    <input type="hidden" name="revenue_channel_id" value="<?=$rev_id; ?>"/>
    <div class="form-actions">
       <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
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
    "src/js/go_back.js",
    "src/js/get_bill_amount.js"
));