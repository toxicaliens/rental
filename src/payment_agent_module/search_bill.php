<fieldset><legend><label class="packlabel"> Search Bill </label> </legend>
 <table>
    <form name="" action="" method="post">
        <tr>
            <td><label class="packlabel">Surname/Firstname/Phone</label></td>
            <td><input type="text" name="value" value="" class="packinput"></td>
         
            <td><label class="packlabel">Bill status</label></td>
            <td>
                <select name="bstatus">
                    <option value="">--select status --</option>
                    <option value="0">Pending</option>
                    <option value="1">Paid</option>
                </select>
            </td>

            <td><label class="packlabel">Service Account</label></td>
            <td><input type="text" name="saccount" value="" class="packinput"></td>

        </tr>
        <tr>
             <td><label class="packlabel">Bill ID</label></td>
            <td><input type="text" name="billid" value="" class="packinput"></td>

            <td>&nbsp;</td>
            <td>&nbsp;</td>

            <td>&nbsp;</td>
            <td align="right"><input type="submit" name="billsearch" value="search" id="confbutton"></td>

        </tr>
    </form>
</table>
  </fieldset>


 <?
 if($_POST['billsearch'] == "search")
 {
  
  $value = strtoupper($_POST['value']);

  $status = $_POST['bstatus'];
  $saccount = $_POST['saccount'];
  $bill_id = $_POST['billid'];

  $customerid =  getCustomerIDByPhoneSurname($value);

  //echo $customerid;

  $b = session_id();
  if(empty ($b))
  {
      session_start();
  }
  $_SESSION['customerid'] = $customerid;
  $_SESSION['saccount'] = $saccount;
  $_SESSION['status'] = $status;
   $_SESSION['billid'] = $bill_id;

   $distinctQuery2 = "select count(bill_id) as total_bills from ".DATABASE.".customer_bills WHERE bill_id like '%%'";
   if($customerid != "")
   {
       $distinctQuery.=" AND customer_id = '$customerid'";
   }
   if($status != "")
   {
       $distinctQuery.=" AND bill_status = '$status'";
   }
   if($saccount != "")
   {
       $distinctQuery.=" AND service_account = '$saccount'";
   }
   
   
   $resultId2 = run_query($distinctQuery2);
   $arraa = get_row_data($resultId2);
   $total_rows2 = $arraa['total_bills'];
 ?>

 <script type="text/javascript">
		$(document).ready(
			function() {
				$("#table1").ingrid({
					url: 'payment_agent_module/remote_search_bill.php',
					height: 400,
					totalRecords: <?=$total_rows2;?>,
					pageNumber: 1,
					recordsPerPage: 0,
					colWidths: [70,120,120,120,120,120,120,100,130,100]
				});
			}
		);
</script>

<?
//if ($_GET['delete_id'])
//{
//    $key = $_GET['delete_id'];
//
//    $query = "DELETE FROM ".DATABASE.".customer_bills WHERE bill_id=$key";
//    if(!run_query($query))
//    {
//    $message ='Entry not deleted';
//    }
//    else
//    {
//    $message ='Entry deleted successfully';
//
//    }
//}
?>

<!--<div>
                    <div style="float:left; width:350px;">
                        <a href="index.php?num=111">NEW</a>
                    </div>
                    <div style="float:right; width:400px; text-align:left;">

                  <span style="color:#33FF33"><?//=$message?></span>
                    </div>
                    <div style="clear:both;"> </div>

                </div>
<br/>-->


 <fieldset><legend class="table_fields"> Bills </legend>
   <table id="table1">
 <thead>
  <tr>
   <th>Bill#</th>
   <th>B.Due date</th>
   <th>Customer Surname</th>
   <th>Customer Firstname</th>
   <th>B.Amount</th>
   <th>B.Status</th>
   <th>Service Account</th>
   <th>B.Balance</th>
  <th>Service Account Type</th>
  <th>Action</th>
  </tr>
 </thead>
 <tbody>

 <?
  
 
   $distinctQuery = "SELECT * FROM ".DATABASE.".customer_bills";
   if($bill_id == "")
   {
       $distinctQuery.=" WHERE bill_id like '%%'";
   }
   if($bill_id != "")
   {
       $distinctQuery.=" WHERE bill_id = '$bill_id'";
   }
   if($customerid != "")
   {
       $distinctQuery.=" AND customer_id = '$customerid'";
   }
   if($status != "")
   {
       $distinctQuery.=" AND bill_status = '$status'";
   }
   if($saccount != "")
   {
       $distinctQuery.=" AND service_account = '$saccount'";
   }
   $distinctQuery.=" Order by bill_id DESC Limit 20";
   
   $resultId = run_query($distinctQuery);
   $total_rows = get_num_rows($resultId);


	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['bill_id']);
                $duedate= date("d-m-Y H:i:s",$row['bill_due_date']);
		$customer_id = $row['customer_id'];
		$bill_amt = $row['bill_amt'];
                $bstatus = $row['bill_status'];
		$serviceaccount = $row['service_account'];
                $bill_balance = $row['bill_balance'];
                $serviceaccounttype = $row['service_account_type'];


		 ?>
		  <tr>
		   <td><?=$trans_id; ?></td>
		   <td><?=$duedate; ?></td>
		   <td>
                   <?
                   if($customer_id == "")
                    {
                       echo "-";
                    }
                    else
                    {
                        echo getTypeNameByTypeId('ccn_customers','surname','ccn_customer_id',$customer_id);
                    }

                   ?>
                   </td>
                   <td>
                   <?
                   if($customer_id == "")
                    {
                       echo "-";
                    }
                    else
                    {
                        echo getTypeNameByTypeId('ccn_customers','firstname','ccn_customer_id',$customer_id);
                    }

                   ?>
                   </td>
                   <td><?=$bill_amt; ?></td>
                   <td><?=($bstatus=="1")? "PAID":"PENDING";?></td>
		   <td><?=$serviceaccount; ?></td>
                   <td><?=$bill_balance; ?></td>
                   <td><?=getTypeNameByTypeId('service_account_types','service_account_type_name','service_account_type_id',$serviceaccounttype);?></td>
                   <td><?='<a href=index.php?num=140&bill_id='.$trans_id.'&amount='.$bill_balance.'><span id=modifytool>PAY</span></a>'?></td>
		  </tr>
		 <?
 	}
	?>
  </tbody>
</table>
</fieldset>
<?
 }
?>