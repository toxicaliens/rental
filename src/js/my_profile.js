function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}
$('#submit-email-change').on('click',function (e) {
    e.preventDefault();
   var new_email = $('#email_address').val();
    if(!isValidEmailAddress(new_email)){
        $('#email-warning-alert').slideDown('slow');
        setTimeout(function(){
            $('#email-warning-alert').slideUp('slow')
        }, 2000);
    }else{
        var data = { 'action': 'change-email',
                        'email_address': new_email
        }
        $.ajax({
           url:'?num=713',
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function(data){
                if(data[0].send_mail){
                    $('#email-confirm-alert').slideDown('slow');
                    $('#email-address').hide();
                    $('#email-change-code').show();

                }
            }
        });
    }

});

$('#change-email-btn').on('click',function (e) {
    e.preventDefault();
    var code = $('#email_address_code').val();
    if(code == ''){
        alert('please enter the reset code that was sent to your email');
    }else{
        var data = {
            'action':'reset-code',
            'reset_email_code': code
        }
        $.ajax({
            url: '?num=713',
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                show_hide(data);
            }
        })
    }
});
function show_hide (data) {

    if(data[0].success){
        $('.em_change').val(data[0].new_email);
        $('#email-change-code,#email-confirm-alert').hide('slow');
        $('#success-message').html('Email change was successful, <br> Your new email is ('+data[0].new_email +')');
        $('#success-fail-success').slideUp('slow');
        $('#success-success').addClass('alert-success').show()
    }else{
        $('#email-change-code').show('slow');
        $('#email-confirm-alert').hide('slow');
        $('#error-message').html('Email change was Unsuccessful, <br> Please check your email for the correct code');
        $('#success-fail-success').addClass('alert-danger').show('slow')
    }
}

$('#submit_phone_number').on('click',function (e) {
    e.preventDefault();
    var phone_number =$('#new_phone_number').val();
    if(!testnumber(phone_number)){
        $('#phone-warning-alert').slideDown('slow');
        setTimeout(function(){
            $('#phone-warning-alert').slideUp('slow')
        }, 2000);
    }else{
        var data = {
            'action':'change-phone_number',
            'phone_number': phone_number
        }

        $.ajax({
            url: '?num=713',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                show_hide_p(data);
            }
        })
    }

});

//fucntion to test phone number validity
function testnumber(number){
    var pattern = /([0-9]{10})|(\([0-9]{3}\)\s+[0-9]{3}\-[0-9]{4})/;
    return pattern.test(number);
}

    function show_hide_p(data) {
        if(data[0].send_phone_number){
            $('#reset_code_sent').show('slow');
            $('#new-phone-number-div').hide('slow');
            $('#phone-reset-code-confirm').show('slow');
        }
    }

$('#change-phone_number-btn').on('click',function (e) {
    e.preventDefault();
    var confirmation_code = $('#phone-reset-code-c').val();
    if(confirmation_code != ''){
        var data = {
            'action':'confirm-phone-reset',
            'confirmation_code':confirmation_code
        };
        $.ajax({
            url:'?num=713',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                confirm(data);
            }
        })
    }else{
        $('#reset_code_sent').hide('slow');
        $('#invalid-phone-code-warning').show('slow');
    }
});

function confirm(data){
    if(data[0].success){
        $('#reset_code_sent').hide('slow');
        $('#phone-reset-code-confirm').hide('slow');
        $('#sucess-pchange-message').html('Your phone number has been changed to ('+ data[0].new_phone+') successfully');
        $('#invalid-phone-code-warning').hide('slow');
        $('#success-phone-change').show('slow');
        $('#new-f').val(data[0].new_phone);
    }else{
        $('#reset_code_sent').hide('slow');
        $('#invalid-phone-code-warning').show('slow');
    }
}