<?php
//error_reporting('0');
switch($_POST['action'])
{
case add_menu_item:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
	//get the values
    $parent_id=$_POST['parent'];
    $text=$_POST['menu_name'];

    if(!checkForExistingEntry('menu', 'text', $text)){
        if($parent_id == 'null'){ 
            $class='has-sub';
        }else{
            $class='';
        }
        $icon=$_POST['icon'];
        if(empty($icon) && $parent_id == 'NULL'){
            $icon = 'icon-keyboard';
        }
        $sequence=$_POST['sequence'];
        $view_id=$_POST['view'];
        $status=$_POST['status'];

    		//validation
    		if (empty($text) && empty($parent_id))
    		{
    		$_SESSION['mes2']='<div class="alert alert-error">
                                <button class="close" data-dismiss="alert">×</button>
                                Some of the fields are mandatory!
                            </div>';
    		} else {

                $query="INSERT INTO ".DATABASE.".menu(
                    parent_id, 
                    icon, 
                    class, 
                    view_id, 
                    status, 
                    text,
                    sequence
                    ) VALUES( 
                    ".$parent_id.",
                    '".$icon."',
                    '".$class."',
                    '".$view_id."',
                    '".$status."',
                    '".$text."',
                    '".$sequence."') 
                    RETURNING menu_id";
                
                if($data=run_query($query)){
                    $_SESSION['mes2'] = '<div class="alert alert-success">
                                    <button class="close" data-dismiss="alert">×</button>
                                    Added a new menu item.
                                </div>';
                }else{
                    $_SESSION['mes2']=pg_last_error();
                }
               
                $id_data = get_row_data($data);
                $id = $id_data['menu_id'];
                //argDump( $data);exit; 
            }
        }else{
             $_SESSION['mes2']='<div class="alert alert-warning">
                                <button class="close" data-dismiss="alert">×</button>
                                The menu item('.$text.') already exists. Please try another
                            </div>';
        }        
break;

// case edit_view:
//     //get the values
//     $view_name=$_POST['view_name']; 
//     $view_id=$_POST['view_id']; 
//     $view_index=$_POST['view_index'];
//     $view_url=$_POST['view_url'];
//     $view_status=$_POST['view_status'];

//         //validation
//         if (empty($view_index) && empty($view_url))
//         {
//         $_SESSION['mes']='<div class="alert alert-error">
//                             <button class="close" data-dismiss="alert">×</button>
//                             You did not enter a role name
//                         </div>';
//         } else {

//             $query = "UPDATE sys_views SET 
//             sys_view_name='$view_name', 
//             sys_view_index='$view_index', 
//             sys_view_url='$view_url', 
//             sys_view_status='$view_status'
//             WHERE sys_view_id = '$view_id'";

//             if($data=run_query($query)){
//                 $_SESSION['done-edits'] = '<div class="alert alert-success">
//                                 <button class="close" data-dismiss="alert">×</button>
//                                 The changes have been successfully saved!
//                             </div>';
//             }

//         }
}
?>
