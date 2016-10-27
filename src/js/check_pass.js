
$('#pass_again').on('keyup', function () {
  if ($('#password').val() == $('#pass_again').val()) {
   $('#message').html('The Passwords are Matching').css('color', 'green'); 
   $("#reset-btn").removeAttr("disabled"); 
  } 
 else {
   $('#message').html('The Passwords Do Not Match').css('color', 'red'); 
   $("#reset-btn").attr("disabled", "disabled"); 
  }
 });
