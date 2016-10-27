<?php

switch ($_POST['action'])
{
	case add_staff:            
		//attributes  to register
		$staff_id=$_POST['staff_id'];
	        $job_id=$_POST['job_id'];
		$gender=$_POST['gender'];
		$email=$_POST['email'];
		$status=$_POST['status'];
		$department_id=$_POST['department_id'];
		$phone_number=$_POST['phone_number'];
		$surname=$_POST['surname'];
		$userLevelId=$_POST['userlevelid'];
		$first_name=$_POST['first_name'];
		$last_name=$_POST['last_name'];
		$active=$_POST['active'];
		//$tot_earn=$_POST['tot_earn'];
		//$tot_ded=$_POST['tot_ded'];
		$username=$_POST['username'];
		$password=md5($_POST['password']);
		$details=$_POST['details'];
		$id_passport=$_POST['id_passport'];
		//$net_pay=$_POST['net_pay'];
		//$month=strtoupper($_POST['month']);
		//$leave_days=$_POST['leave_days'];
		//check for excessive input of leave day characters
		//$ld=strlen($leave_days);
		
                   
		if(strlen($staff_id)>8)
		{
		$message="The staff id is too long";		
		}
	
		//check for correct input of entries
//		if (empty($job_id))
//		{
//		$message="You did not enter the job Name";
//		}
//              /*  elseif(!is_numeric($staff_id))
//                    {
//                    $message="The staff id is supposed to be a number";
//                    }*/
//		
//		elseif (empty($staff_id))
//		{
//		$message="You did not enter the staff Identity Number";
//		}
//		elseif (empty($gender))
//		{
//		$message="You did not enter the gender.";
//		}
//		elseif(empty($email))
//		{
//		$message="You did not enter the email address";
//		}
//		elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email))
//		{
//
//		$message="The email is invalid";
//		}
//		elseif (!isset($status))
//		{
//		$message="You did not enter the status";
//		}
//		elseif (empty($department_id))
//		{
//		$message="You did not enter the department id";
//		}
//		elseif (empty($phone_number))
//		{
//		$message="You did not enter the phone Number";
//		}
//		elseif(strlen($phone_number)>14 || strlen($phone_number)<10)
//		{
//		$message="The phone number is invalid";
//		}
//		elseif (empty($surname))
//		{
//		$message="You did not enter the surname";
//		}
//		elseif (empty($userLevelId))
//		{
//		$message="You did not enter the User Level ";
//		}
//		
//		elseif (empty($first_name))
//		{
//		$message="You did not enter the first name";
//		}
//	
//		elseif (empty($username))
//		{
//		$message="You did not enter your username";
//		}
//		elseif (empty($password))
//		{
//		$message="You did not enter the password";
//		}
//		elseif (empty($details))
//		{
//		$message="You did not enter the details";
//		}
//		elseif (empty($id_passport))
//		{
//		$message="You did not enter the ID/Passport";
//		}
//                elseif(!is_numeric($id_passport))
//                    {
//                    $message="The Id/Passport is supposed to be numeric";
//                    }
//		elseif(strlen($id_passport)>8 || strlen($id_passport)<6)
//		{
//		$message="The Id number/passport  does not meet the required length";
//		}
               // elseif (isset($national_id_number))
/*
		elseif (empty($month))
		{
		$message="You did not enter the month";
		}
		elseif (empty($leave_days))
		{
		$message="You did not enter the leave days";
		}
		
		elseif($ld>5)
			{
			$message="You number of leave days should not be more than a five characters";
			}*/
		else {
		//add the new member
                   if(!empty($staff_id))
                     {
                       
	  		//check if the staff id exists
			$query="SELECT * FROM ".DATABASE.".staff WHERE staff_id='$staff_id'";
			$data=run_query($query);
			$result=get_num_rows($data);
                 }
		if($result > 0)
		{
		$message="A member with that staff id already exists";
		}else{
      	$query="INSERT INTO ".DATABASE.".staff 
            (staff_id,job_id,gender,email,department_id,phone_number,surname,userlevelid,first_name,last_name,username,password,details,id_passport,status)
      VALUES('$staff_id','$job_id','$gender','$email','$department_id','$phone_number','$surname','$userLevelId','$first_name','$last_name','$username','$password','$details','$id_passport','$status')";        
	$new_member=run_query($query);
                }
		}
		//check if the new member has been added
		if($new_member)
		{
		$message="You successfully added a new member - staff :".$staff_id;
                $_SESSION['done-deal']=$message;
		}
       		 $processed = 1;       
		break;
	case edit_staff:
		//values of the staff to be updated
		$staffs_id=$_POST['staff_id'];
		$job_id=$_POST['job_id'];
		$gender=$_POST['gender'];
		$email=$_POST['email'];
		$status=$_POST['status'];
		$department_id=$_POST['department_id'];
		$phone_number=$_POST['phone_number'];
		$surname=$_POST['surname'];
		$userLevelId=$_POST['userlevelid'];
		$first_name=$_POST['first_name'];
		$last_name=$_POST['last_name'];
		$tot_earn=$_POST['tot_earn'];
		$username=$_POST['username'];
		$details=$_POST['details'];
		$id_passport=$_POST['id_passport'];
		$net_pay=$_POST['net_pay'];
		//$month=strtoupper($_POST['month']);
		$leave_days=$_POST['leave_days'];
		$net_pay=$_POST['net_pay'];
      		$tot_earn=$_POST['tot_earn'];
		$tot_ded=$_POST['tot_ded'];
		
		//check for correct input of entries
		if (empty($job_id))
		{
		$message="You did not enter the job Name";
		}
		
		elseif (empty($gender))
		{
		$message="You did not enter the gender.";
		}
		elseif(empty($email))
		{
		$message="You did not enter the email address";
		}
		elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email))
		{

		$message="The email is invalid";
		}
		elseif (!isset($status))
		{
		$message="You did not enter the status";
		}
		elseif (empty($department_id))
		{
		$message="You did not enter the department ";
		}
		elseif (empty($phone_number))
		{
		$message="You did not enter the phone Number";
		}
		elseif(strlen($phone_number)>14 || strlen($phone_number)<10)
		{
		$message="The phone number is invalid";
		}
		elseif (empty($surname))
		{
		$message="You did not enter the surname";
		}
		elseif (empty($userLevelId))
		{
		$message="You did not enter the User Level ";
		}
		
		elseif (empty($first_name))
		{
		$message="You did not enter the first name";
		}
		
		/*elseif (empty($tot_earn))
		{
		$message="Please indicate you total earning";
		}*/
		
		elseif (empty($username))
		{
		$message="You did not enter your username";
		}
		
		elseif (empty($details))
		{
		$message="You did not enter the details";
		}
		elseif (empty($id_passport))
		{
		$message="You did not enter the ID/Passport";
		}
		elseif(strlen($id_passport)>8 || strlen($id_passport)<6)
		{
		$message="The Id number/passport  is invalid";
		}

		/*elseif (empty($net_pay))
		{
		$message="You did not enter the net pay";
		}*/
		/*elseif (empty($month))
		{
		$message="You did not enter the month";
		}*/
		/*elseif (empty($leave_days))
		{
		$message="You did not enter the leave days";
		}
		
		elseif($ld>5)
			{
			$message="You number of leave days should not be more than a five characters";
			}*/
		else {
		//update the staff member
	 	$edit_staff="UPDATE ".DATABASE.".staff SET job_id='$job_id',
	         gender='$gender',email='$email',department_id='$department_id'
		,phone_number='$phone_number',status='$status',surname='$surname',userlevelid='$userLevelId'
		,first_name='$first_name',last_name='$last_name',tot_earn='$tot_earn',tot_ded='$tot_ded',username='$username',details='$details',id_passport='$id_passport',net_pay='$net_pay',leave_days='$leave_days'
		WHERE staff_id='$staffs_id'";
		$edit_staf=run_query($edit_staff);
		}
		if ($edit_staf)
		{
		$message="You updated the staff member information - staff id: ".$staffs_id;
                $_SESSION['done-edit']=$message;
		}

		$processed = 1;
	break;
	case reset_password:
		//get the user for whom to reset the password
		$staff_id=$_POST['staff_id'];
		$password=md5($_POST['password']);
		$reset_pwd="UPDATE ".DATABASE.".staff SET password='$password' WHERE staff_id='$staff_id'";
		$rst=run_query($reset_pwd);
		if($rst)
		{
                $message="The password has been reset - staff id: ".$staff_id;
                $_SESSION['done-edit']=$message;
		}
	$processed = 1;
	break;
	

}

?>
