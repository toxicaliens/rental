<?
	include "../connection/config.php";
	include "../library.php";
        include "../parking_module/library.php";

	$page = $_GET['page'];

	if($page == 1)
	    $offset = 0;
	else
		$offset = $page * 20;


?>
 <table id="table1">
 <tbody>

 <?
   $distinctQuery = "select * from ".DATABASE.".transactions Order by transaction_id DESC Limit 20 OFFSET $offset";
   $resultId = run_query($distinctQuery);
   $total_rows = get_num_rows($resultId);


	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['transaction_id']);
                $cashpaid= $row['cash_paid'];
		$details = $row['details'];
		$receiptnumber = $row['receiptnumber'];
                $tdate = date("d-m-Y H:i:s",$row['transaction_date']);
		$agent = $row['agent_id'];
                $service_type = $row['service_type_id'];


		 ?>
		  <tr>
		   <td><?=$trans_id; ?></td>
		   <td><?=$cashpaid; ?></td>
		   <td><?=$details; ?></td>
                   <td><?=$receiptnumber; ?></td>
                   <td><?=$tdate; ?></td>
		   <td><?=getTypeNameByTypeId('agents','agent_name','agent_id',$agent);?></td>
                   <td><?=getTypeNameByTypeId('service_types','service_type_name','service_type_id',$service_type);?></td>

		  </tr>
		 <?
 	}
	?>
  </tbody>
</table>
