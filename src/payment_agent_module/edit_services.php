<?
set_layout("form-layout.php", array(
    'pageSubTitle' => 'EDIT SERVICES',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'text'=>'payment & Bills' ),
        array ( 'url'=>'index.php?num=152','text'=>'All Services' ),
    array ( 'text'=>'Edit Services' )
    ),
    'pageWidgetTitle' => 'EDIT SERVICE '
));


// if($_POST['edit_services'] == "Save Changes")
// {
//     $creterio = $_GET['edit_id'];
//     extract($_POST);
//     if(empty ($service_name) || empty ($narrative))
//     {
//      $msg = "Error: Please one of the field is blank or Not selected";
//     }
//      else
//     {

         
//          $edit_services="UPDATE services SET service_type_id='".$service_type_id."',
//                                              service_name='".$service_name."',
//                                              narrative='".$narrative."',
//                                              amount='".$amount."',
//                                              keyword='".$keyword."' 
//                                              WHERE service_id=$creterio";

//      //  echo $edit_services;

//         if(!run_query($edit_services))
//         {
//             $msg = "Error: Record not edited";
//         }
//         else
//         {
//             $msg = "Success: Record edited successfully";
//         }
//     }
// }
?>
<div>
                    <div style="float:right; width:400px; text-align:left;">

                  <span style="color:#33FF33"><?=$msg?></span>
                    </div>
                    <div style="clear:both;"> </div>

                </div>
<br/>
<fieldset><legend class="table_fields">EDIT SERVICES</legend>
    <form name="services" id="services" method="post" action="">
     <table>
         <tr>
             <td><label class="packlabel">Service Id</label></td>
             <td><input type="text" name="query_id" value="<?=$_GET['edit_id']?>" readonly style="background-color: #ccc" class="packinput"></td>

             <?php
                       $creterio = $_GET['edit_id'];
                       $query = "SELECT * FROM services WHERE service_id = $creterio";
                       $result = run_query($query);
                       while($row =get_row_data($result)){
                                ?>

             <td>&nbsp;</td>
             <td>&nbsp;</td>
         </tr>
         <tr>
             <td><label class="packlabel">Service Type</label></td>
             <td>
                 <select name="service_type_id" class="packinput">
                     <?=get_select_with_selected('service_types','service_type_id','service_type_name',$row['service_type_id'])?>
                 </select>
             </td>

             <td><label class="packlabel">Service  Name</label></td>
             <td><input type="text" name="service_name" value="<?=$row['service_name']?>" class="packinput"></td>
             </tr>
         <tr>
             <td><label class="packlabel">Narrative</label></td>
             <td><input type="text" name="narrative" value="<?=$row['narrative']?>" class="packinput"></td>

             <td><label class="packlabel">Keyword</label></td>
             <td><input type="text" name="keyword" value="<?=$row['keyword']?>" class="packinput"></td>

              </tr>
         <tr>
            <td><label class="packlabel">Amount</label></td>
             <td><input type="text" name="amount" value="<?=$row['amount']?>" class="packinput"></td>
           
        <?}?>
             <td>&nbsp;</td>
             <td align="right"><input type="submit" name="edit_services" value="Save Changes"></td>
         </tr>

     </table>
</form>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
    //initiate validator on load
    $(function() {
        // validate contact form on keyup and submit
        $("#services").validate({
            //set the rules for the fild names
            rules: {
                service_name: {
                    required: true
                },
                narrative: {
                                       required: true
                },
                                keyword:{
                                    require: true
                                }
            },
            //set messages to appear inline
            messages: {
                service_bill_name: "Please enter service bill name",
                narrative: "Please enter narrative",
                                keyword: "Please enter keyword"
            }
        });
    });
</script>

</fieldset>