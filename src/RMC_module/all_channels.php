<?
set_layout("dt-layout.php", array(
  'pageSubTitle' => 'All Service Options',
  'pageSubTitleText' => '',
  'pageBreadcrumbs' => array (
    array ( 'url'=>'index.php', 'text'=>'Home' ),
    array ( 'text'=>'Revenue Management' ),
    array ( 'text'=>'All service Options' )
  )

));

if(isset($_SESSION['RMC'])){
    echo "<p style='color:#33FF33; font-size:16px;'>".$_SESSION['RMC']."</p>";
    unset($_SESSION['RMC']);
}

$query="SELECT count(service_channel_id)  as total_channels FROM service_channels";
$data=run_query($query);
$the_rows=get_row_data($data);
$customer_num=$the_rows['total_channels'];

?>
<div class="widget">
  <div class="widget-title">
    <h4><i class="icon-reorder"></i>SERVICE OPTIONS</h4>
    <span class="actions">
          <a href="index.php?num=624" class="btn btn-primary btn-small">NEW SERVICE OPTION</a>
      </span>
    </div>
 <div class="widget-body">
 <table id="table1" style="width: 100%" class="table table-bordered">
    <thead>
        <tr>
        <th>Service Channel ID</th>
        <th>Revenue Channel Name</th>
        <th>Service Option</th>
        <th>Service Option Type</th>
        <th>Price</th>
        <th>Option Code</th>
        <th>Parent</th>
        <th>Request Type</th>
        <th>EDIT</th>    
    </tr>
    </thead>
  <tbody>
 <?
   $distinctQuery = "SELECT s.*, r.*, c.* FROM service_channels s 
   LEFT JOIN request_types r ON r.request_type_id = s.request_type_id
   LEFT JOIN revenue_channel c ON c.revenue_channel_id = s.revenue_channel_id
   Order by service_channel_id DESC ";
   $resultId = run_query($distinctQuery); 
   $total_rows = get_num_rows($resultId);
  
   
  $con = 1;
  $total = 0;
  while($row = get_row_data($resultId))
  {
    $revenue_channel_name=$row['revenue_channel_name'];
    $service_channel_id=$row['service_channel_id'];
    $service_option=$row['service_option'];
    $service_option_type=$row['service_option_type'];
    $price=$row['price'];
    $option_code=$row['option_code'];
    $parent_id=$row['parent_id'];
    
    $parent_name = getParentName($parent_id);
    $request_type_name=$row['request_type_name']
    
 ?>
      <tr>
      <td><?=$service_channel_id; ?></td>
      <td><?=$revenue_channel_name; ?></td>
      <td><?=$service_option; ?></td> 
      <td><?=$service_option_type; ?></td>
      <td><?=$price; ?></td>
      <td><?=$option_code; ?></td>
      <td><?=$parent_name; ?></td>
      <td><?=$request_type_name; ?></td>
    <td><a id="edit_link" class="btn btn-mini" href="index.php?num=625&edit_id=<?=$service_channel_id; ?>">
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