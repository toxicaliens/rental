<?php
error_reporting(0);
set_title('Manage Views');
/**
 * Set the page layout that will be used
 */
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Add Views and Actions',
	'pageSubTitleText' => 'allow one to allocate views',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'System Manager' ),
		array ( 'url'=>'?num=add_role', 'text'=>'All User Roles' ),
		array ( 'text'=>'Manage Views' )
	),
	'pageWidgetTitle' => 'Allocate Views to: '.$_GET['role_name']
));

set_css(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css',
	'assets/plugins/bootstrap-datepicker/css/datepicker.css'
));
set_js(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
	'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'
)); 
if(isset($_SESSION['done-add'])){
    echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['done-add']."</p>";
    unset($_SESSION['done-add']);
}

if(isset($_GET['id'])){
	$role_id = $_GET['id'];
	$role_name = $_GET['role_name'];
}

?>    
<!-- BEGIN FORM -->
	<form action="" method="post" id="add_role" enctype="multipart/form-data" class="form-horizontal">
		<div class="alert alert-error hide">
            <button class="close" data-dismiss="alert">×</button>
            You have some form errors. Please check below.
        </div>
        <div class="alert alert-success hide">
            <button class="close" data-dismiss="alert">×</button>
            Your form validation is successful!
        </div>
        <?php if(isset($_SESSION['mes2'])){ echo $_SESSION['mes2']; unset($_SESSION['mes2']); } ?>                              
       	<input type="hidden" name="role_name" disabled value="<?=$role_name; ?>" autocomplete="off" required/>
		<div class="row-fluid">
			<div class="span8">
				<?php displayAllViews(null, $role_name, $role_id); ?>
			</div>
		</div>
		<input type="hidden" name="action" value="manage_views"/>
		<input type="hidden" name="role_id" value="<?=$role_id; ?>"/>
		<!-- <input type="hidden" name="total_count" value="<?php //echo $count; ?>"/> -->
		<div class="form-actions">
			<?php
				viewActions($_GET['num'], $_SESSION['role_id']);
			?>
		</div>
	</form>
	<!-- END FORM -->

 <div id="add_property_errorloc" class="error_strings">
            </div>

<!---->
	<script language="JavaScript" type="text/javascript"
	    xml:space="preserve">//<![CDATA[
	//You should create the validator only after the definition of the HTML form
	  var frmvalidator = new Validator("add_role");
	 frmvalidator.EnableOnPageErrorDisplaySingleBox();
	 frmvalidator.EnableMsgsTogether();

	frmvalidator.addValidation("house_no","req","Please enter your surname");
	frmvalidator.addValidation("plot_id","req", "Please select the plot_id");
	frmvalidator.addValidation("phone","req", "Please Enter your phone number");
	
	  
    function DoCustomValidation()
    {
	var frm = document.forms["add_role"];
	if(frm.phone.value == 'Null')
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
	"src/js/add.crm.property.js",
	"src/js/check_all.js"
));
?>