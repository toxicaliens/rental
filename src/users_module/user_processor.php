<?php
//error_reporting('0');
switch($_POST['action'])
{
case add_user:
	//get the values to add a new property
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
    $username=$_POST['username']; 
    $email=$_POST['email'];
    $status=$_POST['status'];
    $password=$_POST['password'];
    $pass_hash=sha1($password);
    $pass_again=$_POST['pass_again'];
    $user_role=$_POST['user_role'];               
		//validation
		if (empty($user_role) && empty($pass_again) && empty($password) && empty($status) && empty($email) && empty($username))
		{
		$_SESSION['mes']='<div class="alert alert-error">
                            <button class="close" data-dismiss="alert">×</button>
                            All field are required!
                        </div>';
		} else if($password != $pass_again){
            $_SESSION['mes']='<div class="alert alert-error">
                            <button class="close" data-dismiss="alert">×</button>
                            Passwords do not Match!
                        </div>';
        } else {
            $check=run_query("SELECT username FROM user_login2 WHERE username = '$username'");
            if(get_num_rows($check) == 1){
                 $_SESSION['mes']='<div class="alert alert-error">
                            <button class="close" data-dismiss="alert">×</button>
                            The usename already exists. Please try again.
                        </div>';
            } else{ 

            $query="INSERT INTO ".DATABASE.".user_login2(
                username, 
                password, 
                email, 
                user_active, 
                user_role) VALUES(
                    '".$username."',
                    '".$pass_hash."',
                    '".$email."',
                    '".$status."',
                    '".$user_role."'
                    ) 
                RETURNING user_id";
            
            if($data=run_query($query)){
                $_SESSION['mes'] = '<div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                Your form submitted successfully!
                            </div>';
            }
           
            $id_data = get_row_data($data);
            $id = $id_data['id'];
            //argDump( $data);exit; 
    } 

    }       
    break;

    case edit_user:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        //get the values 
        // $username=$_POST['username']; 
        // $email=$_POST['email'];
        $status=$_POST['status'];
        // $password=$_POST['password'];
        // $pass_hash=sha1($password);
        // $pass_again=$_POST['pass_again'];
        $user_role=$_POST['user_role']; 
        $user_id=$_POST['user_id'];              
        //validation
        if (empty($user_role) && empty($status))
        {
        $_SESSION['mes']='<div class="alert alert-error">
                            <button class="close" data-dismiss="alert">×</button>
                            All field are required!
                        </div>';
        }  else {

            $query="UPDATE ".DATABASE.".user_login2 SET
                user_active='$status', 
                user_role='$user_role'
                WHERE user_id='$user_id'";
            
            if($data=run_query($query)){
                $query = "TRUNCATE loginattempts";
                run_query($query);
                $_SESSION['done-edits'] = '<div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                The changes have been successfully save.
                            </div>';
            }

        }
    break;

    case Del255:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
    $user_id = $_POST['user_id'];
    $delete = run_query("DELETE FROM user_login2 WHERE user_id = '".$user_id."'");
    if($delete){
        $_SESSION['done-edits'] = '<div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                The user was successfully deleted!
                            </div>';
    }
    break;

    case change_password:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
    extract($_POST);
    // checkWhetherOldPasswordExists($_SESSION['mf_id'], $old_password);die();
    if(checkWhetherOldPasswordExists($_SESSION['mf_id'], $old_password)){
        if($password == $pass_again){
            $pass_hash = sha1($password);
            $change_password = "UPDATE user_login2 SET
            username = '".$user_name."',
            password = '".$pass_hash."'
            WHERE mf_id = '".$_SESSION['mf_id']."'";
            // var_dump($change_password);exit;
            $result = run_query($change_password);
            if($result){
                $_SESSION['change_password'] = '<div class="alert alert-success">
                                    <button class="close" data-dismiss="alert">×</button>
                                    The Login credentials were successfully changed.
                                </div>';
            }else{
                $_SESSION['change_password'] = pg_last_error();
            }
        }else{
            $_SESSION['change_password'] = '<div class="alert alert-warning">
                                    <button class="close" data-dismiss="alert">×</button>
                                    The passwords do not match!
                                </div>';
        }
    }else{
        $_SESSION['change_password'] = '<div class="alert alert-warning">
                                    <button class="close" data-dismiss="alert">×</button>
                                    The current password is wrong!
                                </div>';
    }
}
?>
