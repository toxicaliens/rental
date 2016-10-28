<?php
include_once('src/model/Payment.php');
$payment = new Payment;

set_layout("dt-layout.php", array(
    'pageSubTitle' => 'Buy Service',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'url'=>'#', 'text'=>'PAYMENT & BILLS' ),
        array ( 'url'=>'?num=165', 'text'=>'Buy Service' ),
        array ( 'text'=>'Buy Service')
    )
));
?>

<div class="widget">
    <div class="widget-title"><h4><i class="icon-money"></i> Buy Service</h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
        </span>
    </div>     
    <div class="widget-body form">
        <?php
            if(isset($_SESSION['parking'])){
              echo $_SESSION['parking'];
              unset($_SESSION['parking']);
            }

            if(!isset($_GET['order_id'])){
                unset($_SESSION['customer']);
            }
        ?>                                     
        <!-- BEGIN FORM -->
        <form name="parking_bills" id="parking_bills" method="post" action="" class="form-horizontal">
            <div class="row-fluid" <?php echo (isset($_SESSION['customer'])) ? 'style="display: none;"' : ''; ?>>
                <div class="span10">
                    <div class="control-group">
                        <label for="customer" class="control-label">Customer: </label>
                        <div class="controls">
                            <select class="span9 live_search" name="customer">
                                <option value="">--Choose Customer--</option>
                                <?php
                                    $customers = $payment->getAllCustomers();
                                    if(count($customers)){
                                        foreach ($customers as $customer) {
                                ?>
                                <option value="<?php echo $customer['mf_id']; ?>">
                                    <?php echo $customer['full_name'].' - '.$customer['id_passport']; ?>
                                </option>
                                <?php }} ?>
                            </select>
                            <button onclick="return false;" id="new_customer" class="btn btn-success btn-small span3 popovers" data-trigger="hover" data-content="If the customer does not exist in the select list, you can click here to add a new customer." title="Add Customer Masterfile"><i class="icon-plus"></i> Add New Customer</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span10">
                    <div class="control-group">
                        <label for="service_account" class="control-label">Service Account:</label>
                        <div class="controls">
                            <input type="text" class="span12" name="service_account" required/>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="row-fluid">
                <div class="span10">
                    <div class="control-group">
                        <label for="revenue_channel" class="control-label">Revenue Channel:</label>
                        <div class="controls">
                            <select name="revenue_channel" id="revenue_channel" class="live_search span12" required>
                                <option value="">--Choose Revenue Channel--</option>
                                <?php
                                    // $rev_result = $payment->getAllRevenueChannels();
                                    // while($rows = get_row_data($rev_result)){
                                ?>
                                <option value="<?php //echo $rows['revenue_channel_id']; ?>"><?php //echo $rows['revenue_channel_name']; ?></option>
                                <?php //} ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="row-fluid">
                <div class="span10">
                    <div class="control-group">
                        <label for="service_option" class="control-label">Service Option:</label>
                        <div class="controls">
                            <select name="service_option" class="span12 live_search" id="service_option" required>
                                <option value="">--Choose Service Option--</option>
                                <?php
                                    $leaves = $payment->getLeafOptions();
                                    if(count($leaves)){
                                        foreach($leaves as $leaf){
                                ?>
                                <option value="<?php echo $leaf['service_channel_id']; ?>"><?php echo $leaf['service_option'].' - '.$leaf['option_code']; ?></option>
                                <?php }} ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span5">
                    <div class="control-group">
                        <label for="price" class="control-label">Quantity:</label>
                        <div class="controls">
                            <input type="number" min="1" name="quantity" class="span12" required/>
                        </div>
                    </div>
                </div>

                <div class="span5">
                    <div class="control-group">
                        <label for="price" class="control-label">Unit Price:</label>
                        <div class="controls">
                            <input type="text" name="price" id="price" class="span12" value="0" required readonly>
                        </div>
                    </div>
                </div>
            </div>
            <!-- hidden fields -->
            <input type="hidden" name="order_id" value="<?php echo (isset($_GET['order_id'])) ? $_GET['order_id'] : ''; ?>">
            <input type="hidden" name="action" value="buy_service_form">
            <div class="form-actions">
               <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
            </div>    
        </form>
        <!-- END FORM -->
    </div>
</div>

<?php
if(isset($_GET['order_id'])){
?>
<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> Order Items <?php echo (!empty($_SESSION['customer'])) ? 'for '.$payment->getFullNameByMfid($_SESSION['customer']) : ''; ?></h4></div>
    <div class="widget-body form">
        <form action="" method="post" class="form-horizontal">
            <table class="table table-stripped table-hover">
                <thead>
                    <tr>
                        <!-- <th>Items#</th> -->
                        <th>#</th>
                        <th>Service Account</th>
                        <!-- <th>Customer</th> -->
                        <th>Service Option</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $rows = $payment->getOrderItems($_GET['order_id']);
                        if(count($rows)){
                            $count = 1;
                            foreach ($rows as $row) {
                    ?>
                    <tr>
                        <!-- <td><?php //echo $row['order_item_id']; ?></td> -->
                        <td>
                            <?php echo $count; ?>
                            <input type="hidden" name="order_item_id<?php echo $count; ?>" value="<?php echo $row['order_item_id']; ?>"/>
                        </td>
                        <td><?php echo $row['service_account']; ?></td>
                        <!-- <td><?php //echo $row['customer_name']; ?></td> -->
                        <td><?php echo $row['service_option']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td style="text-align: left;"><?php echo $row['unit_price']; ?></td>
                        <td class="subtotal"><?php echo $row['subtotal']; ?></td>
                    </tr>
                    <?php
                        $count++;}}
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" style="text-align: right; font-weight:bold;">Total Amount</td>
                        <td style="text-align: left; font-weight:bold; text-decoration: underline" id="total_amount"></td>
                    </tr>
                </tfoot>
            </table>
            <div class="clearfix"></div>
            <br/>

            <div class="row-fluid">
                <div class="span6">
                    <div class="control-group">
                        <label for="revenue_channel" class="control-label">Payment Mode:</label>
                        <div class="controls">
                            <select name="payment_mode" id="payment_mode" class="live_search span12" required>
                                <option value="">--Choose Payment Method--</option>
                                <?php
                                    $modes = $payment->getPaymentModes();
                                    // var_dump($modes);exit;
                                    if(count($modes)){
                                        foreach ($modes as $mode) {
                                ?>
                                <option value="<?php echo $mode['payment_mode_code']; ?>"><?php echo $mode['payment_mode_name']; ?></option>
                                <?php }} ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row-fluid" style="display: none;" id="reference">
                <div class="span6">
                    <div class="control-group">
                        <label for="ref" class="control-label">Reference#:</label>
                        <div class="controls">
                            <input type="text" name="ref" id="ref" class="span12" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- hidden fields -->
            <input type="hidden" name="amount" id="total_amt"/>
            <input type="hidden" name="action" value="process_payment"/>
            <input type="hidden" name="total_count" value="<?php echo $count - 1; ?>"/>
            <input type="hidden" name="order_id" value="<?php echo $_GET['order_id']; ?>"/>

            <div class="form-actions">
                <button class="btn btn-success">Process Payments</button>
            </div>
        </form>
    </div>
</div>
<?php } ?>

<?php set_js(array("src/js/get_bill_amount.js")); ?>