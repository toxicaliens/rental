<?php

/**
 * Include the css needed to display this error message
 */
set_title('Access Denied!');
set_css(array("assets/css/pages/error.css"));
set_layout("layout.php");
?>

		<!-- BEGIN PAGE -->  
		<div id="body" data-height="800" style="">
			<div class="container-fluid">
				<!-- BEGIN PAGE TITLE -->
				<h3 class="page-title">
					Acess Denied
					<small>Denied Access to this page!</small>
				</h3>
				<!-- END PAGE TITLE -->

				<!-- BEGIN BREADCRUMBS -->
<?php

/***
 * Using template function to display the breadcrumb
 */
set_breadcrumbs( array (
	array ( 'url'=>'index.php', 'text'=>'Home' ),
	array ( 'text'=>'Access Denied' )
));
?>
				<!-- END BREADCRUMBS -->
				

				<!-- BEGIN PAGE CONTENT -->
				<div class="row-fluid">
					<div class="span12">
						<div class="row-fluid page-404">
							<div class="span5 number">Access Denied</div>
							<div class="span7 details">
								<h3>You have been denied access to this page!</h3>
								<p>
									Please contact the admin. <a href="index.php">[ Home ]</a><br />
								</p>
							</div>
						</div>
					</div>
				</div>
				<!-- END PAGE CONTENT -->
				
			</div>
		</div>
		<!-- END PAGE -->  

