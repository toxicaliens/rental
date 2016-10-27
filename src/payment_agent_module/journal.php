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

<div>
                    
    <div style="float:right; width:100%; text-align:left;">
    </div>
    <div style="clear:both;"> </div>

</div>
<br/>

   <table id="table1"  class="table table-bordered">
 <thead>
  <tr>
    <th>J.ID#</th>
   <th>Journal Date</th>
   <th>Customer Name</th>
   <th>Service Acc</th>
   <th>Amount</th>
   <th>Particulars</th>
   <th>DR/CR</th>
   <th>Journal Type</th>
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
    $journal_id = $row['journal_id'];
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
        <td><?=$journal_id; ?></td>
		   <td><?=$j_date; ?></td>
       <td><?=$customer_name; ?></td>
       <td><?=$service_account; ?></td>
		   <td><?=$amount; ?></td>
       <td><?=$particulars; ?></td>
       <td><?=$dr_cr; ?></td>
       <td><?=$journal_type; ?></td>
      </tr>
		 <?
 
	}
	
	?>
  </tbody>
</table>

      <div class="clearfix"></div>
    </div>
  </div>