<table id="table1" class="table table-bordered">
		         <thead>
		          <tr>
				  	<th>ID#</th>
				  	<th>View Name</th>
				  	<th>View Index</th>
				  	<th>View Url</th>
				  	<th>Status</th>
				  	<th>Parent View</th>
				  	<th>Edit</th>
				  </tr>
		         </thead>
                                                 
                   <tbody>

 <?php
  $distinctQuery = "SELECT * FROM sys_views Order by sys_view_id DESC ";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
    $con = 1;     
    $total = 0;     
    while($row = get_row_data($resultId))     {
        $sys_view_id = $row['sys_view_id'];
        $view_name = $row['sys_view_name'];
        $view_index = $row['sys_view_index'];
        $view_url = $row['sys_view_url'];
        $view_status = $row['sys_view_status'];
        if($view_status == 't'){
        	$view_status = 'Active';
        }else{
        	$view_status = 'Inactive';
        }
	?>
		  <tr>
		    <td><?=$sys_view_id; ?></td>
		    <td><?=$view_name; ?></td>         
		    <td><?=$view_index; ?></td>  
		    <td><?=$view_url; ?></td>
		    <td><?=$view_status; ?></td>
		    <td><?=getParentViewName($row['parent']); ?></td>
			<td><a id="edit_link" href="index.php?num=edit_view&id=<?=$sys_view_id; ?>" class="btn btn-mini"><i class="icon-edit"></i> Edit</a></td>
		  </tr>
		 <?php
 	}
	?>
  </tbody>
</table>
<div class="clearfix"></div>