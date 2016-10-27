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
					404 Page
					<small>page not found</small>
				</h3>
				<!-- END PAGE TITLE -->

				<!-- BEGIN BREADCRUMBS -->
<?php

/***
 * Using template function to display the breadcrumb
 */
set_breadcrumbs( array (
	array ( 'url'=>'index.php', 'text'=>'Home' ),
	array ( 'text'=>'Page Not Found' )
));
?>
				<!-- END BREADCRUMBS -->
				

				<!-- BEGIN PAGE CONTENT -->
				<div class="row-fluid">
					<div class="span12">
						<div class="row-fluid page-404">
							<div class="span5 number"> 404 </div>
							<div class="span7 details">
								<h3>Opps, You're lost.</h3>
								<p>
									We can not find the page you're looking for.<br />
									Is there a typo in the url?
								</p>
							</div>
						</div>
					</div>
				</div>
				<!-- END PAGE CONTENT -->
				
			</div>
		</div>
		<!-- END PAGE -->  

