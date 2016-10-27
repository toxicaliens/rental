<?php
//error_reporting('0');
switch($_POST['action'])
{
case manage_actions:
    logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
    //get the values to add a new property
    $view_id=$_POST['view_id'];
    $role_id=$_POST['user_role_id'];

        //validation
        if (empty($view_id))
        {
        $_SESSION['mes2']='<div class="alert alert-error">
                            <button class="close" data-dismiss="alert">×</button>
                            You did not enter a view name
                        </div>';
        } else {
            $counter = 1;
            
                $total_count = $_POST['total_count']; 

                while ($counter < $total_count) {
                       # code...
                    $view_label = "view_id_".$counter;
                    $box_label = "view_box_".$counter;
                    
                    $curr_box =$_POST[$box_label];
                    $curr_id = $_POST[$view_label];  

                    //if ticked
                        //if exists, 
                            //continue
                        //else 
                            //insert
                    //elseif not ticked
                        //if exists
                            //remove 
                            //delete from sys_roles_allocations 
                            //where sys_role_id = role_id and sys_view_id = curr_id
                    
                    if($curr_box)
                    {    
                        if(actionExists($view_id, $curr_id, $role_id))
                        {
                            $counter++;
                            continue;
                        }
                        else
                        {
                            $insert="INSERT INTO ".DATABASE.".sys_role_view_actions_allocations(
                                sys_role_views_id,
                                sys_action_id,
                                sys_role_id) 
                            VALUES(
                                '".$view_id."', 
                                '".$curr_id."',
                                '".$role_id."') 
                            RETURNING sys_role_action_id";
                           
                         // $_SESSION['sqlerr'] .= " ".$insert;
                            // $id_data = get_row_data($data);
                            // $id = $id_data['sys_view_id'];
                            //argDump( $data);exit; 
                            if($data=run_query($insert)){
                                $_SESSION['mes2'] = '<div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                Actions have been successfully allocated
                            </div>';
                            }

                        }
                    }
                    else{
                            //if($curr_box = 0){
                                
                                $delete = "delete from sys_role_view_actions_allocations 
                                where sys_role_views_id = '".$view_id."' and sys_action_id = '".$curr_id."' AND sys_role_id = '".$role_id."'";
                                run_query($delete);
                            //}
                               // $_SESSION['sqlerr'] .= "----".$delete;
                        }
                    $counter++;
                }
                
            }
    }        


?>
