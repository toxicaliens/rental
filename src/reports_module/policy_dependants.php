<?php
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'AFYAPOA POLICY DEPENDANTS',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Reports' ),
		array ( 'text'=>'Policy Dependants' )
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
	<div class="widget-title"><h4><i class="icon-reorder"></i> All Policy Dependants</h4></div>
	<div class="widget-body form">
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			  <tr>
			  <th>Dependant ID#</th>
			  <th>Policy#</th>
			  <th>Pricipal</th>
			  <th>Names</th>
			  <th>Gender</th>
			  <th>Depenadent DOB</th>
               <th>Date Created</th>
               <th>Status</th>
               <th>Mcare Id</th>			  
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

   $distinctQuery = "SELECT ad.*, c.customer_id "
           . "FROM afyapoa_dependants ad "
           . "LEFT JOIN customers c "
           . "ON ad.afyapoa_id = c.customer_id "
           . $filter
           . "Order by dependant_id DESC ";
    // var_dump($distinctQuery);exit;
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$dependant_id=$row['dependant_id'];
        $afyapoa_id = $row['afyapoa_id'];
        $customer_id = $row['customer_id'];
		$dependant_names =$row['dependant_names'];
		$dependant_dob=$row['dependant_dob'];
		$dependant_gender=$row['dependant_gender'];
		$date_created =$row['date_created'];
		$status =$row['status'];
		if($status == '0'){
			$status = 'Not Active';
		}else{
			$status = 'Active';
		}
        $mcare_id = $row['mcare_id'];
		
 ?>
		  <tr>
			<td><?=$dependant_id; ?></td>
			<td><?=$afyapoa_id; ?></td>
			<td><?=getPricipalName($afyapoa_id); ?></td>
			<td><?=$dependant_names; ?> </td>
			<td><?=$dependant_gender; ?> </td>
			<td><?=$dependant_dob; ?> </td>		
            <td><?=$date_created; ?> </td>
            <td><?=$status; ?> </td>
            <td><?=$mcare_id; ?> </td>	
			
       </tr>
		 <?php
 
	}
	   
	?>
  
  </tbody>
</table>
<div class="clearfix"></div>
</div>
</div>

