<?php
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'AFYAPOA REGISTRATIONS',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Reports' ),
		array ( 'text'=>'Registrations' )
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
	<div class="widget-title"><h4><i class="icon-reorder"></i> All Registrations</h4></div>
	<div class="widget-body form">
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			  <tr>
			  <th>Policy ID#</th>
			  <th>Cust ID#</th>
			  <th>Names</th>
			  <th>start date</th>
			  <th>Phone</th>
			  <th>Premium</th>
			  <th>Deposit</th>
               <th>Loan</th>			  
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

   $distinctQuery = "SELECT af.*, c.* "
           . "FROM afyapoa_file af "
           . "LEFT JOIN customers c "
           . "ON af.customer_id = c.customer_id "
           . $filter
           . "Order by afyapoa_id DESC ";
        
   $resultId = run_query($distinctQuery);	
   $total_rows = get_num_rows($resultId);
	
   
	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$customer_id=$row['customer_id'];
                $afyapoa_id = $row['afyapoa_id'];
		$surname=$row['surname'];
		$start_date=$row['start_date'];
		$active=$row['active'];
		$customer_type_id=$row['customer_type_id'];

                if(isset($customer_type_id))
                    {
                    //$customer_type_id=getCustomerTypeId($customer_type_id);
                    }
                    
                $surname=$row['surname'];
		$firstname=$row['firstname'];
                $middle_name=$row['middlename'];
                
                $names = $surname . " ".$firstname;
                
		$address_id=$row['address_id'];
		if(isset($address_id))		{
		//$address_name=getAddressName($address_id);
		}
		
		$regdate_stam=$row['regdate_stamp'];
		$regdate_stamp=date("d-m-Y",$regdate_stam);
		$national_id_number=$row['national_id_number'];
		$phone=$row['phone'];
		$passport=$row['passport'];
		$premium =$row['total_premium'];
		$paid_premium =$row['paid_premium'];
                $loan_amount = $row['loan_amount'];
		
		$timedate=date("d-m-Y", strtotime($row['time_date']));
 ?>
		  <tr>
			<td><?=$afyapoa_id; ?></td>
			<td><?=$customer_id; ?></td>
			<td><?=$names; ?></td>
			<td><?=$start_date; ?></td>
			<td><?=$phone; ?> </td>
			<td><?=$premium; ?> </td>
			<td><?=$paid_premium; ?> </td>		
            <td><?=$loan_amount; ?> </td>	
       </tr>
		 <?php
 
	}
	   
	?>
  
  </tbody>
</table>
<div class="clearfix"></div>
</div>
</div>

