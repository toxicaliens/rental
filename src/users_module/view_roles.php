<?php
set_title('All User Roles');
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'View Roles',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'System Manager' ),
		array ( 'text'=>'All User Roles' )
	)
	
));

$query="SELECT count(sys_role_view_id)  as total_roles FROM sys_role_views_allocations";
$data=run_query($query);
$the_rows=get_row_data($data);
$customer_num=$the_rows['total_roles'];

?>
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			<tr>
			  	<th>ID#</th>
			  	<th>ROLES</th>
			  	<th>VIEWS</th>
			  </tr>
 		</thead>
 	<tbody>
 <?php

   $distinctQuery = "SELECT a.*, u.*, v.* FROM sys_role_views_allocations a
   LEFT JOIN user_roles u ON a.sys_role_id = u.role_id
   LEFT JOIN sys_views v ON a.sys_view_id = v.sys_view_id";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
    $con = 1;     
    $total = 0;     
    while($row = get_row_data($resultId))     {
        $view_name = $row['sys_view_name'];
        $view_id = $row['sys_view_id'];
        $role_name = $row['role_name'];
	?>
<tr>             
	<td><?=$view_id; ?></td>
    <td><?=$role_name; ?></td>  
	<td><a id="edit_link" href="index.php?num=edit_action&sys_view_id=<?=$view_id; ?>&name=<?=$view_name; ?>">Manage Actions</a></td>
<?php
 
	}
	   
	?>
  
  </tbody>
</table>

