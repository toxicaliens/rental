<?php
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Search Customer',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Gpay Wallet' ),
		array ( 'text'=>'Search Customer' )
	)
	
));

$resultId = false;
if ( isset($_POST['search_item']) && !empty($_POST['search_item']) )
{
	$search = strtolower(trim($_POST['search_item']));
	$query = "
		SELECT m.*, ct.customer_type_name FROM masterfile m
		LEFT JOIN customer_types ct ON ct.customer_type_id = m.customer_type_id
		WHERE (lower(surname) LIKE '%".sanitizeVariable($search)."%' OR 
		lower(firstname) LIKE '%".sanitizeVariable($search)."%' OR
		lower(middlename) LIKE '%".sanitizeVariable($search)."%') AND b_role = 'client'
	";	
	$resultId = run_query($query);
	//argDump($query);exit;
}

/**
 * Set page layout
 */
set_layout("dt-layout.php");
?>
		<!-- BEGIN PAGE -->  
	        <div class="span12">
				<div class="row-fluid">
				<!-- BEGIN PAGE TITLE -->
				<h3 class="page-title">
					Search for a Customer
					<small></small>
				</h3>
				<!-- END PAGE TITLE -->

				<!-- BEGIN PAGE CONTENT -->
				<div class="row-fluid">
					<div class="span12">
						<div class="row-fluid">
							<div class="widget">
								<div class="widget-title"><h4>Search Parameters</h4></div>
								<div class="widget-body form">
									<form name="market type" method="post" action="" class="form-horizontal">
										<div class="control-group">
											<label for="surname" class="control-label">Search String</label>
											<div class="controls">
												<input name="search_item" type="text" id="search_item" size="50" />
												<span class="help-block">Surname/First Name/Middle Name</span>
											</div>
										</div>
										
										<input name="action" type="hidden" class="header_del_sub" id="action" value="showCustomer" />
										
										<div class="form-actions">
											<button class="btn btn-primary" type="submit">Search</button>
											<button class="btn" type="reset">Reset</button>
										</div>
									</form>
								</div>
							</div>
<?php if ( $resultId !== false ) { ?>

							<div class="widget">
								<div class="widget-title"><h4>Search Results</h4></div>
								<div class="widget-body form">
									<table id="table1" class="table table-bordered">
										<thead>
											<tr class="table_fields">
												<th>MF#</th>
												<th>Start Date</th>
												<th>Surname</th>
												<th>Middle Name</th>
												<th>Customer Type</th>
												<!-- <th>Phone Number</th> -->
												<th>B. Role</th>
												<th>View</th>
											</tr>
										</thead>
										<tbody>
<?php
	$con = 1;
	$total = 0;
	//argDump(get_row_data($resultId));exit;
	
	while ( $row = get_row_data($resultId) )
	{
		$customer_id = $row['mf_id'];
		$surname = $row['surname'];
		$firstname = $row['firstname'];
		
		$middle_name = $row['middlename'];
		$regdate_stam = $row['regdate_stamp'];
		$regdate_stamp = date("d-m-Y", strtotime($regdate_stam));
		$username = $row['username'];
		//$email = $row['email'];
		$date_started = date('d-M-Y', $row['time_stamp']);
		
		$customer_type_name = $row['customer_type_name'];
		$b_role = $row['b_role'];
 ?>
<tr>
	<td><?=$customer_id; ?></td>
	<td><?=$date_started; ?></td>
	<td><?=$surname; ?></td>
	<td><?=$middle_name; ?></td>
	<td><?=$customer_type_name; ?></td>
	<td><?=$b_role; ?></td>		
	<td><a href="?num=view_statement&mf_id=<?=$customer_id; ?>" class="btn btn-mini"><i class="icon-edit"></i> View Statement</a></td>
</tr>
<?php
		$total++;
	} /* End of while loop */
	
	// If there were no records to show
	if ( $total == 0 ) {
?>
<?php }?>
										<tbody>
									</table> <div class="clearfix"></div>
								</div>
							</div>
<?php
} /* End of showing searched results */
?>

						</div>
					</div>
				</div>
				<!-- END PAGE CONTENT -->
				
			</div>
		</div>
		<!-- END PAGE --> 

