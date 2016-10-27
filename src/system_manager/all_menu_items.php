<?php
set_title('The Menu');
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'System Views',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'System Manager' ),
		array ( 'text'=>'All System Views' )
	)
	
));

$query="SELECT count(menu_id) as total_items FROM menu";
$data=run_query($query);
$the_rows=get_row_data($data);
$customer_num=$the_rows['total_views'];

if(isset($_SESSION['done-del'])){
    echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['done-del']."</p>";
    unset($_SESSION['done-del']);
}
?>
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			<tr>
			  	<th>ID#</th>
			  	<th>MENU NAME</th>
			  	<th>PARENT NAME</th>
			  	<th>STATUS</th>
			  	<th>EDIT</th>
			  </tr>
 		</thead>
 	<tbody>
 <?php

   $distinctQuery = "SELECT m.*, s.* FROM menu m
   LEFT JOIN sys_views s ON m.view_id = s.sys_view_id
   Order by sys_view_id DESC ";
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
    $con = 1;     
    $total = 0;     
    while($row = get_row_data($resultId))     {
        $menu_id = $row['menu_id'];
        $view_name = $row['sys_view_name'];
        $parent = $row['text'];
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
	<td><a id="edit_link" href="index.php?num=edit_view&id=<?=$sys_view_id; ?>">Edit</a></td>
<?php
 
	}
	   
	?>
  
  </tbody>
</table>

