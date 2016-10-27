<?php
set_title('All Plots');
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'View Plots',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Plots' ),
		array ( 'text'=>'All Plots' )
	)
	
));

$query="SELECT count(plot_id)  as total_prop FROM plots";
$data=run_query($query);
$the_rows=get_row_data($data);
$customer_num=$the_rows['total_prop'];

?>
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			<tr>
			  	<th>ID#</th>
			  	<th>NAME</th>
			  	<th>UNITS</th>
			  	<th>PAYMENT CODE</th>
			  	<th>PAYBILL NO</th>
			  	<th>ATTACHED TO</th>
			  	<th>EDIT</th>
		      	<th>HOUSES</th>
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
 
 
   $distinctQuery = "SELECT plots.*, masterfile.* FROM plots 
   LEFT JOIN masterfile ON plots.customer_id = customers.customer_id Order by plot_id DESC ";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
    $con = 1;     
    $total = 0;     
    while($row = get_row_data($resultId))     {
        $id = $row['plot_id'];
        $prop_name = $row['plot_name'];
		$payment_code=$row['payment_code']; 
		$paybill_no=$row['paybill_number'];         
		$attached_to=$row['surname'];  
		$fname=$row['firstname'];
		$units=$row['units'];
	?>
<tr>             
	<td><?=$id; ?></td>
    <td><?=$prop_name; ?></td>
    <td><?=$units; ?></td>          
	<td><?=$payment_code; ?> </td>
	<td><?=$paybill_no; ?> </td>
	<td><?=$attached_to.' '.$fname; ?> </td>            
	<td><a id="edit_link" href="index.php?num=edit_plot&plot=<?=$id; ?>">Edit</a></td>
<td><a id="edit_link" href="index.php?num=in_plot&name=<?=$prop_name; ?>&id=<?=$id; ?>">View Houses</a></td>
<?php
 
	}
	   
	?>
  
  </tbody>
</table>

