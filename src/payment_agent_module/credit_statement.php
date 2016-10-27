<?
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Journal',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Payment & Bills' ),
		array ( 'text'=>'Journal' )
	)
));
   // $distinctQuery2 = "SELECT count(bill_id) as tot 
   //                                                  from customer_bills 
   //                                                  where service_account_type='1'";
   // $resultId2 = run_query($distinctQuery2);	
   // $arraa = get_row_data($resultId2);
   // $total_rows2 = $arraa['total_parking_bills'];
 ?>

 <div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> Journal</h4>
      </div>
    <div class="widget-body">

      <!-- Form filters -->
      <form action="" method="POST" class="form-inline">
    <!-- <h3 class="form-section">Person Info</h3> -->
    <div class="controls controls-row">
        <div class="control-group">
            <input type="text" class="datepicker" name="month_picker" />          
        </div>
        <div class="control-group">
            <input type="text" id="search_box" name="customer_name" placeholder="Type a customer name"
              data-provide="typeahead" data-items="4" />   
            <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>         
        </div>
      </div>
      <p><div class="controls controls-row">
      
    </div></p>
   </form>
    
<div>
                    
    <div style="float:right; width:100%; text-align:left;">
    </div>
    <div style="clear:both;"> </div>

</div>
<br/>

   <table id=""  class="table table-bordered">
 <thead>
  <tr>
   <th class="center-align">Date</th>
   <th class="center-align">Particulars</th>
   <th class="center-align">Debit</th>
   <th class="center-align">Credit</th>
  </tr>
 </thead>
 <tbody>
 
 <?

   $distinctQuery = "select j.*, m.* from ".DATABASE.".journal j
   LEFT JOIN masterfile m ON m.mf_id = j.mf_id";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
 
	while($row = get_row_data($resultId))
	{
		$j_date = trim(date('d/m/Y', strtotime($row['journal_date'])));
		$customer_name = $row['surname'].' '.$row['firstname'].' '.$row['middlename'];
		$amount = trim($row['amount']);
    $service_account = $row['service_account'];
    $particulars = $row['particulars'];
		$dr_cr = $row['dr_cr'];
    if($dr_cr == 'DR')
      $dr_cr = 'Debit';
    else
      $dr_cr = 'Credit';
    $journal_type = $row['journal_type'];
    if($journal_type == 1)
      $journal_type = 'Ordinary';
    else if($journal_type == 2)
      $journal_type = 'Closing';
    else
      $journal_type = 'Opening';
    ?>
		  <tr>
		   <td><?=$j_date; ?></td>
       <td><?=$particulars; ?></td>
       <td style="text-align:right;">
          <?php
            if($dr_cr == 'Debit'){
              echo number_format($amount, 2);
            }
          ?>
       </td>
       <td style="text-align:right;">
          <?php
            if($dr_cr == 'Credit'){
              echo number_format($amount, 2);              
            }
          ?>
       </td>
      </tr>
		 <?
 
	}
	?>
  <tr>
    <td colspan="2" style="text-align:right;font-weight:bold">Totals</td>
    <td style="text-align:right;font-weight:bold">
      <?php
        $query = "SELECT SUM(amount) as total_debit FROM journal WHERE dr_cr = 'DR'";
        $result = run_query($query);
        $row = get_row_data($result);
        $debit_total = $row['total_debit'];
        echo number_format($debit_total, 2);
      ?>
    </td>
    <td style="text-align:right;font-weight:bold">
      <?php
        $query = "SELECT SUM(amount) as total_credit FROM journal WHERE dr_cr = 'CR'";
        $result = run_query($query);
        $row = get_row_data($result);
        $credit_total = $row['total_credit'];
        echo number_format($credit_total, 2);
      ?>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="text-align:right;font-weight:bold">Current Balance:</td>
    <td colspan="2" style="text-align:right;font-weight:bold">
      <?php
        $credit_balance = $credit_total - $debit_total;
        echo number_format($credit_balance, 2);
      ?>
    </td>
  </tr>
  </tbody>
</table>

      <div class="clearfix"></div>
    </div>
  </div>

<?php 
  set_css(array("src/css/my_css.css")); 
  set_js(array("src/js/live_search.js"));
?>