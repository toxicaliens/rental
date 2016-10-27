<?php
error_reporting(0);
set_title('Edit Plot');
/**
 * Set the page layout that will be used
 */
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Edit Plot Details',
	'pageSubTitleText' => 'allow one to edit plot details',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Plots' ),
		array ( 'text'=>'Edit Plot' )
	),
	'pageWidgetTitle' => 'Plot Details'
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

if($_POST['action'] == "edit_property")
{
	$pro_id=$_POST['pro_id']; 
    $plot_name = $_POST['plot_name'];
    $payment_code=$_POST['payment_code'];
	$paybill_number=$_POST['paybill_no'];         
	$customer_id=$_POST['attached_to']; 
	$units=$_POST['units'];


	//update the customer
	$query="UPDATE ".DATABASE.".plots SET plot_name='$plot_name', 
	payment_code='$payment_code', customer_id='$customer_id', paybill_number='$paybill_number', units='$units' WHERE plot_id = '$pro_id'";

	$data=run_query($query);
	if ($data)	
	{	
	$message='<div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            You updated the Plot information successfully 
        	</div>';
	}
}

	//get the value
$plot=$_GET['plot'];
if (isset($plot))
{
//get the row
$query="SELECT * FROM ".DATABASE.".plots WHERE plot_id='$plot'";
$data=run_query($query);
$total_rows=get_num_rows($data);
}
$con=1;
$total=0;

$row=get_row_data($data);

//the values
$prop_name = $row['plot_name'];
$plot_id = $row['plot_id'];
$payment_code=$row['payment_code'];
$paybill_no=$row['paybill_number'];
$attached_to=$row['customer_id'];
$units=$row['units'];  
?>    
<!-- BEGIN FORM -->
	<form action="" method="post" id="add_property" enctype="multipart/form-data" class="form-horizontal">
		<div class="alert alert-error hide">
            <button class="close" data-dismiss="alert">×</button>
            You have some form errors. Please check below.
        </div>
        <div class="alert alert-success hide">
            <button class="close" data-dismiss="alert">×</button>
            You have some form errors. Please check below.
        </div>    
        <?php echo $message; ?>                          
        <div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="plot_name" class="control-label">Plot Name<span class="required">*</span></label>
					<div class="controls">
						<input type="text" name="plot_name" value="<?=$prop_name; ?>" required/>
					</div>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="units" class="control-label">Units:<span class="required">*</span></label>
					<div class="controls">
						<input type="number" value="<?=$units; ?>" placeholder="Enter no of units in plot" name="units" required/>
					</div>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="property_desc" class="control-label">Payment Code:</label>
					<div class="controls">
						<input type="text" name="payment_code" value="<?=$payment_code; ?>" required/>
					</div>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="property_desc" class="control-label">Paybill No:</label>
					<div class="controls">
						<input type="number" name="paybill_no" value="<?=$paybill_no; ?>" required/>
					</div>
				</div>
			</div>
		</div>
        
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="attached_to" class="control-label">Attach to:<span class="required">*</span></label>
					<div class="controls">
						<select name="attached_to" required>
							<option value="0">N/A</option>
								<?php

                                $query = "SELECT * FROM customers ORDER BY surname ASC";

                                if ($data = run_query($query))
                                {
                                        while ( $fetch = get_row_data($data) )
                                        {
                                ?>
                                <option value="<?=$fetch['customer_id']; ?>" <?php if($fetch['customer_id'] === $attached_to){ echo 'selected'; } ?>><?php echo $fetch['surname']." ".$fetch['firstname']; ?></option>";
                                <?php
                                    }
                                }
                                ?>
						</select>
					</div>
				</div>
			</div>
		</div>		

		<input type="hidden" name="action" value="edit_property"/>
		<input type="hidden" name="pro_id" value="<?=$plot_id; ?>"/>

		<div class="form-actions">
			<button class="btn btn-primary" type="submit">Save</button>
			<a href="index.php?num=del_plot&id=<?=$plot_id; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
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
	if(frm.prop_name.value == 'Null')
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
