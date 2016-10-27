<?php

/**
 * Include the css needed to display this error message
 */
set_css(array("assets/css/pages/error.css"));
set_layout("layout.php");
?>

		<!-- BEGIN PAGE -->  
		<div id="body" data-height="800" style="">
			<div class="container-fluid">
			
				<!-- BEGIN PAGE TITLE -->
				<h3 class="page-title">
					RENTAL COLLECTION
					<!-- <small>Medical and General Insurance for all!</small> -->
				</h3>
				<!-- END PAGE TITLE -->

				<!-- BEGIN BREADCRUMBS -->
<?php

/***
 * Using template function to display the breadcrumb
 */
set_breadcrumbs( array (
	array ( 'text'=>'Home' )
));
?>
				<!-- END BREADCRUMBS -->
				

				<!-- BEGIN PAGE CONTENT -->
				<div class="row-fluid">
					<div class="span12">
						<div class="row-fluid page-404">
							<div class="span6 number">RENTAL</div>
							<div class="span6 details">
								
							</div>
						</div>
					</div>
				</div>
				<!-- END PAGE CONTENT -->
				
			</div>
		</div>
		<!-- END PAGE -->  

