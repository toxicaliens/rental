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
 $distinctQuery = "select * from ".DATABASE.".services Order by service_id DESC Limit 20 OFFSET $offset";
   $resultId = run_query($distinctQuery);
   $total_rows = get_num_rows($resultId);


	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['service_id']);
		$servicetypeid = $row['service_type_id'];
		$sname = $row['service_name'];
		$narrative = $row['narrative'];
		$sbillamt= $row['amount'];
		$keyword= $row['keyword'];
		 ?>
		  <tr>
		   <td><?=$trans_id; ?></td>
		   <td><?=getTypeNameByTypeId('service_types','service_type_name','service_type_id',$servicetypeid);?></td>
		   <td><?=$sname;?></td>
                   <td><?=$narrative?></td>
                   <td><?=$keyword?></td>
                   <td><?=$sbillamt; ?></td>
                   <td><?='<a href=index.php?num=154&edit_id='.$trans_id.'><img src=img/edit.png /><span id=modifytool>Edit</span></a>'?></td>
                   <td><?='<a href=index.php?num=152&delete_id='.$trans_id.'><img src=img/drop.png /><span id=modifytool>Drop</span></a>'?></td>
                  </tr>
		 <?

	}

	?>
  </tbody>
</table>
