<?
 set_layout("form-layout.php", array(
    'pageSubTitle' => 'ADD SERVICES',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'url'=>'index.php?num=152', 'text'=>'Manage Services' ),
        array ( 'text'=>'Add Service' )
    ),
    'pageWidgetTitle'=>'ADD SERVICE'
));

if($_POST['action'] == "ADD")
{
    extract($_POST);
    if(empty ($service_name) || empty ($narrative))
    {
     $msg = "Error: Please one of the field is blank or Not selected";
    }
     else
    {
         //checks whether the service is available
         if(service_not_available($service_name,$service_type_id))
         {
            if(keyword_not_available($keyword))
            {
             $add_services="INSERT INTO ".DATABASE.".services(  service_type_id,
                                                                service_name,
                                                                narrative,
                                                                amount,
                                                                keyword) 
                                                        VALUES ('".$service_type_id."',
                                                                '".$service_name."',
                                                                '".$narrative."',
                                                                '".$amount."',
                                                                '".$keyword."')";

          // echo $add_services;

            if(!run_query($add_services))
            {
                $msg = "Error: Record not added";
            }
            else
            {
                $msg = "Success: Record added successfully";
            }
            }else
                {
                 $msg = "There is a  service with the same keyword";
                }
         }
         else
         {
             $msg = "The service you are adding exists in our system";
         }
    }
}
?>

<div>
    <div style="float:right; width:400px; text-align:left;">
        <span style="color:#33FF33"><?=$msg?></span>
    </div>
    <div style="clear:both;"> </div>
</div>
<br/>

    <form name="services" id="services" method="post" action="" class="form-horizontal">

        <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label for="packlabel" class="control-label">Service Type</label>
                <div class="controls">
                    <select name="service_type_id" class="packinput">
                     <?php
                    $categories=run_query("SELECT * FROM service_types");
                     while ($fetch=get_row_data($categories))
                     {
                     echo "<option value='".$fetch['service_type_id']."'>".$fetch['service_type_name']."</option>";
                     }
                     ?>
                 </select>
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="control-group">
                <label for="packlabel" class="control-label">Service Name</label>
                <div class="controls">
                    <input type="text" name="service_type_name" value="" class="packinput" required>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label for="packlabel" class="control-label">Narrative</label>
                <div class="controls">
                    <input type="text" name="narrative" value="" class="packinput" required>
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="control-group">
                <label for="packlabel" class="control-label">Keyword</label>
                <div class="controls">
                    <input type="text" name="keyword" value="" class="packinput">
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label for="packlabel" class="control-label">Amount</label>
                <div class="controls">
                    <input type="text" name="amount" value="" class="packinput">
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <td align="center"><input type="submit" button class="btn btn-primary" name="action" value="ADD"></td>
        <td align="center"><input type="submit" name="back" onclick = "history.go(-1);return false" value="Back"></td>
    </div>  

</form>
