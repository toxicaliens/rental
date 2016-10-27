<table id="table1" class="table table-bordered">
		         <thead>
		          <tr>
				  	<th>ID#</th>
				  	<th>ACTION NAME</th>
				  	<th>ACTION CODE</th>
				  	<th>ACTION DESCRIPTION</th>
		            <th>TYPE</th>
		            <th>CLASS</th>
		            <th>VIEW</th>
				  	<th>STATUS</th>
				  	<th>EDIT</th>
				  </tr>
		         </thead>
                                                 
                   <tbody>

 <?
 $distinctQuery = "SELECT a.*, v.* FROM sys_actions a
   LEFT JOIN sys_views v ON a.sys_view_id = v.sys_view_id
   ";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
    $con = 1;     
    $total = 0;     
    while($row = get_row_data($resultId))     {
        $sys_action_id = $row['sys_action_id'];
        $view_name = $row['sys_view_name'];
        $sys_action_code = $row['sys_action_code'];
        $sys_action_name = $row['sys_action_name'];
        $description = $row['sys_action_description'];
        $action_type = $row['sys_action_type'];
        $action_class = $row['sys_action_class'];
        $action_status = $row['sys_action_status'];
        if($action_status == 't'){
        	$action_status = 'Active';
        }else{
        	$action_status = 'Inactive';
        }
	?>
		  <tr>
		    <td><?=$sys_action_id; ?></td>
		    <td><?=$sys_action_name; ?></td>         
		    <td><?=$sys_action_code; ?></td>  
		    <td><?=$description; ?></td>
		    <td><?=$action_type; ?></td>
		    <td><?=$action_class; ?></td>
		    <td><?=$view_name; ?></td>
		    <td><?=$action_status; ?></td>
			<td><a id="edit_link" href="index.php?num=ed_action&id=<?=$sys_action_id; ?>" class="btn btn-mini"><i class="icon-edit"></i> Edit</a></td>
		  </tr>
		 <?
 	}
	?>
  </tbody>
</table>
<div class="clearfix"></div>