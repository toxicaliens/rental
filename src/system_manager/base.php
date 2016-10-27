<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php
	// The page title
	$templateResource = self::getResource('title');
	$templateResource = ($templateResource=="") ? "AfyaPoa Admin": $templateResource;
?>
	<title><?php echo $templateResource; ?></title>

	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="assets/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet" />
	<link href="assets/css/style-responsive.css" rel="stylesheet" />
	<link href="assets/css/themes/default.css" rel="stylesheet" id="style_color" />
	<link href="assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
	<link href="#" rel="stylesheet" id="style_metro" />
	<!-- END GLOBAL MANDATORY STYLES -->
<?php
	// The CSS included
	if ($templateResource = self::getResource('css')) {
?>

	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<link href="assets/css/pages/login.css" rel="stylesheet" type="text/css" />
<?php
		foreach ($templateResource as $style) {
?>
	<link rel="stylesheet" href="<?php echo $style; ?>" />
<?php
		}
?>
	<!-- END PAGE LEVEL PLUGINS -->
<?php
	}
?>

	<!-- Le fav and touch icons -->
	<link rel="apple-touch-icon-precomposed" sizes="129x129" href="favicon-2.png">
	<link rel="shortcut icon" href="favicon-2.png" /> 
</head>
<body class="fixed-top">
<?php
/**
 * Show the contents of the page
 */
echo $content;
?>
	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	<!-- BEGIN CORE PLUGINS -->
	<script src="assets/plugins/jquery-1.8.3.min.js"></script> 
	<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->  
	<script src="assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>    
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!--[if lt IE 9]>
	<script src="assets/plugins/excanvas.js"></script>
	<script src="assets/plugins/respond.js"></script> 
	<![endif]-->  
	<script src="assets/plugins/breakpoints/breakpoints.js"></script>
	<script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/plugins/jquery.blockui.js"></script>
	<script src="assets/plugins/jquery.cookie.js"></script>
	<script src="assets/plugins/uniform/jquery.uniform.min.js" ></script>
	<!-- END CORE PLUGINS -->
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="assets/scripts/app.js"></script>
	<script> jQuery(document).ready(function() { App.init(); }); </script>
	<script src="assets/scripts/login.js"></script>
	<script src="src/js/check_pass.js"></script> 
	<script src="assets/scripts/index.js" type="text/javascript"></script>
<?php
	/***
	 * Specify the scripts that are to be added.
	 */
	if ($templateResource = self::getResource('js')) {
		foreach ($templateResource as $js) {
?>
	<script src="<?php echo $js; ?>"></script>
<?php
		}
	}
?>
	<!-- END PAGE LEVEL PLUGINS -->
</body>
</html>

