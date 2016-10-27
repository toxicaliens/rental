<?php
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Attached IFMIS Records',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Revenue Management' ),
		array ( 'text'=>'All Attached IFMIS Records' )
	)
	
));

$query="SELECT count(revenue_channel_id)  as total_channels FROM revenue_channel";
$data=run_query($query);
$the_rows=get_row_data($data);
$customer_num=$the_rows['total_channels'];

?>
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			  <tr>
			  <th>Revenue Channel ID</th>
			  <th>Revenue Channel Name</th>
			  <th>Head Code ID</th>
			  <th>Subcode ID</th>
			  <th>STATUS</th>
			  <th>EDIT</th>    
		</tr>
 		</thead>
 	<tbody>
 <?
   $distinctQuery = "SELECT * FROM revenue_channel where status=true Order by revenue_channel_id DESC ";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$revenue_channel_name=$row['revenue_channel_name'];
		$revenue_channel_id=$row['revenue_channel_id'];
		$head_code_id=$row['head_code_id'];
		$subcode_id=$row['subcode_id'];
		$status=$row['status'];
		
 ?>
		  <tr>
			<td><?=$revenue_channel_id; ?></td>
			<td><?=$revenue_channel_name; ?></td>
			<td><?=$head_code_id; ?></td>
			<td><?=$subcode_id; ?></td>
			<td><?=$status; ?></td>	
		<td><a id="edit_link" class="btn btn-mini" href="index.php?num=622&edit_id=<?=$revenue_id; ?>">
                    <i class="icon-edit"></i> Edit</a></td>
       </tr>
		 <?
 
	}
	   
	?>
  
  </tbody>
</table>

