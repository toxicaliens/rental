<?php
$query="SELECT count(role_id)  as total_roles FROM user_roles";
$data=run_query($query);
$the_rows=get_row_data($data);
$customer_num=$the_rows['total_roles'];
?>
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			<tr>
			  	<th>ID#</th>
			  	<th>ROLE_NAME</th>
			  	<th>STATUS</th>
			  	<th>EDIT</th>
			  	<th>MANAGE VIEWS</th>
			  </tr>
 		</thead>
 	<tbody>
 <?php

   $distinctQuery = "SELECT ur.*, ucr.* FROM user_roles ur
   LEFT JOIN user_created_roles ucr ON ucr.role_id = ur.role_id
   WHERE ucr.mf_id = '".$_SESSION['mf_id']."'";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
    $con = 1;     
    $total = 0;     
    while($row = get_row_data($resultId))     {
        $role_id = $row['role_id'];
        $role_name = $row['role_name'];
        $role_status = $row['role_status'];
        if($role_status == 't'){
        	$role_status = 'Active';
        }else{
        	$role_status = 'Inactive';
        }
	?>
<tr>             
	<td><?=$role_id; ?></td>
    <td><?=$role_name; ?></td>         
    <td><?=$role_status; ?></td>  
	<td><a id="edit_link" href="index.php?num=edit_role&id=<?=$role_id; ?>">Edit</a></td>
	<td><a id="edit_link" href="index.php?num=manage_views&id=<?=$role_id; ?>&role_name=<?=$role_name; ?>">Manage Views</a></td>
<?php
 
	}
	   
	?>
  
  </tbody>
</table>

