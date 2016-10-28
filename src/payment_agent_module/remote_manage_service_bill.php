<?
	include "../connection/config.php";
	include "../library.php";
        include "library.php";

	$page = $_GET['page'];

	if($page == 1)
	    $offset = 0;
	else
		$offset = $page * 20;


?>
 <table id="table1">
 <tbody>

 <?
 $distinctQuery = "select * from ".DATABASE.".service_bills Order by service_bill_id DESC Limit 20 OFFSET $offset";
   $resultId = run_query($distinctQuery);
   $total_rows = get_num_rows($resultId);


	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['service_bill_id']);
		$service_id = $row['service_id'];
		$sbilltype = $row['service_bill_type'];
		$sbillname = $row['service_bill_name'];
		$sbilldesc = $row['service_bill_description'];
		$sbillamt= $row['service_bill_amt'];
                $sbillduetime = $row['service_bill_due_time'];
                $servicetypeid = $row['service_type_id'];
		 ?>
		  <tr>
		   <td><?=$trans_id; ?></td>
		   <td><?=getTypeNameByTypeId('services','service_name','service_id',$service_id);?></td>
		   <td><?=$sbilltype;?></td>
                   <td><?=$sbillname?></td>
                   <td><?=$sbilldesc; ?></td>
                   <td><?=$sbillamt?></td>
                   <td><?=$sbillduetime; ?></td>
                   <td><?=getTypeNameByTypeId('service_types','service_type_name','service_type_id',$servicetypeid); ?></td>
                   <td><?='<a href=index.php?num=162&edit_id='.$trans_id.'><img src=img/edit.png /><span id=modifytool>Edit</span></a>'?></td>
                   <td><?='<a href=index.php?num=160&delete_id='.$trans_id.'><img src=img/drop.png /><span id=modifytool>Drop</span></a>'?></td>
          </tr>
		 <?

	}

	?>
  </tbody>
</table>
