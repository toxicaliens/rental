<?php
//error_reporting('0');
switch($_POST['action'])
{
case add_action:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
	//get the values
    $action_name=$_POST['action_name']; 

    //this will limit the action code to three characters and then add an incrementing value
    $limiter = substr($action_name, 0, 3);

    //get the current action_id and add 1 to it to get the future action_id and concatenate on the limiter variable

    $counter = 1;
    $query = "SELECT sys_action_id FROM sys_actions ORDER BY sys_action_id ASC";
    $result = run_query($query);
    while($row = get_row_data($result)){
        $action_id = $row['sys_action_id'];
    }
    $action_id = $action_id + 1;
    $action_code = $limiter.''.$action_id;

    $action_description=$_POST['action_description'];
    $action_status=$_POST['action_status'];
    $view_name=$_POST['view_name'];
    // $action_id=$_POST['action_id'];
    $action_type=$_POST['type'];
    $action_class=$_POST['class'];
    $button_type=$_POST['button_type'];
    $others = $_POST['others'];

		//validation
		if (empty($action_code) && empty($view_name))
		{
		$_SESSION['mes2']='<div class="alert alert-error">
                            <button class="close" data-dismiss="alert">×</button>
                            You did not enter the code and the view_name
                        </div>';
		} else {

            $query="INSERT INTO ".DATABASE.".sys_actions(
                sys_action_code, 
                sys_action_description, 
                sys_view_id, 
                sys_action_status, 
                sys_action_name,
                sys_action_type,
                sys_action_class,
                sys_button_type,
                others
                ) VALUES(
                '".$action_code."', 
                '".$action_description."',
                '".$view_name."',
                '".$action_status."',
                '".$action_name."',
                '".$action_type."',
                '".$action_class."',
                '".$button_type."',
                '".$others."'
                ) 
                RETURNING sys_action_id";
            
            if($data=run_query($query)){
                $rows = get_row_data($data);
                if(allocateViewAction($_SESSION['role_id'], $view_name, $rows['sys_action_id'])){
                    $_SESSION['mes2'] = '<div class="alert alert-success">
                        <button class="close" data-dismiss="alert">×</button>
                        Your form submitted successfully!
                    </div>';
                }else{
                    $_SESSION['mes2'] = get_last_error();
                }
            }
           
            $id_data = get_row_data($data);
            $id = $id_data['sys_action_id'];
            //argDump( $data);exit; 
    }        
break;

case ed_action:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
    //get the values
    $action_name=$_POST['action_name']; 
    $action_description=$_POST['action_description'];
    $action_status=$_POST['action_status'];
    $view_name=$_POST['view_name'];
    $action_id=$_POST['action_id'];
    $action_type=$_POST['type'];
    $action_class=$_POST['class'];
    $button_type=$_POST['button_type'];
    $others = $_POST['others'];
        //validation
        if (empty($action_code) && empty($view_name))
        {
        $_SESSION['mes']='<div class="alert alert-error">
                            <button class="close" data-dismiss="alert">×</button>
                            You did not enter the code and the view_name
                        </div>';
        } else {

            $query = "UPDATE sys_actions SET
            sys_action_description='$action_description', 
            sys_view_id='$view_name', 
            sys_action_status='$action_status', 
            sys_action_name='$action_name',
            sys_action_type='$action_type',
            sys_action_class='$action_class',
            sys_button_type='$button_type',
            others = '".$others."'
            WHERE sys_action_id = '$action_id'";

            if($data=run_query($query)){
                $_SESSION['done-edits'] = '<div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                The changes have been successfully saved!
                            </div>';
            }

        }
        break;

case Del180:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
    $action_id = $_POST['action_id'];
    $query = run_query("DELETE FROM sys_actions WHERE sys_action_id = '".$action_id."'");
    if($query){
        $_SESSION['RMC'] = '<div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                The action was successfully deleted!
                            </div>';
                        App::redirectTo('index.php?num=all_actions');
    }
}
?>
