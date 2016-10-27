<?php

// Start the session
ini_set("session.gc_maxlifetime", "14400");
session_start();

// Load basic app functions
include WPATH . "core/Oriems/App.php";

// Specify the library files to include
App::libInclude("basic");

// Specify the constants that have to be defined
App::defineConstants("basic");

// Specify the libraries to include during a post action
if ( isset($_POST['action']) ) App::libInclude("post");

// Login/Authentication event
if (isset($_POST['entry_point']) && $_POST['entry_point']=="valid" && (!isset($_SESSION['logged']) || $_SESSION['logged']==false)) {
  $user_ip = getUserIp();

  //var_dump(checkLogin($username, $password));exit;
  // if (!isset($_POST['secure'])){
  // $_SESSION['secure']=rand(1000,9999);  
  // } else {
  // if($_SESSION['secure']==$_POST['secure']){
  
    if (!checkLogin($_POST['username'], $_POST['password'], $user_ip)) {
      recordUnSuccessfulLoginAttempt($_POST['username'], $_POST['password'], $user_ip);
      $_SESSION['loginerror'] = "Login was un-successful. Please try again!";
      addLoginAttempt($user_ip);
      

      if(confirmIPAddress($user_ip, $_POST['username'])){
        $_SESSION['loginerror'] = "Maximum no of logins reached. The acount has been blocked. Please contact the admin!";
      }
      
    }else {
      $_SESSION['sess_id'] = recordSuccessfulLogin($_SESSION['login_id'], $_SESSION['mf_id'], session_id());
      resetLoginAttempts();
      App::redirectTo("index.php");
    }
  // }else{
  //   $_SESSION['loginerror'] = "Incorrect Captcha Value, try again!";
  //   $_SESSION['secure']=rand(1000,9999);
  // }
 // }
    
}
else if ( isset($_GET['signout']) && $_GET['signout']=="t") {
    App::logOut();
}

//check if a the forget password form has been submitted
if(isset($_POST['check_mail'])){
   if (!checkEmail($_POST['email'])){
   	  $_SESSION['loginerror'] = "Please enter a valid E-mail and try again!";
   }   
   else{
      $email = $_POST['email'];
      $username = checkUsername($email);
      $token = sha1(uniqid($username, true));
      $expFormat = mktime(date("H"), date("i"), date("s"), date("m")  , date("d")+3, date("Y"));
      $expDate = date("Y-m-d H:i:s",$expFormat);
      $reset = array('token' => $token,'email' => $email, 'username' => $username, 'expdate' => $expDate);
       //var_dump($reset);exit;
      if (!saveTokens($reset)){
       // $_SESSION['loginerror'] = "Please enter a valid E-mail and try again!";
       } 
       else{

    	$to = $email;
        $subject = 'Password Recovery';
       $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/reset_password.php';
        $passwordLink = $url.'?token='.$token;
       // var_dump($passwordLink);exit;
        $message = "Dear $username,\r\n";
        $message .= "Please visit the following link to reset your password:\r\n";
        $message .= "-----------------------\r\n";
        $message .= "$passwordLink\r\n";
        $message .= "-----------------------\r\n";
        $message .= "Please be sure to copy the entire link into your browser. The link will expire after 3 days for security reasons.\r\n\r\n";
        $message .= "If you did not request this forgotten password email, no action is needed, your password will not be reset as long as the link above is not visited. However, you may want to log into your account and change your security password, as someone may have tried using it.\r\n\r\n";
        $message .= "Thanks,\r\n";
        $message .= "-- Our team";
        if(mail($to, $subject, $message)){
          
        $_SESSION['loginerror2'] = "An email has been sent to you with instructions on how to reset your password.";
    	}else{
    		$_SESSION['loginerror'] = 'Sorry, the Email was not sent!';
    	}
   }
 }
}

//check if the reset password form has been submitted
  if(isset($_POST['reset_pass'])){
    $email = $_POST['email'];
    $status = $_POST['1'];
    $pass_hash = sha1($password);
    $pass = array('email' => $email, 'user_active' => $status, 'password' => $pass_hash);
     //var_dump($pass);exit;
    if (!resetPassword($pass)){
        $_SESSION['loginerror'] = "Sorry, the Password was not Reset!";
       } 
       else{
         $_SESSION['loginerror2'] = "Your Password has been Reset Successfully!";
        App::redirectTo("login.php");
       }
  }

// Load the appropriate page using the template controller
include WPATH . "core/Oriems/Template/TemplateController.php";
$template = new TemplateController();
$page = null;

if ( !isset($_SESSION['logged']) || $_SESSION['logged']==false ) {
	if ( !empty($_GET) ) {
		App::redirectTo("index.php");
	}
	$page = "login";
}
$template->render($page);
