<div class="widget">
<div class="widget-title"><h4> SUB COUNTY DETAILS </h4></div>
<table id="table1" class="table table-bordered">
                   <thead>
                    <tr>
                     <th> Sub County Id</th>
                     <th>Sub County Name</th>
                     <th>County Name</th>
                     <th>Edit</th>
                    </tr>
                   </thead>
                                                 
                   <tbody>

 <?
   $distinctQuery = "SELECT s.*, c.* FROM sub_county s
   LEFT JOIN county_ref c ON s.county_ref_id = c.county_ref_id
    Order by sub_county_id DESC ";
   $resultId = run_query($distinctQuery);
   $total_rows = get_num_rows($resultId);
   //var_dump($total_rows);exit;

  $con = 1;
  $total = 0;
  while($row = get_row_data($resultId))
  {
    $sub_county_id =$row['sub_county_id'];
    $sub_county_name = $row['sub_county_name'];
    $county_ref_id = $row['county_ref_id'];
    $county_name= $row['county_name'];
    
    
     ?>
      <tr>
       <td><?=$sub_county_id; ?></td>
       <td><?=$sub_county_name; ?></td>
       <td><?=$county_name; ?></td>
      <td><a id="edit_link" class="btn btn-mini" href="index.php?num=644&edit_id=<?=$sub_county_id; ?>">
                    <i class="icon-edit"></i> Edit</a> </td>
      </tr>
     <?
  }
  ?>
  </tbody>
</table>
<div class="clearfix"></div>
</div>
</div>   