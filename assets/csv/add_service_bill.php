<?
if(!empty($_SESSION['cus_mf_id']))
    $mf_id = $_SESSION['cus_mf_id'];
set_layout("form-layout.php", array(
    'pageSubTitle' => 'Add New Service Bill',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'url'=>'?num=163', 'text'=>'Select Customer'),
        array ( 'url'=>'index.php?num=146', 'text'=>'Bills' ),
        array ( 'text'=>'Add Service Bills' )
    ),
    'pageWidgetTitle'=>'Add Service Bill - Step 2 of 2'
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
                <label for="packlabel" class="control-label">Bill due Date</label>
                <div class="controls">
                    <input type="text" class="date-picker" name="bill_due_date" required/>
                    <!-- <input type="text" name="bill_due_date" value="" 
                    class="packinput" onclick="displayDatePicker('bill_due_date',this,'ymd','-')"> -->
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="control-group">
                <label for="packlabel" class="control-label">Amount</label>
                <div class="controls">
                  <input type="text" name="bill_amt" value="" readonly id="bill_amount" class="packinput" required>
                </div>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label for="packlabel" class="control-label">Service bill</label>
                <div class="controls">
                    <select name="service_bill_id" id="service_bill_id" class="packinput" required>
                        <option value="">--Choose Service--</option>
                   <?php
                        $query = "select * FROM revenue_service_bill";
                        $categories=run_query($query);
                         while ($fetch=get_row_data($categories))
                         {
                         echo "<option value='".$fetch['revenue_bill_id']."'>".
                         $fetch['bill_name']."</option>";
                         }
                         ?>
                     </select>
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="control-group">
                <label for="packlabel" class="control-label">sms notification</label>
                <div class="controls">
                  <select name="sms_notification" class="packinput">
                         <option value="1">Sent</option>
                         <option value="0">Not SENT</option>
                     </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label for="packlabel" class="control-label">Service account type<span class="required">*</span></label>
                <div class="controls">
                    <select name="service_account_type" class="packinput" required>
                        <option value="">--Choose Revenue Channel--</option>
                    <?php
                        $categories=run_query("select * from revenue_channel");
                         while ($fetch=get_row_data($categories))
                         {
                         echo "<option value='".$fetch['revenue_channel_id']."'>".
                                            $fetch['revenue_channel_name']."</option>";
                         }
                         ?>
                     </select>
                </div>
            </div>
        </div>
        
        <div class="span6">
            <div class="control-group">
                <label for="packlabel" class="control-label">email notification</label>
                <div class="controls">
                    <select name="email_notification" class="packinput">
                         <option value="1">Sent</option>
                         <option value="0">Not SENT</option>
                     </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label for="packlabel" class="control-label">Service Account</label>
                <div class="controls">
                  <input type="text" name="service_account" value=""  class="packinput" required>
                </div>
            </div>
        </div>  
        <div class="span6">
            <div class="control-group">
                <label for="description" class="control-label">Description:</label>
                <div class="controls">
                    <textarea name="description"></textarea>
                </div>
            </div>
        </div>
        
    </div>

     <div class="row-fluid">
        
     </div>
     <input type="hidden" name="action" value="add_service_bills"/>
     <input type="hidden" name="customer_id" value="<?php if(isset($mf_id)) echo $mf_id; ?>"/>
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
    "src/js/get_service_bill_amt.js"
));