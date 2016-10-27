<?php
error_reporting('0');
switch($_POST['action'])
{
case manage_views:
    //get the values to add a new property
    
    $role_id=$_POST['role_id'];

    //validation
    if (empty($role_id))
    {
    $_SESSION['mes2']='<div class="alert alert-error">
                        <button class="close" data-dismiss="alert">×</button>
                        You did not enter a role name
                    </div>';
    } else {
        $counter = 1;
        $query = "SELECT * FROM sys_views ORDER BY sys_view_name ASC";
        $result = run_query($query);
            while ($row = get_row_data($result)) {

                $view_label = "view_id_".$row['sys_view_id'];
                $box_label = "view_box_".$row['sys_view_id'];

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
                    if(exists($role_id, $curr_id))
                    {
                        
                        $counter++;
                        continue;
                    }
                    else
                    {
                        $insert="INSERT INTO ".DATABASE.".sys_role_views_allocations(
                            sys_role_id,
                            sys_view_id) 
                        VALUES(
                            '".$role_id."', 
                            '".$curr_id."') 
                        RETURNING sys_role_view_id";
                       
                     // $_SESSION['sqlerr'] .= " ".$insert;
                        // $id_data = get_row_data($data);
                        // $id = $id_data['sys_view_id'];
                        //argDump( $data);exit; 
                        if($data=run_query($insert)){
                           $_SESSION['mes2'] = '<div class="alert alert-success">
                            <button class="close" data-dismiss="alert">×</button>
                            Views have been successfully allocated
                        </div>';
                        }

                    }
                }
                else{
                        //if($curr_box = 0){
                            
                            $delete = "delete from sys_role_views_allocations 
                            where sys_role_id = '".$role_id."' and sys_view_id = '".$curr_id."'";
                            run_query($delete);
                        //}
                           // $_SESSION['sqlerr'] .= "----".$delete;
                    }
                $counter++;
            }
            
        }

        //}
    }        


?>
