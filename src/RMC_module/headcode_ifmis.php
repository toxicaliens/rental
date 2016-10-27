<table id="table1" class="table table-bordered">
                   <thead>
                    <tr>
                      <th>Head Code ID</th>
                      <th>Head Code Name</th>
                      <th>IFMIS Code</th>
                      <th>EDIT</th> 
                    </tr>
                   </thead>
                                                 
                   <tbody>

 <?
   $distinctQuery = "SELECT * FROM ifmis_headcodes Order by head_code_id DESC ";
   $resultId = run_query($distinctQuery); 
   $total_rows = get_num_rows($resultId);
  
  $con = 1;
  $total = 0;
  while($row = get_row_data($resultId))
  {
    $head_code_id=$row['head_code_id'];
    $head_code_name=$row['head_code_name'];
    $ifmis_code=$row['ifmis_code'];
  
     ?>
      <tr>
       <td><?=$head_code_id; ?></td>
      <td><?=$head_code_name; ?></td>
      <td><?=$ifmis_code; ?></td> 
     <td><a id="edit_link" class="btn btn-mini" href="index.php?num=631&edit_id=<?=$head_code_id; ?>">
                    <i class="icon-edit"></i> Edit</a></td>
      </tr>
     <?
  }
  ?>
  </tbody>
</table>