<?php
include_once('src/model/Reciepts.php');
$order_id = (isset($_GET['order_id'])) ? $_GET['order_id'] : '';
$receipt = new Reciepts($order_id);
set_layout("dt-layout.php", array(
    'pageSubTitle' => 'County Receipt',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'text'=>'Payments' ),
        array ( 'url'=>'index.php?num=145', 'text'=>'All Transactions' ),
        array ( 'text'=>'View Receipts' )
    )
));

set_css(array(
    'assets/css/pages/invoice.css',
    'assets/css/pages/invoice.css' 
));

set_js(array(
    'assets/plugins/data-tables/jquery.dataTables.js',
    'assets/plugins/data-tables/DT_bootstrap.js'
));
$path = usp_logo;
$Gok = usp_kenya;
?>
 <!-- BEGIN PAGE CONTAINER-->
<div class="container-fluid">    
<div id="page">
   <div class="invoice">
            <table class="table table-condensed" style="margin:0px;">
                  <tr>
                      <td class="hidden-480">
                        <img src='data:image/JPG;base64,<?php echo base64_encode(file_get_contents("$path")); ?>' alt="" width="115" height="115" />
                      </td>
                     <td class="hidden-480">
                        <br />
                        <h3 align="center"><strong><?php echo usp_name; ?></strong></h3>
                        <h4 align="center">CUSTOMER SERVICE OFFICE</h4>
                        <h4 align="center">PAYMENT RECEIPT</h4>
                     <td>
                     <td class="hidden-480">
                        <img src='data:image/JPG;base64,<?php echo base64_encode(file_get_contents("$Gok")); ?>' alt="" width="115" height="115" align="right"/>
                      </td>
                  </tr> 
            </table>
            <table class="table table-condensed" style="margin:0px;">
               <tbody>
                  <tr>
                      <td class="hidden-480">
                         <strong>Order No:</strong> <?php echo (isset($_GET['order_id'])) ? $_GET['order_id'] : ''; ?> <br/>
                         <strong>Payment Ref:</strong> <?php echo $receipt->getPaymentId($order_id); ?> <br/>
                         <strong>Customer Name:</strong> <?php echo $receipt->getCustomerName($order_id); ?>
                     </td>
                     <td class="hidden-480">
                      <strong>DATE:</strong> <?= date('Y-m-d');?>
                     </td>   
                  </tr>
               </tbody>
            </table>
            <table class="table table-bordered table-condensed" style="margin:0px;">
               <thead>
                  <tr>
                  	<th>#</th>
                    <th>Service</th>
                    <th>Service Account</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody>
                	<?php
                		$rec_data = $receipt->getReceiptData();
                		$counter = 1;
                		if(count($rec_data)){
                			foreach ($rec_data as $data) {
                	?>
	                <tr>
	                	<td><?php echo $counter; ?></td>
	                    <td><?=$data['service_option']; ?></td>
	                    <td><?=$data['service_account']; ?></td>
	                    <td><?=$data['quantity']; ?></td>
	                    <td><?=$data['unit_price']; ?></td>
	                    <td class="subtotal"><?=$data['subtotal']; ?></td>
	                </tr>
	                <?php $counter++;}} ?>
                </tbody>
                <tfoot>
                	<tr>
                		<td colspan="5" style="text-align: right; font-weight:bold;"><strong>Total Amount</strong></td>
                		<td id="total_amount" style="text-align: left; font-weight:bold; text-decoration: underline"></td>
                	</tr>
                </tfoot>
                
            </table>
              <table class="table table-condensed" style="margin:0px;">
               <tbody>
                  <tr>
                    <td class="hidden-480">
                          <div>
                              <?php
                              $data= $receipt->servedBy($_SESSION['mf_id']);
                              ?>
                              <strong>You were served by:</strong> <?=$data['surname'].' '.$data['firstname'].' '.$data['middlename']; ?> <br />
                          </div>
                      </td>
                     <td class="hidden-480">
                        <br />
                        <br />
                      <a class="btn btn-success btn-large hidden-print" onclick="javascript:window.print();">Print <i class="icon-print icon-big"></i></a>
                     <td>
                  </tr>
               </tbody>
            </table>    
   </div>
</div>
</div>

<!-- END PAGE CONTENT-->
<?php set_js(array("src/js/get_bill_amount.js")); ?>
