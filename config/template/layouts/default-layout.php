<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php
	// The page title
	$templateResource = self::getResource('title');
	$templateResource = ($templateResource=="") ? "RENTAL": $templateResource; ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php
	// The page title
	$templateResource = self::getResource('title');
	$templateResource = ($templateResource=="") ? "RENTAL COLLECTION": $templateResource;
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

	<!-- BEGIN TOP NAVIGATION BAR -->
	<div id="header" class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<!-- BEGIN LOGO -->
				<a class="brand" href="#">G-TEL CARE:Welcome<?php echo isset($_SESSION['sys_name'])?", ".$_SESSION['sys_name'].' - '.$_SESSION['role_name']:''; ?></a>
				<!-- END LOGO -->

				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
				<a class="btn btn-navbar collapsed" id="main_menu_trigger" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="arrow"></span>
				</a>          
				<!-- END RESPONSIVE MENU TOGGLER -->   
				
				<!-- BEGIN TOP NAVIGATION MENU -->  
				<div class="top-nav">
					<ul class="nav pull-right" id="top_menu">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="icon-user"></i>
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li><a href="index.php?num=713"><i class="icon-user"></i> Profile</a></li>
								<li class="divider"></li>
								<li><a href="index.php?signout=t"><i class="icon-key"></i> Log Out</a></li>
							</ul>
						</li>
					</ul>
				</div>
				<!-- END TOP NAVIGATION MENU -->  
			</div>
		</div>
	</div>
	<!-- END TOP NAVIGATION BAR -->
	
	<!-- BEGIN CONTAINER -->
	<div id="container" class="row-fluid">

		<!-- BEGIN SIDEBAR -->
		<div id="sidebar" class="nav-collapse collapse">
			<div class="sidebar-toggler hidden-phone"></div>
			<?php
				//display the menu with only views accessible to the identified role
				getDbMenu(null, $_GET['num'], getAllocatedViews($_SESSION['role_id'])); 
			?>
		</div>
		<!-- END SIDEBAR -->
		
		<!-- BEGIN PAGE -->  
		<div id="body" data-height="800" style="">
			<div class="container-fluid">
				<!-- BEGIN PAGE CONTENT -->
				<div class="row-fluid">
					<div class="span12">
<?php
/**
 * Show the contents of the page
 */
echo $content;
?>
					</div>
				</div>
				<!-- END PAGE CONTENT -->
				
			</div>
		</div>
		<!-- END PAGE -->  
	</div>
	<!-- END CONTAINER -->
	
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
	<script>
		$(document).ready(function(){
			$('ul ul').addClass('sub');
			$('ul.sub .paro').hide();
			$('li.active').parent().css('display','block').addClass('live-active');;
			$('.live-active').parent().addClass('active');
			$('ul.sub:empty').hide();
		});
	</script>
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

	<!-- BEGIN TOP NAVIGATION BAR -->
	<div id="header" class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<!-- BEGIN LOGO -->
				<a class="brand" href="#">AFYAPOA: Welcome<?php echo isset($_SESSION['sys_name'])?", ".$_SESSION['sys_name'].' - '.$_SESSION['role_name']:''; ?></a>
				<!-- END LOGO -->

				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
				<a class="btn btn-navbar collapsed" id="main_menu_trigger" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="arrow"></span>
				</a>          
				<!-- END RESPONSIVE MENU TOGGLER -->   
				
				<!-- BEGIN TOP NAVIGATION MENU -->  
				<div class="top-nav">
					<ul class="nav pull-right" id="top_menu">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="icon-user"></i>
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li><a href="#"><i class="icon-user"></i><?php echo isset($_SESSION['sys_name'])?", ".$_SESSION['sys_name']:''; ?>'s Settings</a></li>
								<li class="divider"></li>
								<li><a href="index.php?signout=t"><i class="icon-key"></i> Log Out</a></li>
							</ul>
						</li>
					</ul>
				</div>
				<!-- END TOP NAVIGATION MENU -->  
			</div>
		</div>
	</div>
	<!-- END TOP NAVIGATION BAR -->
	
	<!-- BEGIN CONTAINER -->
	<div id="container" class="row-fluid">

		<!-- BEGIN SIDEBAR -->
		<div id="sidebar" class="nav-collapse collapse">
			<div class="sidebar-toggler hidden-phone"></div>
			<?php getDbMenu(null, $_GET['num'], getAllocatedViews($_SESSION['role_id'])); ?>
		</div>
		<!-- END SIDEBAR -->
		
		<!-- BEGIN PAGE -->  
		<div id="body" data-height="800" style="">
			<div class="container-fluid">
				<!-- BEGIN PAGE CONTENT -->
				<div class="row-fluid">
					<div class="span12">
<?php
/**
 * Show the contents of the page
 */
echo $content;
?>
					</div>
				</div>
				<!-- END PAGE CONTENT -->
				
			</div>
		</div>
		<!-- END PAGE -->  
	</div>
	<!-- END CONTAINER -->
	<div id="footer">
		<?=date('Y'); ?> &copy; Oriems Powered by <a href="http://obulexsolutions.com">Obulex Solutions</a>.
		<!-- <div class="span pull-right">
			<span class="go-top"><i class="icon-arrow-up"></i></span>
		</div> -->
	</div>
	
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
	<script type="text/javascript" src="src/js/delete.js"></script>
	<!-- END CORE PLUGINS -->
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="assets/scripts/app.js"></script>
	<script> jQuery(document).ready(function() { App.init(); }); </script>
	<script>
		$(document).ready(function(){
			$('ul ul').addClass('sub');
			$('ul.sub .paro').hide();
			$('li.active').parent().css('display','block').addClass('live-active');
			$('.live-active').parent().addClass('active');
			$('ul.sub:empty').hide();
		});
	</script>
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

