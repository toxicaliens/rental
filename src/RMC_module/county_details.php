<div class="widget">
<div class="widget-title"><h4> COUNTY DETAILS </h4></div>
 <div class="widget-body form">
<table id="table1" class="table table-bordered">
					         <thead>
					          <tr>
					           <th>County Id</th>
					           <th>County Name</th>
                               <th>Edit</th>
					          </tr>
					         </thead>
                                                 
                   <tbody>

 <?
   $distinctQuery = "SELECT * from county_ref
                     Order by county_ref_id DESC";
   $resultId = run_query($distinctQuery);
   $total_rows = get_num_rows($resultId);


	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$county_ref_id =($row['county_ref_id']);
		$county_name = $row['county_name'];
		
		 ?>
		  <tr>
		   <td><?=$county_ref_id; ?></td>
           <td><?=$county_name; ?></td>
           <td><a id="edit_link" class="btn btn-mini" href="index.php?num=641&edit_id=<?=$county_ref_id; ?>">
                   <i class="icon-edit"></i> Edit</a></td>
		  </tr>
		 <?
 	}
	?>
  </tbody>
</table>
<div class="clearfix"></div>
</div>
</div>