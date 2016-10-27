<?php
set_layout("dt-layout.php", array(
  'pageSubTitle' => 'Payment',
  'pageSubTitleText' => 'Allows cashier to record the payment of bills',
  'pageBreadcrumbs' => array (
    array ( 'url'=>'index.php', 'text'=>'Home' ),
    array ( 'url'=>'?num=139', 'text'=>'Payment and Bills' ),
    array ( 'text'=>'Over the Counter Payment' )
  )
));

if(isset($_SESSION['done-deal'])){
  echo $_SESSION['done-deal'];
  unset($_SESSION['done-deal']);
}

  if(isset($_GET['bill_id'])){
    $bill_id = $_GET['bill_id'];
  }

   $distinctQuery2 = "SELECT c.*, m.surname, m.firstname, m.middlename, s.service_option, s.service_channel_id FROM customer_bills c
   LEFT JOIN masterfile m ON m.mf_id = c.mf_id
   LEFT JOIN service_channels s ON s.service_channel_id = c.service_channel_id
   WHERE c.bill_id = '".$bill_id."'";
   $resultId2 = run_query($distinctQuery2);
   $row = get_row_data($resultId2);

   $full_name = $row['surname'].' '.$row['firstname'].' '.$row['middlename'];
   $bill_balance = $row['bill_balance'];
   $service_option = $row['service_option'];
   $service_account = $row['service_account'];
   $mf_id = $row['mf_id'];
   $bill_amount = $row['bill_amount'];
   $amount_paid_so_far = $row['bill_amount_paid'];
 ?>
<div>
    <div style="clear:both;"> </div>
</div>
<br/>

<div class="widget">
  <div class="widget-title">
    <h4><i class="icon-reorder"></i> 
      Pay for <span style="color:green;"><?=$full_name; ?></span> 
      Account No: <span style="color:green;"><?=$service_account; ?></span> 
      Service: <span style="color:green;"><?=$service_option; ?></span> 
      Amount Paid: <span style="color:green;"><?php if(empty($amount_paid_so_far)) echo 0; else echo $amount_paid_so_far; ?></span>
    </h4>
  </div>
  <div class="widget-body form">
    <?php
      if(empty($bill_balance)) {
        $bill_balance = 0;
      }
      if($bill_balance > 0){
    ?>
     <form name="cdetails" method="post" action="" class="form-horizontal">
      <div class="row-fluid">
        <div class="span6">
          <div class="control-group">
            <label for="bill_balance" class="control-label">Bill Balance:</label>
            <div class="controls">
              <input type="text" name="bill_balance" class="span12" readonly value="<?=$bill_balance; ?>" required/>
            </div>
          </div>
        </div>
        <div class="span6">
          <div class="control-group">
            <label for="bill_amt" class="control-label">Bill Amount:</label>
            <div class="controls">
              <input type="number" name="bill_amt" class="span12" readonly value="<?=$bill_amount; ?>" required/>
            </div>
          </div>
        </div>        
      </div>
      <div class="row-fluid">
        <div class="span6">
          <div class="control-group" id="cash">
            <label for="amount_paid" class="control-label">Cash Received:<span class="required">*</span></label>
            <div class="controls">
              <input type="number" name="amount_paid" title="The cash received should not be higher than the bill balance." max="<?=$bill_amount; ?>" class="span12" required>
              <span class="help-block hide">The cash received should not be higher than the bill balance.</span>
            </div>
          </div>
        </div>
        <div class="span6">
            <div class="control-group">
                <label for="description" class="control-label">Description:</label>
                <div class="controls">
                    <textarea name="description" class="span12"></textarea>
                </div>
            </div>
        </div>
      </div>

      <!-- hidden fields -->
      <input type="hidden" name="agent" value="<?=$_SESSION['mf_id']; ?>" class="span12" required/>
      <input type="hidden" name="option_code" value="<?php echo $row['service_channel_id']; ?>" />
      <input type="hidden" name="attached_mf_id" value="<?php echo $mf_id; ?>" />

      <div class="form-actions">
        <?php
        $query = "SELECT request_type_id FROM request_types WHERE request_type_code = '".Pay_Bill."'";
        $result = run_query($query);
        while ($row = get_row_data($result)) {
          $request_type_id = $row['request_type_id'];
        }
      ?>
        <input type="hidden" name="request_type_id" value="<?=$request_type_id; ?>"/>
      <input type="hidden" name="action" value="update_customer_bill_and_log_transaction"/>
      <input type="hidden" name="bill_id" value="<?=$bill_id; ?>"/>
      
      <input type="hidden" name="service_account" value="<?=$service_account; ?>"/>
      <input type="hidden" name="mf_id" value="<?=$mf_id; ?>"/>
        <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
      </div>
          
  </form>
  <?php }else{
    echo 'Bill was settled successfully';
  } 
?>
</div>
</div>
<? set_js(array("src/js/cash_received.js")); ?>