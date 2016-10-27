<?php
        // A function to get customer id
    function getCustomerIDByPhoneSurname($value)
    {
           
           $empty = "";
           $unavailablevalue = "wrongvalue";

           //echo "phone=".$phone."  surname=".$surname."  firstname=".$firstname;
           $query = "SELECT * FROM ".DATABASE.".ccn_customers WHERE phone = '$value' OR surname = '$value' OR firstname = '$value'";
           
           // echo $query;
            $data = run_query($query);
            $numrows = get_num_rows($data);
            if($numrows > 0)
            {
            $rows = get_row_data($data);
            $customerid = trim($rows['ccn_customer_id']);
            return $customerid;
            }
            elseif(empty($value))
            {
                return $empty;
            }
            else
             {
             return $unavailablevalue;
            }
    }
    /* Function to add a cash agent record*/
    function addcashagentrecord($inv_no,$amount,$billid)
    {
      $add_clamp_records=run_query("INSERT INTO ".DATABASE.".ccncashagent(invoice_number,status,amount,bill_id) VALUES ('".$inv_no."','0','".$amount."','".$billid."')");
    }

    /* Function to update the cash agent record status*/
    function updatecashagent($transid)
    {
      $add_clamp_records=run_query("UPDATE ".DATABASE.".ccncashagent SET status='1' WHERE transaction_id=$transid");
    }

    /*Function to pass a request for paying bill*/
   function pay_bill($bid, $amnt)
                {
                              $string_arr = array(  'AgentCode' => "CCNCASHIER",
                                                    'AgentPassword' => "123456",
                                                    'AgentTransId' => "",
                                                    'CustomerOption' => "209",
                                                    'CustomerAccount' => $bid,
                                                    'CustomerInputs' => $bid,
                                                    'PayingAmount' => $amnt,
                                                    'CustomerPhone' => "",
                                                    'CustomerEmail' => "",
                                                    'FundAgent' => "PIID",
                                                    'FundAccount' =>"",
                                                    'FundPin' => "4444",
                                                    'FundInputs' => "",
                                                    'SwcVersion' => '1.0');
                              
                                $client = new SoapClient("http://localhost/bibi/soap/ccn_ebppp.wsdl");
                               
                                $arr = $client->payBill($string_arr);

                                 // print_r($arr);
                                 $result_array = array();

                                 if($arr['request_status'] == "REQSUCCESS")
                                 {
                                        sleep(5);
                                        $status_string = array(
                                        'AgentCode' => "CCNCASHIER",
                                        'AgentPassword' => "123456",
                                        'EbpppTransId' => $arr['ebppp_trans_id']
                                         );

                                        $result= $client->checkStatus($status_string);

                                        $trans = $result['ebppp_trans_id'];
                                        $request_status = $result['request_status'];
                                        $Invno = $result['invoice_number'];

                                        if($request_status=="REQUEST_IN_QUEUE")
                                        {
                                          $result_array['response'] = "The transaction is being processed wait for 10 seconds and refresh the page";
                                        }
                                        elseif($request_status=="REQUEST_PENDING_FUNDS") {

                                        addcashagentrecord($Invno,$amnt,$bid);

                                        $result_array['response'] = "Confirm that you have the stated <b>Amount</b> at hand then click <b>Confirm<b> ";
                                        $result_array['trans_id'] = $trans;
                                        }

                                           elseif($request_status=="UNKNOWN_TRANSACTION"){
                                          $result_array['response'] = "Unknown Transaction";
                                        }

                                    }
                                    else
                                    {
                                     $result_array['response'] = "Account not debited .. retry again";
                                    }
                                  return  $result_array;
                }


/*Function to pass a request for buying service*/
   function buyservice($caccount,$amnt,$phone,$email,$optcode)
                {
                          $string_arr = array(
                                 'AgentCode' =>"CCNCASHIER",
                                 'AgentPassword' => "123456",
                                 'AgentTransId' => "",
                                 'CustomerOption' => $optcode,
                                 'CustomerAccount' => $caccount,
                                 'CustomerInputs' => $caccount,
                                 'CustomerPhone' => $phone,
                                 'CustomerEmail' => $email,
                                 'FundAgent' => "PIID",
                                 'FundAccount' => "",
                                 'FundPin' => "4444",
                                 'FundInputs' => "",
                                 'ServiceAmount' => $amnt,
                                 'SwcVersion' => "1.1"
                              );

                                $client = new SoapClient("http://localhost/bibi/soap/ccn_ebppp.wsdl");

                                $arr = $client->buyService($string_arr);

                                // print_r($arr);
                                $resultarray = array();

                                 if($arr['request_status'] == "REQSUCCESS")
                                 {
                                        sleep(5);
                                        $status_string = array(
                                        'AgentCode' => "CCNCASHIER",
                                        'AgentPassword' => "123456",
                                        'EbpppTransId' => $arr['ebppp_trans_id']
                                         );

                                        $result= $client->checkStatus($status_string);

                                        $trans = $result['ebppp_trans_id'];
                                        $request_status = $result['request_status'];
                                        $Invno = $result['invoice_number'];

                                        

                                        if($request_status=="REQUEST_IN_QUEUE"){
                                         $resultarray['response'] =  "The transaction is being processed wait for 10 seconds and refresh the page";
                                        }
                                        elseif($request_status=="REQUEST_PENDING_FUNDS"){

                                        addcashagentrecord($Invno,$amnt,$bid);
                                        $resultarray['response'] =  "Confirm that you have the stated <b>Amount</b> at hand then click <b>Confirm<b>";
                                        $resultarray['invoice_number'] = $Invno;
                                        $resultarray['trans_id'] = $trans;

                                        }
                                       elseif($request_status=="UNKNOWN_TRANSACTION"){
                                          
                                           $resultarray['response'] = "Unknown Transaction";

                                        }

                                    }
                                    else
                                    {
                                     $resultarray['response'] = "Account not debited .. retry again";
                                    }
                             return $resultarray;
                }


/* Function to confirm the payment*/
 function sourceoffund($transid,$amount,$invoiceno,$ebbtransid)
        {
                      $string_arr = array(  'sofCode' => "CCNCASHIER",
                                            'sofPassword' => "123456",
                                            'sofTransId' => $transid,
                                            'CustomerOption' => "",
                                            'ebpppRequestId' =>$invoiceno,
                                            'sofAmount' =>$amount,
                                            'sofTransStatus' => "",
                                            'sofReceipt' => $transid,
                                            'sofResponse' => "");

                        $client = new SoapClient("http://localhost/bibi/soap/ccn_ebppp.wsdl");

                        $arr = $client->sofReturn($string_arr);
                       // print_r($arr);
                        $sof_resultarray = array();

                        updatecashagent($transid);

                         if($arr == "REQSUCCESS")
                                 {
                                        sleep(5);
                                        $status_string = array(
                                        'AgentCode' => "CCNCASHIER",
                                        'AgentPassword' => "123456",
                                        'EbpppTransId' => $ebbtransid
                                         );

                                        $result= $client->checkStatus($status_string);

                                        //print_r($result);

                                        $trans = $result['ebppp_trans_id'];
                                        $request_status = $result['request_status'];
                                        $usp_status = $result['usp_status'];
                                        $usp_response = $result['usp_response'];

                                        if($request_status=="REQUEST_IN_QUEUE"){
                                         $sof_resultarray['response'] = "The transaction is being processed wait for 10 seconds and refresh the page";
                                        }
                                        elseif($request_status=="REQUEST_COMPLETE"){
                                            
                                         $sof_resultarray['response']= $usp_response;
                                        }
                                    }
                                    else
                                    {
                                     $sof_resultarray['response'] = "Account not debited .. retry again";
                                    }
                                    return $sof_resultarray;
        }

/*Function to check the status of a business account if the account has no bill associated to it */
function checkbusinessaccountstatus($saccount)
{
    $distinctQuery1 = "select * from ".DATABASE.".business where business_id='$saccount'";
         //echo $distinctQuery;
         $resultId1 = run_query($distinctQuery1);
         $total_rows1 = get_num_rows($resultId1);
         if($total_rows1 < 1)
         {
            $msg =  "The Business account does not exist";
         }
         else
         {
             while( $row = pg_fetch_array($resultId1))
            {
                $rowstatus = $row['business_status'];
            }
            if( $rowstatus == "1")
                {
                $msg = "No bill associated to that Business Account";
                }
             else
             {
                 $msg = "The Business Account is inactive";
             }
         }
         return $msg;
}
/*Function to check the status of a business account if the account has no bill associated to it */
function checklandratesaccountstatus($saccount)
{
    $distinctQuery1 = "select * from ".DATABASE.".land_rates where plot_number='$saccount'";
         //echo $distinctQuery;
         $resultId1 = run_query($distinctQuery1);
         $total_rows1 = get_num_rows($resultId1);
         if($total_rows1 < 1)
         {
            $msg =  "The Land Rates account does not exist";
         }
         else
         {
             while( $row = pg_fetch_array($resultId1))
            {
                $rowstatus = $row['land_status'];
            }
            if( $rowstatus == "1")
                {
                $msg = "No bill associated to that Land Rates Account";
                }
             else
             {
                 $msg = "The Land Rates Account is inactive";
             }
         }
         return $msg;
}

/*Function to check the status of a house account if the account has no bill associated to it */
function checkhouserentaccountstatus($saccount)
{
    $distinctQuery1 = "select * from ".DATABASE.".house_rent where house_number='$saccount'";
         //echo $distinctQuery;
         $resultId1 = run_query($distinctQuery1);
         $total_rows1 = get_num_rows($resultId1);
         if($total_rows1 < 1)
         {
            $msg =  "The HouseRent/MarketStall account does not exist";
         }
         else
         {
             while( $row = pg_fetch_array($resultId1))
            {
                $rowstatus = $row['rent_status'];
            }
            if( $rowstatus == "1")
                {
                $msg = "No bill associated to that HouseRent/MarketStall Account";
                }
             else
             {
                 $msg = "The HouseRent/MarketStall Account is inactive";
             }
         }
         return $msg;
}

function array2json($arr) {
    if(function_exists('json_encode')) return json_encode($arr); //Lastest versions of PHP already has this functionality.
    $parts = array();
    $is_list = false;

    //Find out if the given array is a numerical array
    $keys = array_keys($arr);
    $max_length = count($arr)-1;
    if(($keys[0] == 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1
        $is_list = true;
        for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position
            if($i != $keys[$i]) { //A key fails at position check.
                $is_list = false; //It is an associative array.
                break;
            }
        }
    }

    foreach($arr as $key=>$value) {
        if(is_array($value)) { //Custom handling for arrays
            if($is_list) $parts[] = array2json($value); /* :RECURSION: */
            else $parts[] = '"' . $key . '":' . array2json($value); /* :RECURSION: */
        } else {
            $str = '';
            if(!$is_list) $str = '"' . $key . '":';

            //Custom handling for multiple data types
            if(is_numeric($value)) $str .= $value; //Numbers
            elseif($value === false) $str .= 'false'; //The booleans
            elseif($value === true) $str .= 'true';
            else $str .= '"' . addslashes($value) . '"'; //All other things
            // :TODO: Is there any more datatype we should be in the lookout for? (Object?)

            $parts[] = $str;
        }
    }
    $json = implode(',',$parts);

   // return hello;

    if($is_list) return '[' . $json . ']';//Return numerical JSON
    return '{' . $json . '}';//Return associative JSON
}

function getbill($serviceaccount,$service_account_type)
{
 $distinctQuery = "select * from ".DATABASE.".customer_bills where service_account='$serviceaccount' AND bill_status='0' Order by bill_id DESC";
 //echo $distinctQuery;
 $resultId = run_query($distinctQuery);
 $total_rows = get_num_rows($resultId);
 if($total_rows > 0)
 {

       
        $myBill = array();

        $count = 0;
	while($row = get_row_data($resultId))
	{
		$trans_id = trim($row['bill_id']);
		$bill_amount = $row['bill_amt'];

                 $myBill[$count] = array(
                     'transid' => $trans_id,
                     'billamount' => $bill_amount
                 );

                $count ++;
		
	}
       // return $myBill;
      return  array2json($myBill);
 }
 elseif($service_account_type == "3")
     {
        return  checkbusinessaccountstatus($serviceaccount);
     }
 elseif($service_account_type == "4")
     {
        return checklandratesaccountstatus($serviceaccount);
     }
 elseif($service_account_type == "5")
     {
        return checkhouserentaccountstatus($serviceaccount);
     }
  else{
      return "No bill to settle";
  }
}




//Daemon to send sms notifications
function sendbillnotifications()
{
   //Get all bills whose sms notifications have not been sent
    $query = "SELECT * FROM customer_bills WHERE sms_notification = '0'";
    $result = run_query($query);
    while($row = get_row_data($result))
    {
        $serviceacc = $row['service_account'];
        $customerid = $row['customer_id'];
        $billbalance = $row['bill_balance'];

        //call the web service
          $client = new SoapClient("http://192.168.100.13/sms/webservice/smsWebservice.wsdl");

        //checks whether a customer attached to the bill exists
        if($customerid != "")
        {
           //get customers phone
           // print_r(getcustomerphone($customerid));
            $phone = getcustomerphone($customerid);

            //send sms
            $string_arr = array(  'AGENTCODE' => "CCNMODULES",
                                  'SMSTEXT' => "Dear customer You have a pending balance of ksh ". $billbalance ."Thank you",
                                   'PHONE' => '$phone',
                                   'SHORTCODE' => "3034"
                );

            $arr = $client->sendSingleSMS($string_arr);

        }
        //get subscriptions related the bill account(they are an array)
         $myphone = getsubscription($serviceacc);

         $count = 0;
         //get each value of an array index
         while($count <= count($myphone))
         {
             $phone = $myphone[$count];

             // send sms
             $string_arr = array(  'AGENTCODE' => "CCNMODULES",
                                  'SMSTEXT' => "Dear customer You have a pending balance of ksh ". $billbalance ."Thank you",
                                   'PHONE' => $phone,
                                   'SHORTCODE' => "3034"
                );

            $arr = $client->sendSingleSMS($string_arr);

         }


    }
}

function service_bill_not_available($servicebillname,$serviceid)
{
    $query = "SELECT * FROM service_bills WHERE service_bill_name = '$servicebillname' AND service_type_id = '$serviceid'";
    $results = run_query($query);
    $num_rows = get_num_rows($results);
    if($num_rows > 0)
    {
        return FALSE;
    }
    else
    {
        return TRUE;
    }
}
function service_not_available($servicename,$servicetypeid)
{
    $query = "SELECT * FROM services WHERE service_name = '$servicename' AND service_type_id= '$servicetypeid'";
    $results = run_query($query);
    $num_rows = get_num_rows($results);
    if($num_rows > 0)
    {
        return FALSE;
    }
    else
    {
        return TRUE;
    }
}
function keyword_not_available($keyword)
{
    $query = "SELECT * FROM services WHERE keyword= '$keyword'";
    $results = run_query($query);
    $num_rows = get_num_rows($results);
    if($num_rows > 0)
    {
        return FALSE;
    }
    else
    {
        return TRUE;
    }
}

