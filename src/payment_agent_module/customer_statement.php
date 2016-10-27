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