<?
if($_POST['edit_service_bill'] == "Save Changes")
{
    $creterio = $_GET['edit_id'];
    extract($_POST);
    if(empty ($service_bill_name) || empty ($service_bill_description))
    {
     $msg = "Error: Please one of the field is blank or Not selected";
    }
     else
    {

         $edit_service_bill="UPDATE ".DATABASE.".service_bills SET service_type_id='".$service_id."',service_bill_type='".$service_bill_type."',service_bill_name='".$service_bill_name."',service_bill_description='".$service_bill_description."',service_bill_amt='".$service_bill_amt."',service_bill_duetime='".$service_bill_duetime."' WHERE service_bill_id=$creterio";

       // echo $edit_service_bill;
        if(!run_query($edit_service_bill))
        {
            $msg = "Error: Record not edited";
        }
        else
        {
            $msg = "Success: Record edited successfully";
        }
    }
}
?>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
	//initiate validator on load
	$(function() {
		// validate contact form on keyup and submit
		$("#servicebill").validate({
			//set the rules for the fild names
			rules: {
				service_bill_name: {
					required: true,
				},
				service_bill_description: {
                                       required: true,
				},
				service_bill_due_time: {
                                       required: true,
				},
			},
			//set messages to appear inline
			messages: {
				service_bill_name: "Please enter service bill name",
				service_bill_description: "Please enter service bill description",
				service_bill_due_time: "Please enter service bill due time"
			}
		});
	});
</script>
<div>
                    <div style="float:right; width:400px; text-align:left;">

                  <span style="color:#33FF33"><?=$msg?></span>
                    </div>
                    <div style="clear:both;"> </div>

                </div>
<br/>
<fieldset><legend class="table_fields">EDIT SERVICE BILL</legend>
    <form name="servicebill" id="servicebill" method="post" action="">
     <table>
          <tr>
             <td><label class="packlabel">Service Bill Id</label></td>
             <td><input type="text" name="query_id" value="<?=$_GET['edit_id']?>" readonly style="background-color: #ccc" class="packinput"></td>

             <?php
                       $creterio = $_GET['edit_id'];
                       $query = "SELECT * FROM service_bills WHERE service_bill_id = $creterio";
                       $result = run_query($query);
                       while($row =get_row_data($result)){
                                ?>

             <td>&nbsp;</td>
             <td>&nbsp;</td>
         </tr>
         <tr>
             <td><label class="packlabel">Service</label></td>
             <td>
                 <select name="service_id" class="packinput">
                     <?=get_select_with_selected('service_types','service_type_id','service_type_name',$row['service_type_id'])?>
                 </select>
             </td>

              <td><label class="packlabel">Service Bill Type</label></td>
             <td>
                 <select name="service_bill_type">
                     <option <?if($row['service_bill_type']==1){?>selected="selected"<?}?> value="1"> Once Off Fee</option>
                     <option <?if($row['service_bill_type']==5){?>selected="selected"<?}?> value="5"> Regular Fee</option>
                 </select>
             </td>
             </tr>
         <tr>
             <td><label class="packlabel">Service Bill Name</label></td>
             <td><input type="text" name="service_bill_name" value="<?=$row['service_bill_name']?>" class="packinput"></td>

             <td><label class="packlabel">Service Bill Description</label></td>
             <td><input type="text" name="service_bill_description" value="<?=$row['service_bill_description']?>" class="packinput"></td>
             </tr>
         <tr>
             <td><label class="packlabel">Service Bill Amount</label></td>
             <td><input type="text" name="service_bill_amt" value="<?=$row['service_bill_amt']?>" class="packinput"></td>

             <td><label class="packlabel">Service Bill Due Time</label></td>
             <td><input type="text" name="service_bill_duetime" value="<?=$row['service_bill_duetime']?>" class="packinput" onclick="displayDatePicker('service_bill_duetime',this,'ymd','-')"></td>


              </tr>
         <tr>

             <td>&nbsp;</td>
             <td>&nbsp;</td>
    <?}?> 
             <td>&nbsp;</td>
             <td align="right"><input type="submit" name="edit_service_bill" value="Save Changes"></td>
         </tr>

     </table>
</form>
</fieldset>
