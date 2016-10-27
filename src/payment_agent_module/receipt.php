<?
set_layout("dt-layout.php", array(
    'pageSubTitle' => 'BILL DETAILS',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array(
        array( 'url'=>'index.php', 'text'=>'Home' ),
        array( 'text'=>'Receipt' )
    )
));

set_css(array(
    'assets/css/pages/invoice.css',
));

set_js(array(
    'assets/plugins/data-tables/jquery.dataTables.js',
    'assets/plugins/data-tables/DT_bootstrap.js'
)); 

$today = date('Y-m-d');

$distinctQuery = "SELECT * 
                    FROM payments 
               LEFT JOIN ccn_customers
                      ON payments.customer_id = ccn_customers.ccn_customer_id
               LEFT JOIN payment_mode
                      ON payments.payment_mode = payment_mode.payment_mode_name
                ORDER BY payment_id DESC LIMIT 1";

$resultId = run_query($distinctQuery);
$row = get_row_data($resultId);

$surname = $row['surname'];
$firstname = $row['firstname'];
$cust_id = $row['customer_id'];
$phone_no = $row['phone_no'];
$acc_no = $row['service_account_no'];
$payment_id = $row['payment_id'];
//$status = $row['status'];
$serv_type = $row['serv_type'];
$description = $row['description'];
$amount = $row['amount'];
$bill_id = $row['bill_id'];
$payment_mode_name = $row['payment_mode_name'];


?>
 <!-- BEGIN PAGE CONTAINER-->
<div class="container-fluid">    
<div id="page">
   <div class="invoice">
    <div class="row-fluid invoice-logo">
      <div class="span6 invoice-logo-space"><h1>County Government</h1> </div>
      <div class="span6">
        <p>Receipt # : <?=$payment_id; ?> <span class="muted">Date: <? echo $today; ?></span></p>
      </div>
   </div>
   <hr />
     <div class="row-fluid">
        <div class="span4">
           <h4>Client:</h4>
           <ul class="unstyled">
              <li><strong>Name : </strong> <?=$firstname; echo $surname; ?></li>
              <li><strong>CustomerID : </strong><?=$cust_id; ?></li>
              <li><strong>Phone No : </strong>0<?=$phone_no; ?></li>
           </ul>
        </div>
        <div class="span4">
           
        </div>
        <div class="span4 invoice-payment">
           <h4>Payment Details:</h4>
           <ul class="unstyled">
              <li><strong>Service_account_no:</strong> <?=$acc_no; ?></li>
              <li><strong>Bill Id:</strong> <?=$bill_id; ?> </li>
              <li><strong>Payment Mode:</strong> <?=$payment_mode_name; ?> </li>
           </ul>
        </div>
      </div>

      <div class="row-fluid">
                        <table class="table table-striped table-hover">
                           <thead>
                              <tr>
                                 <th>#</th>
                                 <th>Item</th>
                                 <th class="hidden-480">Description</th>
                                 <th>Total</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td>1</td>
                                 <td><?=$serv_type; ?></td>
                                 <td class="hidden-480"><?=$description; ?></td>
                                 <td class="hidden-480"><?=$amount; ?></td>
                                </tr>
                           </tbody>
                        </table>
                     </div>

                     <div class="row-fluid">
                        <div class="span4">
                           
                        </div>
                        <div class="span8 invoice-block">
                           <ul class="unstyled amounts">
                              <li><strong>Total amount:</strong> <?=$amount?></li>
                           </ul>
                           <br />
                           <a class="btn btn-success btn-large hidden-print" onclick="javascript:window.print();">Print <i class="icon-print icon-big"></i></a>
                           
                        </div>
                     </div>
          
          </div>
   </div>
</div>
</div>
<!-- END PAGE CONTENT-->