 <?php
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'G-pay Transction',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Payments & Bills' ),
		array ( 'text'=>'Gpay Transaction' )
	)
));
?>

<div class="widget">
  <div class="widget-title">
    <h4>G-pay Transaction</h4>
  </div>
  <div class="widget-body">

    <table id="table1" class="table table-bordered">
      <thead>
        <tr>
         <th>Transaction Id</th>
         <th>Date</th>
         <th>Customer Name</th>
         <th>Transaction Type</th>
         <th>Amount</th>
         <th>Status</th>
        </tr>
      </thead>
      <tbody>

       <?
         $query = "SELECT gt.*, gty.type_name, m.surname, m.firstname, m.middlename FROM ".DATABASE.".gpay_transactions gt
         LEFT JOIN gpay_transaction_type gty ON gty.type_id = gt.type_id
         LEFT JOIN masterfile m ON m.mf_id = gt.transaction_mf_id";
         $resultId = run_query($query);
         $total_rows = get_num_rows($resultId);


      	$con = 1;
      	$total = 0;
      	while($row = get_row_data($resultId))
      	{
      		$transaction_id = $row['transaction_id'];
          $transaction_date= date("d-m-Y H:i:s",strtotime($row['transaction_date']));
          $full_name = $row['surname'].' '.$row['firstname'].' '.$row['middlename'];
      		$type_name = $row['type_name'];
      		$transaction_amount = $row['transaction_amount'];
          $status = $row['status'];
          $transaction_mf_id = $row['transaction_mf_id'];


  		 ?>
  		  <tr>
  		    <td><?=$transaction_id; ?></td>
  		    <td><?=$transaction_date; ?></td>
          <td><?=$full_name; ?></td>
          <td><?=$type_name; ?></td>
          <td><?=$transaction_amount; ?></td>
          <td><?=($row['status']=='0') ? 'Pending': 'Done'; ?></td>
  		  </tr>
  		    <? } ?>
      </tbody>
    </table>
    <div class="clearfix"></div>
  </div>
</div>