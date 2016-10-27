<?php
error_reporting(0);
set_title('Edit House');
/**
 * Set the page layout that will be used
 */
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Edit House Details',
	'pageSubTitleText' => 'allow one to edit house details',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'House/Units' ),
		array ( 'text'=>'Edit House' )
	),
	'pageWidgetTitle' => 'House Details'
));

set_css(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css',
	'assets/plugins/bootstrap-datepicker/css/datepicker.css'
));
set_js(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
	'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'
)); 
if(isset($_SESSION['done-edits'])){
    echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['done-edits']."</p>";
    unset($_SESSION['done-edits']);
}

//get the value
$house=$_GET['house'];
if (isset($house))
{
//get the row
$query="SELECT * FROM ".DATABASE.".houses WHERE house_id='$house'";
$data=run_query($query);
$total_rows=get_num_rows($data);
}
$con=1;
$total=0;

$row=get_row_data($data);

//the values
$id = $row['house_id'];
$house_no = $row['house_number'];
$rent_amount=$row['rent_amount'];    
$tenant=$row['tenant_id'];
$attached_to=$row['attached_to'];  
?>    
<!-- BEGIN FORM -->
	<form action="" method="post" id="add_house" enctype="multipart/form-data" class="form-horizontal">
		<div class="alert alert-error hide">
            <button class="close" data-dismiss="alert">×</button>
            You have some form errors. Please check below.
        </div>
        <div class="alert alert-success hide">
            <button class="close" data-dismiss="alert">×</button>
            You have validated the form successfully.
        </div>                              
        <div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="house_no" class="control-label">House No.:<span class="required">*</span></label>
					<div class="controls">
						<input type="text" name="house_no" value="<?=$house_no; ?>" required/>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="rent_amount" class="control-label">Rent Amount:<span class="required">*</span></label>
					<div class="controls">
						<input type="number" name="rent_amount" value="<?=$rent_amount; ?>" required/>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="plot_id" class="control-label">Plot:<span class="required">*</span></label>
					<div class="controls">
						<select name="plot_id" required>
							<option value="0">N/A</option>
								<?php

                                $query = run_query("SELECT * FROM plots ORDER BY plot_name ASC");

                                if ( $query !== false )
                                {
                                        while ( $fetch = get_row_data($query) )
                                        {
                                ?>
                                <option value="<?=$fetch['plot_id']; ?>" <?php if($fetch['plot_id'] === $attached_to){ echo 'selected'; } ?>><?php echo $fetch['plot_name']; ?></option>
                                <?php           
                                    }
                                }
                                ?>
						</select>
					</div>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="tenant" class="control-label">Tenant:<span class="required">*</span></label>
					<div class="controls">
						
						<select name="tenant" required>
							<option value="">--Choose Tenant--</option>
							<?php

								$query = "SELECT * FROM tenants";
								$result = run_query($query);
								while($row = get_row_data($result)){
									$ten_id=$row['tenant_id'];
									$surname=$row['surname'];
									$firstname=$row['firstname'];
							?>
							<option value="<?php echo $id; ?>" <?php if($ten_id === $tenant){ echo 'selected'; } ?> ><?php echo "$surname $firstname"; ?></option>
							<?php
								}
							?>
						</select>

					</div>
				</div>
			</div>
		</div>

		<input type="hidden" name="action" value="edit_house"/>
		<input type="hidden" name="house_id" value="<?=$id; ?>"/>

		<div class="form-actions">
			<button class="btn btn-primary" type="submit">Save</button>
			<a class="btn btn-danger" id="delete_link" href="index.php?num=del_house&house=<?=$id; ?>"
	onclick="return confirm('Are you sure you want to delete?')">Delete</a>
			<button class="btn" type="reset">Reset</button>
		</div>
	</form>
	<!-- END FORM -->

 <div id="add_property_errorloc" class="error_strings">
            </div>

<!---->
	<script language="JavaScript" type="text/javascript"
	    xml:space="preserve">//<![CDATA[
	//You should create the validator only after the definition of the HTML form
	  var frmvalidator  = new Validator("add_property");
	 frmvalidator.EnableOnPageErrorDisplaySingleBox();
	 frmvalidator.EnableMsgsTogether();

	frmvalidator.addValidation("prop_name","req","Please enter your surname");
	frmvalidator.addValidation("prop_units","req", "Please enter the no of units");
	
	  
    function DoCustomValidation()
    {
	var frm = document.forms["edit_prop"];
	if(frm.firstname.value == 'Null')
	{
	    sfm_show_error_msg("You can't submit this form. Go away! ");
	    return false;
	}
	else
	{
	    return true;
	}
    }
	
	frmvalidator.setAddnlValidationFunction(DoCustomValidation);
	//]]></script>
	<!---->
<?php
/**
 * Using jQuery Validator Plugin
 */
set_css(array("assets/plugins/bootstrap-datepicker/css/datepicker.css"));
set_js(array(
	"assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js",
	"assets/scripts/form-validator.js",
	"src/js/add.crm.property.js"
));
?>
