 <?
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'M-pesa Request',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Payments & Bills' ),
		array ( 'text'=>'M-pesa Request' )
	)
));
?>

<div class="widget">
  <div class="widget-title">
    <h4>G-pay M-pesa Request</h4>
  </div>
  <div class="widget-body">

    <table id="table1" class="table table-bordered">
      <thead>
        <tr>
         <th>Request Id</th>
         <th>Type</th>
         <th>Amount</th>
         <th>M-pesa Receipt</th>
         <th>Date</th>
         <th>a/c Code</th>
         <th>Status</th>
        </tr>
      </thead>
      <tbody>

       <?
         $query = "SELECT * FROM ".DATABASE.".mpesa_request ";
         $result = run_query($query);
         $total_rows = get_num_rows($result);


      	$con = 1;
      	$total = 0;
      	while($row = get_row_data($result))
      	{
      		$mpesa_request_id = $row['mpesa_request_id'];
          $request_type = $row['request_type'];
      		$request_amount = $row['request_amount'];
      		$mpesa_receipt = $row['mpesa_receipt'];
          $request_date= date("d-m-Y H:i:s",strtotime($row['request_date']));
          $account_code = $row['account_code'];
          $request_status = $row['request_status'];


  		 ?>
  		  <tr>
  		    <td><?=$mpesa_request_id; ?></td>
          <td><?=($row['request_status']=='0') ? 'Auto': 'User'; ?></td>
          <td><?=$request_amount; ?></td>
          <td><?=$mpesa_receipt; ?></td>
          <td><?=$request_date; ?></td>
          <td><?=$account_code; ?></td>
          <td><?=($row['request_status']=='0') ? 'Fail': 'Success'; ?></td>
  		  </tr>
  		    <? } ?>
      </tbody>
    </table>
    <div class="clearfix"></div>
  </div>
</div>