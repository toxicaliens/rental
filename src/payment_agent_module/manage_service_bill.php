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
   $distinctQuery2 = "select count(service_bill_id) as total_service_bill from ".DATABASE.".service_bills";
   $resultId2 = run_query($distinctQuery2);
   $arraa = get_row_data($resultId2);
   $total_rows2 = $arraa['total_service_bill'];
 ?>

<?
if ($_GET['delete_id'])
{
    $key = $_GET['delete_id'];

    $query = "DELETE FROM ".DATABASE.".service_bills WHERE service_bill_id=$key";
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
    <h4>Service Bills</h4>
      <span class="actions">
        <a href="index.php?num=150" class="btn btn-primary btn-small">NEW</a>
      </span>
  </div>
  <div class="widget-body">
    <table id="table1" class="table table-bordered">
     <thead>
      <tr>
       <th>Sbill#</th>
       <th>Service Type</th>
       <th>Sbill type</th>
       <th>Sbill name</th>
       <th>Sbill description</th>
       <th>Sbill amount</th>
       <th>Sbill due date</th>
       <th>Edit</th>
       <th>Drop</th>
      </tr>
     </thead>
     <tbody>

     <?
       $distinctQuery = "select * from ".DATABASE.".service_bills Order by service_bill_id DESC Limit 20";
       $resultId = run_query($distinctQuery);
       $total_rows = get_num_rows($resultId);


    	$con = 1;
    	$total = 0;
    	while($row = get_row_data($resultId))
    	{
    		$trans_id = trim($row['service_bill_id']);
    		$service_id = $row['service_id'];
    		$sbilltype = $row['service_bill_type'];
    		$sbillname = $row['service_bill_name'];
    		$sbilldesc = $row['service_bill_description'];
    		$sbillamt= $row['service_bill_amt'];
                    $sbillduetime = $row['service_bill_duetime'];
    		 ?>
    		  <tr>
    		   <td><?=$trans_id; ?></td>
    		   <td><?=getTypeNameByTypeId('service_types','service_type_name','service_type_id',$service_id);?></td>
    		   <td><?=($sbilltype == 1)? "Once Off":"Regular";?></td>
                       <td><?=$sbillname?></td>
                       <td><?=$sbilldesc; ?></td>
                       <td><?=$sbillamt?></td>
                       <td><?=$sbillduetime; ?></td>
                       <td><?='<a href=index.php?num=151&edit_id='.$trans_id.'>
                              <img src=src/img/edit.png /><span id=modifytool>Edit</span></a>'?>
                       </td>
                       <td><?='<a href=index.php?num=149&delete_id='.$trans_id.'>
                                <img src=src/img/drop.png /><span id=modifytool>Drop</span></a>'?>
                       </td>
                      </tr>
    		 <?

    	}

    	?>
      </tbody>
    </table>
    <div class="clearfix"></div>
  </div>
</div>