<?php
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'AFYAPOA HOSPITAL & MSP VISITS',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Reports' ),
		array ( 'text'=>'Hospital & Msp Visits' )
	)
	
));
?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> Filters</h4>
		<span class="tools">
			<a href="javascript:;" class="icon-chevron-down"/></a>
		</span>
	</div>
	<div class="widget-body form">
		<form action="" method="post" class="form-horizontal">
			<div class="row-fluid">
				<div class="span6">
					<label for="date_range" class="control-label">Date Range:</label>
					<div class="controls">
						<div class="input-prepend span3">
				           <span class="add-on"><i class="icon-calendar"></i></span><input required title="Choose the date-range" for="date-range" name="date_range" type="text" class="date-range" />
				    	</div>
					</div>
				</div>
			</div>
			<div class="form-actions">
	    		<? viewActions($_GET['num'], $_SESSION['role_id']); ?>
	    	</div>
		</form>
	</div>
</div>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> All Hospital & MSP Visits</h4></div>
	<div class="widget-body form">
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			  <tr>
			  <th>Visit ID#</th>
			  <th>Cust ID#</th>
			  <th>MSP ID</th>
			  <th>Visit Date</th>
			  <th>Bill Amount</th>
			  <th>Mcare Ref</th>		  
			  </tr>
 		</thead>
 	<tbody>
 <?php
 	//filter
 	if(isset($_POST['date_range'])){
 		$date_range = $_POST['date_range'];
 		$date_array = explode(' - ', $date_range);
 		// echo '<pre>',print_r($date_array), '</pre>';
 		$from = strtotime($date_array[0]);
 		$to = strtotime($date_array[1]);

 		$filter = " WHERE date_started >= '".$from."' AND date_started <= '".$to."'";
 	}else{
 		$filter = "";
 	}

   $distinctQuery = "SELECT mv.*, c.* "
           . "FROM msp_visits mv "
           . "LEFT JOIN customers c "
           . "ON mv.customer_id = c.customer_id "
           . $filter
           . "Order by visit_id DESC ";
        
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$visit_id=$row['visit_id'];
        $customer_id = $row['customer_id'];
		$surname=$row['surname'];
		$firstname=$row['firstname'];
        $middle_name=$row['middlename'];
        $names = $surname . " ".$firstname;
		$visit_date=$row['visit_date'];
		$bill_amount=$row['bill_amount'];
		$msp_id=$row['msp_id'];
		$mcare_ref=$row['mcare_ref'];

           
 ?>
		  <tr>
			<td><?=$visit_id; ?></td>
			<td><?=$names; ?></td>
			<td><?=$msp_id; ?> </td>
			<td><?=$visit_date; ?> </td>
			<td><?=$bill_amount; ?> </td>		
            <td><?=$mcare_ref; ?> </td>	
       </tr>
		 <?php
 
	}
	   
	?>
  
  </tbody>
</table>
<div class="clearfix"></div>
</div>
</div>

