<?
set_layout("form-layout.php", array(
	'pageSubTitle'=> 'PAYMENT',
	'pageSubtitleText' => '',
	'pageBreadcrumbs' => array(
		array('url'=>'index.php', 'text'=>'Home'),
		array('text'=>'Pay')
		),
	'pageWidgetTitle'=>'PAY'
	));
$bill_id=$_GET['bill_id'];
// update ccn customer bills
if($_POST['action']=='Confirm')
	{
		$bill_id=$_GET['bill_id'];
		$bill_status=$_POST['bill_status'];

		$Query = "UPDATE customer_bills
					 SET bill_status = '".$bill_status."'
				   WHERE bill_id = '".$bill_id."'";
	 run_query($Query);
   		
	}

			//Insert into the database

if($_POST['action']=='Confirm')
	{
		$cust_name=$_POST['cust_name'];
		$cust_id = $_POST['cust_id'];
		$phone_no = $_POST['phone_no'];
		$serv_account_no=$_POST['serv_account_no'];
		$date = $_POST['date'];
		$service_account_type = $_POST['serv_type'];
		$amount = $_POST['amount'];
		$payment_mode = $_POST['payment_mode'];
		$bill_id_no = $_POST['bill_id'];
		$description = $_POST['description'];

		$Query = "INSERT INTO payments( customer_name,
										customer_id,
										phone_no,
										service_account_no,
										bill_id,
										payday,
										serv_type,
										amount,
										payment_mode,
										description
										)
								VALUES( '".$cust_name."',
										'".$cust_id."',
										'".$phone_no."',
										'".$serv_account_no."',
										'".$bill_id_no."',
										'".$date."',
										'".$service_account_type."',
										'".$amount."',
										'".$payment_mode."',
										'".$description."'
										)";
//echo $Query;
	 if(!run_query($Query))
   		{
	     	$message = ".<div class='alert alert-error'>
					 		<button class='close' data-dismiss='alert'>×</button>
					 		<strong>Error!</strong> Record not added.
					 	</div>.";
     	}
     else
		{     
	     	$message = ".<div class='alert alert-success'>
					 		<button class='close' data-dismiss='alert'>×</button>
					 		<strong>Success!</strong> Record added successfully.
					 	</div>.";

			//header('location:page2.php?msg=succes');
					 	header( "refresh:5;url=index.php?num=156" );
     	}
     	 
	}
	
	//Select from the database
	$bill_id=$_GET['bill_id'];
	$service_type = $_GET['servicetype'];
	$database = DATABASE;
	$table = 'customer_bills';
	$conditions = "WHERE bill_id = '$bill_id' ";
	$extras = '';
	$result = getdata($database, $table, $conditions, $extras);
	$data1 = get_row_data($result);
	//var_dump($data1);

	$customer_id = $data1['customer_id'];
	
	$query = "SELECT * 
				FROM ccn_customers
				WHERE ccn_customer_id = '$customer_id' ";
	//echo $query;

	 $resultId = run_query($query);
     $total_rows = get_num_rows($resultId);
     $data2 = get_row_data($resultId);

     $query3 = "SELECT * 
     			FROM service_account_types
     			-- WHERE service_account_type_id = $service_type";
     $resultId3 = run_query($query3);
     $data3 = get_row_data($resultId3);			

// echo $customer_id;

?>

<div>
    <div style="float:right; width:100%; text-align:left;">
       <? echo $message;?>
    </div>
    <div style="clear:both;"> 
    </div>
</div>
<br/>

<form name="pay" id="pay" method="post" action="" class="form-horizontal">

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="packlabel" class="control-label">Customer Name:</label>
				<div class="controls">
					<input type="text" name="cust_name" id="cust_name" value="<?=$data2['surname']; ?>"
							readonly style="background-color: #ccc">
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="packlabel" class="control-label">Customer ID:</label>
				<div class="controls">
					<input type="text" class="cust_id" name="cust_id" value="<?=$data1['customer_id']; ?>"
							readonly style="background-color: #ccc">
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="packlabel" class="control-label">Phone No:</label>
				<div class="controls">
					<input type="text" class="phone_no" name="phone_no" value="<?=$data2['phone']; ?>"
							readonly style="background-color: #ccc">
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="packlabel" class="control-label">Service Account No:</label>
				<div class="controls">
					<input type="text" class="serv_account_no" name="serv_account_no" 
					value="<?=$data1['service_account']; ?>" readonly style="background-color: #ccc">
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="packlabel" class="control-label">Date:</label>
				<div class="controls">
					<input type="text" name="date" id="date" value="<?=date('Y-m-d H:i:s');?>" 
							readonly style="background-color: #ccc">
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="packlabel" class="control-label">Service Account Type:</label>
				<div class="controls">
					<input type="text" name="serv_type" id="serv_type" 
							value="<?=$data3['service_account_type_name']; ?>" 
							readonly style="background-color: #ccc">
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="packlabel" class="control-label">Payment Mode:</label>
				<div class="controls">
					<select name="payment_mode" class="packinput">
                    <?php
                        $categories=run_query("select * from payment_mode");
                         while ($fetch=get_row_data($categories))
                         {
                         echo "<option value='".$fetch['payment_mode_name']."'>".$fetch['payment_mode_name']."</option>";
                         }
                         ?>
                     </select>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label for="packlabel" class="control-label">Amount:</label>
				<div class="controls">
					<input type="text" name="amount" id="amount" required>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label for="packlabel" class="control-label">Payment Description:</label>
				<div class="controls">
					<textarea type="text" name="description" class="input-large" row="3" required></textarea>
					<!-- <input type="textarea" name="description" id="description" required> -->
				</div>
			</div>
		</div>
	</div>

	<input type="hidden" name="bill_id" id="bill_id" value="<?=$data1['bill_id']; ?>">
	<input type="hidden" name="bill_status" id="bill_status" value="1">

	<div class="form-actions">
		<td align="center"><input type="submit" button class="btn btn-primary" name="action" value="Confirm"></td>
		<td align="center"><input type="submit" name="back" onclick = "history.go(-1);return false" value="Back"></td>
    </div>  
</form>
