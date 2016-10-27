$('#forget-password').click(function () {
    $('#loginform').hide();
    $('#forgotform').show(200);
});

$('#forget-btn').click(function () {

    $('#loginform').slideDown(200);
    $('#forgotform').slideUp(200);
});