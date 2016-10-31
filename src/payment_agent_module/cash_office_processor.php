<?php
// error_reporting(0);
switch($_POST['action'])
{
    case cash_collected:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);        
        //get the values 
        extract($_POST);
        $today = date('Y-m-d H:i:s');
        $timestamp = strtotime($today);
        //var_dump($_POST);exit;
        $cash_collected="INSERT INTO clerk_settlement
        (mf_id, cash_recieved, date_recieved, recieved_by,details,bank_name,account_no,reference_no) 
      VALUES ('".$mf_id."',
      '".$cash_recieved."',
      '".$today."',
      '".$_SESSION['mf_id']."',
      '".$details."',
      '".$bank_name."',
      '".$account_no."',
      '".$reference_no."')";
      //var_dump($cash_collected);exit;
       $result = run_query($cash_collected);
	    if($result){
	      $journal_tranc = "INSERT INTO journal(
	                journal_date, 
	                amount, 
	                dr_cr, 
	                mf_id,
	                journal_type,
	                particulars,
	                service_account,
	                journal_code,
	                stamp,
	                post_date)
	                    VALUES (
	                        '".$report_date."',
	                        '".$cash_recieved."', 
	                        'DR', 
	                        '".$_SESSION['mf_id']."',
	                        1,
	                        '".$details."',
	                        NULL,
	                        NULL,
	                        '".$timestamp."',
	                        '".$today."')";
            if(run_query($journal_tranc)){
                  $journal_tranc2 = "INSERT INTO journal(
	                journal_date, 
	                amount, 
	                dr_cr, 
	                mf_id,
	                journal_type,
	                particulars,
	                service_account,
	                journal_code,
	                stamp,
	                post_date)
	                    VALUES (
	                        '".$report_date."',
	                        '".$cash_recieved."', 
	                        'CR', 
	                        '".$mf_id."',
	                        1,
	                        '".$details."',
	                        NULL,
	                        NULL,
	                        '".$timestamp."',
	                        '".$today."')";
               if(run_query($journal_tranc2)){
						$message='<div class="alert alert-success">
								<button class="close" data-dismiss="alert">x</button>
								<strong>Success!</strong> The Record was added successfully.
							</div>';		
				        $_SESSION['done-deal']=$message;
				        App::redirectTo('index.php?num=168');
				    }else{
				    	$_SESSION['done-deal']='<div class="alert alert-error">
								<button class="close" data-dismiss="alert">x</button>
								<strong>Error!</strong> The Record was Not Added!
							</div>';
				    }
            }
        }
    $processed = 1;
	break;

}
	
?>