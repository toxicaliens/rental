<?

include_once('src/model/IsioloReciepts.php');

if(isset($_GET['trans'])){

  $Trans = $_GET['trans'];

}

$receipt = new IsioloReciepts;

set_layout("dt-layout.php", array(

    'pageSubTitle' => 'Lamu County Receipt',

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

 

 $data=$receipt->getIsioloReciepts($Trans);

?>

 <!-- BEGIN PAGE CONTAINER-->

<div class="container-fluid">    

<div id="page">

   <div class="invoice">

            <table class="table table-condensed" style="margin:0px;">

                  <tr>

                      <td class="hidden-480">

                        <img src="assets/img/isiolo.png" alt="" width="115" height="115" />                      

                      </td>

                     <td class="hidden-480">

                        <br />

                        <h3 align="center"><strong>LAMU COUNTY</strong></h3>

                        <h4 align="center">CUSTOMER SERVICE OFFICE</h4>

                        <h4 align="center">PAYMENT RECEIPT</h4>

                     <td>

                     <td class="hidden-480">

                        <img src="assets/img/kenya-coat-of-arms.png" alt="" width="115" height="115" align="right"/>                      

                      </td>

                  </tr> 

            </table>

            <table class="table table-condensed" style="margin:0px;">

               <tbody>

                  <tr>

                      <td class="hidden-480">

                         <strong>Reciept No:</strong> <?php echo $data['transaction_id']; ?> <br/>

                         <strong>Customer Name:</strong> 

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

                    <th>Service</th>

                    <th>Amount</th>

                  </tr>

                </thead>

                <tbody>

	                <tr>

	                    <td><?=$data['service_option']; ?></td>

	                    <td class="cash_paid"><?=$data['cash_paid']; ?></td>

	                </tr>

                </tbody>

                <tfoot>

                	<tr>

                		<td colspan="1" style="text-align: right; font-weight:bold;"><strong>Total Amount</strong></td>

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

<?php set_js(array("src/js/pay_bill.js")); ?>