<?php
    include_once('src/models/RevenueManager.php');
    $revenue_manager = new RevenueManager;

// error_reporting(0);
switch($_POST['action'])
{
  case add_channel_inputs:
    $service_id = $_POST['service_id'];
    $data_source = $_POST['data_source'];
    $input_category = $_POST['input_category'];
    $input_type = $_POST['input_type'];
    $input_label = $_POST['input_label'];
    $default_value = $_POST['default_value'];

    $query = "INSERT INTO service_channel_inputs(service_id, data_source, input_category, input_type, input_label, default_value)
    VALUES ('".$service_id."', '".$data_source."', '".$input_category."', '".$input_type."',  '".$input_label."', '".$default_value."')";
      if(pg_query($query)){
        $_SESSION['RMC'] = '<div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> Input successfully added.
                            </div>';
      }else{
        echo pg_last_error();
      }
  break;

  case edit_channel_input:
    $input_id = $_POST['input_id'];
    $service_id = $_POST['service_id'];
    $data_source = $_POST['data_source'];
    $input_category = $_POST['input_category'];
    $input_type = $_POST['input_type'];
    $input_label = $_POST['input_label'];
    $default_value = $_POST['default_value'];
    $edit_id = $_POST['edit_id'];

    $update = "UPDATE service_channel_inputs SET 
    service_id = '".$service_id."', 
    data_source = '".$data_source."', 
    input_category = '".$input_category."', 
    input_type = '".$input_type."', 
    input_label = '".$input_label."', 
    default_value = '".$default_value."' 
    WHERE input_id = '".$edit_id."'";
      if(run_query($update)){
         $_SESSION['RMC'] = '<div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> Input successfully updated.
                            </div>';
      }else{
        echo pg_last_error();
      }
  break;

  case delete_channel_input:
    extract($_POST);
    if(!empty($delete_id)){
      $query = "DELETE FROM service_channel_inputs WHERE input_id = '".$delete_id."'";
      if(run_query($query)){
        $_SESSION['RMC'] = '<div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> Input successfully deleted.
                            </div>';
      }
    }
  break;

    case add_revenue_channels:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        //var_dump($_POST);exit;
        $revenue_manager->addRevenueChannel($_POST);
        $processed = 1;
        break;

	case edit_revenue_channels:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        // $revenue_channel_id = $_POST['edit_id'];
              extract($_POST);
              if(!onEditCheckForExistingEntry('revenue_channel', 'revenue_channel_name', $revenue_channel_name, 'revenue_channel_id', $revenue_channel_id)){
                if(!onEditCheckForExistingEntry('revenue_channel', 'revenue_channel_code', $revenue_channel_code, 'revenue_channel_id', $revenue_channel_id)){
                  $edit_revenue_channels="UPDATE revenue_channel 
                                    SET  revenue_channel_name='".$revenue_channel_name."',
                                         revenue_channel_code='".$revenue_channel_code."'
                                         WHERE revenue_channel_id=$revenue_channel_id";
                                         // var_dump($edit_revenue_channels);exit;

                  //echo $edit_revenue_channels;
                  if(!run_query($edit_revenue_channels))
                  {
                      $msg = '<div class="alert alert-error">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Error!</strong> Entry not Edited.
                            </div>';
                    $_SESSION['RMC'] = $msg;
                  }
                  else
                  {
                      $msg = '<div class="alert alert-success">
                                  <button class="close" data-dismiss="alert">×</button>
                                  <strong>Success!</strong> Entry Edited successfully.
                              </div>';
                    $_SESSION['RMC'] = $msg;
                  }
                }else{
                    $_SESSION['RMC'] = '<div class="alert alert-warning">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Success!</strong> The revenue channel code('.$revenue_channel_code.') already exists.
                        </div>';
                }    
                }else{
                  $_SESSION['RMC'] = '<div class="alert alert-warning">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Success!</strong> The revenue channel name('.$revenue_channel_name.') already exists.
                        </div>';
                }       
            $processed = 1;
    break;

	case Del559:
		logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
		$revenue_channel_id = $_POST['revenue_channel_id'];
		$delete = run_query("DELETE FROM revenue_channel WHERE revenue_channel_id= '".$revenue_channel_id."'");
		if($delete){
			$_SESSION['RMC'] = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert">×</button>
						<strong>Success!</strong> The item was successfully deleted!.
					</div>';
            App::redirectTo('index.php?num=620');
		}else{
      $_SESSION['RMC'] = '<div class="alert alert-warning">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Warning!</strong> The item cannot be deleted since it is still attached to another item in the system!.
          </div>';
    }
     $processed = 1;
    break;

	 case add_setup_channels:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
              // inserting into database service channels
	            extract($_POST);
              $parent_id = ($parent_id != 0) ? $parent_id : 'NULL';
                $add_setup_channels="INSERT INTO service_channels
                (revenue_channel_id,service_option,service_option_type,option_code,price,parent_id,request_type_id)
			                       VALUES
			    ('".$revenue_channel_id."','".$service_option."','". $service_option_type."',
			    	'".$option_code."','".$price."',".$parent_id.",'".$request_type_id."')";
 //var_dump($add_setup_channels);exit;
                $result = run_query($add_setup_channels);

                if (!$result) {
                    $errormessage = '<div class="alert alert-warning">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <strong>Error!</strong>Encountered an error while saving!
                                    </div>'; 
                    $_SESSION['RMC'] = get_last_error();
                  }else{
                  $_SESSION['RMC'] = '<div class="alert alert-success">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Success!</strong>The Service Option('.$service_option.') added successfully.
                        </div>';
                         App::redirectTo('index.php?num=623');
                    }
            $processed = 1;
	break;

  case edit_setup_channels:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        // $service_channel_id = $_POST['edit_id'];
              extract($_POST);
              $parent_id = ($parent_id != 0) ? $parent_id : 'NULL';
              $edit_setup_channels="UPDATE service_channels 
                                SET  revenue_channel_id='".$revenue_channel_id."',
                                     service_option='".$service_option."',
                                     service_option_type='".$service_option_type."',
                                     price='".$price."',
                                     option_code='".$option_code."',
                                     parent_id=".$parent_id.",
                                     request_type_id='".$request_type_id."',
                                     status = '".$status."'
                                     WHERE service_channel_id=$service_channel_id";
                                     //var_dump($edit_setup_channels);exit;
                                     
              //echo $edit_setup_channels;
              if(!run_query($edit_setup_channels))
              {
                  $msg = '<div class="alert alert-error"> 
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Error!</strong> Entry not Edited.
                        </div>';
                $_SESSION['RMC'] = get_last_error();
              }
              else
              {
                  $msg = '<div class="alert alert-success">
                              <button class="close" data-dismiss="alert">×</button>
                              <strong>Success!</strong> Entry Edited successfully.
                          </div>';
                $_SESSION['RMC'] = $msg;
              }
            
              $processed = 1;
    break;

    case Del564:
    // var_dump($_POST);exit;
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
    $service_channel_id = $_POST['service_channel_id'];
    $delete = run_query("DELETE FROM service_channels WHERE service_channel_id= '".$service_channel_id."'");
    if($delete){
      $_SESSION['RMC'] = '<div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Success!</strong> The item was successfully deleted!.
          </div>';
           App::redirectTo('index.php?num=623');
    }else{
      $_SESSION['RMC'] = get_last_error();
     $processed = 1;
    }
    break;

    case add_bank_details:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
              // inserting into database service channels
              extract($_POST);
              if(!checkForExistingEntry('revenue_banks','bank_account_number',$bank_account_number)){
              if(!checkForExistingEntry('revenue_banks','ifmis_bank_branch_code',$ifmis_bank_branch_code)){
              if(!checkForExistingEntry('revenue_banks','bank_name',$bank_name)){
              if(!checkForExistingEntry('revenue_banks','ifmis_bank_code',$ifmis_bank_code)){
                $add_bank_details="INSERT INTO revenue_banks
                (bank_name,bank_branch,bank_account_number,ifmis_bank_code,ifmis_bank_branch_code)
                             VALUES
          ('".$bank_name."','".$bank_branch."','". $bank_account_number."',
            '". $ifmis_bank_code."','".$ifmis_bank_branch_code."')";
  
                $result = run_query($add_bank_details);
                if (!$result) {
                    $errormessage = '<div class="alert alert-errors">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <strong>Error!</strong> Encountered an error!
                                    </div>'; 
                    $_SESSION['RMC'] = $errormessage;
                  }else{
                  $_SESSION['RMC'] = '<div class="alert alert-success">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Success!</strong> Entry added successfully.
                        </div>';
                    }
                  }else{
                     $_SESSION['RMC'] .= '<div class="alert alert-warning">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Warning!</strong> The Bank Code('.$ifmis_bank_code.') already exists.
                        </div>';
                  }
                  }else{
                     $_SESSION['RMC'] .= '<div class="alert alert-warning">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Warning!</strong> The Bank name('.$bank_name.') already exists.
                        </div>';
                  }
                  }else{
                    $_SESSION['RMC'] .= '<div class="alert alert-warning">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Warning!</strong> The Bank Branch Code('.$ifmis_bank_branch_code.') already exists.
                        </div>';
                  }
                }else{
                  $_SESSION['RMC'] .= '<div class="alert alert-warning">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Warning!</strong> The Bank Number('.$bank_account_number.') already exists.
                        </div>';
                }
           $processed = 1;
    break;

    case edit_bank_details:
      logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
              extract($_POST);
              if(!onEditcheckForExistingEntry('revenue_banks','bank_account_number',$bank_account_number, 'revenue_bank_id', $revenue_bank_id)){
              if(!onEditcheckForExistingEntry('revenue_banks','ifmis_bank_branch_code',$ifmis_bank_branch_code, 'revenue_bank_id', $revenue_bank_id)){
              if(!onEditcheckForExistingEntry('revenue_banks','bank_name',$bank_name, 'revenue_bank_id', $revenue_bank_id)){
              if(!onEditcheckForExistingEntry('revenue_banks','ifmis_bank_code',$ifmis_bank_code, 'revenue_bank_id', $revenue_bank_id)){
              $edit_bank_details="UPDATE revenue_banks
                                SET  bank_name='".$bank_name."',
                                     bank_branch='".$bank_branch."',
                                     bank_account_number='".$bank_account_number."',
                                     ifmis_bank_code='".$ifmis_bank_code."',
                                     ifmis_bank_branch_code='".$ifmis_bank_branch_code."'
                                     WHERE revenue_bank_id=$revenue_bank_id";
                                     
              //echo $edit_bank_details;
                $result = run_query($edit_bank_details);                      
              if(!$result)
              {
                  $msg = '<div class="alert alert-error">
                            <button class="close" data-dismiss="errors">×</button>
                            <strong>Error!</strong> Encountered an error.
                        </div>';
                $_SESSION['RMC'] = $msg;
              }
              else
              {
                  $msg = '<div class="alert alert-success">
                              <button class="close" data-dismiss="alert">×</button>
                              <strong>Success!</strong> Entry Edited successfully.
                          </div>';
                $_SESSION['RMC'] = $msg;
              }
            }else{
                     $_SESSION['RMC'] .= '<div class="alert alert-warning">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Warning!</strong> The Bank code('.$ifmis_bank_code.') already exists.
                        </div>';
                  }
                  }else{
                     $_SESSION['RMC'] .= '<div class="alert alert-warning">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Warning!</strong> The Bank name('.$bank_name.') already exists.
                        </div>';
                  }
                  }else{
                    $_SESSION['RMC'] .= '<div class="alert alert-warning">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Warning!</strong> The Bank name('.$ifmis_bank_branch_code.') already exists.
                        </div>';
                  }
                }else{
                  $_SESSION['RMC'] .= '<div class="alert alert-warning">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Warning!</strong> The Bank name('.$bank_account_number.') already exists.
                        </div>';
                }
              $processed = 1;
    break;

    case Del309:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
    $revenue_bank_id = $_POST['revenue_bank_id'];
    $delete = run_query("DELETE FROM revenue_banks WHERE revenue_bank_id= '".$revenue_bank_id."'");
    if($delete){
      $_SESSION['RMC'] = '<div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Success!</strong> The item was successfully deleted!.
          </div>';
    }
     $processed = 1;
    break;

    case add_head_ifmis:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
              // inserting into database service channels
              extract($_POST);
              if(!checkForExistingEntry('ifmis_headcodes','head_code_name',$head_code_name)){
                if(!checkForExistingEntry('ifmis_headcodes','ifmis_code',$ifmis_code)){
                  $add_head_ifmis="INSERT INTO ifmis_headcodes
                  (head_code_name,ifmis_code)
                               VALUES
            ('".$head_code_name."','".$ifmis_code."')";
    
                  $result = run_query($add_head_ifmis);
                  if (!$result) {
                      $errormessage = '<div class="alert alert-error">
                                          <button class="close" data-dismiss="alert">×</button>
                                          <strong>Error!</strong> Encountered an error!
                                      </div>'; 
                      $_SESSION['RMC'] = $errormessage;
                    }else{
                    $_SESSION['RMC'] = '<div class="alert alert-success">
                              <button class="close" data-dismiss="alert">×</button>
                              <strong>Success!</strong> Entry added successfully.
                          </div>';
                      }
                }else{
                  $_SESSION['RMC'] = '<div class="alert alert-warning">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Warning!</strong> The ifmis code('.$ifmis_code.') already exists.
                        </div>';
                }
              }else{
                 $_SESSION['RMC'] = '<div class="alert alert-warning">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Warning!</strong> The ifmis head code name('.$head_code_name.') already exists.
                        </div>';
              }
           $processed = 1;
    break;

    case edit_head_ifmis:
      logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        // $service_channel_id = $_POST['edit_id'];
              extract($_POST);
              if(!onEditCheckForExistingEntry('ifmis_headcodes', 'head_code_name', $head_code_name, 'head_code_id', $head_code_id)){
                if(!onEditCheckForExistingEntry('ifmis_headcodes', 'ifmis_code', $ifmis_code, 'head_code_id', $head_code_id)){
                  $edit_head_ifmis="UPDATE ifmis_headcodes
                                    SET  head_code_name='".$head_code_name."',
                                         ifmis_code='".$ifmis_code."'
                                         WHERE head_code_id=$head_code_id";

                  //echo $edit_head_ifmis;
                    $result = run_query($edit_head_ifmis); 
                                                              
                  if(!$result)
                  {
                      $msg = '<div class="alert alert-error">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Error!</strong> Entry not Edited.
                            </div>';
                    $_SESSION['RMC'] = $msg;
                  }
                  else
                  {
                      $msg = '<div class="alert alert-success">
                                  <button class="close" data-dismiss="alert">×</button>
                                  <strong>Success!</strong> Entry Edited successfully.
                              </div>';
                    $_SESSION['RMC'] = $msg;
                  }
                }else{
                  $msg = '<div class="alert alert-warning">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Warning!</strong> The IFMIS code ('.$ifmis_code.') already exists.
                            </div>';
                  $_SESSION['RMC'] = $msg;
                }
              }else{
                $msg = '<div class="alert alert-warning">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Warning!</strong>The Head Code Name('.$head_code_name.') already exists.
                            </div>';
                  $_SESSION['RMC'] = $msg;
              }
            
              $processed = 1;
    break;

    case Del314:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
    $head_code_id = $_POST['head_code_id'];
    $delete = run_query("DELETE FROM ifmis_headcodes WHERE head_code_id= '".$head_code_id."'");
    if($delete){
      $_SESSION['RMC'] = '<div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Success!</strong> The item was successfully deleted!.
          </div>';
    }
     $processed = 1;
    break;

     case add_sub_ifmis:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
              // inserting into database service channels
              extract($_POST);
              if(!checkForExistingEntry('ifmis_subcodes', 'ifmis_subcode', $ifmis_subcode)){
                if(!checkForExistingEntry('ifmis_subcodes', 'subcode_name', $subcode_name)){
                $add_sub_ifmis="INSERT INTO ifmis_subcodes
                (subcode_name,head_code_id,ifmis_subcode)
                             VALUES
          ('".$subcode_name."','".$head_code_id."','".$ifmis_subcode."')";
                // var_dump($add_sub_ifmis);exit;
                $result = run_query($add_sub_ifmis);
                if (!$result) {

                    $errormessage = '<div class="alert alert-error">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <strong>Error!</strong> Encountered an error!
                                    </div>'; 
                    $_SESSION['RMC'] = $errormessage;
                  }else{
                  $_SESSION['RMC'] = '<div class="alert alert-success">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Success!</strong> Entry added successfully.
                        </div>';
                    }
                  }else{
                    $errormessage = '<div class="alert alert-warning">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <strong>Warning!</strong> The IFMIS Subcode name ('.$subcode_name.')  already exists. Try another!
                                    </div>';
                  $_SESSION['RMC'] .= $errormessage;
                  }
                }else{
                  $errormessage = '<div class="alert alert-warning">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <strong>Warning!</strong> The IFMIS Subcode ('.$ifmis_subcode.')  already exists. Try another!
                                    </div>';
                  $_SESSION['RMC'] .= $errormessage;
                }
           $processed = 1;
    break;

    case edit_sub_ifmis:
      logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        // $service_channel_id = $_POST['edit_id'];
              extract($_POST);
              if(!onEditCheckForExistingEntry('ifmis_subcodes', 'subcode_name', $subcode_name, 'subcode_id', $subcode_id)){
                if(!onEditCheckForExistingEntry('ifmis_subcodes', 'ifmis_subcode', $ifmis_subcode, 'subcode_id', $subcode_id)){
                  $edit_sub_ifmis="UPDATE ifmis_subcodes
                                    SET  subcode_name='".$subcode_name."',
                                         head_code_id='".$head_code_id."',
                                         ifmis_subcode='".$ifmis_subcode."'
                                         WHERE subcode_id=$subcode_id";

                  //echo $edit_sub_ifmis;
                    $result = run_query($edit_sub_ifmis); 
                                                              
                  if(!$result)
                  {
                      $msg = '<div class="alert alert-error">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Oops!</strong> Encountered an error.
                            </div>';
                    $_SESSION['RMC'] = $msg;
                  }
                  else
                  {
                      $msg = '<div class="alert alert-success">
                                  <button class="close" data-dismiss="alert">×</button>
                                  <strong>Success!</strong> Entry Edited successfully.
                              </div>';
                    $_SESSION['RMC'] = $msg;
                  }
                }else{
                  $msg = '<div class="alert alert-warning">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Warning!</strong> The sub code('.$ifmis_subcode.') already exitst.
                            </div>';
                    $_SESSION['RMC'] = $msg;
                }
              }else{
                $msg = '<div class="alert alert-warning">
                              <button class="close" data-dismiss="alert">×</button>
                              <strong>Warning!</strong> The sub code name('.$subcode_name.') already exitst.
                          </div>';
                  $_SESSION['RMC'] = $msg;
              }
            
              $processed = 1;
    break;

    case Del319:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
    $subcode_id = $_POST['subcode_id'];
    $delete = run_query("DELETE FROM ifmis_subcodes WHERE subcode_id= '".$subcode_id."'");
    if($delete){
      $_SESSION['RMC'] = '<div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Success!</strong> The item was successfully deleted!.
          </div>';
    }
     $processed = 1;
  break;

  case addcounty:
      logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
      extract($_POST);

        //var_dump($_POST);exit;
      $addcounty="INSERT INTO  county_ref(county_name)
                   VALUES('".$county_name."')";
                    //var_dump($addcounty);exit;
      $result = run_query($addcounty);

      if (!$result) {
          $errormessage = '<div class="alert alert-warning">
                              <button class="close" data-dismiss="alert">×</button>
                              <strong>Warning!</strong> The County ('.$county_name.') already exists. Try another!
                          </div>'; 
          $_SESSION['RMC'] = $errormessage;
        }else{
        $_SESSION['RMC'] = '<div class="alert alert-success">
                  <button class="close" data-dismiss="alert">×</button>
                  <strong>Success!</strong> The County ('.$county_name.') added successfully.
              </div>';
          }            $processed = 1;
  break;

   case edit_county:
      logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
       $county_name=$_POST['county_name'];
       $county_ref_id=$_POST['county_ref_id'];

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
                 $target_path = "assets/img/logo/".$_FILES["profile-pic"]["name"];
                 move_uploaded_file($_FILES["profile-pic"]["tmp_name"], $target_path);

                }
            }
        } else {
         "Invalid file";
       }
       //validation
            if (empty($county_name))
            {
            $message="You did not enter the county name";
            }
            else
            {

       $query="UPDATE county_ref SET 
                  county_name='$county_name',
                  county_logo='$target_path'
                  WHERE county_ref_id='$county_ref_id'";
                  //var_dump($query);exit;
                 $result=run_query($query);
                  //var_dump($result);exit;
                  }
                  if (!$result) {
                  $errormessage = '<div class="alert alert-warning">
                                      <button class="close" data-dismiss="alert">×</button>
                                      <strong>Warning!</strong> The County not edited
                                  </div>'; 
                  $_SESSION['RMC'] = $errormessage;
                }else{
                $_SESSION['RMC'] = '<div class="alert alert-success">
                          <button class="close" data-dismiss="alert">×</button>
                          <strong>Success!</strong> The County ('.$county_name.')Edited successfully.
                      </div>';
                  }            
    $processed = 1;
  break;

  case Del405:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
    $county_ref_id = $_POST['county_ref_id'];
    $delete = run_query("DELETE FROM county_ref WHERE county_ref_id= '".$county_ref_id."'");
    if($delete){
      $_SESSION['RMC'] = '<div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Success!</strong> The item was successfully deleted!.
          </div>';
    }
     $processed = 1;
  break;

  case addsubcounty:
      logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
      extract($_POST);
        //var_dump($_POST);exit;
      $addsubcounty="INSERT INTO  sub_county(sub_county_name,county_ref_id)
                   VALUES('".$sub_county_name."','".$county_ref_id."')";
      $result = run_query($addsubcounty);

      if (!$result) {
          $errormessage = '<div class="alert alert-error">
                              <button class="close" data-dismiss="alert">×</button>
                              <strong>Error!</strong> The  Sub County ('.$sub_county_name.') already exists. Try another!
                          </div>'; 
          $_SESSION['RMC'] = $errormessage;
        }else{
        $_SESSION['RMC'] = '<div class="alert alert-success">
                  <button class="close" data-dismiss="alert">×</button>
                  <strong>Success!</strong> Entry added successfully.
              </div>';
          }            $processed = 1;
  break;


  case edit_sub_county:
      logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
      extract($_POST);
        //var_dump($_POST);exit;
      if(!onEditcheckForExistingEntry('sub_county', 'sub_county_name',  $sub_county_name, 'sub_county_id', $sub_county_id)){
      $edit_sub_county="UPDATE sub_county
                                SET  sub_county_name='".$sub_county_name."',
                                     county_ref_id='".$county_ref_id."'
                                     WHERE sub_county_id=$sub_county_id";
      $result = run_query($edit_sub_county);

      if (!$result) {
          $errormessage = '<div class="alert alert-error">
                              <button class="close" data-dismiss="alert">×</button>
                              <strong>Error!</strong>Entry not Added
                          </div>'; 
          $_SESSION['RMC'] = $errormessage;
        }else{
        $_SESSION['RMC'] = '<div class="alert alert-success">
                  <button class="close" data-dismiss="alert">×</button>
                  <strong>Success!</strong> Entry added successfully.
              </div>';
          }
           }else{
                    $_SESSION['RMC'] = '<div class="alert alert-warning">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Warning!</strong> The  Sub County ('.$sub_county_name.') already exists. Try another!
                        </div>';
                  }            $processed = 1;
  break;

<<<<<<< HEAD
    case Del413:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $sub_county_id = $_POST['sub_county_id'];
        $delete = run_query("DELETE FROM sub_county WHERE sub_county_id= '".$sub_county_id."'");
            if($delete){
            $_SESSION['RMC'] = '<div class="alert alert-success">
                <button class="close" data-dismiss="alert">×</button>
                <strong>Success!</strong> The item was successfully deleted!.
                </div>';
            }
        $processed = 1;
        break;
=======
   case Del413:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
    $sub_county_id = $_POST['sub_county_id'];
    $delete = run_query("DELETE FROM sub_county WHERE sub_county_id= '".$sub_county_id."'");
    if($delete){
      $_SESSION['RMC'] = '<div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Success!</strong> The item was successfully deleted!.
          </div>';
    }
     $processed = 1;
  break;

 case addservicebill:
                logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
                extract($_POST);
                  //var_dump($_POST);exit;
                if(!checkForExistingEntry('revenue_service_bill', 'bill_code',  $bill_code)){
                  if(!checkForExistingEntry('revenue_service_bill', 'bill_name',  $bill_name)){
//                   if(isset($_POST['plot_id'])&&($_POST['product_id'])){
//                       $plot_id = $_POST['plot_id'];
//                       $product_id = $_POST['product_id'];
//                   }else{
//                       $plot_id = '';
//                       $product_id = '';
//                   }
                $addservicebill="INSERT INTO revenue_service_bill
                     (bill_name,bill_description,bill_category,bill_type,amount_type,bill_code,bill_due_time,amount,revenue_channel_id,bill_interval,service_channel_id)
                             VALUES('".$bill_name."','".$bill_description."','".$bill_category."','".$bill_type."',
                              '".$amount_type."','".$bill_code."','".$bill_due_time."','".$amount."','".$revenue_channel_id."', '".$interval."', '".$service_option."')";
//                  var_dump($addservicebill);exit;
                $result = run_query($addservicebill);
>>>>>>> ce6694a7570de335a014da154df4e13a0c87cc66

    case addservicebill:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $revenue_manager->addServiceBill($_POST);
        $_SESSION['warnings'] = $revenue_manager->getWarnings();
        break;

   case editservicebill:
      logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        // $service_channel_id = $_POST['edit_id'];
              extract($_POST);
              $interval = ($bill_type == "Onceoff") ? '': $interval; 
              if(!onEditcheckForExistingEntry('revenue_service_bill', 'bill_code',  $bill_code, 'revenue_bill_id', $revenue_bill_id)){
                  if(!onEditcheckForExistingEntry('revenue_service_bill', 'bill_name',  $bill_name, 'revenue_bill_id', $revenue_bill_id)){
              $editservicebill="UPDATE revenue_service_bill
                                SET  bill_name='".$bill_name."',
                                     bill_description='".$bill_description."',
                                     bill_category='".$bill_category."',
                                     bill_type='".$bill_type."',
                                     amount_type='".$amount_type."',
                                     amount='".$amount."',
                                     bill_code='".$bill_code."',
                                     revenue_channel_id='".$revenue_channel_id."',
                                     bill_due_time='".$bill_due_time."',
                                     service_channel_id = '".$service_option."',
                                     bill_interval = '".$interval."'
                                     WHERE revenue_bill_id=$revenue_bill_id";
                                     
              //echo $editservicebill;
                $result = run_query($editservicebill);                      
              if(!$result)
              {
                  $msg = '<div class="alert alert-error">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Error!</strong> Entry not Edited.
                        </div>';
                $_SESSION['RMC'] = get_last_error();
              }
              else
              {
                  $msg = '<div class="alert alert-success">
                              <button class="close" data-dismiss="alert">×</button>
                              <strong>Success!</strong> Entry Edited successfully.
                          </div>';
                $_SESSION['RMC'] = $msg;
              }

              }else{
                    $_SESSION['RMC'] = '<div class="alert alert-warning">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Warning!</strong> The bill name('.$bill_name.') already exists.
                        </div>';
                  }
                  }else{
                    $_SESSION['RMC'] = '<div class="alert alert-warning">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Warning!</strong> The bill code('.$bill_code.') already exists.
                        </div>';
                  }
            
              $processed = 1;
  break;

  case Del569:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
    $revenue_bill_id = $_POST['revenue_bill_id'];
    $delete = run_query("DELETE FROM revenue_service_bill WHERE revenue_bill_id= '".$revenue_bill_id."'");
    if($delete){
      $_SESSION['RMC'] = '<div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Success!</strong> The item was successfully deleted!.
          </div>';
          App::redirectTo('index.php?num=642');
    }
     $processed = 1;
  break;

   case add_requests:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
              // inserting into database service channels
              extract($_POST);
                $add_requests="INSERT INTO request_types(request_type_name, request_type_code)
                             VALUES
          ('".$request_type_name."', '".$request_type_code."')";
  
                $result = run_query($add_requests);
                if (!$result) {
                    $errormessage = '<div class="alert alert-warning">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <strong>warning!</strong> The Request Type Name ('.$request_type_name.') already exists. Try another!
                                    </div>'; 
                    $_SESSION['RMC'] = $errormessage;
                  }else{
                  $_SESSION['RMC'] = '<div class="alert alert-success">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Success!</strong> Entry added successfully.
                        </div>';
                    }
           $processed = 1;
   break;

  case edit_requests:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
              // inserting into database service channels
             extract($_POST);
              if(!onEditcheckForExistingEntry('request_types', 'request_type_code',  $request_type_code, 'request_type_id', $request_type_id)){
                  if(!onEditcheckForExistingEntry('request_types', 'request_type_name',  $request_type_name, 'request_type_id', $request_type_id)){
              $editservicebill="UPDATE request_types
                                SET  request_type_name='".$request_type_name."',
                                     request_type_code='".$request_type_code."'
                                     WHERE request_type_id=$request_type_id";
                                     
              //echo $editservicebill;
                $result = run_query($editservicebill);                      
              if(!$result)
              {
                  $msg = '<div class="alert alert-error">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Error!</strong> Entry not Edited.
                        </div>';
                $_SESSION['RMC'] = $msg;
              }
              else
              {
                  $msg = '<div class="alert alert-success">
                              <button class="close" data-dismiss="alert">×</button>
                              <strong>Success!</strong> Entry Edited successfully.
                          </div>';
                $_SESSION['RMC'] = $msg;
              }

              }else{
                    $_SESSION['RMC'] = '<div class="alert alert-warning">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Warning!</strong> The Request name('.$request_type_name.') already exists.
                        </div>';
                  }
                  }else{
                    $_SESSION['RMC'] = '<div class="alert alert-warning">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Warning!</strong> The Request code('.$request_type_code.') already exists.
                        </div>';
                  }
            
              $processed = 1;
    break;

    case Del410:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
    $request_type_id = $_POST['request_type_id'];
    $delete = run_query("DELETE FROM request_types WHERE request_type_id= '".$request_type_id."'");
    if($delete){
      $_SESSION['RMC'] = '<div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Success!</strong> The item was successfully deleted!.
          </div>';
    }

  break;

    case add_subcounty_forecast:
      logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
      extract($_POST);
      // var_dump($_POST);exit;
      $query = "INSERT INTO forecast (region_id, subcounty_id, target_amount, revenue_channel_id)
      VALUES(NULL, '".$subcounty."', '".$target_amount."', '".$revenue_channel."')";
      // var_dump($query);exit;
      if(!$revenue_manager->checkForExistingForecast('forecast', 'subcounty_id', $subcounty, 'revenue_channel_id', $revenue_channel)){
        if(run_query($query)){
          $_SESSION['RMC'] = '<div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Success!</strong> Forecast has been recorded.
          </div>';
        }
      }else{
        $_SESSION['RMC'] = '<div class="alert alert-warning">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Warning!</strong> Forecast was already recorded.
          </div>';
      }
    break;

    case add_region_forecast:
      logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
      extract($_POST);
      // var_dump($_POST);exit;
      $query = "INSERT INTO forecast (region_id, subcounty_id, target_amount, revenue_channel_id)
      VALUES('".$region."', NULL, '".$target_amount."', '".$revenue_channel."')";
      // var_dump($revenue_manager->checkForExistingForecast('forecast', 'region_id', $region, 'revenue_channel_id', $revenue_channel));exit;
      if(!$revenue_manager->checkForExistingForecast('forecast', 'region_id', $region, 'revenue_channel_id', $revenue_channel)){
        if(run_query($query)){
          $_SESSION['RMC'] = '<div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Success!</strong> Forecast has been recorded.
          </div>';
        }
      }else{
        $_SESSION['RMC'] = '<div class="alert alert-warning">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Warning!</strong> Forecast already exists!.
          </div>';
      }
    break;

    case edit_region_forecast:
      logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
      extract($_POST);

      //get the count for all the regions under the selected revenue channel
      $query = "SELECT f.region_id, f.target_amount, f.revenue_channel_id, r.region_name FROM forecast f
      LEFT JOIN region r ON r.region_id = f.region_id
      WHERE revenue_channel_id = '".$revenue_channel."' AND f.subcounty_id IS NULL";

      $result = run_query($query);
      $num_rows = get_num_rows($result);
      $end_count = $num_rows - 1;
      $count = 0;

      while ($count <= $end_count) {
        //post variables
        $target_amount = $_POST['target_amount'.$count];
        $region_id = $_POST['region_id'.$count];

        $query = "UPDATE forecast SET target_amount = '".$target_amount."' 
        WHERE revenue_channel_id = '".$revenue_channel."' AND region_id = '".$region_id."'";
        
        if(run_query($query)){
          $_SESSION['RMC'] = '<div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Success!</strong> Forecast changes have been saved.
          </div>';
        }

        $count++;
      }
    break;

    case edit_subcounty_forecast:
      logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
      extract($_POST);

      //get the count for all the regions under the selected revenue channel
      $query = "SELECT f.region_id, f.target_amount, f.revenue_channel_id, s.sub_county_name FROM forecast f
    LEFT JOIN sub_county s ON s.sub_county_id = f.subcounty_id
      WHERE revenue_channel_id = '".$revenue_channel."' AND f.region_id IS NULL";

      $result = run_query($query);
      $num_rows = get_num_rows($result);
      $end_count = $num_rows - 1;
      $count = 0;

      while ($count <= $end_count) {
        //post variables
        $target_amount = $_POST['target_amount'.$count];
        $subcounty_id = $_POST['subcounty_id'.$count];

        $query = "UPDATE forecast SET target_amount = '".$target_amount."' 
        WHERE revenue_channel_id = '".$revenue_channel."' AND subcounty_id = '".$subcounty_id."'";
        
        if(run_query($query)){
          $_SESSION['RMC'] = '<div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Success!</strong> Forecast changes have been saved.
          </div>';
        }

        $count++;
      }
    break; 

    case add_each_region_forecast:
      logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
      extract($_POST);

      // persist the forecast to the db
      $query = "INSERT INTO forecast(region_id, revenue_channel_id, target_amount, subcounty_id)
      VALUES('".$region."', '".$revenue_channel."', '".$target_amount."', NULL)";
      // var_dump($query);exit;
      if(run_query($query)){
        $_SESSION['RMC'] = '<div class="alert alert-success">
          <button class="close" data-dismiss="alert">×</button>
          <strong>Success!</strong> Forecast has been successfully added.
        </div>';
      }
    break;

    case add_each_sub_forecast:
      logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
      extract($_POST);

      // persist the forecast to the db
      $query = "INSERT INTO forecast(revenue_channel_id, region_id, target_amount, subcounty_id)
      VALUES('".$revenue_channel."', NULL, '".$target_amount."', '".$subcounty."')";
      if(run_query($query)){
        $_SESSION['RMC'] = '<div class="alert alert-success">
          <button class="close" data-dismiss="alert">×</button>
          <strong>Success!</strong> Forecast has been successfully added.
        </div>';
      }
    break;
}
