<?php
if(isset($_GET['id']) && isset($_GET['name'])){
	$plot = $_GET['id'];
	$name = $_GET['name'];
}

$query = "SELECT houses.*, plots.* FROM houses 
   LEFT JOIN plots ON plots.plot_id = houses.attached_to 
   WHERE attached_to = '$plot'";
if($data = run_query($query)){
	$num_rows = get_num_rows($data);
}

set_title('All Houses');
set_layout("dt-layout.php", array(
	'pageSubTitle' => "Plot $name ($num_rows)",
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
			  <th>PHONE</th>
			  <th>EMAIL</th>
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
 

   $distinctQuery = "SELECT houses.*, plots.* FROM houses
   LEFT JOIN plots on houses.attached_to = plots.plot_id
   WHERE attached_to = '$plot' Order by house_id DESC";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
    $con = 1;     
    $total = 0;     
    while($row = get_row_data($resultId)) {
       	$id = $row['house_id'];
        $house_no = $row['house_number'];
		$rent_amount=$row['rent_amount'];         
		$tenant=$row['tenant'];
		$phone=$row['phone'];
		$email=$row['email'];
		$attached_to=$row['plot_name'];
	?>
<tr>             
	<td><?=$id; ?></td>             
	<td><?=$house_no; ?></td>            
	<td><?=$rent_amount; ?> </td>
	<td><?=$attached_to; ?> </td>
	<td><?=$tenant; ?> </td>
	<td><?=$phone; ?> </td>
	<td><?=$email; ?> </td>          
	<td><a id="edit_link" href="index.php?num=edit_house&house=<?=$id; ?>">Edit</a></td>
	<!-- <td><a id="delete_link" href="index.php?num=del_house&house=<?=$id; ?>"
	onclick="return confirm('Are you sure you want to delete?')">Delete</a></td> -->
	<td><a id="edit_link" href="index.php?num=add_house">Payments</a></td>        
	</tr>          <?php
 
	}
	   
	?>
  
  </tbody>
</table>

