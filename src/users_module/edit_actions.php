<?php
error_reporting(0);
set_title('Manage Actions');
/**
 * Set the page layout that will be used
 */
set_layout("form-layout.php", array(
	'pageSubTitle' => 'Add Actions to Views',
	'pageSubTitleText' => 'allow one to allocate actions to views',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'System Manager' ),
		array ( 'url'=> '?num=add_role', 'text'=>'All User Roles' ),
		array ( 'text'=>'Manage Views' ),
		array ( 'text'=>'Manage Actions' )
	),
	'pageWidgetTitle' => 'Allocate Actions to Views'
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

if(isset($_GET['name'])){
	$view_id = $_GET['view_id'];
	$role_id = $_GET['role_id'];
	$name = $_GET['name'];
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
        <div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<label for="name" class="control-label">View Name:<span class="required">*</span></label>
					<div class="controls">	
						<input type="text" name="name" disabled value="<?=$name; ?>" autocomplete="off" required/>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group">
					<div class="controls">
						<? //$_SESSION['sqlerr']; ?>
						<table>
						<?php

							$count = 1;
							$views = "SELECT * FROM sys_actions WHERE sys_view_id = '".$view_id."' ORDER BY sys_action_name ASC";
							$result = run_query($views);
							while($row = get_row_data($result)){
								$action_id = $row['sys_action_id'];

								if(viewAllocatedActions($view_id, $action_id, $role_id)) { 
									$checked = 'checked'; 
								}else{
									$checked = '';
								}
						?>
						<tr>
							<td><?=$row['sys_action_name']; ?></td>
							<td style="text-align:left;"><input type="checkbox" name="view_box_<?=$count; ?>" value="1" <?=$checked; ?> /> 
									<input type="hidden" name="view_id_<?=$count; ?>" value="<?=$action_id; ?>"/>   </td>
						</tr>
						<?php
								$count++;
							}
						?>
						</table>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" name="action" value="manage_actions"/>
		<input type="hidden" name="view_id" value="<?=$view_id; ?>"/>
		<input type="hidden" name="user_role_id" value="<?=$role_id; ?>"/>
		<input type="hidden" name="total_count" value="<?=$count; ?>"/>

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
	"src/js/delete.js"
));
?>