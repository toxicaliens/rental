<!--<div class="span2"><a href="#edit-logo" data-toggle="modal"><img src="--><?//=$profile_pic; ?><!--" alt="" /></a>-->
<div class="span12">

<div class="span2" style="margin-right: 15px">
    <div class="thumbnail">
        <img src="<?php echo (!empty($profile_pic))? $profile_pic: 'assets/img/no-image.png' ?>" alt="" />
    </div>
</div>
    <form>
       <div class="span9">
          <div class="row-fluid">
             <div class="span12">
                <div class="control-group">
                   <label for="full_name" class="control-label span2">Full Name:</label>
                   <div class="controls">
                      <input type="text" readonly value="<?=$row['surname'].' '.$row['firstname'].' '.$row['middlename']; ?>" class="span4">
                   </div>
                </div>
             </div>
          </div>
          <div class="row-fluid">
             <div class="span12">
                <div class="control-group">
                   <label for="full_name" class="control-label span2">Email:</label>
                   <div class="controls">
                      <div class="span8">
                      <div class="span6"><input type="text" readonly value="<?=$row['email'];?>" class="span12 em_change"></div><a href="#change-email" data-toggle="modal" class="btn btn-success span4">Change Email</a>
                      </div>
                   </div>
                </div>
             </div>
          </div>

          <div class="row-fluid">
             <div class="span12">
                <div class="control-group">
                   <label for="full_name" class="control-label span2">Phone Number:</label>
                   <div class="controls">
                      <div class="span8">
                         <div class="span6"><input type="text" id="new-f" readonly value="<?=$row['phone']; ?>" class="span12"></div><a href="#change-phone" data-toggle="modal" class="btn btn-success span4">Change phone no.</a>
                      </div>
                   </div>
                </div>
             </div>
          </div>

          <div class="row-fluid">
             <div class="span12">
                <div class="control-group">
                   <label for="full_name" class="control-label span2">ID No/Passport:</label>
                   <div class="controls">
                      <input type="text" readonly value="<?=$row['id_passport']; ?>" class="span4">

                   </div>

                </div>
             </div>
          </div>

          <div class="row-fluid">
             <div class="span12">
                <div class="control-group">
                   <label for="full_name" class="control-label span2">User Role:</label>
                   <div class="controls">
                      <input type="text" readonly value="<?=$row['role_name']; ?>" class="span4">
                   </div>
                </div>
             </div>
          </div>

          <div class="row-fluid">
             <div class="span12">
                <div class="control-group">
                   <label for="full_name" class="control-label span2">User Name:</label>
                   <div class="controls">
                      <input type="text" readonly value="<?=$row['username']; ?>" class="span4 em_change">
                   </div>
                </div>
             </div>
          </div>

       </div>
    </form>
</div>

<!--modal for edditing user logo-->
<form action="" method="post">
<div id="change-email" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="myModalLabel1">Change Email address </h3>
   </div>
   <div class="modal-body">
      <div class="alert alert-block alert-info fade in" id="email-warning-alert" style="display: none;">
         <button type="button" class="close" data-dismiss="alert">×</button>
<!--         <h4 class="alert-heading">Info!</h4>-->
         <p>
            Please Enter a valid email address
         </p>
      </div>

      <div class="alert alert-block alert-success fade in" id="email-confirm-alert" style="display: none">
         <button type="button" class="close" data-dismiss="alert">×</button>
         <!--         <h4 class="alert-heading">Info!</h4>-->
         <p>
            An email with a reset code was sent to (<?php echo $row['email'];?>). <br> please enter the reset code to finish
         </p>
      </div>
      <div class="alert alert-block  fade in" id="success-success" style="display: none">
         <button type="button" class="close" data-dismiss="alert">×</button>
         <!--         <h4 class="alert-heading">Info!</h4>-->
         <p id="success-message">

         </p>
      </div>
      <div class="alert alert-block  fade in" id="success-fail-success" style="display: none">
         <button type="button" class="close" data-dismiss="alert">×</button>
         <!--         <h4 class="alert-heading">Info!</h4>-->
         <p id="error-message">

         </p>
      </div>



      <div class="row-fluid" id="email-address" style="margin-bottom: 10px;">
         <div class="controls">
            <label for="email_address">Enter your new email address</label>
            <input type="email" id="email_address" autocomplete="off" name="email" class="span12" required>
         </div>
         <div class="pull-right" style="margin-top: 20px">
            <button class="btn btn-success" id="submit-email-change">Submit</button>
             <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
         </div>
      </div>
      <div class="row-fluid" id="email-change-code" style="display: none; margin-bottom: 10px;">
         <div class="controls">
            <label for="email_address">Please enter the code that was sent to your email</label>
            <input type="number" id="email_address_code" autocomplete="off" name="reset_code" class="span12">
         </div>
         <div class="pull-right" style="margin-top: 20px">
            <button class="btn btn-success" id="change-email-btn">Submit</button>
             <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
         </div>
      </div>

   </div>
   <!-- the hidden fields -->
<!--   <input type="hidden" name="action" value="change-email"/>-->
<!--   <div class="modal-footer">-->
<!--      -->
<!--<!--      <button class="btn btn-primary">Change</button>-->
<!--   </div>-->
</div>
</form>

<!--?modal for reseting phone number-->

<form action="" method="post">
    <div id="change-phone" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel1">Change Phone number </h3>
        </div>
        <div class="modal-body">
            <div class="alert alert-block alert-info fade in" id="phone-warning-alert" style="display: none;">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <!--         <h4 class="alert-heading">Info!</h4>-->
                Please enter a valid phone number eg (0700 123 456)
                </p>
            </div>

            <div class="alert alert-block alert-success fade in" id="reset_code_sent" style="display: none">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <!--         <h4 class="alert-heading">Info!</h4>-->
                <p>
                    A reset code was sent to (0<?php echo $row['phone'];?>). <br> please enter the reset code to finish
                </p>
            </div>
            <div class="alert alert-block alert-success fade in" id="success-phone-change" style="display: none">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <!--         <h4 class="alert-heading">Info!</h4>-->
                <p id="sucess-pchange-message">

                </p>
            </div>
            <div class="alert alert-block alert-danger fade in" id="invalid-phone-code-warning" style="display: none">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <!--         <h4 class="alert-heading">Info!</h4>-->

                    The code you entered does not appear to be valid,<br>
                    Please confirm your sms and try again.
                </p>
            </div>



            <div class="row-fluid" id="new-phone-number-div" style="margin-bottom: 10px;">
                <div class="controls">
                    <label for="email_address">Enter your new phone number</label>
                    <input type="number" id="new_phone_number" autocomplete="off" name="phone_number" class="span12" required>
                </div>
                <div class="pull-right" style="margin-top: 20px">
                    <button class="btn btn-success" id="submit_phone_number">Submit</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                </div>
            </div>
            <div class="row-fluid" id="phone-reset-code-confirm" style="display: none; margin-bottom: 10px;">
                <div class="controls">
                    <label for="email_address">Please enter the code that was sent to your phone</label>
                    <input type="number" id="phone-reset-code-c" autocomplete="off" name="reset_code" class="span12">
                </div>
                <div class="pull-right" style="margin-top: 20px">
                    <button class="btn btn-success" id="change-phone_number-btn">Submit</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                </div>
            </div>

        </div>
        <!-- the hidden fields -->
<!--        <input type="hidden" name="action" value="change-email"/>-->
<!--        <div class="modal-footer">-->
<!--            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>-->
<!--            <!--      <button class="btn btn-primary">Change</button>-->
<!--        </div>-->
    </div>
</form>