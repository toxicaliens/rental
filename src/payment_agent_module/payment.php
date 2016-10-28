<?php
include_once 'src/model/Payment.php';
$payment = new Payment();

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

   $distinctQuery2 = "SELECT c.*, m.*, r.* FROM customer_bills c
   LEFT JOIN masterfile m ON m.mf_id = c.mf_id
   LEFT JOIN revenue_channel r ON r.revenue_channel_id = c.revenue_channel_id
   WHERE bill_id = '".$bill_id."'";
   $resultId2 = run_query($distinctQuery2);
   $row = get_row_data($resultId2);

   $full_name = $row['surname'].' '.$row['firstname'].' '.$row['middlename'];
   $bill_balance = $row['bill_balance'];
   $service_account_type_name = $row['revenue_channel_name'];
   $service_account = $row['service_account'];
   $mf_id = $row['mf_id'];
   $rev_chan_id = $row['revenue_channel_id'];
   $bill_amount = $row['bill_amt'];
   $amount_paid_so_far = $row['total_cash_received'];
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
      Account Type: <span style="color:green;"><?=$service_account_type_name; ?></span> 
      Amount Paid: <span style="color:green;"><?php if(empty($amount_paid_so_far)) echo 0; else echo $amount_paid_so_far; ?></span>
    </h4>
  </div>
  <div class="widget-body form">
    <?php
    (isset($_SESSION['warnings'])) ? $payment->displayWarnings('warnings') : '';
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
              <input type="number" name="amount_paid" title="The cash received should not be higher than the bill amount." max="<?=$bill_amount; ?>" class="span12" required>
              <span class="help-block hide">The cash received should not be higher than the bill amount.</span>
            </div>
          </div>
        </div>
        <div class="span6">
          <div class="control-group">
            <label for="option_code" class="control-label">Service Option:</label>
            <div class="controls">
              <select name="option_code" class="span12 live_search" required>
                <option value="">--Choose Service Option--</option>
                <?php
                  $result = run_query("SELECT * FROM service_channels");
                  while ($rows = get_row_data($result)) {
                    $service_channel_id = $rows['service_channel_id'];
                    $option_code = $rows['option_code'];
                    $service_option = $rows['service_option'];
                    echo "<option value=\"$service_channel_id\">$service_option [$option_code]</option>";
                  }
                ?>
              </select>
            </div>
          </div>
        </div>
      </div>
        
      <div class="row-fluid">
          <div class="span6">
              <div class="control-group">
                  <label for="received_from" class="control-label">Received From</label>
                  <div class="controls">
                      <input type="text" name="received_from" class="span12"/>
                  </div>
              </div>
          </div>
        <div class="span6">
          <div class="control-group">
            <label for="agent" class="control-label">Staff<span class="required">*</span></label>
            <div class="controls">
              <select name="agent" class="span12" required>
                <?php
                  $query = "SELECT * FROM masterfile WHERE mf_id = '".$_SESSION['mf_id']."'";
                  $result = run_query($query);
                  $staff = get_row_data($result);
                ?>
                <option value="<?=$staff['mf_id']; ?>"><?=$staff['surname'].' '.$staff['firstname'].' '.$staff['middlename']; ?></option>
              </select>
            </div>
          </div>
        </div>
      </div>
         <div class="row-fluid">
             <div class="span6">
                 <div class="control-group">
                     <label for="description" class="control-label">Description:</label>
                     <div class="controls">
                         <textarea name="description" class="span12"></textarea>
                     </div>
                 </div>
             </div>
         </div>
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
      <input type="hidden" name="revenue_channel" value="<?=$rev_chan_id; ?>"/>
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