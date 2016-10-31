<?
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Services',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Payments & Bills' ),
		array ( 'text'=>'Services' )
	)
));
   $distinctQuery2 = "SELECT count(service_id) as total_services from services";
   $resultId2 = run_query($distinctQuery2);
   $arraa = get_row_data($resultId2);
   $total_rows2 = $arraa['total_services'];
 ?>
   
<?
if ($_GET['delete_id'])
{
    $key = $_GET['delete_id'];

    $query = "DELETE FROM services WHERE service_id=$key";
    if(!run_query($query))
    {
    $msg='Entry not deleted';
    }
    else
    {
    $msg='Entry deleted successfully';

    }
}
?>
<div>                   
    <div style="float:right; width:100%; text-align:left;">
      <span style="color:#33FF33"><?=$msg?></span>
    </div>
    <div style="clear:both;"> </div>
</div>
<br/>

<div class="widget">
  <div class="widget-title">
    <h4>Services</h4>
      <span class="actions">
        <a href="index.php?num=153" class="btn btn-primary btn-small">NEW</a>
      </span>
  </div>
  <div class="widget-body">
    <table id="table1" class="table table-bordered">
     <thead>
      <tr>
       <th>Service#</th>
       <th>Servicetype#</th>
       <th>Service name</th>
       <th>Narrative</th>
       <th>Keyword</th>
       <th>Amount</th>
       <th>Edit</th>
      </tr>
     </thead>
     <tbody>

 <?
   $distinctQuery = "SELECT * from services Order by service_id DESC";
   $resultId = run_query($distinctQuery);
   $total_rows = get_num_rows($resultId);


	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = $row['service_id'];
		$servicetypeid = $row['service_type_id'];
		$sname = $row['service_name'];
		$narrative = $row['narrative'];
		$sbillamt= $row['amount'];
		$keyword= $row['keyword'];
		 ?>
		  <tr>
		   <td><?=$trans_id; ?></td>
		   <td><?=getTypeNameByTypeId('service_types','service_type_name','service_type_id',$servicetypeid);?></td>
		   <td><?=$sname;?></td>
                   <td><?=$narrative?></td>
                   <td><?=$keyword?></td>
                   <td><?=$sbillamt; ?></td>
                    <td><a id="edit_link" class="btn btn-mini" href="index.php?num=154&edit_id=<?=$trans_id; ?>">
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