<?php
    include_once 'src/models/Payment.php';
    $payment = new Payment();

    set_layout("dt-layout.php", array(
      'pageSubTitle' => 'Search for a Bill',
      'pageSubTitleText' => 'Over the counter bills',
      'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'url'=>'?num=139', 'text'=>'Payment and Bills' ),
        array ( 'text'=>'Pay Bill' )
      )
    ));

    $payment->splash('otc');
    (isset($_SESSION['warnings'])) ? $payment->displayWarnings('warnings') : '';
?>

<div class="widget">
  <div class="widget-title">
    <h4><i class="icon-reorder"></i> Search for Bills</h4>
  </div>
  <div class="widget-body form">

     <form name="cdetails" method="post" action="" class="form-horizontal">
      <div class="row-fluid">
        <div class="span6">
          <div class="control-group">
            <label for="account_type" class="control-label">Revenue Channel:<span class="required">*</span></label>
            <div class="controls">
              <select name="service_account_type" class="packinput span12">
                 <option value="">--All Bill--</option>
                 <?php
                     $categories=run_query("select * from revenue_channel");
                     while ($fetch=get_row_data($categories))
                         {
                         echo "<option value='".$fetch['revenue_channel_id']."'>".$fetch['revenue_channel_name']."</option>";
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
            <label for="account_no" class="control-label">House Number:<span class="required">*</span></label>
            <div class="controls">
              <input type="text" name="service_account" value="" required class="span12 m-wrap popovers" data-trigger="hover" required>
            </div>
          </div>
        </div>
      </div>
      <div class="form-actions">
        <input type="hidden" name="details"/>
        <?php //viewActions($_GET['num'], $_SESSION['role_id']); ?>
          <button class="btn btn-primary">Search</button>
      </div>
</form>
</div>
</div>

<?php
    if(isset($_POST['details'])){
        $service_account_type = $_POST['service_account_type'];
        $serviceaccount = trim($_POST['service_account']);
        $bill_balances = array();
?>
<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> Bills for Service Account: <span style="color: green;"><?php echo $serviceaccount; ?></span> </h4>
        <span class="actions">
            <button class="btn btn-small btn-success" data-target="#bulk_payment" data-toggle="modal"><i class="icon-money"></i> Payment</button>
        </span>
    </div>
    <div class="widget-body form">
        <?php
            $condition = (!empty($service_account_type)) ? " AND s.revenue_channel_id = '" . $service_account_type . "' ": '';
            $distinctQuery = "select c.*, s.* from customer_bills c
            LEFT JOIN service_channels s ON s.service_channel_id = c.service_channel_id
            where c.service_account='$serviceaccount' and bill_balance > 0 $condition";
//            echo $distinctQuery;
            $resultId = run_query($distinctQuery);
            $total_rows = get_num_rows($resultId);
            if ($total_rows > 0) {
        ?>
        <table id="table1" class="table table-bordered">
            <thead>
                <tr>
                    <th>B.ID#</th>
                    <th>B.Date</th>
                    <th>Service</th>
                    <th>Bill Balance</th>
                    <th>Due.Date</th>
<!--                    <th>ACTION</th>-->
                </tr>
            </thead>
            <tbody>
            <?php
                while ($row = get_row_data($resultId)) {
                    $trans_id = trim($row['bill_id']);
//                    $service_bill_id = trim($row['service_bill_id']);
                    $serviceaccount = $row['service_account'];
                    $bill_date = date("d-m-Y", strtotime($row['bill_date']));
                    $due_date = date("d-m-Y", strtotime($row['bill_due_date']));
                    // $end_date = date("d-m-Y H:i:s",$row['time_out']);
                    $bill_name = $row['service_option'];
                    // $parking_type = $row['parking_type_id'];
//                    $revenue_channel_name = $row['revenue_channel_name'];
                    $status = $row['bill_status'];
                    // $agent_id = $row['agent_id'];
                    $bill_amount = $row['bill_balance'];
                    // $clamping_flag = $row['clamping_flag'];
                    $bill_balances[] = array(
                        'service_option' => $bill_name,
                        'balance' => $bill_amount,
                        'bill_id' => $trans_id
                    );
                    ?>
                    <tr>

                        <td><?= $trans_id; ?></td>
                        <td><?= $bill_date; ?></td>
                        <td><?= $bill_name; ?></td>
                        <td>Ksh. <?= number_format($bill_amount, 2); ?></td>
                        <td><?= $due_date; ?></td>
<!--                        <td>-->
<!--                            <a href=index.php?num=140&bill_id=--><?//= $trans_id; ?><!-- class="btn btn-mini">-->
<!--                                <i class="icon-money"></i> Pay</a>-->
<!--                        </td>-->

                    </tr>
                    <?
                }
            }else{
            ?>
                <tr>
                    <td colspan="6" align="center">No bills found</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <div class="clearfix"></div>

        <form action="" id="pay_bill" method="post">
            <div id="bulk_payment" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel1"><i class="icon-money"></i> Payment</h3>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <label for="cash_received">Cash Received</label>
                        <div class="input-prepend input-append">
                            <span class="add-on">Ksh. </span><input class="m-wrap " step="any" id="cash_received" name="total_cash_received" type="number" min="1" required/><span class="add-on">.00</span>
                        </div>
                    </div>
                    <?php
                        if($bill_count = count($bill_balances)){
                            $count = 1;
                            foreach ($bill_balances as $bill){
                    ?>
                    <div class="row-fluid" bill-id="<?php echo $bill['bill_id']; ?>">
                        <label><?=$bill['service_option']; ?> (<?php echo number_format($bill['balance'], 3); ?>)</label>
                        <input type="number" step="any" name="cash_received<?php echo $count; ?>" id="tag<?php echo $count; ?>" class="span12 cash_paid_per_bill
" min="0" max="<?php echo $bill['balance']; ?>"/>
                        <input type="hidden" name="bill_id<?php echo $count; ?>" value="<?php echo $bill['bill_id']; ?>"/>
<!--                        <input type="hidden" name="serv_bill_id--><?php //echo $count; ?><!--" value="--><?php //echo $bill['bill_id']; ?><!--"/>-->
                    </div>
                    <?php $count++;}} ?>
                    <input type="hidden" id="bill_count" value="<?php echo $bill_count; ?>"/>

                    <div class="row-fluid">
                        <label for="payment_mode">Payment Mode:</label>
                        <select name="payment_mode" class="span12 payment_mode" required>
                            <option value="">--Choose Payment Mode--</option>
                            <?php
                                $pms = $payment->selectQuery('payment_mode', '*');
                                if(count($pms)){
                                    foreach ($pms as $pm){
                            ?>
                            <option value="<?php echo $pm['payment_mode_code']; ?>"><?php echo $pm['payment_mode_name']; ?></option>
                            <?php }} ?>
                        </select>
                    </div>

                    <div class="row-fluid pay_mode" style="display: none;">
                        <label for="payment_ref">Payment Ref:</label>
                        <input type="text" name="payment_ref" class="span12"/>
                    </div>

                    <div class="row-fluid">
                        <label for="received_from">Received From:</label>
                        <input type="text" name="received_from" class="span12"/>
                    </div>
                    <div class="row-fluid">
                        <label for="desc">Description:</label>
                        <textarea name="desc" class="span12" style="font-style: italic;"></textarea>
                    </div>
                    <!-- hidden fields -->
                    <input type="hidden" name="action" value="bulk_payment"/>
                    <input type="hidden" name="service_account" value="<?php echo $serviceaccount; ?>"/>
                    <input type="hidden" name="revenue_channel" value="<?php echo $service_account_type; ?>"/>
                </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button class="btn btn-primary">Submit</button>
                <?php //createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo578'); ?>
                <?php //createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav577'); ?>
            </div>
        </form>
        <div class="clearfix"></div>
    </div>
</div>
<?php }
set_js(array('src/js/bulk_payment.js'));
?>