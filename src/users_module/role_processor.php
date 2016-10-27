<?php
//error_reporting('0');
switch($_POST['action'])
{
case add_role:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
	//get the values to add a new property
    $role_name=$_POST['role_name']; 
    $status=$_POST['status'];
		//validation
		if (empty($role_name) && empty($status))
		{
		$_SESSION['done-add']='<div class="alert alert-error">
                            <button class="close" data-dismiss="alert">×</button>
                            You did not enter a role name
                        </div>';
		} else {
            $id = '';
            if(!checkForExistingEntry('user_roles', 'role_name', $role_name)){

                $query="INSERT INTO ".DATABASE.".user_roles(role_name,role_status, created_by) VALUES('".$role_name."', '".$status."', '".$_SESSION['mf_id']."') 
                RETURNING role_id";
                
                if($data=run_query($query)){
                    $_SESSION['done-add'] = '<div class="alert alert-success">
                                    <button class="close" data-dismiss="alert">×</button>
                                    Your form submitted successfully!
                                </div>';
                }
              //var_dump($query);exit;
                $id_data = get_row_data($data);
                $id = $id_data['role_id'];
                //argDump( $data);exit; 

            }
            
            if(empty($id))
            {
                //get role_id using role_name
                $role_data = getRoleFromName($role_name);
                $id = $role_data['role_id'];
            }

            if(!checkIfUserCreatedRoleExists($_SESSION['mf_id'], $id))
            {
                //insert 
                $query = "INSERT INTO user_created_roles(
                            mf_id, role_id)
                    VALUES ('".$_SESSION['mf_id']."', '".$id."')";
                if(run_query($query)){
                    $_SESSION['done-add'] = '<div class="alert alert-success">
                                    <button class="close" data-dismiss="alert">×</button>
                                    Your form submitted successfully!
                                </div>';
                }
            }
            else
            {
                //error
                $_SESSION['done-add'] = '<div class="alert alert-warning">
                                    <button class="close" data-dismiss="alert">×</button>
                                    The Role Name('.$role_name.') already exists.
                                </div>';
            }
        }        

break;

case edit_role:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
    $role_id=$_POST['role_id']; 
    $role_name = $_POST['role_name'];
    $status = $_POST['status'];

    //update the customer
    $query="UPDATE ".DATABASE.".user_roles SET role_name='$role_name',role_status='$status' WHERE role_id = '$role_id'";

    $data=run_query($query);
    if ($data)  
    {   
    $_SESSION['done-edits']='<div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            You updated the Role information successfully 
            </div>';
    }
    break;

case Del258:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
    $role_id = $_POST['role_id'];
    $delete = run_query("DELETE FROM user_roles WHERE role_id = '".$role_id."'");
    if($delete){
        $_SESSION['done-edits'] = '<div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                The role was successfully deleted
                            </div>';
    }
    break;
}
?>
