<?
	include "../connection/config.php";
	include "../library.php";
        include "../parking_module/library.php";

	$page = $_GET['page'];

	if($page == 1)
	    $offset = 0;
	else
		$offset = $page * 20;


?>
 <table id="table1">
 <tbody>

 <?
      $b = session_id();
      if(empty ($b))
      {
          session_start();
      }

      $customerid = $_SESSION['customerid'];
      $status = $_SESSION['status'];
      $saccount = $_SESSION['saccount'];
      $bill_id = $_SESSION['billid'];


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
   $distinctQuery.=" Order by bill_id DESC Limit 20 OFFSET $offset";

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
