<?php
//error_reporting('0');
switch($_POST['action'])
{
case manage_menu:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
	$result = run_query("SELECT * FROM menu");
    while($row = get_row_data($result)){
        $menu_id = $row['menu_id'];
        if(isset($_POST['parent_id'.''.$menu_id]) && isset($_POST['id'.''.$menu_id])){
            $parent_id = $_POST['parent_id'.''.$menu_id];
            $id = $_POST['id'.''.$menu_id];
            if(!empty($id)){
                if($parent_id == ''){
                    $query="UPDATE menu SET
                    parent_id = NULL,
                    class='has-sub'
                    WHERE menu_id = '".$id."'";
                }else{
                    $query="UPDATE menu SET
                    parent_id='".$parent_id."',
                    class=''
                    WHERE menu_id = '".$id."'";
                }
            }
                
            if($data=run_query($query)){
                $_SESSION['mes3'] = '<div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                The changes have been successfully saved!
                            </div>';
            }else{
                $_SESSION['mes3']=pg_last_error();
            }
        } 
    }       
break;

case edit_menu_details:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
    //get the values
    $menu_name=$_POST['menu_name']; 
    $icon=$_POST['icon']; 
    $view=$_POST['view'];
    $status=$_POST['status'];
    $menu_id=$_POST['menu_id'];
    $sequence=$_POST['sequence'];

    //validation
    if (empty($menu_name) && empty($view))
    {
    $_SESSION['done-edits']='<div class="alert alert-error">
                        <button class="close" data-dismiss="alert">×</button>
                        You neither entered a name nor a view
                    </div>';
    } else {

        $query = "UPDATE menu
        SET  
        icon='".$icon."',  
        view_id='".$view."', 
        status='".$status."', 
        text='".$menu_name."',
        sequence='".$sequence."'
        WHERE menu_id = '".$menu_id."'";

        if($data=run_query($query)){
            $_SESSION['done-edits'] = '<div class="alert alert-success">
                            <button class="close" data-dismiss="alert">×</button>
                            The changes have been successfully saved!
                        </div>';
        }

    }
break;

case Del262:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
    $menu_id = $_POST['menu_id'];
    $delete = run_query("DELETE FROM menu WHERE menu_id = '".$menu_id."'");
    if($delete){
        $_SESSION['done-edits'] = '<div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                The Menu Item has been successfully deleted!
                            </div>';
    }
}
?>
