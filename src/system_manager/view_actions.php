<?php
set_title('All User Roles');
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'View Roles',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'System Manager' ),
		array ( 'text'=>'All Roles' )
	)
	
));

$query="SELECT count(sys_view_id)  as total_views FROM sys_views";
$data=run_query($query);
$the_rows=get_row_data($data);
$customer_num=$the_rows['total_views'];

?>
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			<tr>
			  	<th>ID#</th>
			  	<th>VIEWS</th>
			  	<th>EDIT</th>
			  	<th>ACTIONS</th>
			  </tr>
 		</thead>
 	<tbody>
 <?php

   $distinctQuery = "SELECT * FROM sys_views Order by sys_view_name ASC ";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
    $con = 1;     
    $total = 0;     
    while($row = get_row_data($resultId))     {
        $view_name = $row['sys_view_name'];
        $view_id = $row['sys_view_id'];
	?>
<tr>             
	<td><?=$role_id; ?></td>
    <td><?=$view_name; ?></td>  
	<td><a id="edit_link" href="index.php?num=edit_actions&sys_view_id=<?=$view_id; ?>&name=<?=$view_name; ?>">Manage Actions</a></td>
<?php
 
	}
	   
	?>
  
  </tbody>
</table>

