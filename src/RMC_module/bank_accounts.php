<table id="table1" class="table table-bordered">
                   <thead>
                    <tr>
                    <th>Bank Name</th>
                    <th>Bank Branch</th>
                    <th>Account number</th>
                    <th>IFMIS Bank Code</th>
                    <th>IFMIS Branch Code</th>
                    <th>EDIT</th>  
                    </tr>
                   </thead>
                                                 
                   <tbody>

 <?
    $distinctQuery = "SELECT * FROM revenue_banks Order by revenue_bank_id DESC ";
   $resultId = run_query($distinctQuery); 
   $total_rows = get_num_rows($resultId);
  
   
  $con = 1;
  $total = 0;
  while($row = get_row_data($resultId))
  {
    $revenue_bank_id=$row['revenue_bank_id'];
    $bank_name=$row['bank_name'];
    $bank_branch=$row['bank_branch'];
    $bank_account_number=$row['bank_account_number'];
    $ifmis_bank_code=$row['ifmis_bank_code'];
    $ifmis_bank_branch_code=$row['ifmis_bank_branch_code'];
       
     ?>
      <tr>
      <td><?=$bank_name; ?></td>
      <td><?= $bank_branch; ?></td> 
      <td><?=$bank_account_number; ?></td>
      <td><?= $ifmis_bank_code; ?></td>
      <td><?= $ifmis_bank_branch_code; ?></td>
      <td><a id="edit_link" class="btn btn-mini" href="index.php?num=628&edit_id=<?=$revenue_bank_id; ?>">
                    <i class="icon-edit"></i> Edit</a></td>
      </tr>
     <?
  }
  ?>
  </tbody>
</table>