<?php set_layout("base.php"); set_css(array("assets/css/pages/login.css")); ?>
	<!-- BEGIN LOGO -->
	<div id="logo" class="center">
		<h4 style="color:white;">RENTAL</h4>
	</div>
	<!-- END LOGO -->
 
	<!-- BEGIN LOGIN FORM -->
	<div id="login">
<?php if ( isset($_SESSION['loginerror']) ) { ?>
		<div class="alert">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Warning!</strong> <?php echo $_SESSION['loginerror'] ?>
		</div>
<?php unset($_SESSION['loginerror']); } ?>
<?php if ( isset($_SESSION['loginerror2']) ) { ?>
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Success!</strong> <?php echo $_SESSION['loginerror2'] ?>
		</div>
<?php unset($_SESSION['loginerror2']); } ?>
		<form id="loginform" class="form-vertical no-padding no-margin" action="#" method="post">
			<p class="center">Enter your username and password.</p>
			<div class="control-group">
				<div class="controls">
					<div class="input-prepend">
						<span class="add-on"><i class="icon-user"></i></span>
						<input type="text" id="username" name="username" placeholder="Username" />
					</div>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<div class="input-prepend">
						<span class="add-on"><i class="icon-lock"></i></span>
						<input type="password" id="password" name="password" placeholder="Password" />
					</div>
				</div>
			</div>
		
			<div class="control-group remember-me">
		        <div class="controls">
		          <label class="checkbox">
		          <input type="checkbox" name="remember" value="1"/> Remember me
		          </label>
		          <a href="javascript:;" class="pull-right" id="forget-password">Forgot Password?</a>
		        </div>
		    </div>
			<input type="hidden" name="entry_point" value="valid" />
			<input type="submit" id="login-btn" class="btn btn-block btn-inverse" value="Login" />
		</form>
		<!-- BEGIN FORGOT PASSWORD FORM -->
	    <form id="forgotform" method="post" class="form-vertical no-padding no-margin hide" action="">
	      <p class="center">Enter your e-mail address to reset your password.</p>
	      <div class="control-group">
	        <div class="controls">
	          <div class="input-prepend">
	            <span class="add-on"><i class="icon-envelope"></i></span><input id="input-email" type="email" name="email" placeholder="Email" />
	          </div>
	        </div>
	        <div class="space10"></div>
	      </div>
	      <input type="hidden" name="check_mail" value="valid" />
	      <input type="submit" id="forget-btn" class="btn btn-block btn-inverse" value="Submit" />
	    </form>
    <!-- END FORGOT PASSWORD FORM -->
	</div>
	<!-- END LOGIN FORM --> 
	<!-- BEGIN COPYRIGHT -->
  <div id="login-copyright">
   <?=date('Y'); ?> &copy; Oriems Powered by <a href="http://obulexsolutions.com">Obulex Solutions</a>.
  </div>
  <!-- END COPYRIGHT -->
 