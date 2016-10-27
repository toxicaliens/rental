<?php
include_once('src/models/SystemProfile.php');
$system = new SystemProfile();
//error_reporting('0');
switch($_POST['action'])
{
case add_view:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
	//get the values
    $view_name=$_POST['view_name']; 
    $view_index=$_POST['view_index'];
    $view_url=$_POST['view_url'];
    $view_status=$_POST['view_status'];
    $view_parent=$_POST['parent'];

		//validation
		if (empty($view_index) && empty($view_url))
		{
		$_SESSION['mes']='<div class="alert alert-error">
                            <button class="close" data-dismiss="alert">×</button>
                            You did not enter a role name
                        </div>';
		} else {
            if(!checkForExistingEntry('sys_views', 'sys_view_name', $view_name)){
                $query="INSERT INTO ".DATABASE.".sys_views(
                    sys_view_name, 
                    sys_view_index, 
                    sys_view_url, 
                    sys_view_status,
                    parent
                    ) VALUES(
                    '".$view_name."', 
                    '".$view_index."',
                    '".$view_url."',
                    '".$view_status."',
                    ".$view_parent.") 
                    RETURNING sys_view_id";
                
                if($data=run_query($query)){
                    $rows = get_row_data($data);
                    if(allocateSysView($_SESSION['role_id'], $rows['sys_view_id'])){
                        $_SESSION['mes2'] = '<div class="alert alert-success">
                                    <button class="close" data-dismiss="alert">×</button>
                                    Your form submitted successfully!
                                </div>';
                    }else{
                        $_SESSION['mes2'] = get_last_error();
                    }
                }else{
                    $_SESSION['mes2']='<div class="alert alert-error">
                                <button class="close" data-dismiss="alert">×</button>
                                There was an error while saving the view!
                            </div>';
                }
               
                $id_data = get_row_data($data);
                $id = $id_data['sys_view_id'];
                //argDump( $data);exit; 
            }else{
                $_SESSION['mes2']='<div class="alert alert-warning">
                                <button class="close" data-dismiss="alert">×</button>
                                A view with the name('.$view_name.') already exist!
                            </div>';
            }
    }        
break;

case edit_view:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
    //get the values
    $view_name=$_POST['view_name']; 
    $view_id=$_POST['view_id']; 
    $view_index=$_POST['view_index'];
    $view_url=$_POST['view_url'];
    $view_status=$_POST['view_status'];
    $view_parent=$_POST['parent'];

        //validation
        if (empty($view_index) && empty($view_url))
        {
        $_SESSION['mes']='<div class="alert alert-error">
                            <button class="close" data-dismiss="alert">×</button>
                            You did not enter a role name
                        </div>';
        } else {

            $query = "UPDATE sys_views SET 
            sys_view_name='$view_name', 
            sys_view_index='$view_index', 
            sys_view_url='$view_url', 
            sys_view_status='$view_status',
            parent=".$view_parent."
            WHERE sys_view_id = '$view_id'";

            if($data=run_query($query)){
                $_SESSION['done-edits'] = '<div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                The changes have been successfully saved!
                            </div>';
            }

        }
    break;

    case Del175:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
    $view_id = $_POST['view_id'];
    $delete = run_query("DELETE FROM sys_views WHERE sys_view_id = '".$view_id."'");
    if($delete){
        $_SESSION['RMC'] = '<div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                The view has been deleted successfully!
                            </div>';
                        App::redirectTo('index.php?num=all_views');
    }


case add_setting:
logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
$system->addSetting();
break;

case edit_setting:
$system->editSetting();
break;

case delete_setting:
$system->deleteSetting();
break;
}
?>
