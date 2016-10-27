<table id="table1" class="table table-bordered">
                   <thead>
                    <tr>
                     <th>Subcode ID</th>
                      <th>Subcode Name</th>
                      <th>Head Code ID</th>
                      <th>IFMIS subcode</th>
                      <th>EDIT</th>    
                    </tr>
                   </thead>
                                                 
                   <tbody>

 <?
   $distinctQuery = "SELECT * FROM ifmis_subcodes Order by subcode_id DESC ";
   $resultId = run_query($distinctQuery); 
   $total_rows = get_num_rows($resultId);
  
   
  $con = 1;
  $total = 0;
  while($row = get_row_data($resultId))
  {
    $subcode_id=$row['subcode_id'];
    $subcode_name=$row['subcode_name'];
    $head_code_id=$row['head_code_id'];
     // if (isset($head_code_id))
      // {
      // $head_code_name=getHeadCodeName($head_code_id);
      // }
    $ifmis_subcode=$row['ifmis_subcode'];
    
     ?>
      <tr>
      <td><?=$subcode_id; ?></td>
      <td><?=$subcode_name; ?></td>
      <td><?=$head_code_id; ?></td>
      <td><?=$ifmis_subcode; ?></td>    
      <td><a id="edit_link" class="btn btn-mini" href="index.php?num=634&edit_id=<?=$subcode_id; ?>">
                    <i class="icon-edit"></i> Edit</a></td>
      </tr>
     <?
  }
  ?>
  </tbody>
</table>   