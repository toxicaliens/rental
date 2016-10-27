<? 
	include "../connection/config.php";
	include "../library.php";
	
	$page = $_GET['page'];
	
	if($page == 1)
	    $offset = 0;
	else
		$offset = $page * 20;


?> 
   <table id="table1">
 <tbody>
 <?php
//row to be deleted
$stuff=$_GET['staff'];
if (isset($stuff))
{
//delete the row
$delete_staffs="DELETE FROM ".DATABASE.".staff WHERE staff_id='$stuff'";
$delete_staff=run_query($delete_staffs);
if ($delete_staff)
    {
      echo "<p><font color='#006600'>The Item has been deleted</font></p>";
    }
}


?>
 <?
   $distinctQuery = "SELECT * FROM staff Order by staff_id DESC Limit 20 OFFSET $offset";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$staff_id=$row['staff_id'];
		$job_id=$row['job_id'];
		$job_name=getJobName($job_id);
		
		$email=$row['email'];
		$phone_number=$row['phone_number'];
		$surname=$row['surname'];
		
		$department_id=$row['department_id'];
		$department_name=getDepartmentName($department_id);
		$userLevelId=$row['userlevelid'];
		$userLevelName=getUserLevelName($userLevelId);
		$active=$row['active'];
		$id_passport=$row['id_passport'];
		$leave_days=$row['leave_days'];
		$details=$row['details'];
		$first_name=$row['first_name'];
		$username=$row['username'];

		$status=$row['status'];
		$tot_earn=$row['tot_earn'];
		$tot_ded=$row['tot_ded'];
		$net_pay=$row['net_pay'];
		 ?>
		  <tr>
		<td><?=$staff_id; ?></td>
                <td><?=$surname; ?></td>
		<td><?=$job_name; ?></td>
               <td><?=$department_name; ?></td>
	       <td><?=$userLevelName; ?> </td>	
		<td><?=$phone_number; ?></td>
		<td><?=$email; ?></td>
	      
		


		<td><a id="edit_link" href="index.php?num=702&staff=<?=$staff_id; ?>">Edit</a></td>
		<td><a id="delete_link" href="index.php?num=701&staff=<?=$staff_id; ?>" onclick="return confirm('Are you sure you want to delete?')">Remove</a></td>
		<td><a id="edit_link" href="index.php?num=705&staff=<?=$staff_id; ?>">Profile</a></td>
		  </tr>
		 <?
 
	}
	
	?>
   <tr><td><a href="index.php?num=703">ADD</a></td></tr> 
  </tbody>
</table>
