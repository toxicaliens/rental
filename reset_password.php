<?php
session_start();
  //connection to the database
 include "src/connection/config.php";
 include "src/library.php";
   // retrieve token
    if (isset($_GET["token"]) && preg_match('/^[0-9A-F]{40}$/i', $_GET["token"])) {
        $token = $_GET["token"];
    
  //check if the token exists in the system and if the token has expired
  if(!checkToken($token)){
        $_SESSION['loginerror'] = "Please Provide a valid Token and Try again!";
     }
     else { 

     //Check to see if link has expired
      // $currentDate = strtotime(checkCurrentdate($token));
      $expDate = strtotime(checkExpdate($token));
      if ($_SERVER["REQUEST_TIME"] > $expDate) {
          $_SESSION['loginerror'] = " The Token you are trying to use has expired!";
            header('location: index.php');
      } 
    }
  } 
  //check if the reset password form has been submitted
  if(isset($_POST['reset_pass'])){
    if (!resetPassword($_POST)){
      $_SESSION['loginerror'] = "Sorry, the Password was not Reset!";
    }else{
       $_SESSION['loginerror2'] = "Your Password has been Reset Successfully!";
       // var_dump($_SESSION['loginerror2']);exit;
       header('location: index.php');
    }
  }

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
  <meta charset="utf-8" />
  <title>Password Recovery</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="description" />
  <meta content="" name="author" />
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
  <!-- BEGIN PAGE LEVEL STYLES -->  
  <link href="assets/css/pages/login.css" rel="stylesheet" type="text/css" />
  <!-- END PAGE LEVEL STYLES -->
  <!-- Le fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="129x129" href="favicon-2.png">
  <link rel="shortcut icon" href="favicon-2.png" /> 
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body>
  <!-- BEGIN LOGO -->
  <div id="logo" class="center">
        <h4 style="color:white;">Reset your Password!</h4>
    </div>
  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div id="login">
    <p>Welcome back,<strong><?=getUsernameFromToken($token); ?></strong></p>
    <p><b>In the fields below, enter your new password.</b></p>
    <!-- BEGIN LOGIN FORM -->
   <form action="" method="post">
        <div class="control-group">
            <label for="password">New Password</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-lock"></i></span>
                        <input type="password" class="input" name="password" id="password" value="" maxlength="12">
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label for="pass_again">Confirm Password</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-lock"></i></span>
                        <input type="password" class="input" name="pass_again" id="pass_again" value="" maxlength="12">
                    </div>
                     <span id='message'></span>
                </div>
            </div>
        <input type="hidden" name="username" value="<?=getUsernameFromToken($token); ?>"/>
        <input type="hidden" name="reset_pass" value="valid" />
        <input type="submit" id="reset-btn" class="btn btn-block btn-inverse" value="Reset password" />
    </form>
    <!-- END LOGIN FORM -->        
  </div>
  <!-- END LOGIN -->
  <!-- BEGIN COPYRIGHT -->
  <div id="login-copyright">
   <?=date('Y'); ?> &copy; Oriems Powered by <a href="http://obulexsolutions.com">Obulex Solutions</a>.
  </div>
  <!-- END COPYRIGHT -->
  <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
  <!-- BEGIN CORE PLUGINS -->
  <script src="assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script> 
  <!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->  
  <script src="assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>    
  <script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <!--[if lt IE 9]>
  <script src="assets/plugins/excanvas.js"></script>
  <script src="assets/plugins/respond.js"></script> 
  <![endif]-->  
  <script src="assets/plugins/breakpoints/breakpoints.js" type="text/javascript"></script>  
  <script src="assets/plugins/jquery.blockui.js" type="text/javascript"></script> 
  <script src="assets/plugins/jquery.cookie.js" type="text/javascript"></script>
  <script src="assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>  
  <!-- END CORE PLUGINS -->
  <!-- BEGIN PAGE LEVEL SCRIPTS -->
  <script src="assets/scripts/app.js"></script>
  <script src="assets/scripts/login.js"></script>
  <script src="src/js/check_pass.js"></script>  
  <!-- END PAGE LEVEL SCRIPTS --> 
  <script>
    jQuery(document).ready(function() {     
      // initiate layout and plugins
      App.init();
      Login.init();
    });
  </script>
  <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>