<?php
include_once('src/models/GpayWallet.php');
$gpay = new GpayWallet;

set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Customer Balances',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Gpay Wallet' ),
		array ( 'url'=>'?num=customer_statement', 'text'=>'Customer Statement' ),
		array ( 'text'=>'View Statement')
	)

));

$mf_id = $_GET['mf_id'];

set_css(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css',
	'assets/plugins/bootstrap-datepicker/css/datepicker.css'
));
set_js(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
	'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'
));
?>

<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> Filter</h4></div>
	<div class="widget-body form">
		<form action="" class="form-horizontal" method="post">
		  <div class="control-group">
		    <label class="control-label">Month: </label>
		     <div class="controls">
		        <div class="input-append date date-picker" data-date="102/2012" data-date-format="yyyy-mm" data-date-viewmode="years" data-date-minviewmode="months">
		           <input class="m-wrap m-ctrl-medium" size="16" type="text" name="month" required/><span class="add-on"><i class="icon-calendar"></i></span>
		        </div>
		        <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
		     </div>
		  </div>
		</form>
	</div>
</div>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> Statement for <span style="color: green;"><?=$gpay->getCustomerName($_GET['mf_id']); ?></span></h4></div>
	<div class="widget-body form">
		<table id="" class="table table-bordered">
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
		  $month_from = '';
		  $month_to = '';

		    $month_from = date('Y-m-01');
		    $month_to = date('Y-m-d');

		    $criteria = "AND journal_date::date >= '".$month_from."' AND journal_date::date <= '".$month_to."'";

		    if(isset($_POST['month'])){
		      $month = $_POST['month'];
		      if(!empty($month)){
		        $month_from = date($month.'-01');
		        $year_month = explode('-', $month);
		        $month_to = last_day($year_month[1], $year_month[0]);
		      
		        $criteria = "AND (journal_date::date >= '".$month_from."' AND journal_date::date <= '".$month_to."')";
		      }
		    }

		   $distinctQuery = "select j.*, m.* from ".DATABASE.".wallet_journal j
		   LEFT JOIN masterfile m ON m.mf_id = j.mf_id
		   WHERE j.mf_id = '".$mf_id."' $criteria ORDER by journal_date ASC
		   ";
		   // var_dump($distinctQuery);exit;
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
		    <td colspan="2" style="text-align:right;font-weight:bold">Totals:</td>
		    <td style="text-align:right;font-weight:bold">
		      <?php
		        $query = "SELECT SUM(amount) as total_debit FROM wallet_journal WHERE dr_cr = 'DR' AND mf_id = '".$mf_id."' $criteria";
		        $result = run_query($query);
		        $row = get_row_data($result);
		        $debit_total = $row['total_debit'];
		        echo number_format($debit_total, 2);
		      ?>
		    </td>
		    <td style="text-align:right;font-weight:bold">
		      <?php
		        $query = "SELECT SUM(amount) as total_credit FROM wallet_journal WHERE dr_cr = 'CR' AND mf_id = '".$mf_id."' $criteria";
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
		        if($credit_balance < 0){
		          $absolute = abs($credit_balance);
		          $negative = number_format($absolute, 2);
		          echo "<span class='negative'>($negative)</span>";
		        }else{
		          echo number_format($credit_balance, 2);
		        }
		        
		      ?>
		    </td>
		  </tr>
		  </tbody>
		</table>
	</div>
</div>