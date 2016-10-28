<?php

//function to get all subscriptions
function getsubscription($serviceaccount)
{
    $query = "SELECT * FROM ccn_subscriptions WHERE service_account ='$serviceaccount'";
    $result = run_query($query);
    $myvalues = array();
    $count = 0;
    while($row = get_row_data($result))
    {
        $myvalues[$count] = array(
            'phone'=>$row['phone'],
            'email'=>$row['email']
        );
        $count ++;
    }
    return $myvalues;
}

//function to get customers phone and email
function getcustomerphone($customerid)
{
    $query = "SELECT * FROM ccn_customers WHERE ccn_customer_id ='$customerid'";
    $result = run_query($query);

    while($row = get_row_data($result))
    {
        $phone = $row['phone'];
        $email= $row['email'];
        $myvalues = array(
            'phone'=>$phone,
            'email'=>$email
        );
    }
    return $myvalues;
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
           //get customers phone and email
            $values =  getcustomerphone($customerid);
            $phone = $values['phone'];
            $email = $values['email'];

            //send sms
            $string_arr = array(  'AGENTCODE' => "CCNMODULES",
                                  'SMSTEXT' => "Dear customer You have a pending balance of ksh". $billbalance ." For account " .$serviceacc. " Thank you",
                                   'PHONE' => $phone,
                                   'SHORTCODE' => "3034"
                );

            $arr = $client->sendSingleSMS($string_arr);

            //send email

            $string_arr2 = array(  'AGENTCODE' => "CCNMODULES",
                                  'SMSTEXT' => "Dear customer You have a pending balance of ksh". $billbalance ." For account " .$serviceacc. " Thank you",
                                   'EMAIL' => $email,
                                   'NAME' => "Michael"
                );

            $arr = $client->sendSingleEmail($string_arr2);


        }
        //get subscriptions related the bill account(they are an array)
        
         $myvalues = getsubscription($serviceacc);

         $count = 0;
         //get each value of an array index
         while($count <= count($myvalues))
         {
            //get customers phone and email
             $phone = $myvalues[$count]['phone'];
             $email = $myvalues[$count]['email'];

             // send sms
             $string_arr = array(  'AGENTCODE' => "CCNMODULES",
                                  'SMSTEXT' => "Dear customer You have a pending balance of ksh ". $billbalance ."Thank you",
                                   'PHONE' => $phone,
                                   'SHORTCODE' => "3034"
                );

            $arr = $client->sendSingleSMS($string_arr);


            //send email
            $string_arr2 = array(  'AGENTCODE' => "CCNMODULES",
                                  'SMSTEXT' => "Dear customer You have a pending balance of ksh". $billbalance ." For account " .$serviceacc. " Thank you",
                                   'EMAIL' => $email,
                                   'NAME' => "Michael"
                );

            $arr = $client->sendSingleEmail($string_arr2);

         }


    }

    }

?>
