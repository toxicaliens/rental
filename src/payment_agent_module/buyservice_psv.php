<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
	//initiate validator on load
	$(function() {
		// validate contact form on keyup and submit
		$("#cdetails").validate({
			//set the rules for the fild names
			rules: {
				platenumber: {
					required: true,
				},
				phonenumber: {
					required: true,

				},
				email: {
					required: true,

				},
			},
			//set messages to appear inline
			messages: {
				platenumber: "Please enter plate number",
				phonenumber: "Please enter phone number",
				email: "Please enter email address"
			}
		});
	});
</script>


<div>

                    <div style="float:right; width:400px; text-align:left;">

                  <span style="color:#33FF33"><?=$msg?></span>
                    </div>
                    <div style="clear:both;"> </div>

                </div>
<br/>
<fieldset><legend class="table_fields"><?=$_GET['nme']?></legend>
    <form name="cdetails" id="cdetails" method="post" action="">
     <table>
         <tr>
             <td><label class="packlabel">Plate Number</label></td>
             <td><input type="text" name="platenumber" value=""  class="packinput"></td>


             <td><label class="packlabel">Phone number</label></td>
             <td><input type="text" name="phonenumber" value=""  class="packinput"></td>
        </tr> <tr>
             <td><label class="packlabel">Customer Email</label></td>
             <td><input type="text" name="email" value=""  class="packinput"></td>

             <td>&nbsp;</td>
             <td><td align="right"><input type="submit" name="details" value="GO"></td>
         </tr>
             </table>

         <?php
             if($_POST['details'] == "GO")
             {
                 $amt = $_GET['amt'];
                 $optcode = $_GET['optcode'];
                 $svcac = $_POST['platenumber'];
                 $phn = $_POST['phonenumber'];
                 $email = $_POST['email'];

              $resulset =  buyservice($svcac,$amt,$phn,$email,$optcode);

              //  print_r($resulset);
                $invoiceno = $resulset['invoice_number'];
                $response =  $resulset['response'];
                $ebbtransid = $resulset['trans_id'];
               ?>


</form>
</fieldset>

<fieldset><legend> Confirmation of Receipt Cash</legend>
    <br/><span><?php echo $response; ?></span><br/><br/>
    <?

 if($invoiceno != "")
    {
$serviceaccount = $_POST['service_account'];

 $distinctQuery = "select * from ".DATABASE.".ccncashagent where invoice_number='$invoiceno' AND status ='0' Order by bill_id DESC";
 //echo $distinctQuery;
 $resultId = run_query($distinctQuery);
 $total_rows = get_num_rows($resultId);
 if($total_rows > 0)
 {
    ?>

   <table id="table1"  width="600" border="0" align="left" bgcolor="#F2F2F2" cellspacing="2" cellpadding="3">
 <thead>
  <tr bgcolor="#C7C7C7">

   <th width="147" align="left" valign="middle">Transaction  ID</th>
   <th width="147" align="left" valign="middle">Invoice Number</th>
   <th width="147" align="left" valign="middle">Amount</th>

   <th width="147" align="left" valign="middle">ACTION</th>

  </tr>
 </thead>
 <tbody>

 <?



	$con = 1;
	$total = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['transaction_id']);
		$invno = $row['invoice_number'];
		$amount = $row['amount'];
		$status = $row['status'];
		 ?>
		  <tr>

		   <td align="left" valign="top"><?=$trans_id; ?></td>
		   <td align="left" valign="top"><?=$invno; ?></td>
                   <td align="left" valign="top">Ksh.<?=$amount?></td>
                   <td align="left" valign="top"><?='<a href=index.php?num=141&trns_id='.$trans_id.'&amount='.$amount.'&invno='.$invno.'&ebbtransid='.$ebbtransid.'><span id=modifytool>CONFIRM</span></a>'?></td>

		  </tr>
		 <?

	}
 }
	?>
  </tbody>
</table>
<?}?>
</fieldset>

 <?}?>