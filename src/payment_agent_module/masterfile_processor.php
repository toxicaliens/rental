<?php
// error_reporting(0);
switch($_POST['action'])
{
    case add_masterfile:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);        
        //get the values to add the new customer
        $surname=$_POST['surname'];

        // $status=$_POST['active'];
        $gender=$_POST['gender'];
        $b_role = $_POST['b_role'];
        if($b_role == ''){
            $b_role = 0;
        }
        //$status=get_status_value($status);
        $firstname=$_POST['firstname'];
        $middlename=$_POST['middlename'];
        $regdate_stamp=$_POST['regdate_stamp'];
        $national_id_number=$_POST['national_id_number'];

        $target_path='';

		$allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["profile-pic"]["name"]);
        $extension = end($temp);

        
        if ((($_FILES["profile-pic"]["type"] == "image/gif")
        || ($_FILES["profile-pic"]["type"] == "image/jpeg")
        || ($_FILES["profile-pic"]["type"] == "image/jpg")
        || ($_FILES["profile-pic"]["type"] == "image/pjpeg")
        || ($_FILES["profile-pic"]["type"] == "image/x-png")
        || ($_FILES["profile-pic"]["type"] == "image/png"))
        && ($_FILES["profile-pic"]["size"] < 5000000)
        && in_array($extension, $allowedExts)) {
            if ($_FILES["profile-pic"]["error"] > 0) {
               "Return Code: " . $_FILES["profile-pic"]["error"] . "<br>";
            } else {
                "Upload: " . $_FILES["profile-pic"]["name"] . "<br>";
                "Type: " . $_FILES["profile-pic"]["type"] . "<br>";
                "Size: " . ($_FILES["profile-pic"]["size"] / 1024) . " kB<br>";
                "Temp file: " . $_FILES["profile-pic"]["tmp_name"] . "<br>";

                if (file_exists("profile/" . $_FILES["profile-pic"]["name"])) {
                    $error = $_FILES["profile-pic"]["name"] . " already exists. ";
                    // var_dump($error);exit;
                } else {
                 $target_path = "assets/img/profile/".$_FILES["profile-pic"]["name"];
                 move_uploaded_file($_FILES["profile-pic"]["tmp_name"], $target_path);
                } else {
        	$_SESSION['done-deal']='<div class="alert alert-warning">
					<button class="close" data-dismiss="alert">×</button>
					<strong>Warning!</strong> The image file is Invalid!
				</div>';
       }

                 
		//validation
		// if (empty($surname)){
  //           $message="You did not enter the surname";
		// }elseif(is_numeric($surname)){
  //           $message="The surname is not a number";
  //       }elseif(empty($firstname)){
  //           $message="You did not enter the first name";
		// }elseif(empty($gender)){
  //           $message="You did not choose the gender";
		// }elseif (empty($regdate_stamp)){
  //           $message="You did not enter the registration date";
		// }elseif (!empty($national_id_number) && !is_numeric($national_id_number)){
  //           $message="The national Id Number/passport is supposed to be numeric";
		// }elseif (!empty($middlename) && is_numeric($middlename)){
		// 	$message="The middle name is numeric";
		if (empty($national_id_number)){
            $message="You need to fill in at least the ID no. or the passport number";
		} else {    
		    //add the new record to the database
		   	if(!checkForExistingEntry('masterfile', 'id_passport', $national_id_number)){
				$query="INSERT INTO masterfile(
					surname,
					firstname,
					middlename,
					regdate_stamp,
					id_passport,
					images_path,
					gender,
					b_role)
				VALUES(
					'".$surname."',
					'".$firstname."',
					'".$middlename."',
					'".$regdate_stamp."',
					'".$national_id_number."',
					'".$target_path."',
					'".$gender."',
					'".$b_role."') 
					RETURNING mf_id";
					//argDump($query);exit;
	                // var_dump($query);exit;
				$data=run_query($query);
				$id_data = get_row_data($data);
		        //check if the data has been added 
				if($data){
					//redirect to a the correct page
					$mf_id = $id_data['mf_id'];
					//$b_role = $id_data['b_role'];
					if($b_role=='Staff'){
						$_SESSION['done-deal']='<div class="alert alert-success">
							<button class="close" data-dismiss="alert">×</button>
							<strong>Success!</strong> You successfully added a new masterfile. Please add the staff details.
						</div>';
						//App::re2directTo($page);//call the redirect function through self reference
						App::redirectTo('index.php?num=703&mf_id='.$mf_id);
					}elseif($b_role=='Client'){
						$_SESSION['done-deal']='<div class="alert alert-success">
							<button class="close" data-dismiss="alert">×</button>
							<strong>Success!</strong> You successfully added a new masterfile. Please add the Client details.
						</div>';
						App::redirectTo('index.php?num=803&mf_id='.$mf_id);
					}else{
						$_SESSION['done-deal']='<div class="alert alert-success">
							<button class="close" data-dismiss="alert">×</button>
							<strong>Success!</strong> You successfully added a new masterfile. Please add the Agent details.
						</div>';
						App::redirectTo('index.php?num=3000&mf_id='.$mf_id);
					}
				} else { 
					$message='<div class="alert alert-error">
								<button class="close" data-dismiss="alert">×</button>
								<strong>Error!</strong> You have some form errors. Please check below.
							</div>';		
				        $_SESSION['done-add']=$message;
				}
			}else{
				$_SESSION['done-deal']='<div class="alert alert-warning">
					<button class="close" data-dismiss="alert">×</button>
					<strong>Warning!</strong> The Id/Passport No.('.$national_id_number.') already exists!
				</div>';
			}
		}

		//add record only when the image has been uploaded successfully
		}
            }

		$processed = 1;
	break;

	case edit_masterfile:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		//get the values of the customer to be updated
		$surname=$_POST['surname'];
		$firstname=$_POST['firstname'];
		$middlename=$_POST['middlename'];
		$regdate_stam=$_POST['regdate_stamp'];
		$regdate_stamp=$regdate_stam;
		$national_id_number=$_POST['national_id_number'];
		$b_role = $_POST['b_role'];
		$mf_id = $_POST['mf_id'];
		//$time_date=strtotime($_POST['time_date']);

		$target_path = '';
		$allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["profile-pic"]["name"]);
        $extension = end($temp);

       if ((($_FILES["profile-pic"]["type"] == "image/gif")
       || ($_FILES["profile-pic"]["type"] == "image/jpeg")
       || ($_FILES["profile-pic"]["type"] == "image/jpg")
       || ($_FILES["profile-pic"]["type"] == "image/pjpeg")
       || ($_FILES["profile-pic"]["type"] == "image/x-png")
       || ($_FILES["profile-pic"]["type"] == "image/png"))
       && ($_FILES["profile-pic"]["size"] < 500000)
       && in_array($extension, $allowedExts)) {
       if ($_FILES["profile-pic"]["error"] > 0) {
          "Return Code: " . $_FILES["profile-pic"]["error"] . "<br>";
       } else {
          "Upload: " . $_FILES["profile-pic"]["name"] . "<br>";
          "Type: " . $_FILES["profile-pic"]["type"] . "<br>";
          "Size: " . ($_FILES["profile-pic"]["size"] / 1024) . " kB<br>";
          "Temp file: " . $_FILES["profile-pic"]["tmp_name"] . "<br>";

     if (file_exists("profile/" . $_FILES["profile-pic"]["name"])) {
         $_FILES["profile-pic"]["name"] . " already exists. ";
     } else {
      $target_path = WPATH."assets/img/profile/".$_FILES["profile-pic"]["name"];
      move_uploaded_file($_FILES["profile-pic"]["tmp_name"], $target_path);
          
     }
          }
        } else {
         "Invalid file";
       }
		//validation
		if (empty($surname))
		{
		$message="You did not enter the surname";
		}
		else if(empty($firstname))
		{
		$message="You did not enter the first name";
		}
		else if (empty($regdate_stamp))
		{
		$message="You did not enter the registration date";
		}
        else if (!empty($national_id_number) && !is_numeric($national_id_number))
		{
		$message="The national Id Number/passport is supposed to be numeric";
		}
		elseif (empty($national_id_number) )
		{
		$message="You need to fill in  the ID no./passport number";
		}
		else
		{
		//update the customer
		$query="UPDATE ".DATABASE.".masterfile SET 
		surname='$surname',
		firstname='$firstname',
		middlename='$middlename',
		regdate_stamp='$regdate_stamp',
		id_passport='$national_id_number',
		images_path='$target_path',
		b_role='$b_role' 
		WHERE mf_id='$mf_id'";
		// var_dump($query);exit;
		$data=run_query($query);
		}
		if ($data)
		{
			//$b_role = $id_data['b_role'];
			if($b_role=='Staff'){
				$message='<div class="alert alert-success">
					<button class="close" data-dismiss="alert">×</button>
					<strong>Success!</strong> You updated the masterfile information successfully. You may also update Staff details below.
				</div>';
				$_SESSION['done-edit']=$message;
				//App::re2directTo($page);//call the redirect function through self reference
				App::redirectTo('index.php?num=702&mf_id='.$mf_id);
			}elseif($b_role=='Client'){
				$message='<div class="alert alert-success">
					<button class="close" data-dismiss="alert">×</button>
					<strong>Success!</strong> You updated the masterfile information successfully. You may also update Client details below.
				</div>';
				$_SESSION['done-edit']=$message;
				App::redirectTo('index.php?num=802&mf_id='.$mf_id);
			}else{
				$message='<div class="alert alert-success">
					<button class="close" data-dismiss="alert">×</button>
					<strong>Success!</strong> You updated the masterfile information successfully. You may also update Agent\'s details below.
				</div>';
				$_SESSION['done-edit']=$message;
				App::redirectTo('index.php?num=3000&mf_id='.$mf_id);
			}
		}else{ 
		$message='<div class="alert alert-error">
						<button class="close" data-dismiss="alert">×</button>
						<strong>Error!</strong> You have some form errors. Please check below.
					</div>';

		        $_SESSION['done-edits']=$message;
		}
		$processed = 1;
	break;

	case Del252:
	logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
	$mf_id = $_POST['mf_id'];
	$delete = run_query("DELETE FROM masterfile WHERE mf_id = '".$mf_id."'");
	if($delete){
		$_SESSION['done-edits'] = '<div class="alert alert-success">
				<button class="close" data-dismiss="alert">×</button>
				<strong>Success!</strong> The item was successfully deleted!.
			</div>';
	}
}


?>
