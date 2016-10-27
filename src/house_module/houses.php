<?php
set_title('All Houses');
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'VIEW HOUSES',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Houses/Units' ),
		array ( 'text'=>'All Houses' )
	)
	
));

$query="SELECT count(house_id)  as total_houses FROM houses";
$data=run_query($query);
$the_rows=get_row_data($data);
$customer_num=$the_rows['total_houses'];

?>
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			  <tr>
			  <th>HID#</th>
			  <th>HNO</th>
			  <th>RENT</th>
			  <th>PLOT</th>
			  <th>TENANT</th>
			  <th>EDIT</th>
              <!-- <th>VIEW</th> -->
			  <th>PAYMENTS</th>
			  </tr>
 		</thead>
 	<tbody>
 <?php
//row to be deleted
// $customer=(isset($_GET['customer'])); 
// if (isset($customer))
// {
// //delete the row
// $delete_customers="DELETE FROM ".DATABASE.".ccn_customers WHERE ccn_customer_id='$customer'";
// $delete_customer=run_query($delete_customers);

// if ($delete_customer)
//     {
//       echo "<p><font color='#006600'>The Item has been deleted</font></p>";
//     }
// }
 
 
   $distinctQuery = "SELECT houses.*, plots.*, masterfile,* FROM houses 
   LEFT JOIN plots on houses.attached_to = plots.plot_id
   LEFT JOIN masterfile on houses.tenant_mf_id = masterfile.mf_id";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
    $con = 1;     $total = 0;     
    while($row = get_row_data($resultId)) {
        $id = $row['house_id'];
        $house_no = $row['house_number'];
		$rent_amount=$row['rent_amount'];
		$plot=$row['plot_name'];
		$surname=$row['surname'];
		$firstname=$row['firstname'];
	?>
<tr>             
	<td><?=$id; ?></td>             
	<td><?=$house_no; ?></td>            
	<td><?=$rent_amount; ?> </td>
	<td><?=$plot; ?> </td>
	<td><?=$surname.' '.$firstname; ?> </td>        
	<td><a id="edit_link" href="index.php?num=edit_house&house=<?=$id; ?>">Edit</a></td>
	<!-- <td><a id="delete_link" href="index.php?num=del_house&house=<?=$id; ?>"
	onclick="return confirm('Are you sure you want to delete?')">Delete</a></td> -->
	<!-- <td><a id="edit_link" href="index.php?num=view_house&id=<?=$id; ?>">View House</a></td> -->
	<td><a id="edit_link" href="index.php?num=add_house">Payments</a></td>        
	</tr>          <?php
 
	}
	   
	?>
  
  </tbody>
</table>

