<?php
include_once('src/models/Reciepts.php');
$receipt = new Reciepts(1);
// $usp = $receipt->getSystemSettings(usp_name);

$receipt_no = (isset($_GET['rec_no'])) ? $_GET['rec_no'] : '';
$payments = $receipt->selectQuery('receipt_data', 'SUM(cash_paid) AS subtotal, service_id as bill_name', "receiptnumber = '".$receipt_no."' GROUP BY bill_name");
$tranc_data = $receipt->selectQuery('receipt_data', '*', "receiptnumber = '".$receipt_no."'");
$tranc_data_specs = $tranc_data[0];
set_layout("dt-layout.php", array(
    'pageSubTitle' => 'County Receipt',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'text'=>'Payments & Bills' ),
        array ( 'text'=>'Receipt' )
    )
));

set_css(array(
    'assets/css/pages/invoice.css',
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
                        <h4 align="center">Customer Service Office</h4>
                        <h5 align="center">Payment Receipt</h5>
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
                            <strong>Payment Mode:</strong> <?php echo $receipt->getModeName($tranc_data_specs['payment_mode_id']); ?> <br/>
                            <strong>Payment Ref:</strong> <?php echo $tranc_data_specs['receiptnumber']; ?> <br/>
                            <strong>Receipt#:</strong> <?php echo $tranc_data_specs['receipt_id'] ?><br/>
                            <strong>House No:</strong> <?php echo $tranc_data_specs['service_account'] ?><br/>
                            <strong>Customer Name:</strong> <?php echo $tranc_data_specs['customer_name']; ?>
                      </td>
                      <td class="hidden-480">
                          <strong>DATE:</strong> <?= date('Y-m-d');?><br/>
                          <strong>Details:</strong> <?php echo $tranc_data_specs['details']; ?>
                      </td>
                  </tr>
               </tbody>
            </table>
            <table class="table table-striped table-condensed table-hover" style="width: 100%">
               <thead>
                  <tr>
                  	<th>#</th>
                    <th>Service</th>
                    <th>Amount Paid</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                    $count = 1;
                    $total = 0;
//                    var_dump($payments);exit;
                    if(count($tranc_data)){
                        foreach ($tranc_data as $transaction){
                            $total = $total + $transaction['cash_paid'];
                ?>
                <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $receipt->getService($transaction['service_id']); ?></td>
                    <td><?php echo number_format(round($transaction['cash_paid'],2),2); ?></td>
                </tr>
                <?php $count++;}} ?>
                </tbody>
                <tfoot>
                	<tr>
                		<th colspan="2" style="text-align: right; font-weight:bold;">Total Amount Paid</th>
                		<th style="text-align: left; font-weight:bold; text-decoration: underline"><?php echo number_format(round($total, 2), 2); ?></th>
                	</tr>
                </tfoot>
            </table>
              <table class="table table-condensed" style="margin:0px;">
               <tbody>
                  <tr>
                    <td class="hidden-480">
                          <div>
                              <?php $data= $receipt->servedBy($tranc_data_specs['transacted_by']); ?>
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
