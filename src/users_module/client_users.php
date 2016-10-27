<?php
set_title('All Users');
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'View Users',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'User Management' ),
		array ( 'text'=>'All Users' )
	)
	
));

if(isset($_SESSION['del'])){ echo $_SESSION['del']; unset($_SESSION['del']); }

// $query="SELECT count(user_id)  as total_users FROM user_login2";
// $data=run_query($query);
// $the_rows=get_row_data($data);
// $customer_num=$the_rows['total_users'];

?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> Manage Users</h4></div>
	<div class="widget-body form">
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			<tr>
			  	<th>ID#</th>
			  	<th>USERNAME</th>
			  	<th>EMAIL</th>
			  	<th>STATUS</th>
			  	<th>USER ROLE</th>
			  	<th>EDIT</th>
		      	<th>PROFILE</th>
			  </tr>
 		</thead>
 	<tbody>
 <?php

   $distinctQuery = "SELECT u.*, r.* FROM user_login2 u LEFT JOIN user_roles r ON u.user_role = r.role_id WHERE client_mf_id = '".$_SESSION['mf_id']."'";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
   
    $con = 1;     
    $total = 0;     
    while($row = get_row_data($resultId))     {
        $id = $row['user_id'];
        $username = $row['username'];
		$email=$row['email'];
		$status=$row['user_active']; 
		if($status == 't'){
			$status = 'Active';
			$class = 'label label-success';
		}else{
			$status = 'Blocked';
			$class = 'label label-danger';
		}
		$user_role=$row['role_name'];
	?>
<tr>             
	<td><?=$id; ?></td>
    <td><?=$username; ?></td>
    <td><?=$email; ?></td>          
	<td><span class="<?=$class; ?>"><?=$status; ?></span></td>
	<td><?=$user_role; ?> </td>          
	<td><a id="edit_link" class="btn btn-mini" href="index.php?num=edit_user&user=<?=$id; ?>"><i class="icon-edit"></i> Edit</a></td>
	<td><a id="edit_link" class="btn btn-mini blue-stripe" href="index.php?num=view_prof&user=<?=$id; ?>&id=<?=$id; ?>"><i class="icon-eye-open"></i> Profile</a></td>
<?php
 
	}
	   
	?>
  
  </tbody>
</table>
<div class="clearfix"></div>
</div></div>

