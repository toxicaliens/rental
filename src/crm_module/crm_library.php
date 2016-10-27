<?php
function getAddressName($address_id)
{
$query="SELECT post_office_box FROM address WHERE address_id=$address_id";
$data=run_query($query);
$result=get_row_data($data);
return $result[post_office_box];
}
function getAddressId($address_name)
{
$query="SELECT address_id FROM  address WHERE post_office_box='$address_name'";
$data=run_query($query);
$result=get_row_data($data);
return $result[address_id];
}
function getCustomerTypeName($customer_type_id)
{
    $query="SELECT customer_type_id FROM customer_types WHERE customer_type_id='$customer_type_id'";
    $data=run_query($query);
    $result=get_row_data($data);
    return $result['customer_type_id'];
}

function registerProviderToMcare($customer_data)
{
    $fields_string = '';
    $reg_fname = $customer_data['firstname'];
    $customer_id = $customer_data['customer_id'];
    // $reg_lname = $customer_data['lastname'];
    $reg_mname = $customer_data['middlename'];
    
    $provider_name = $reg_fname . " " .$reg_mname ." " . $reg_fname;
    
    // $reg_dob   = $customer_data['dob'];
    $reg_email = $customer_data['email'];
    $reg_idno  = $customer_data['national_id_number'];
    $reg_phone = $customer_data['phone'];
   
    //set POST variables
    //$url = 'http://localhost/pregister/index.php/ndovu/regonFamily_acc';//local Test. no .htaccess
    $url = 'http://41.222.11.190/pregister/index.php/ndovu/regonProvider_acc'; //Public use
    $fields = array(
                    'company' => $provider_name,
                    'office_street'=>'Kariobangi South',
                    'office_building'=>'KEMABRAIN House',
                    'office_floor'=>'Mezzanine',
                    'contact_name'=>$provider_name,
                    'office_phone'=>$reg_phone,
                    'cellphone' => $reg_phone,
                    'email'=>$reg_email,
                    'office_city'=>'Nairobi',
                    'postal_address'=>'156',
                    'postal_code'=>'00100',
                    'merchant_id'=>$customer_id,
                    'country_id'=>404,//Constant
                    'password'=>'rESPECT45'
                );

    //url-ify the data for the POST
    foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
    rtrim($fields_string, '&');

    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //execute post
    $result = curl_exec($ch);
    //echo $result;//returns 1 if successfull
    //close connection
    $json2 = json_decode($result, true);
    // Now get membership ID.
    //echo $json['member_id'];
    curl_close($ch);
    return $json2['member_id'];
}

?>
